<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UserAccount;
use common\models\Account;
use common\models\UsersSearch;
use common\models\Mailer;
use common\models\CompaniesUsers;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use backend\models\Goals;


/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    public function behaviors()
    {
        if(!isset(Yii::$app->user->identity->id))
        {
          $this->redirect(\Yii::$app->urlManager->createUrl("site/index"));
        }
        if(isset(Yii::$app->user->identity) && !Yii::$app->user->identity->isVerified())
        {
          $this->redirect(\Yii::$app->urlManager->createUrl("site/verification"));
        }
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->role->hasModule('users'))
        {
            throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->company->getCompanyID());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->user->identity->id == $id || !Yii::$app->role->canRead('users'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        return $this->render('view', [
            'model' => $this->findModel($id, Yii::$app->company->getCompanyID()),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        if(!Yii::$app->role->canCreate('users'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $model = new Users();


        if ($model->load(Yii::$app->request->post())) {  
          $password = GlobalFunctions::generateRandomPassword();
            $user = Users::findByEmail($model->user_email);
            if($user)
            {
              $model = $user;
              $flag = true;
            } else {
              $model->id = GlobalFunctions::generateUniqueId();
              $model->generateAuthKey();
            
              $model->setPassword($password);
              $model->status = Users::STATUS_ACTIVE;
              $model->user_verified = 0;
              $model->user_create_time = date('Y-m-d H:i:s');
              $flag = $model->save();
              $file = UploadedFile::getInstance($model, 'user_new_photo');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
                $model->user_photo = $file->name;
                $model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }
            }
            if($flag)
            {
              
              $relation = CompaniesUsers::find()->where(['user_id' => $model->id, 'company_id' => Yii::$app->company->getCompanyID()])->one();
              if($relation)
              {
                return $this->redirect('site/error', [
                    'name' => 'Server Error',
                    'message' => 'There was an error while processing your request, please try again.'
                ]);
              }
              else {
                $relation = new CompaniesUsers();
                $relation->company_id = Yii::$app->company->getCompanyID();
                $relation->user_id = $model->id;
                $relation->user_role_id = $model->user_role_id;

                $account = new Account();
                $account->account_id = GlobalFunctions::generateUniqueId();
                $account->created_at = date('Y-m-d H:i:s');
                $account->account_name = $model->user_name;
                $account->level_id = GlobalFunctions::getLevel()->level_id;
                //var_dump($account->level_id);die;
                $account->company_id=Yii::$app->company->getCompanyID();

                $u_account = new UserAccount();
                $u_account->account_id = $account->account_id;
                $u_account->user_id = $model->id;

           
              }
              if($relation->save() 
                && $account->save()
                && $u_account->save()
               
                )
              {
                     $goal_types = ['daily','weekly','monthly'];

                for($i=0;$i<3;$i++){
                  $goal = new Goals();
                  $goal->goal_id = GlobalFunctions::generateUniqueId();
                  $goal->goal_type = $goal_types[$i];
                  $goal->goal_value = 0;
                  $goal->account_id = $account->account_id;
                  $goal->start_date = date('Y-m-d'); 
                  $goal->save();
                }
                  $authUrl="http://localhost/repshub/backend/web/site/authenticate?email=".$model->user_email."&authkey=".$model->user_auth_key;
                  // if(isset($password))
                  // {
                    
                  //   Mailer::sendUserAddedEmail($model, $authUrl);
                  // } else {
                   Mailer::sendUserAddedEmail($model, $authUrl, $password);
               //   }
                  return $this->redirect(['view', 'id' => $model->id]);
              } else {
                  $model->delete();
                  return $this->redirect('site/error', [
                      'name' => 'Server Error',
                      'message' => 'There was an error while processing your request, please try again.'
                  ]);
              }
            }
            else {
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->identity->id == $id || !Yii::$app->role->canUpdate('users'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $flag = true;
            if(Yii::$app->role->isOwner() && $model->id != Yii::$app->company->getCompanyOwner())
            {
              $relation = CompaniesUsers::find()->where(['company_id' => Yii::$app->company->getCompanyID() ,'user_id' => $model->id])->one();
              if(isset(Yii::$app->request->post()['Users']['user_role_id']))
              {
                $relation->user_role_id = Yii::$app->request->post()['Users']['user_role_id'];
                $model->user_update_time = date('Y-m-d H:i:s');
              }
              $flag = $relation->save();
            }
            if($model->save() && $flag)
            {
              $file = UploadedFile::getInstance($model, 'user_new_photo');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
                $model->user_photo = $file->name;
                $model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }
              return $this->redirect(['view', 'id' => $model->id]);
            }
            else {
              return $this->render('create', [
                  'model' => $model,
              ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->role->canDelete('users'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }
        if(Yii::$app->company->getCompanyOwner() != $id)
        {

          $relation = CompaniesUsers::find()->where(['user_id' => $id, 'company_id' => Yii::$app->company->getCompanyID()])->one();
          $relation->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::find()->joinWith('companies')->joinWith('companies.role')->where(['users.id' => $id, 'companies_users.company_id' => Yii::$app->company->getCompanyID(), 'status' => Users::STATUS_ACTIVE])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}

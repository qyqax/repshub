<?php

namespace backend\controllers;

use Yii;
use common\models\UserRoles;
use common\models\UserRolesSearch;
use common\models\RolePermissions;
use common\models\GlobalFunctions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;

/**
 * RolesController implements the CRUD actions for UserRoles model.
 */
class RolesController extends Controller
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
     * Lists all UserRoles models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->role->isOwner())
        {
          
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $searchModel = new UserRolesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->company->getCompanyID());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserRoles model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->role->isOwner())
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserRoles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->role->isOwner())
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $model = new UserRoles();
        $permissions_size = count($model->permissions);
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post()['UserRoles'];
            $model->id = GlobalFunctions::generateUniqueId();
            $model->company_id = Yii::$app->company->getCompanyID();
            if($model->save())
            {
              if($post['module_clients'])
              {
                $permissions_clients = new RolePermissions();
                $permissions_clients->user_role_id = $model->id;
                $permissions_clients->module = "clients";
                $permissions_clients->crud = $this->getCrud($post, "clients");
                $permissions_clients->save();
              }
              if($post['module_users'])
              {
                $permissions_users = new RolePermissions();
                $permissions_users->user_role_id = $model->id;
                $permissions_users->module = "users";
                $permissions_users->crud = $this->getCrud($post, "users");
                $permissions_users->save();
              }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing UserRoles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->role->isOwner())
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }
        $model = $this->findModel($id);
        $permissions_size = count($model->permissions);
        if(isset($model->permissions) && $permissions_size > 0)
        {
          for($i = 0; $i < $permissions_size; $i++)
          {
            if($model->permissions[$i]->module == "clients")
            {
              $model['module_clients'] = 1;
              $model['clients_create'] = $model->permissions[$i]->crud[0];
              $model['clients_read'] = $model->permissions[$i]->crud[1];
              $model['clients_update'] = $model->permissions[$i]->crud[2];
              $model['clients_delete'] = $model->permissions[$i]->crud[3];
            }
            if($model->permissions[$i]->module == "users")
            {
              $model['module_users'] = 1;
              $model['users_create'] = $model->permissions[$i]->crud[0];
              $model['users_read'] = $model->permissions[$i]->crud[1];
              $model['users_update'] = $model->permissions[$i]->crud[2];
              $model['users_delete'] = $model->permissions[$i]->crud[3];
            }
          }
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $post = Yii::$app->request->post()['UserRoles'];
            $permissions_clients = RolePermissions::findOne(['user_role_id' => $model->id, 'module' => 'clients']);
            if($post['module_clients'])
            {
              if(isset($permissions_clients))
              {
                $permissions_clients->crud = $this->getCrud($post, "clients");
              }
              else {
                $permissions_clients = new RolePermissions();
                $permissions_clients->user_role_id = $model->id;
                $permissions_clients->module = "clients";
                $permissions_clients->crud = $this->getCrud($post, "clients");
              }
              $permissions_clients->save();
            }
            else {
              if(isset($permissions_clients))
              {
                $permissions_clients->delete();
              }
            }
            $permissions_users = RolePermissions::findOne(['user_role_id' => $model->id, 'module' => 'users']);
            if($post['module_users'])
            {
              if(isset($permissions_users))
              {
                $permissions_users->crud = $this->getCrud($post, "users");
              }
              else {
                $permissions_users = new RolePermissions();
                $permissions_users->user_role_id = $model->id;
                $permissions_users->module = "users";
                $permissions_users->crud = $this->getCrud($post, "users");
              }
              $permissions_users->save();
            }
            else {
              if(isset($permissions_users))
              {
                $permissions_users->delete();
              }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function getCrud($model, $module)
    {
        return (string)$model[$module.'_create'].(string)$model[$module.'_read'].(string)$model[$module.'_update'].(string)$model[$module.'_delete'];
    }
    /**
     * Deletes an existing UserRoles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->role->isOwner())
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the UserRoles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserRoles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
          if (($model = UserRoles::find()->where(['id' => $id, 'company_id' => Yii::$app->company->getCompanyID()])->joinWith('permissions')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

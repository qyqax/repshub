<?php

namespace backend\controllers;

use Yii;
use backend\models\Clients;
use backend\models\ClientsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use common\models\Users;
use backend\models\ClientAttributes;
use backend\models\Attributes;
use backend\models\Model;
use backend\models\ImportClients;


/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends Controller
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
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!Yii::$app->role->hasModule('clients'))
        {
            throw new ForbiddenHttpException('You do not have permission to access this page.');
        }
        $user= Users::findByid(Yii::$app->user->identity->id);
        
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->searchAll(Yii::$app->request->queryParams, Yii::$app->company->getCompanyID());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Clients model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!Yii::$app->role->canRead('clients'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }
        $model = $this->findModel($id, Yii::$app->company->getCompanyID());
        $attributes=$model->clientAttributes;

        return $this->render('view', [
            'model' => $model,
            'attributes' => $attributes,
        ]);
    }

    /**
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    protected function saveCustomAttributes($attrArray, $id)
  {
    foreach ($attrArray as $attr) {
      $el = ClientAttributes::find()->where(['client_id' => $id, 'attribute_id' => $attr->attribute_id])->one();
      if($el)
      {
        $el->option_id = $attr->option_id;
        $el->attribute_value = $attr->attribute_value;
        $el->save();
      } else
      {
        $attr->client_id = $id;
        $attr->save();
      }
    }
  }

    public function actionCreate()
    {
     
        if(!Yii::$app->role->canCreate('clients'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $model = new Clients();
        
        $account_id = empty(Yii::$app->user->identity->accounts->account_id) ? NULL : Yii::$app->user->identity->accounts->account_id;
        $extra_fields = Attributes::find()
        ->where(['company_id' => Yii::$app->company->getCompanyId()])
        ->andWhere(['account_id' => NULL])
        ->orWhere(['account_id' =>$account_id])->all();
        $number_of_fields = count($extra_fields);
        $attributes_array = [];
        for($i = 0; $i < $number_of_fields; $i++)
        {
          $attributes_array[] = new ClientAttributes();
        }

        if ($model->load(Yii::$app->request->post())) {
            $attrs = Model::createMultiple(ClientAttributes::classname());
            Model::loadMultiple($attrs, Yii::$app->request->post());
            $model->id = GlobalFunctions::generateUniqueId();
            $model->user_id = Yii::$app->user->identity->id;
            $model->company_id = Yii::$app->company->getCompanyID();
            $model->client_create_time = date('Y-m-d H:i:s');
            $model->is_client_lead=1;
            $model->status = Clients::STATUS_ACTIVE;

           
            //$model->client_birthdate =  date_format(date_create_from_format(Yii::$app->user->identity->settings->date_format,$model->client_birthdate ), 'Y-m-d');
           
          

          if($model->validate())
          {
             $transaction = \Yii::$app->db->beginTransaction();
          try{
            if ($model->save(false)) {
              $file = UploadedFile::getInstance($model, 'client_new_photo');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
                $model->client_photo = $file->name;
                $model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }

              $this->saveCustomAttributes($attrs,$model->id);
              $transaction->commit();

              return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                throw new ErrorException('Something goes wrong');
            }
            

          }
          catch(Exception $e){

              $transaction->rollBack();
              break;
          }

          }else {
            return $this->render('create', [
                'model' => $model,
               'extra_fields' => $extra_fields,
          'attributes_array' => (empty($attributes_array)) ? [new ClientAttributes] : $attributes_array,
          'number_of_fields' => $number_of_fields,
            ]);
        }
         
        }else {
            return $this->render('create', [
                'model' => $model,
               'extra_fields' => $extra_fields,
          'attributes_array' => (empty($attributes_array)) ? [new ClientAttributes] : $attributes_array,
          'number_of_fields' => $number_of_fields,
            ]);
        }
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->role->canUpdate('clients'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }
       
        $model = $this->findModel($id);     

        $account_id = empty(Yii::$app->user->identity->accounts->account_id) ? NULL : Yii::$app->user->identity->accounts->account_id;
        $extra_fields = Attributes::find()
        ->where(['company_id' => Yii::$app->company->getCompanyId()])
        ->andWhere(['account_id' => NULL])
        ->orWhere(['account_id' =>$account_id])->all();
        
        $number_of_fields = count($extra_fields);
       
          for($i = 0; $i < $number_of_fields; $i++)
            {
              $attributes_array[] = new ClientAttributes();
            }
       

        if ($model->load(Yii::$app->request->post())) {
         
            $attrs = Model::createMultiple(ClientAttributes::classname());
            Model::loadMultiple($attrs, Yii::$app->request->post());
           
            $model->client_update_time = date('Y-m-d H:i:s');
            
            // $model->client_birthdate =  date_format(date_create_from_format(Yii::$app->user->identity->settings->date_format,$model->client_birthdate ), 'Y-m-d');
           
          

          if($model->validate())
          {
             $transaction = \Yii::$app->db->beginTransaction();
          try{
            if ($model->save(false)) {
              $file = UploadedFile::getInstance($model, 'client_new_photo');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
                $model->client_photo = $file->name;
                $model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }

              $this->saveCustomAttributes($attrs,$model->id);
              $transaction->commit();

              return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                throw new ErrorException('Something goes wrong');
            }
            

          }
          catch(Exception $e){

              $transaction->rollBack();
              break;
          }

          }else {
            return $this->render('create', [
                'model' => $model,
               'extra_fields' => $extra_fields,
          'attributes_array' => (empty($attributes_array)) ? [new ClientAttributes] : $attributes_array,
          'number_of_fields' => $number_of_fields,
            ]);
        }
       
        } else {
            return $this->render('create', [
                'model' => $model,
               'extra_fields' => $extra_fields,
          'attributes_array' => (empty($attributes_array)) ? [new ClientAttributes] : $attributes_array,
          'number_of_fields' => $number_of_fields,
            ]);
        }

    }

    /**
     * Deletes an existing Clients model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!Yii::$app->role->canDelete('clients'))
        {
          throw new ForbiddenHttpException('You do not have permission to access this page.');
        }

        $model = $this->findModel($id);
        $model->status = Clients::STATUS_INACTIVE;
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionImport() {
      
      $model = new ImportClients();
      
      if ($model->load(Yii::$app->request->post())) {
        
        $selected_columns = explode( ',', $model->columns );
        $number_of_selected_columns = count($selected_columns);

        $file = UploadedFile::getInstance($model, 'csv_file');
            if(is_object($file)){
              try{
                   $transaction = \Yii::$app->db->beginTransaction();
                   $handle = fopen("$file->tempName", "r");
                  
                  
                   while (($data = fgetcsv($handle, 1000, $model->delimiter)) !== FALSE) {
                    $newmodel=new Clients; 
                      for ($i=0; $i < $number_of_selected_columns; $i++) { 
                        switch ($selected_columns[$i]) {
                          case 'client_name':
                            $newmodel->client_name=$data[$i];
                            break;
                          case 'client_email':
                            $newmodel->client_email=$data[$i];
                            break;
                          case 'client_phone':
                            $newmodel->client_phone=$data[$i];
                            break;
                          case 'client_city':
                            $newmodel->client_city=$data[$i];
                            break;
                          case 'client_country':
                            $newmodel->client_country=$data[$i];
                            break;
                          case 'client_address':
                            $newmodel->client_address=$data[$i];
                            break;
                          case 'client_postal_code':
                            $newmodel->client_postal_code=$data[$i];
                            break;
                          case 'client_gender':
                            
                            if($data[$i]=='0' || $data[$i]=='1' ){
                              $newmodel->client_gender=(int)$data[$i];
                            }elseif(strtoupper($data[$i])=='M'){
                              $newmodel->client_gender=1;
                            }elseif(strtoupper($data[$i])=='F'){
                              $newmodel->client_gender=0;
                            }elseif(strtoupper($data[$i])=='MALE'){
                              $newmodel->client_gender=1;
                            }elseif(strtoupper($data[$i])=='FEMALE'){
                              $newmodel->client_gender=0;
                            }else{
                              $newmodel->client_gender=NULL;
                            }
                            var_dump($newmodel->client_gender);die;
                            break;
                          case 'client_birthdate':
                            $newmodel->client_birthdate=$data[$i];
                            break;
                          case 'card_id_number':
                            $newmodel->card_id_number=$data[$i];
                            break; 
                          case 'NIF':
                            $newmodel->NIF=$data[$i];
                            break;
                          case 'client_fb':
                            $newmodel->client_fb=$data[$i];
                            break;   
                          case 'client_tw':
                            $newmodel->client_tw=$data[$i];
                            break;                  
                          default:                            
                            break;
                        }
                      }
                    
                            $newmodel->id = GlobalFunctions::generateUniqueId();
                            $newmodel->user_id = Yii::$app->user->identity->id;
                            $newmodel->company_id = Yii::$app->company->getCompanyID();
                            $newmodel->client_create_time = date('Y-m-d H:i:s');
                            $newmodel->status = Clients::STATUS_ACTIVE;
                            $newmodel->is_client_lead=1;
                            
                            if(!$newmodel->save(false)){

                              throw new Exception("Error Processing Request", 1);
                              
                            }            
                            
                   }

                   $transaction->commit();
                   return $this->redirect(['index']);

                   }catch(Exception $error){
                       print_r($error);
                       $transaction->rollback();
                   }         
                 }        
              
      }else{
         return $this->renderAjax('import', ['model' => $model ]);
      }

  }

    /**
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::find()->select(['clients.*', 'users.user_name'])->where(['clients.id' => $id, 'clients.company_id' => Yii::$app->company->getCompanyID(), 'clients.status' => Clients::STATUS_ACTIVE])->joinWith('user')->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

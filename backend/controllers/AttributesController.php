<?php

namespace backend\controllers;

use Yii;
use backend\models\Attributes;
use backend\models\AttributesSearch;
use backend\models\DropdownOptions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;

/**
* AttributesController implements the CRUD actions for Attribute model.
*/
class AttributesController extends Controller
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
  * Lists all Attribute models.
  * @return mixed
  */
  public function actionIndex()
  {

    $searchModel = new AttributesSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider,
      ]);
    }

    /**
    * Displays a single Attribute model.
    * @param string $id
    * @return mixed
    */
    public function actionView($id)
    {
      $model = $this->findModel($id);
      if($model->attribute_type === 'dropdown')
      {
        $model->setDropdownOptionTags();
      }
      return $this->render('view', [
        'model' => $model,
        ]);
      }

      protected function saveDropdownOptions($options, $attribute_id)
      {
        foreach($options as $opt)
        {
          if($opt != '') {
            $option_model = new DropdownOptions();
            $option_model->id = GlobalFunctions::generateUniqueId();
            $option_model->attr_id = $attribute_id;
            $option_model->label = trim($opt);
            $option_model->save();
          }
        }
      }

      protected function deleteDropdownOptions($options, $attribute_id)
      {
        foreach($options as $opt)
        {
          $option_model = DropdownOptions::find()->where(['attr_id' => $attribute_id, 'label' => trim($opt)])->one();
          if($option_model) {
            $option_model->delete();
          }
        }
      }

      /**
      * Creates a new Attribute model.
      * If creation is successful, the browser will be redirected to the 'view' page.
      * @return mixed
      */
      public function actionCreate()
      {

        $model = new Attributes();
        if ($model->load(Yii::$app->request->post())) {
          $model->id = GlobalFunctions::generateUniqueId();          
          $model->account_id = empty(Yii::$app->user->identity->accounts->account_id) ? NULL : Yii::$app->user->identity->accounts->account_id;
          $model->company_id = Yii::$app->company->getCompanyID();
          if($model->save())
          {
            if($model->attribute_type === "dropdown")
            {
              $options_exploded = explode("," , Yii::$app->request->post()["Attributes"]["option_tags"]);
              $this->saveDropdownOptions($options_exploded, $model->id);
            }
            return $this->redirect(['index']);
          } else {
            return $this->renderAjax('create', [
              'model' => $model,
              'options' => (empty($options)) ? [new DropdownOptions] : $options,
              ]);
            }
          } else {
            return $this->renderAjax('create', [
              'model' => $model,
              'options' => (empty($options)) ? [new DropdownOptions] : $options,
              ]);
            }
          }

          /**
          * Updates an existing Attribute model.
          * If update is successful, the browser will be redirected to the 'view' page.
          * @param string $id
          * @return mixed
          */
          public function actionUpdate($id)
          {
            

            $model = $this->findModel($id);
            $model->setDropdownOptionTags();
            $old_options = $model->option_tags;
            $old_type = $model->attribute_type;

            if ($model->load(Yii::$app->request->post())) {
              if($model->attribute_type === "dropdown")
              {
                $old_exploded = explode("," , $old_options);
                $new_exploded = explode("," , Yii::$app->request->post()["Attributes"]["option_tags"]);
                $options_to_delete = array_diff($old_exploded, $new_exploded);
                $options_to_add = array_diff($new_exploded, $old_exploded);
                $this->saveDropdownOptions($options_to_add, $model->id);
                $this->deleteDropdownOptions($options_to_delete, $model->id);
              }
              if($old_type === "dropdown" && $old_type != $model->attribute_type)
              {
                DropdownOptions::deleteAll(['id' => $model->id]);
              }
              if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
              } else {
                return $this->render('update', [
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
            * Deletes an existing Attribute model.
            * If deletion is successful, the browser will be redirected to the 'index' page.
            * @param string $id
            * @return mixed
            */
            public function actionDelete($id)
            {
                $this->findModel($id)->delete();


              return $this->redirect(['index']);
            }

            /**
            * Finds the Attribute model based on its primary key value.
            * If the model is not found, a 404 HTTP exception will be thrown.
            * @param string $id
            * @return Attribute the loaded model
            * @throws NotFoundHttpException if the model cannot be found
            */
            protected function findModel($id)
            {
              if (($model = Attributes::find()->where(['id' => $id, 'company_id' => Yii::$app->company->getCompanyId()])->one()) !== null) {
                return $model;
              } else {
                throw new NotFoundHttpException('The requested page does not exist.');
              }
            }
          }

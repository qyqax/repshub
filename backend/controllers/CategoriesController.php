<?php

namespace backend\controllers;

use Yii;
use backend\models\Categories;
use backend\models\CategoriesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use backend\models\ProductSubcategory;
use backend\models\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * CategoriesController implements the CRUD actions for Categories model.
 */
class CategoriesController extends Controller
{
    public function behaviors()
    {
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
     * Lists all Categories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriesSearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(isset($_POST['hasEditable']))
        {
            $categoryId= $_POST['editableKey'];
            $category = Categories::findOne($categoryId);

            $out = Json::encode(['output'=>'','message'=>'']);
            $post = [];
            $posted = current($_POST['Categories']);
            $post['Categories'] = $posted;
            if($category->load($post))
            {
                $category->save();
                $output = $category->category_name;
                $out = Json::encode(['output'=>$output,'message'=>'']);
            }
            echo $out;
            return;
        }


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        
        //return $this->render('index', ['categories'=>$categories = Categories::find()->all(),]);
    }
 

    /**
     * Displays a single Categories model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Categories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Categories();
        $subcategories = [new Categories()];

        if ($model->load(Yii::$app->request->post()) ) {
            $model->category_id=GlobalFunctions::generateUniqueId();
            //$model->parent_id=$id;
                $model->parent_id=NULL;
                $model->company_id= Yii::$app->company->getCompanyID();
             //$subcategories = Model::createMultiple(Categories::classname());
               $models = [];
                for($i = 0; $i<sizeof(Yii::$app->request->post()['Categories']);$i++ ){
                    if(isset(Yii::$app->request->post()['Categories'][$i]))
                    $models[$i] = new Categories();
                }
                $subcategories =$models;

             //var_dump($subcategories);die;
            Model::loadMultiple($subcategories, Yii::$app->request->post());

               
            $valid = $model->validate();


            $valid = Model::validateMultiple($subcategories) && $valid;

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($subcategories as $subcategory) {
                            $subcategory->category_id=GlobalFunctions::generateUniqueId();
                            $subcategory->parent_id = $model->category_id;
                            $subcategory->company_id= Yii::$app->company->getCompanyID();
                            if (! ($flag = $subcategory->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        
                          return $this->redirect(['view', 'id' => $model->category_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }else {
            return $this->render('create', [
                'model' => $model,
                'subcategories' => (empty($subcategories)) ? [new Categories] : $subcategories
            ]);
        }
        

           
        } else {
            return $this->render('create', [
                'model' => $model,
                 'subcategories' => (empty($subcategories)) ? [new Categories] : $subcategories
            ]);
        }
    }

    public function actionAddsubcategory($id)
    {
        $model = new Categories();
          if ($model->load(Yii::$app->request->post()) ) {
            $model->parent_id=$id;
            $model->category_id=GlobalFunctions::generateUniqueId();
            $model->company_id= Yii::$app->company->getCompanyID();
            if($model->save())
            {
               return $this->redirect(['index']);
            }
            else{
                var_dump($subcategories);die;
                return $this->renderAjax('addSubcategory', ['model'=>$model]);
            }
          }else{
                return $this->renderAjax('addSubcategory', ['model'=>$model]);
          }
    }

    /**
     * Updates an existing Categories model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
   /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $subcategories = $model->categories;


        if ($model->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($subcategories, 'category_id', 'category_id');
            $multipleModels = $subcategories;
            $keys = array_keys(ArrayHelper::map($multipleModels, 'category_id', 'category_id'));
            $multipleModels = array_combine($keys, $multipleModels);
            $models = [];
                for($i = 0; $i<sizeof(Yii::$app->request->post()['Categories']);$i++ ){
                    if(isset(Yii::$app->request->post()['Categories'][$i])&& !empty(Yii::$app->request->post()['Categories'][$i]['category_id']) && isset($multipleModels[Yii::$app->request->post()['Categories'][$i]['category_id']]))
                    {
                        $models[$i] = $multipleModels[Yii::$app->request->post()['Categories'][$i]['category_id']];
                    }
                    else{
                        $models[$i] = new Categories();
                    }
                }
                $subcategories =$models;
           //  $subcategories=   Model::createMultiple(Categories::classname(), $subcategories);
            Model::loadMultiple($subcategories, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($subcategories, 'category_id', 'category_id')));
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($subcategories) && $valid;
            
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            Categories::deleteAll(['category_id' => $deletedIDs]);
                        }
                        foreach ($subcategories as $subcategory) {
                            if(empty($subcategory->category_id))
                            {
                                $subcategory->category_id= GlobalFunctions::generateUniqueId();
                            }
                            $subcategory->parent_id = $model->category_id;
                            if (! ($flag = $subcategory->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->category_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
               }
            }else {
            return $this->render('update', [
                'model' => $model,
                'subcategories' => (empty($subcategories)) ? [new Categories] : $subcategories
            ]);
        }
        

           
        } else {
            return $this->render('update', [
                'model' => $model,
                 'subcategories' => (empty($subcategories)) ? [new Categories] : $subcategories
            ]);
        }
    }*/

    /**
     * Deletes an existing Categories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        var_dump(1);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    
    //public $enableCsrfValidation = false;
   

    public function actionList($id)
    {
        $countSubCat = Categories::find()->where(['parent_id'=>$id])->count();

        $subcategories = Categories::find()->where(['parent_id'=>$id])->all();

        

        if($countSubCat>0)
        {
            foreach ($subcategories as $subcategory) {
                echo "<option value='".$subcategory->category_id."'>".$subcategory->category_name."</option>";
            }
        }
        else{
            echo "<option>-</option>";
        }
    }

    /**
     * Finds the Categories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Categories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Categories::find()->where(['company_id'=>Yii::$app->company->getCompanyID(),'category_id'=>$id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    

}

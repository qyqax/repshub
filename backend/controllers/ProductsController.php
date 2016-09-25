<?php

namespace backend\controllers;

use Yii;
use backend\models\Products;
use backend\models\Categories;
use backend\models\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\web\UploadedFile;
use backend\models\ProductSubcategory;
use backend\models\Model;
use yii\helpers\ArrayHelper;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
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
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();
        //$subcategories=[new ProductSubcategory];

        if ($model->load(Yii::$app->request->post())) {


           $file = UploadedFile::getInstance($model, 'product_new_image');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
                $model->product_image = $file->name;
                //$model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }
          
              if($model->expiry_date== NULL)
            {
               $model->expiry_date= 0 ;
            }



           // $subcategories = Model::createMultiple(ProductSubcategory::classname());
               
           // Model::loadMultiple($subcategories, Yii::$app->request->post());
            $model->company_id = Yii::$app->company->getCompanyID();
            $model->product_id=GlobalFunctions::generateUniqueId();
            $model->created_at=date('Y-m-d H:i:s');


                $valid = $model->validate();


               // $valid = Model::validateMultiple($subcategories) && $valid;

            if ($valid) 
                    {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            if ($flag = $model->save(false)) {
                                foreach ($model->subcategories as $cat_id) {
                                   $subcategory = new ProductSubcategory();
                                   $subcategory->category_id=$cat_id;
                                $subcategory->product_id = $model->product_id;
                                    if (! ($flag = $subcategory->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                }
                            }
                            if ($flag) {
                                    $transaction->commit();
                                    
                                return $this->redirect(['view', 'id' => $model->product_id]);                                
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                        }
                    }      

/*            if($model->save())
            {

                return $this->redirect(['view', 'id' => $model->product_id]);
            }*/
            else
            {
                return $this->render('create', [
                'model' => $model,
                //'subcategories' =>$subcategories,
            ]);
            }
            

        } else {
            return $this->render('create', [
                'model' => $model,
               // 'subcategories' =>$subcategories,
            ]);
        }
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->subcategories = $model->categories;
       // var_dump($model->subcategories );die;
        

        if ($model->load(Yii::$app->request->post()) ) {

            
            if($model->expiry_date== NULL)
            {
               $model->expiry_date= 0 ;
            }
            $model->updated_at=date('Y-m-d H:i:s');
            
            $file = UploadedFile::getInstance($model, 'product_new_image');
            if(is_object($file))
            {
              $images_path = $_SERVER['DOCUMENT_ROOT'].'/repshub/common/images';
              $model->product_image = $file->name;
              
              $file->saveAs($images_path.'/'.$file->name);
            }
            if (is_array($model->subcategories) && count($model->subcategories) > 0) {
                // Unlink all categories first
                $model->unlinkAll('categories', true);

                // Link categories
                foreach ($model->subcategories as $category) {
                    $category = Categories::findOne($category);
                    $model->link('categories', $category);
                }
            }

            $model->save();
           // $model->link('categories',$model->subcategories);

            return $this->redirect(['view', 'id' => $model->product_id]);   
        }else{

        return $this->render('update', [
            'model' => $model,
            'subcategories' => (empty($subcategories)) ? [new ProductSubcategory] : $subcategories
        ]);}
    }

    /**
     * Deletes an existing Products model.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\Purchases;

use backend\models\Products;
use backend\models\Clients;
use backend\models\PurchaseProduct;
use backend\models\PurchaseStatuses;
use backend\models\PurchasesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use common\models\Users;
use backend\models\Model;
use backend\models\Model2;
use yii\helpers\ArrayHelper;
use yii\db\Query;
use yii\helpers\Html;
use backend\models\Reports;
use kartik\mpdf\Pdf;
use common\models\StatsFunctions;
use backend\models\PurchaseExport;
use backend\models\PurchaseExportCSV;
use common\models\Company;


/*
*
 * PurchasesController implements the CRUD actions for Purchases model.
 */
class PurchasesController extends Controller
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
     * Lists all Purchases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PurchasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

           

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Purchases model.
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
     * Creates a new Purchases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $cid = Yii::$app->company->getCompanyID();  
        $company_products = Company::findOne($cid)->products;
     

        if(empty($company_products)){
            return $this->render('productsnotfound');
        }

        $model = new Purchases();
        $products = [new PurchaseProduct()];
       // $client = new Clients();
       // $client = 'kurde';
        $level_before_create = GlobalFunctions::getLevel();
        if ($model->load(Yii::$app->request->post())  ) {
          
            $model->purchase_id=GlobalFunctions::generateUniqueId();
            
            $model->user_id=Yii::$app->user->identity->id;
            $model->created_at=date('Y-m-d H:i:s');
            $model->sum =0;
         
            $products = Model::createMultiple(PurchaseProduct::classname());
             
            Model::loadMultiple($products, Yii::$app->request->post());

               
            $valid = $model->validate();


            $valid = Model::validateMultiple($products) && $valid;

            if ($valid) 
                    {
                        $transaction = \Yii::$app->db->beginTransaction();
                        try {
                            /*
                            * if client added in form
                            */

                                    if(empty($model->client_id))
                                    { 
                                      
                                        $client = new Clients();
                                        $model->client_id=GlobalFunctions::generateUniqueId();
                                       
                                       /*data from form*/ 
                                        $client->client_email = $model->client_email;
                                        $client->client_name = $model->client_name;
                                        $client->client_phone =$model->client_phone;
                                        $client->client_country = $model->client_country; 
                                        $client->client_city =$model->client_city;
                                        $client->client_address=$model->client_address;
                                        $client->client_postal_code=$model->client_postal_code;
                                        $client->NIF=$model->NIF;
                                        $client->card_id_number=$model->card_id_number;
                                        $client->is_client_lead=0;

                                        $client->id =$model->client_id;
                                        $client->user_id = Yii::$app->user->identity->id;
                                        $client->company_id = Yii::$app->company->getCompanyID();  
                                        $client->client_create_time = date('Y-m-d H:i:s');
                                        $client->status = Clients::STATUS_ACTIVE;     
                                            if (! ($flag=$client->save(false))) {

                                        $transaction->rollBack();
                                        break;
                                    
                                    }
                                                 
                                    }else{
                                        $client= Clients::find()->where(['id'=>$model->client_id])->one();
                                        $client->is_client_lead=0;
                                        $client->save();
                                    }
                                    
                                    
                                   
                            if ($flag = $model->save(false)) {
                                

                                foreach ($products as $product) {
                                  
                                   $product->purchase_id = $model->purchase_id;
                                   //$product->id = GlobalFunctions::generateUniqueId();
                                   
                                   $item= Products::findOne($product->product_id);
                                  
                                   $price=$item->product_price;
                                   $quantity=$product->quantity;
                                   $base_price=$quantity * $price;                                  
                                   
                                    /*
                                    if(empty($product->discount) || $product->discount <= 0 )
                                    {
                                        $product->discount = 0;
                                        $product->discount_type = '%';
                                        $product->total_amount = $base_price;
                                    }
                                    else
                                    {
                                        if($product->discount_type !== '%')
                                        {
                                           $product->total_amount = $base_price - $product->discount;
                                        }
                                        else
                                        {                                                                                      
                                            $product->total_amount = $base_price - ($base_price * ($product->discount /100) );                                           
                                        }
                                    }*/

                                    if(!empty($product->discount) )
                                    {

                                       if($product->discount_type !== '%')
                                        {
                                         
                                            $product->total_amount= $base_price  - ($base_price * ($product->discount /100));
                                        }
                                        else
                                        {                                                                                      
                                            $product->total_amount= $base_price - $product->discount;                                           
                                        }
                                    }
                                    else
                                    {
                                        $model->discount = 0;
                                        $model->discount_type = "%";
                                        $product->total_amount= $base_price;
                                    }

                                
                                    if($product->total_amount<0)
                                    {
                                        $product->total_amount=0;
                                    }                            
                                   
                                
                                   
                                   $model->sum = $model->sum + $product->total_amount;
                                
                                   
                                    if (! ($flag = $product->save(false))) {
                                        $transaction->rollBack();
                                        break;
                                    }
                                
                                }
                            }                            
                            if ($flag) {
                                    
                                    $transaction->commit();
                                    
                                    $discount= $model->discount;
                                    $sum = $model->sum;

                                    if(!empty($model->discount) )
                                    {
                                       if($product->discount_type !== '%')
                                        {
                                         
                                            $model->sum= $sum  - ($sum * ($discount /100));
                                        }
                                        else
                                        {                                                                                      
                                            $model->sum= $sum - $model->discount;                                           
                                        }
                                    }
                                    else
                                    {
                                        $model->discount = 0;
                                        $model->discount_type = "%";
                                    }

                                    if($model->sum<0){
                                        $model->sum=0;
                                    }
                                   

                                   
                                    $status = new PurchaseStatuses();
                                    $status->purchase_id=$model->purchase_id;
                                    $status->status_id = GlobalFunctions::generateUniqueId();
                                    $status->status= 'purchase';
                                    $status->status_date = date('Y-m-d H:i:s');
                                    $status->save();                                 
                                   
                                    $model->save();
                                   
                                    
                                return $this->redirect(['view', 'id' => $model->purchase_id]);                                
                            }
                        } catch (Exception $e) {
                            $transaction->rollBack();
                        }
                      
       }else {
            return $this->render('create', [
                'model' => $model,
                'products' => $products,
               // 'client' => $client,
            ]);
        }
        } else {
            return $this->render('create', [
                'model' => $model,
                'products' => $products,
               // 'client' => $client,
            ]);
        }
    }

    /**
     * Updates an existing Purchases model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $products = [];
        $originals =ArrayHelper::map($model->myproducts, 'product_id', 'product_id');
        $level_before_update = GlobalFunctions::getLevel();
        
        if(Yii::$app->request->isGet){
            
        foreach($model->myproducts as $item)
        {
            $item = PurchaseProduct::find()->where(['product_id'=>$item->product_id])
            ->andWhere(['purchase_id'=>$model->purchase_id])->one();
           
            $item->id=GlobalFunctions::generateUniqueId();
            array_push($products , $item);

        

        }


        }

        if ($model->load(Yii::$app->request->post())) {


            
            $model->sum=0;
            $model->updated_at=date('Y-m-d H:i:s');
            $model->save();

            $products = Model2::createMultiple(PurchaseProduct::classname(), $products,1);
           
            $products=[];
            foreach($_POST["PurchaseProduct"] as $i)
        {
            
            
            $item = PurchaseProduct::find()->where(['product_id'=>$i["product_id"]])
            ->andWhere(['purchase_id'=>$model->purchase_id])->one();
            if($item==NULL){
                $item = new PurchaseProduct();
                $item->product_id=$i['product_id'];

            }
            $item->quantity=(float)$i['quantity'];
            $item->product_id=$i['product_id'];
        $item->id=$i['id'];
        $item->discount=$i['discount'];
         $item->discount_type=$i['discount_type'];
          $item->send_alert=$i['send_alert'];
       
            array_push($products , $item);
        

        }
      
            $valid = $model->validate();

            $valid = Model::validateMultiple($products) && $valid;

            if ($valid) {
               
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                       //remove item
                        if(count($originals)!=count($products)){
                         $deletedIDs = array_diff($originals, array_filter(ArrayHelper::map($products, 'product_id', 'product_id')));
                        foreach ($deletedIDs as $delete) {
                            $remove= PurchaseProduct::find()->where(['purchase_id' => $model->purchase_id,'product_id'=>$delete])->one();
                            $remove->delete();
                        }
                        }
                       

                        foreach ($products as $product) {
                        
                            $product->purchase_id = $model->purchase_id;
                                   
                                   
                                   $item= Products::findOne($product->product_id);
                                  
                                   $price=$item->product_price;
                                   $q=$product->quantity;
                                   $base_price=$q * $price;   


                                   
                                    if(!empty($product->discount) )
                                    {

                                       if($product->discount_type !== '%')
                                        {
                                            $product->total_amount= $base_price - $product->discount;
                                            

                                        }
                                        else
                                        {                                                                                      
                                             $product->total_amount= $base_price  - ($base_price * ($product->discount /100));                                          
                                        }
                                    }
                                    else
                                    {
                                        $product->discount = 0;
                                        $product->discount_type = "%";
                                        $product->total_amount= $base_price;
                                    }

                                
                                    if($product->total_amount<0)
                                    {
                                        $product->total_amount=0;
                                    }                                   
                                   $model->sum = $model->sum + $product->total_amount;
                       
                            if (! ($flag = $product->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                    }
                    if ($flag) {
                        $transaction->commit();
                         $discount= $model->discount;
                                    $sum = $model->sum;

                                    if(!empty($model->discount) )
                                    {

                                       if($model->discount_type !== '%')
                                        {
                                         
                                             $model->sum= $sum - $model->discount;
                                        }
                                        else
                                        {   
                                             $model->sum= $sum  - ($sum * ($discount /100));                                                                              
                                                                                      
                                        }
                                    }
                                    else
                                    {
                                        $model->discount = 0;
                                        $model->discount_type = "%";
                                       
                                    }

                                    if($model->sum<0){
                                        $model->sum=0;
                                    }
                                    
                                    
                                                                       
                                    $status = new PurchaseStatuses();
                                    $status->purchase_id=$model->purchase_id;
                                    $status->status_id = GlobalFunctions::generateUniqueId();
                                    $status->status= 'purchase';
                                    $status->status_date = date('Y-m-d H:i:s');
                                    $status->save();  

                                    $model->save();
                                  
                                    
                                    
                                     
                                       $level = GlobalFunctions::getLevel();
                                        if($level_before_update->commision_percent>$level->commision_percent)
                                        {
                                            Yii::$app->getSession()->setFlash('danger', [
                                                'type' => 'danger',
                                                'duration' => 12000,
                                                'icon' => 'fa fa-level-down',
                                                'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                                                'title' => Yii::t('app', Html::encode('Unfortunately your level has changed.')),
                                                'positonY' => 'top',
                                                'positonX' => 'right'
                                            ]);
                                         }
                                    


                        return $this->redirect(['view', 'id' => $model->purchase_id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }else{return $this->render('update', [
                'model' => $model,
                'products' => $products,
            ]);}
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'products' => $products,
            ]);
        }
    }

    /**
     * Deletes an existing Purchases model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $level_before_delete = GlobalFunctions::getLevel();
        $this->findModel($id)->delete();
        $level = GlobalFunctions::getLevel();
        if($level_before_delete->commision_percent>$level->commision_percent)
        {
            Yii::$app->getSession()->setFlash('danger', [
                'type' => 'danger',
                'duration' => 12000,
                'icon' => 'fa fa-level-down',
                'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                'title' => Yii::t('app', Html::encode('Unfortunately your level has changed.')),
                'positonY' => 'top',
                'positonX' => 'right'
            ]);
           
         }

        return $this->redirect(['index']);
    }

    public function actionProductlist($q = null, $id = null ,$arr = '1') {

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['items' => ['id' => '', 'text'=>'', 'product_name' => '' , 'product_code'=>'','product_price'=>'','product_image'=>'']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('product_id as id,product_name as text, product_name , product_code , product_price ,product_image')
            ->from('products')
            ->where('company_id = "'.Yii::$app->company->getCompanyID().'"')
            ->andwhere('product_name LIKE "%' . $q .'%"')
            ->orwhere('product_id LIKE "%' . $q .'%"')
            ->orwhere('product_code LIKE "%' . $q .'%"')
            ->andWhere("product_id not in ('".$arr."') ")
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['items'] = array_values($data);
    }
   
    return $out;
}

public function actionClientlist($q = null, $id = null ) {

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $out = ['items' => ['id' => '', 'text'=>'', 'client_email'=>'','client_address'=>'','client_photo'=>'','client_phone'=>'','client_city'=>'']];
    if (!is_null($q)) {
        $query = new Query;
        $query->select('id as id,client_name as text, client_email , client_address ,client_photo,client_phone,client_city')
            ->from('clients')
            ->where('company_id = "'.Yii::$app->company->getCompanyID().'"')
            ->andWhere('status = "'.Clients::STATUS_ACTIVE.'"')
            ->andwhere('client_name LIKE "%' . $q .'%" or 
            client_phone LIKE "%' . $q .'%" or
            client_email LIKE "%' . $q .'%" or
            NIF LIKE "%' . $q .'%"')
            ->limit(20);
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out['items'] = array_values($data);
    }
   
    return $out;
}

    public function actionStatus($purchase_id)
    {

        $model = new PurchaseStatuses();
        $level_before_action = GlobalFunctions::getLevel();
        
        if ($model->load(Yii::$app->request->post())) {

            $model->purchase_id=$purchase_id;
            $model->status_date = date('Y-m-d H:i:s');
            $model->status_id = GlobalFunctions::generateUniqueId();

            $purchase =$this->findModel($purchase_id);
            $purchase_old_status = $purchase->purchaseStatuses->status;
           

            $model->save();
            $level = GlobalFunctions::getLevel();
            if($model->status == 'delivery'){
                //check goals/levels

                
                $purchase->trigger(Purchases::EVENT_NEW_PURCHASE);
                if($level_before_action->level_id!= $level->level_id)
                {
                   
                     Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 12000,
                        'icon' => 'fa fa-level-up',
                        'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                        'title' => Yii::t('app', Html::encode('Congratulation. You leveled up!')),
                        'positonY' => 'top',
                        'positonX' => 'right'
                    ]);
                }

            }else{

                    
                //check if previous status was delivery
                if($purchase_old_status == 'delivery'){
                    
                    
                    if($level_before_action->commision_percent>$level->commision_percent){
                        Yii::$app->getSession()->setFlash('danger', [
                            'type' => 'danger',
                            'duration' => 12000,
                            'icon' => 'fa fa-level-down',
                            'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                            'title' => Yii::t('app', Html::encode('Unfortunately your level has changed.')),
                            'positonY' => 'top',
                            'positonX' => 'right'
                        ]);
                       
                     }
                }

                
            }


            

            return $this->redirect(['view', 'id' => $purchase_id]);

        }
        else{
        
        $purchase = $this->findModel($purchase_id);

        if(empty($purchase))
        {
            return $this->redirect(['index']);
        }else{
             
            return $this->renderAjax('status', [
                'model' => $model,
            ]);
        } 
        }

       
    }
     public function actionExportcsv(){
         $user_id = Yii::$app->user->identity->id;
        //$purchases = Purchases::find(['user_id'=>$user_id])->all();
        $account = Yii::$app->user->identity->accounts;

        $model = new PurchaseExportCSV();

          if ($model->load(Yii::$app->request->post())){




        $separator= strrpos($model->date_range, "to");
        $start= substr($model->date_range, 0, $separator);
        $end = substr($model->date_range,$separator+3);

        $statuses = [];

            
        if($model->is_contact){
                array_push($statuses, 'contact');
            } 
        if($model->is_delivery){
                array_push($statuses, 'delivery'); 
            }
        if($model->is_purchase ){
                array_push($statuses, 'purchase');
            }



        $purchases = StatsFunctions::purchasesDayRange($start,$end,$statuses);
        
        $selected_columns = explode( ',', $model->columns );
        $number_of_selected_columns = count($selected_columns);

        $filename = $model->file_name.".csv";

       

        $output = fopen('php://output', 'w');

       
        fputcsv($output, $selected_columns,$model->delimiter);
     
        $put = [];
        foreach ($purchases as $key => $value) {
            $purchase= Purchases::findOne(['purchase_id'=>$value["purchase_id"]]); 

            $row=[];
         for ($i=0; $i < $number_of_selected_columns; $i++) {

            
                        switch ($selected_columns[$i]) {
                          case 'client_name':
                            array_push($row,$purchase->client->client_name);
                            break;
                          case 'client_email':
                           array_push($row,$purchase->client->client_email);
                            break;
                          case 'total_amount':
                           array_push($row,$purchase->sum);
                            break;
                          case 'discount':
                            array_push($row,$purchase->discount);
                            break;
                          case 'status':
                            array_push($row,$purchase->purchaseStatuses->status);
                            break;
                          default:                            
                            break;
                        }
                      }

                    
                    fputcsv($output, $row,$model->delimiter);
                    unset($row);

                  }
                   fclose($output);
        

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');
        
           
          }else{
             return $this->renderAjax('exportpreferencescsv', [
                'model' => $model,
            ]);
         }


     }

    public function actionExportpdf(){
        $user_id = Yii::$app->user->identity->id;
        //$purchases = Purchases::find(['user_id'=>$user_id])->all();
        $account = Yii::$app->user->identity->accounts;

        $model = new PurchaseExport();

          if ($model->load(Yii::$app->request->post())){
            $separator= strrpos($model->date_range, "to");
            $start= substr($model->date_range, 0, $separator);
            $end = substr($model->date_range,$separator+3);

            $statuses = [];

            
            if($model->is_contact){
                array_push($statuses, 'contact');
            } 
            if($model->is_delivery){
                array_push($statuses, 'delivery'); 
            }
            if($model->is_purchase ){
                array_push($statuses, 'purchase');
            }



            $purchases = StatsFunctions::purchasesDayRange($start,$end,$statuses);

            $model->title = $account->account_name.". Purchases realized.";

            $pdf = new Pdf([
                'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

                'content' =>  $this->renderPartial('exportpdf',['purchases'=>$purchases,'account'=>$account,'model'=>$model]),
                
                'options' => [
                    'title' => $model->title,
                    'subject' => $model->title
                ],
                'methods' => [
                    'SetHeader' => ['Generated On: ' . date('r')],
                    'SetFooter' => ['|Page {PAGENO}|'],
                ]
            ]);

            return $pdf->render();


          }else{
             return $this->renderAjax('exportpreferences', [
                'model' => $model,
            ]);
         }


    }

        
     

   
    /**
     * Finds the Purchases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Purchases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchases::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}

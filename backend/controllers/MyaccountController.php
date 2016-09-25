<?php

namespace backend\controllers;

use common\models\Account;
use common\models\Users;
use common\models\StatsFunctions;
use backend\models\Reports;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\mpdf\Pdf;
use backend\models\PurchasesSearch;

class MyaccountController extends \yii\web\Controller
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

    public function actionIndex()
    {
    	$user_id = Yii::$app->user->id;
        $model= $this->findModel($user_id)->accounts;    
          

        $total_amount =  StatsFunctions::currentMonthRevenue();

        return $this->render('index',['model'=>$model,'total_amount'=>$total_amount]);
    }
    public function actionStats()
    {
        $user_id = Yii::$app->user->id;
        $model= $this->findModel($user_id)->accounts;

        $searchModel = new PurchasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
       // $command = Yii::$app->db->createCommand("SELECT sum(sum) FROM purchases where user_id='".$user_id."'");
        /* $command = Yii::$app->db->createCommand("SELECT sum(sum) FROM purchases p join purchase_statuses ps 
            on p.purchase_id = ps.purchase_id where user_id='".$user_id."'");

        $total_amount = $command->queryScalar();
    */
       
        return $this->render("stats", [
            /*'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,*/
            'model'=>$model,
        ]);
    
    }

    public function actionReport() {

        $model = new Reports();

     ///   if ($model->load(Yii::$app->request->post())) {

        $graphs = [];
        $account = Yii::$app->user->identity->accounts;
        
        $graphs['clients'] = Yii::$app->session->get('clients');
        $graphs['products'] = Yii::$app->session->get('bestsellers');
        $graphs['daily'] = Yii::$app->session->get('salesPerDay');

       

    $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

        'content' =>  $this->renderPartial('report',['graphs'=>$graphs,'account'=>$account]),
        
        'options' => [
            'title' => 'Report',
            'subject' => 'Monthly Report'
        ],
        'methods' => [
            'SetHeader' => ['Generated On: ' . date('r')],
            'SetFooter' => ['|Page {PAGENO}|'],
        ]
    ]);

    return $pdf->render();
/*
}else{
    return $this->renderAjax('preferences', [
                'model' => $model,
            ]);
}*/

}

public function actionCustomreport() {

        $model = new Reports();

        if ($model->load(Yii::$app->request->post())) {
       

      
        $graphs = [];
        $account = Yii::$app->user->identity->accounts;
        
        $graphs['clients'] = Yii::$app->session->get('clients');
        $graphs['products'] = Yii::$app->session->get('bestsellers');
        $graphs['daily'] = Yii::$app->session->get('salesPerDay');
        $graphs['salesPerDayCompare']= Yii::$app->session->get('salesPerDayCompare');
        $graphs['bestsellerscompare']= Yii::$app->session->get('bestsellerscompare');
        $graphs['clientscompare']= Yii::$app->session->get('clientscompare');

        

        if(isset($_POST['range_label'])&&$_POST['range_label']!='Custom range'){
            $range = $_POST['range_label'];
        }else{
            $range = " From ".$model->date_range;
        }

        if(isset($_POST['compare_range'])){
            $compare_range = $_POST['compare_range'];
        }
        

       $content = "<div id='header'><h1 style='text-align: center;padding:1em'>".$model->title."</h1>
       <h2 style='text-align: center;padding:0.5em'>Time frames: ".$range." </h2>        
        <div id='account'>
          <h2>".$account->account_name."</h2>
            <p><b>Current month trade: ". StatsFunctions::currentMonthRevenue()." ".Yii::$app->company->company->company_currency." </b> </p>
            <p><b>Items sold: ". StatsFunctions::numberOfProducts()." units </b> </p>
        </div>
    </div>";

    foreach ($model->items as $key => $value) {
       switch ($value) {
           case 'salesPerDay': 

           $content = $content." <div id='salesPerDay' style='padding:1em'>
        <h3>".++$key.".Monthly takings</h3>
       <img src='". $graphs['daily']."'> </img>";
       if($model->add_comparision){
            if(empty($graphs['salesPerDayCompare'])){
                $content = $content."<p>There is no data to compare to.</p>";
            }else{
                $content = $content."<p>Comparision (".$compare_range.") :</p><img src='". $graphs['salesPerDayCompare']."'> </img>";
            }       
       }
        
         $content = $content."</div>";
        break;
        case 'clients': 
         $content = $content."<div id='clients' style='padding:1em'>
        <h3>".++$key.".Clients</h3>
        <img src='". $graphs['clients']."'> </img> ";
        if($model->add_comparision){
            if(empty($graphs['clientscompare'])){
                $content = $content."<p>There is no data to compare to.</p>";
            }else{
                $content = $content."<p>Comparision (".$compare_range.") :</p><img src='". $graphs['clientscompare']."'> </img>";
            }
        }
        $content = $content."</div>";
        break;
        case 'bestsellers': 
           $content = $content."<div id='bestsellers' style='padding:1em'>
        <h3>".++$key.".Products</h3>
        <img src='". $graphs['products']."' > </img> ";
        if($model->add_comparision){
            if(empty($graphs['bestsellerscompare'])){
                 $content = $content."<p>There is no data to compare to</p>";
            }else{
                $content = $content."<p>Comparision (".$compare_range.") :</p><img src='".$graphs['bestsellerscompare']."'> </img>";
            }
        }
        $content = $content."</div>";
        break;
        default: break;
       }
    }

//$content = $content." <div id= 'png'></div>";


    $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

        'content' => $content/* $this->renderPartial('report',['graphs'=>$graphs,'account'=>$account])*/,
       // 'destination'=>Pdf::DEST_DOWNLOAD,
        'options' => [
            'title' => $model->title,
            'subject' => 'Monthly Report'
        ],
        'methods' => [
            'SetHeader' => ['Generated On: ' . date('r')],
            'SetFooter' => ['|Page {PAGENO}|'],
        ]
    ]);

      
   $pdf->render();

   return;



}else{
    return $this->renderAjax('preferences', [
                'model' => $model,
            ]);
}

}


public function actionGraph(){

    $data = Yii::$app->request->post();

    foreach ($data as $key => $value) {
        Yii::$app->session[$key] = $value;
      //  echo Yii::$app->session->get($key);
    }



   // $content = '<img src ='.Yii::$app->request->post('clients').'>  </img>';   
}

public function actionMonthlyrevenuedata($start,$end)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

       $data = StatsFunctions::salesPerDayRange($start,$end);
       $items = ['data' => $data];
return $items;




}

public function actionClientsdata($start,$end)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

       $data = StatsFunctions::clientsInfoRange($start,$end);
       $items = ['data' => $data];
return $items;




}


public function actionBestsellersdata($start,$end)
{
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

       $data = StatsFunctions::bestsellersRange($start,$end);
       $items = ['data' => $data];
return $items;




}
public function actionExportproducts(){

   

    $account = Yii::$app->user->identity->accounts;
    $products = StatsFunctions::productsSold();


    $pdf = new Pdf([
        'mode' => Pdf::MODE_UTF8, // leaner size using standard fonts

        'content' =>  $this->renderPartial('products',['products'=>$products,'account'=>$account]),
        
        'options' => [
            'title' => 'Report',
            'subject' => 'Monthly Report'
        ],
        'methods' => [
            'SetHeader' => ['Generated On: ' . date('r')],
            'SetFooter' => ['|Page {PAGENO}|'],
        ]
    ]);

    return $pdf->render();

}

    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}

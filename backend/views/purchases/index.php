<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use kartik\growl\Growl;
use common\models\StatsFunctions;
use backend\models\PurchaseStatuses;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use backend\models\Products;

use yii\helpers\Url;
use yii\bootstrap\Modal;


$this->title = Yii::t('app', 'Purchases');
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    
    .btn-group{
        float: right;
    }
</style>
<div class="purchases-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Purchases'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php   echo

 Html::button(Yii::t('app', '<i class="fa glyphicon glyphicon-export"></i> Export PDF'), [ 'value'=>Url::to(['/purchases/exportpdf']) , 'class' => 'ExportPdfModalButton btn btn-primary']) 
    ?>
    <?php   echo

 Html::button(Yii::t('app', '<i class="fa glyphicon glyphicon-export"></i> Export CSV'), [ 'value'=>Url::to(['/purchases/exportcsv']) , 'class' => 'ExportCSVModalButton btn btn-primary']) 
    ?>
  


          <?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Change State Of Purchase</h2>',
            'id' => 'createModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='createModalContent'></div>";

    Modal::end();

    ?>
<?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Export Purchases</h2>',
            'id' => 'exportPdfModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='exportPdfModalContent'></div>";

    Modal::end();

    ?>
    <?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Export Purchases</h2>',
            'id' => 'exportCSVModal',
            'size' => 'modal-lg',
        ]);


echo "<div id='exportCSVModalContent'></div>";

    Modal::end();

    ?>


   

<?php  Pjax::begin(['id'=>'pjax']);?>
    <?php 



$viewMsg="View";
$updateMsg="Update";
$deleteMsg="Delete";
$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        'width'=>'50px',
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail'=>function ($model, $key, $index, $column) {
            $products = $model->myproducts;
            $purchase = $model->purchase_id;
           // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return Yii::$app->controller->renderPartial('_expand-row-details' ,['products'=>$products,'purchase'=>$purchase]);
        },
        'headerOptions'=>['class'=>'kartik-sheet-style'], 
        'expandOneOnly'=>true,
        'detailRowCssClass'=> '',
        'hiddenFromExport' => false,
    ],
    [
        'label' => Yii::t('app', 'Client Name'),
        'attribute' => 'client_name',
        'format' => 'html',
        'value' => function($data) {
        $client = $data->client;
        return Html::a($client->client_name, ['clients/view', 'id' => $client->id]);
        },
        'filter' => Html::activeTextInput($searchModel, 'client_name', ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Client Name')]),
    ],
    [
        'label' => Yii::t('app', 'Client Email'),
        'attribute' => 'client_email',
        'format' => 'html',
        'value' => function($data) {
        $client = $data->client;
        return Html::a($client->client_email, ['clients/view', 'id' => $client->id]);
        },
        'filter' => Html::activeTextInput($searchModel, 'client_email', ['class' => 'form-control', 'placeholder' => Yii::t('app', 'Client Email')]),
    ],
                  
       
      [
      'label' => 'Total amount',
        'attribute' => 'sum',
        'value' =>  function ($model){

            return $model->sum." ".Yii::$app->company->company->company_currency;
        },
        
       ],
       [
                
        'label' => 'Purchase Status',
        'value' =>function ($model, $key, $index, $column) { 
            return $model->purchaseStatuses->status;  
        }
        ,

       'filter' => Select2::widget([
        'model' => $searchModel,
            //'name'=>'status',
        'attribute'=>'status',
        'data' => ["contact"=>"Contact","purchase"=>'Purchase','delivery'=>'Delivery'],
        'options' => ['placeholder' => 'Purchase Status...'],

        'pluginOptions' => [
            'allowClear' => true,

        ],

         ]),
        'contentOptions' =>['style' => 'width:30%'],
        ],
     
        
         [
            'class' => 'kartik\grid\ActionColumn',
            
            'vAlign'=>'middle',
            
            'viewOptions'=>['title'=>$viewMsg, 'data-toggle'=>'tooltip'],
            'updateOptions'=>['title'=>$updateMsg, 'data-toggle'=>'tooltip'],
            'deleteOptions'=>['title'=>$deleteMsg, 'data-toggle'=>'tooltip'], 
            'template'=>'{view} {update} {delete} {status}',

       
        ],
];
    
     echo  GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    //'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true,
    'columns' => $gridColumns,'rowOptions' => function($model){
                if($model->purchaseStatuses->status=='contact'){
                    
                    return ['class'=>'warning'];
                }if($model->purchaseStatuses->status=='purchase'){
                    
                    return ['class'=>'info'];
                }
                if($model->purchaseStatuses->status=='delivery'){
                    
                    return ['class'=>'success'];
                }
        },
]);

?>
 <?php  Pjax::end(); ?>
 <?php $this->registerJs(
'
function createModal(){
    $(".CreateModalButton").click(function(){
        $("#createModal").modal("show").find("#createModalContent").load($(this).attr("value"));
    });
}

createModal();

$("#pjax").on("pjax:success", function() {
  createModal();
});

function exportPdfModal(){
    $(".ExportPdfModalButton").click(function(){
        $("#exportPdfModal").modal("show").find("#exportPdfModalContent").load($(this).attr("value"));
    });
}

exportPdfModal();

$("#pjax").on("pjax:success", function() {
  exportPdfModal();
});

 function exportCSVModal(){
    $(".ExportCSVModalButton").click(function(){
        $("#exportCSVModal").modal("show").find("#exportCSVModalContent").load($(this).attr("value"));
    });
}

exportCSVModal();

$("#pjax").on("pjax:success", function() {
  exportCSVModal();
});
    
'); ?>
</div>

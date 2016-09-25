<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clients');
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    
    .btn-group{
        float: right;
    }
</style>


<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
    
     $( document ).ready(function() {
    $(".CreateModalButton").click(function(){
        $("#createModal").modal('show').find("#createModalContent").load($(this).attr('value'));
    });

    /*$("a[title='Update']").click(function(){
        
        $("#updateModal").modal('show').find("#updateModalContent").load($(this).attr('value'));
    });*/
});
</script>
<div class="clients-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->role->canCreate('clients')) { ?>
          <?= Html::a(Yii::t('app', 'Create A New Client'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>

    </p>
    <?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Choose CSV file to import</h2>',
            'id' => 'createModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='createModalContent'></div>";

    Modal::end();

    ?>

    <?php 
    echo
 Html::button(Yii::t('app', '<i class="fa glyphicon glyphicon-list-alt"></i> Import CSV'), [ 'value'=>Url::to(['/clients/import']) , 'class' => 'btn btn-success CreateModalButton']) 
    
            ?>
  
    <?php
      $columntemplate = Yii::$app->role->getModuleQuickActions('clients');
    ?>
     <?php  Pjax::begin();?>

     <?php
        $gridColumns=
        [
          ['class' => 'kartik\grid\SerialColumn'],
          
            [
                'label' => 'Photo',
                'format' => ['image',['width'=>'25','height'=>'25']],
                'value' => function ($data) {
                  return 'http://localhost/repshub/common/images/'.$data->getPhoto();
                },
            ],
            'client_name',
            'client_email:email',
            'client_phone',
             ['class' => 'kartik\grid\ActionColumn']
        ];
     ?>
     <?php
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'hiddenColumns'=>[0, 5],//hide serial and action columns
    'noExportColumns'=>[5],//don't show action column in export file
    'exportConfig' => [
        ExportMenu::FORMAT_TEXT => false,
        ExportMenu::FORMAT_HTML => false,
        ExportMenu::FORMAT_EXCEL => false,
        ExportMenu::FORMAT_EXCEL_X => false,

    ], 
    'messages'=>[
        'allowPopups'=>false,
    ],
    'dropdownOptions' => [
        'label' => 'Export All',
        'class' => 'btn btn-default'
    ],

]) .'<div style="clear:both"></div>'.
GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,'rowOptions' => function($model){
                if($model->is_client_lead==1){
                    
                    return ['class'=>'warning'];
                }else{
                  return ['class'=>'info'];
                }
        },
]); 

     ?>
 
 <?php  Pjax::end(); ?>
</div>

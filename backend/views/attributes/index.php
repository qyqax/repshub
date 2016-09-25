<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AttributesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Clients Attributes');
$this->params['breadcrumbs'][] = $this->title;
?>

<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
    
     $( document ).ready(function() {
    $("#CreateModalButton").click(function(){
        $("#createModal").modal('show').find("#createModalContent").load($(this).attr('value'));
    });

    /*$("a[title='Update']").click(function(){
        
        $("#updateModal").modal('show').find("#updateModalContent").load($(this).attr('value'));
    });*/
});
</script>

<div class="attributes-index">

    <h1 style="text-align: center"><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Create a new attribute'), [ 'value'=>Url::to('attributes/create') , 'class' => 'btn btn-success','id'=>'CreateModalButton']) ?>
    </p>

    <?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Create a new client attribute</h2>',
            'id' => 'createModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='createModalContent'></div>";

    Modal::end();

    ?>


    <?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Update attribute</h2>',
            'id' => 'updateModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='updateModalContent'></div>";

    Modal::end();

    ?>


 <?php  Pjax::begin();?>
  

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function($model){
                if($model->account_id==NULL){
                    
                    return ['class'=>'warning'];
                }else{
                  return ['class'=>'info'];
                }
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'attribute_name',
            'attribute_type',
            
            [
                'attribute' => 'account_id',
                'value'=> function($data){
                        if($data->account_id==NULL){
                            return $data->company->company_name;
                        }
                        else{
                             return $data->account->account_name;
                        }
                  
                },//'account_id' == NULL ? 'company.company_name' : 'leszcz',//'account.account_name',
                'label' => "Created by ",
                'format' => 'raw',
                'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'account_id',
                'data' => ["Company"=>"Company",Yii::$app->user->identity->accounts->account_id=>"Me"],
                'options' => ['placeholder' => 'Show only created by...'],
                'pluginOptions' => [
                    'allowClear' => true,

                ],

            ]),
                'contentOptions' =>['style' => 'width:30%'],
            ],
                   

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php  Pjax::end(); ?>

</div>

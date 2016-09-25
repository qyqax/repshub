<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;

use kartik\select2\Select2;
use backend\models\Categories;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Products');
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    .btn-group{
        float: right;
    }
   
</style>
<div class="products-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Products'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
     <?php  Pjax::begin();?>

     <?php
        $gridColumns=[
            ['class' => 'kartik\grid\SerialColumn'],
            'product_name',
            'product_code',
            
            [
                'label'=>'Product price',
                'attribute' =>'product_price',
                'value' => function($model){
                    return $model->product_price." ".Yii::$app->company->company->company_currency;
                },
            ],
            [
                //'attribute' => 'category_id',
                'value'=>'category.category_name',
                'label' => 'Main category',
                'filter' => Select2::widget([
                'model' => $searchModel,
                'attribute' => 'category_id',
                'data' => ArrayHelper::map(Categories::find()->where(['parent_id'=>NULL])->asArray()->all(), 'category_id', 'category_name'),
                'options' => ['placeholder' => 'Select a category...'],
                'pluginOptions' => [
                    'allowClear' => true,

                ],

            ]),
                'contentOptions' =>['style' => 'width:30%'],
            ],
            [
                'value' => 'subCategories',
                'label' => 'subcategories',
                'attribute' => 'categories',
            ],
            ['class' => 'kartik\grid\ActionColumn']
        ];

    ?>
 <?php
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumns,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'hiddenColumns'=>[0, 6],//hide serial and action columns
    'noExportColumns'=>[6],//don't show action column in export file
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
    'columns' => $gridColumns,
]); 

     ?>
 
 <?php  Pjax::end(); ?>
   
</div>

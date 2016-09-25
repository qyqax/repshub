<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use backend\models\SubCategoriesSearch;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .maincategory
        {
           padding:10px;
           margin:10px 10px 10px 40px;
           
           font-weight: bold;
        }

    .subcategory
        {   
            padding:10px;
            margin:10px 10px 10px 80px;
           
            font-weight: bold;
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
<?php

    Modal::begin([
            'header'=>'<h2 style="text-align:center">Create a new subcategory</h2>',
            'id' => 'createModal',
            'size' => 'modal-lg',
        ]);

echo "<div id='createModalContent'></div>";

    Modal::end();

    ?>
<div class="categories-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create new category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

   <div class="container" style='border: 0.1em solid #ddd;' >
        <?php  /*foreach ($categories as $category ) { if(!isset($category->parent_id)){ ?>
        <div class="row" style="background-color: #f5f5f5">
            <div class="col-md-2 maincategory" style=''><?= $category->category_name?> </div>
           <div class="col-md-9 pull-left" style=' padding:13px'>
                <?= Html::a(Yii::t('app', 'Add subcategory'), ['create','id'=>$category->category_id], ['class' => 'btn btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Update category'), ['update','id'=>$category->category_id], ['class' => 'btn btn-info']) ?>
                <?= Html::a(Yii::t('app', 'Delete category'), ['delete','id'=>$category->category_id], ['class' => 'btn btn-danger','data-method'=>'post']) ?>
                
            </div>
            <div style="clear:both ;border-bottom: 0.1em solid #ddd;" ></div>
        </div>
            <?php } foreach ($categories as $subcategory ) { if($category->category_id==$subcategory->parent_id){ ?>
                <div class="row" >
                    <div class="col-md-3 subcategory" style=''><?= $subcategory->category_name?> </div>
                    <div class="col-md-8 pull-left" style='padding:13px'>
                        
                        <?= Html::a(Yii::t('app', 'Update category'), ['update','id'=>$subcategory->category_id], ['class' => 'btn btn-info']) ?>
                        <?= Html::a(Yii::t('app', 'Delete category'), ['delete','id'=>$subcategory->category_id], ['class' => 'btn btn-danger','data-method'=>'post']) ?>
                    </div>
                    <div style="clear:both ;border-bottom: 0.1em solid #ddd;" ></div>
                </div>
            <?php }}?>
        <?php } */ ?>

   </div>

   <?php /* echo
 GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    //'showPageSummary'=>true,
    'pjax'=>true,
    'striped'=>true,
    'hover'=>true,
    //'panel'=>['type'=>'primary', 'heading'=>'Grid Grouping Example'],
    'columns'=>[
        ['class'=>'kartik\grid\SerialColumn'],
        [
            'attribute'=>'category_id', 
            //'width'=>'310px',
            'value'=> 'category_name',
            'label'=> 'Category',
           // 'group'=>true,  // enable grouping,
           // 'groupedRow'=>true,                    // move grouped column to a single grouped row
          //  'groupOddCssClass'=>'kv-grouped-row',  // configure odd group cell css class
           // 'groupEvenCssClass'=>'kv-grouped-row', // configure even group cell css class
        ],
        [
            'attribute'=>'category_id', 
            //'width'=>'310px',
            'value'=> 'categories.category_name',
            'label'=> 'Category',
        ],
        
       
        ['class' => 'yii\grid\ActionColumn'],
    ],
]);

     */?>


    <?php 



$gridColumns = [
    ['class' => 'kartik\grid\SerialColumn'],
    [
        'class'=>'kartik\grid\ExpandRowColumn',
        //'width'=>'50px',
        'value'=>function ($model, $key, $index, $column) {
            return GridView::ROW_COLLAPSED;
        },
        'detail'=>function ($model, $key, $index, $column) {
           $searchModel = new SubCategoriesSearch();
            $searchModel->parent_id = $model->category_id;
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return Yii::$app->controller->renderPartial('subcategories' ,['searchModel'=>$searchModel,'dataProvider'=>$dataProvider,'parent_id'=>$model->category_id]);
           /* $subcategories = $model->categories;

             return Yii::$app->controller->renderPartial('subcategories' ,['subcategories'=>$subcategories]);*/
        },
        'headerOptions'=>['class'=>'kartik-sheet-style'], 
        'expandOneOnly'=>true,

    ],
      [
            'class' => 'kartik\grid\EditableColumn',
            'header' => 'Main Category',
            'attribute'=>'category_name',
            'editableOptions' => function ($model, $key, $index) {
                    return [
                        'formOptions' => [
                            'id' => 'igl_' . $model->category_id,
                           // 'action' => \yii\helpers\Url::to(['/ingredient-group-lang'])
                        ],
                        'options' => [
                            'id' => $index . '_' . $model->category_id,
                        ]
                    ];
                },
            //'value'=>function($model)
        ],
     
        ['class' => 'yii\grid\ActionColumn','template'=>'{delete}'],
];

echo GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true,
   // 'pjax'=>true,
    'export'=>false,
]);

?>
</div>

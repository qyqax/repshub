<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\helpers\Url;
use yii\bootstrap\Modal;
?> 


 

<div>
	<?=

 Html::button(Yii::t('app', 'Add a new subcategory'), [ 'value'=>Url::to(['addsubcategory','id'=>$parent_id]) , 'class' => 'btn btn-success CreateModalButton']) 
     ?>
	<?= 
		GridView::widget([
		'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax'=>true,
        'export'=>false,
        'columns' => [
       [
        	'class' => 'kartik\grid\SerialColumn'
        ],
        [
        	'class' => 'kartik\grid\EditableColumn',
			'pageSummary' => true,
        	'header' => 'Subcategory',
        	'attribute'=>'category_name',
        	 // 'asPopover' => false,
        	 // 'options' => ['class'=>'form-control', 'placeholder'=>'Subcategory...'],
        	'editableOptions' => function ($model, $key, $index) {
                    return [
                        'formOptions' => [
                            'id' => 'igl_' . $model->category_id,
                           // 'action' => \yii\helpers\Url::to(['/ingredient-group-lang'])
                        ],
                        'options' => [
                            'id' => $index . '_' . $model->category_id,
                        ],
                        
                    ];
                },
        	//'value'=>function($model)
		],
            ['class' => 'yii\grid\ActionColumn','template'=>'{delete}'],
        ],
        

			]);
	?>
</div>
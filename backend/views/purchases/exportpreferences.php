<?php

use yii\helpers\Html;

use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\daterange\DateRangePicker;
use kartik\checkbox\CheckboxX;



?>


<div class="preference-form">

 

  <?php $form = ActiveForm::begin(['id'=>'preferences-form','options'=>['target'=>'_blank']]); ?>
  
   
  <?php  
echo $form->field($model, 'date_range',['options'=> ['class '=>'drp-container form-group','id'=>'selectRange']])->widget(
    DateRangePicker::classname(),[
    'name'=>'selectRange',
    'presetDropdown'=>true,
    
    'hideInput'=>true,
    'pluginOptions'=>[
       
        'separator'=>' to ',
        
    ]
])->label("Export Date Range");

?>
  <?php 
  $data=[
  'client_name'=>'Client name',
  'client_email'=>'Client email',
  'total_amount'=>'Total amount',
  'discount'=>'Discount',
  'status'=>'Purchase status',
  'products_list'=>'List of products',
  ];

  echo $form->field($model, 'items')->widget(Select2::classname(),[
    'model' => $model,
    'attribute' => 'items','value'=> $model->items=[
  'client_name',
  'client_email',
  'total_amount',
  'discount',
  'status',
  'products_list',
  ], 

    
    'data' => $data,
    'options' => ['placeholder' => 'Select export elements...', 'multiple' => true,'class'=>'form group'],
    'pluginOptions' => [
        'tags' => false,
        'maximumInputLength' => 10
    ],
]);

?>

<label class="control-label">Select purchase statuses</label>

<?php $pluginOptions = [
    'inline'=>false, 
    //'iconChecked'=>'<i class="glyphicon glyphicon-plus"></i>',    
    'threeState'=>false
    
];
$model->is_delivery = $model->is_purchase = $model->is_contact = true;
echo  $form->field($model, 'is_delivery')->widget(CheckboxX::classname(), [

    'pluginOptions'=>$pluginOptions,
]);
echo  $form->field($model, 'is_purchase')->widget(CheckboxX::classname(), [ 
   
    'pluginOptions'=>$pluginOptions,
]);
echo $form->field($model, 'is_contact')->widget(CheckboxX::classname(), [
    
    'pluginOptions'=>$pluginOptions,
]); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Export'), ['class' => 'btn btn-success' ]) ?>
    </div>

    

    <?php ActiveForm::end(); ?>

</div>
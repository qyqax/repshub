<?php

use yii\helpers\Html;

use dosamigos\datepicker\DatePicker;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;
use kartik\checkbox\CheckboxX;
use kartik\sortinput\SortableInput;


?>


<div class="preference-form">

 

  <?php $form = ActiveForm::begin(['id'=>'preferences-form','options'=>['target'=>'_blank']]); ?>

  <?php echo $form->field($model,'file_name')->textInput();  ?>
  
   
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

<div class="row">
<div class="col-md-6">
<label class="control-label">Drag column which you would like to include in your file and drop it there -></label>
<?= SortableInput::widget([
    'name'=>'kv-conn-1',
    'items' => $model->items,
    'hideInput' => true,
    'sortableOptions' => [
        'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true]
]) ?>
</div>
<div class="col-sm-6">

<?= $form->field($model, 'columns')->widget(SortableInput::classname(), [
    'name'=>'kv-conn-2',
    'items' => [
        'client_name' => ['content' => 'Client Name'],
       
    ],
    'hideInput' => true,
    'sortableOptions' => [
        'connected'=>true,
    ],
    'options' => ['class'=>'form-control', 'readonly'=>true ]
])->label('Column included in your file'); 

?>

</div>
</div>

<?= $form->field($model,'delimiter')->textInput() ?>  

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
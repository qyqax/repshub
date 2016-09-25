<?php

use yii\helpers\Html;
use kartik\file\FileInput;
use yii\widgets\ActiveForm;
use kartik\sortinput\SortableInput;
?>
<style type="text/css">
    .sortable-box{
        width: 40%;
        float: left;

    }
</style>

<div class="import-form">

<?php $form = ActiveForm::begin([
    'options'=>['enctype'=>'multipart/form-data']
]); ?>
<div class="row">
<div class="col-md-6">
<label class="control-label">Drag column included in your file and drop it there -></label>
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
        'client_name' => ['content' => 'Full name'],
       
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

<?= $form->field($model, 'csv_file')->widget(FileInput::classname(), [
        'options' => [
                
                'duplicate' => 'Duplicate file!', 
                'denied' => 'Invalid file type',    
                'multiple'=>'false',
                ],
        'pluginOptions'=>[
          'allowedFileExtensions' => ['csv'],
           // 'showCaption' => false,
            'showRemove' => false,
            'showUpload' => false,
            'showPreview' => false,
          'msgInvalidFileExtension' =>'Invalid extension for file "{name}". Please choose file with "{extensions}" extension.',
        ],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Generate'), ['class' => 'btn btn-success' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


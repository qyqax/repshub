<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\selectize\SelectizeTextInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Attribute */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="attribute-form">

  <?php $form = ActiveForm::begin(); ?>

  <?= $form->field($model, 'attribute_type')->dropDownList([ 'textfield' => 'Textfield', 'textarea' => 'Textarea', 'dropdown' => 'Dropdown', 'checkbox' => 'Checkbox', ], ['prompt' => 'Select field type...', 'onchange' => "if(this.value == 'dropdown'){	$('div[name=\"extra\"]').slideDown();}else{	$('div[name=\"extra\"]').slideUp();}"]) ?>

  <?= $form->field($model, 'attribute_name')->textInput(['maxlength' => true]) ?>

  <div name="extra" class="form-group" style="<?= ($model->attribute_type === 'dropdown') ? "" : "display:none;" ?>">
    <?= $form->field($model, 'option_tags')->widget(SelectizeTextInput::className(), [
      'loadUrl' => [''],
      'name' => 'options',
      'clientOptions' => [
        'plugins' => ['remove_button'],
        'valueField' => 'name',
        'labelField' => 'name',
        'searchField' => ['name'],
        'create' => true,
      ],])->label(Yii::t('app', 'Options')) ?>
  </div>
  <div class="form-group">
    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

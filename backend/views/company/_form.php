<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use backend\models\Settings;
/* @var $this yii\web\View */
/* @var $model common\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_slug_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_legal_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_postal_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_vat')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_currency')->widget(Select2::classname(), [
        'data' => Settings::getAvailableCurrencies(),
        //'options' => ['placeholder' => 'Select a state ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]);  ?>

    

    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

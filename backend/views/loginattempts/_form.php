<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoginAttempts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-attempts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_status')->textInput() ?>

    <?= $form->field($model, 'attempt_browser')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_os')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_device')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'attempt_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

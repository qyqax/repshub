<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserPasswordResets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-password-resets-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'new_password')->textInput(['maxlength' => true])->passwordInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

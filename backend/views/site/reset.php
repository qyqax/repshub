<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserRolesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-roles-search">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Reset Password', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

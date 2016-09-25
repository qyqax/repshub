<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LoginAttemptsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-attempts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'attempt_password') ?>

    <?= $form->field($model, 'attempt_status') ?>

    <?= $form->field($model, 'attempt_browser') ?>

    <?php // echo $form->field($model, 'attempt_ip') ?>

    <?php // echo $form->field($model, 'attempt_os') ?>

    <?php // echo $form->field($model, 'attempt_device') ?>

    <?php // echo $form->field($model, 'attempt_city') ?>

    <?php // echo $form->field($model, 'attempt_country') ?>

    <?php // echo $form->field($model, 'attempt_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ClientsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'company_id') ?>

    <?= $form->field($model, 'client_name') ?>

    <?= $form->field($model, 'client_email') ?>

    <?= $form->field($model, 'client_phone') ?>

    <?php // echo $form->field($model, 'client_city') ?>

    <?php // echo $form->field($model, 'client_country') ?>

    <?php // echo $form->field($model, 'client_address') ?>

    <?php // echo $form->field($model, 'client_postal_code') ?>

    <?php // echo $form->field($model, 'client_photo') ?>

    <?php // echo $form->field($model, 'client_gender') ?>

    <?php // echo $form->field($model, 'client_birthdate') ?>

    <?php // echo $form->field($model, 'client_create_time') ?>

    <?php // echo $form->field($model, 'client_update_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

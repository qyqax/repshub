<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CompanySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'company_slug_name') ?>

    <?= $form->field($model, 'company_legal_name') ?>

    <?= $form->field($model, 'company_email') ?>

    <?php // echo $form->field($model, 'company_url') ?>

    <?php // echo $form->field($model, 'company_phone') ?>

    <?php // echo $form->field($model, 'company_address') ?>

    <?php // echo $form->field($model, 'company_postal_code') ?>

    <?php // echo $form->field($model, 'company_vat') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'company_trial_end_time') ?>

    <?php // echo $form->field($model, 'company_create_time') ?>

    <?php // echo $form->field($model, 'company_update_time') ?>

    <?php // echo $form->field($model, 'company_delete_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

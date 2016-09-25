<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UsersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-users-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_name') ?>

    <?= $form->field($model, 'user_email') ?>

    <?= $form->field($model, 'user_password') ?>

    <?= $form->field($model, 'user_photo') ?>


    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'user_verified') ?>

    <?php // echo $form->field($model, 'company_id') ?>

    <?php // echo $form->field($model, 'user_create_time') ?>

    <?php // echo $form->field($model, 'user_update_time') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

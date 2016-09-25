<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\GoalsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goals-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'goal_id') ?>

    <?= $form->field($model, 'goal_type') ?>

    <?= $form->field($model, 'goal_value') ?>

    <?= $form->field($model, 'account_id') ?>

    <?= $form->field($model, 'time_of_receive') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

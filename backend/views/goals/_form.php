<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Goals */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goals-form">

    <?php $form = ActiveForm::begin(); ?>

    

    <?= $form->field($model, 'goal_type')->dropDownList([ 'daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'goal_value')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

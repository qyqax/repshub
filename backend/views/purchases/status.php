<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Attribute */
/* @var $form yii\widgets\ActiveForm */

?>


<div class="status-form">

  <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'status')->dropDownList([ 'contact' => 'Contact', 'purchase' => 'Purchase', 'delivery' => 'Delivery', ], ['prompt' => '']) ?>
 
 <div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Change Status'), ['class'=>'btn btn-success']) ?>
  </div>

  <?php ActiveForm::end(); ?>

</div>

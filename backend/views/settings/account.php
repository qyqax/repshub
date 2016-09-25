<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

?>

<style type="text/css">
	.account-update{
		width:50%;
		margin-left: auto;
		margin-right: auto;
		}
	.account-update h1 {
		text-align: center;
	}
	#submit{
		/*margin-left: auto;
		margin-right: auto;*/
	text-align: center;
	}

</style>

<div class="account-update">

    <h1>Change account details</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <?php /* echo $form->field($settings,'currency')->widget(Select2::classname(), [
	    'data' => $settings->availableCurrencies,
	    //'options' => ['placeholder' => 'Select a state ...'],
	    'pluginOptions' => [
	        'allowClear' => true
	    ],
	]); */?>
 	
 	<?= $form->field($settings,'language')->widget(Select2::classname(), [
	    'data' => $settings->languages,
	    //'options' => ['placeholder' => 'Select a state ...'],
	    'pluginOptions' => [
	        'allowClear' => true
	    ],
	]); ?>

	<?= $form->field($settings,'date_format')->widget(Select2::classname(), [
	    'data' => $settings->dateFormats,
	    //'options' => ['placeholder' => 'Select a state ...'],
	    'pluginOptions' => [
	        'allowClear' => true
	    ],
	]); ?>

	<?php  /*echo $form->field($settings,'timezone')->widget(Select2::classname(), [
	    'data' => $settings->dateFormats,
	    //'options' => ['placeholder' => 'Select a state ...'],
	    'pluginOptions' => [
	        'allowClear' => true
	    ],
	]); */ ?>


    
 
    <div class="form-group" id='submit'>
        <?= Html::submitButton("SAVE CHANGES", ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
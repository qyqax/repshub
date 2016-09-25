<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


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

    <h1>Change password</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model,'oldpass')->passwordInput() ?>
        
    <?= $form->field($model,'newpass')->passwordInput() ?>
        
    <?= $form->field($model,'repeatnewpass')->passwordInput() ?>
    
 
    <div class="form-group" id='submit'>
        <?= Html::submitButton("SAVE CHANGES", ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php  $this->registerJs("jQuery(document).ready(function($){
                    jQuery.ajax( {
                      url: '//freegeoip.net/json/',
                      type: 'POST',
                      dataType: 'jsonp',
                      success: function(location) {
                          $('#loginform-ip').val(location.ip);
                          $('#loginform-country').val(location.country_name);
                          $('#loginform-city').val(location.city);
                      }
                    } );
            })");
            $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::activeHiddenInput($model, 'ip', []) ?>
                <?= Html::activeHiddenInput($model, 'country', []) ?>
                <?= Html::activeHiddenInput($model, 'city', []) ?>
                <div style="color:#999;margin:1em 0">
                    If you forgot your password you can <?= Html::a('reset it', ['site/reset']) ?>.
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

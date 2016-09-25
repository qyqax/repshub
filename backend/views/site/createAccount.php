<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Company;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

$this->title = 'Create account';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to create account:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'company_id')->dropDownList(
                    ArrayHelper::map(Company::find()->all(),'id','company_name'),['prompt'=>'Select company in which you work']
                )->label('Company Name') ?>
                
                <?= $form->field($model, 'user_name')->label('Name') ?>
                <?= $form->field($model, 'user_email')->label('Email') ?>
                <?= $form->field($model, 'repeat_user_email')->label('Repeat Email') ?>
                <?= $form->field($model, 'user_password')->passwordInput()->label('Password') ?>
                <?= $form->field($model, 'repeat_user_password')->passwordInput()->label('Repeat Password') ?>
                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
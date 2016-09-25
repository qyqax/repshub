<?php
use common\models\CompaniesUsers;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Choose company';
$this->params['breadcrumbs'][] = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Which company do you wish to login into:</p>
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'choosecompany-form']); ?>
                <?= $form->field($model, 'company_id')->dropDownList(ArrayHelper::map($model->companies, 'company_id', 'company.company_name'))->label("") ?>
                <div class="form-group">
                    <?= Html::submitButton('Proceed', ['class' => 'btn btn-primary', 'name' => 'chooseCompany-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

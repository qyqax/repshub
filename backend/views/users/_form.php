<?php

use common\models\UserRoles;
use backend\controllers\UsersController;

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="new-users-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord) { ?>

      <?= $form->field($model, 'user_email')->textInput(['maxlength' => true]) ?>

    <?php }
          if(Yii::$app->role->isOwner() && $model->id != Yii::$app->company->getCompanyOwner()){?>
          <?= $form->field($model, 'user_role_id')->dropDownList(ArrayHelper::map(UserRoles::find()->select(['id', 'user_role_name'])->where(['company_id' => Yii::$app->company->getCompanyID()])->all(), 'id', 'user_role_name'),['prompt'=>'Select role']) ?>
    <?php } ?>

    <?= $form->field($model, 'user_new_photo')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => ['previewFileType' => 'image', 'showUpload' => false],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

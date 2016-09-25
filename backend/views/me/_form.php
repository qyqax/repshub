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

    <?= $form->field($model, 'user_new_photo')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
        'pluginOptions' => ['previewFileType' => 'image', 'showUpload' => false],
    ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

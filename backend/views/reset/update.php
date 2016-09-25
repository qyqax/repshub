<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserPasswordResets */

$this->title = Yii::t('app', 'Update password for ') . ' ' . $model->user_name;
$this->params['breadcrumbs'][] = Yii::t('app', 'Reset password');
?>
<div class="user-password-resets-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

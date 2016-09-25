<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserPasswordResets */

$this->title = Yii::t('app', 'Create User Password Resets');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Password Resets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-password-resets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

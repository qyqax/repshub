<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserRoles */

$this->title = Yii::t('app', 'Update Role: ') . ' ' . $model->user_role_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_role_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-roles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

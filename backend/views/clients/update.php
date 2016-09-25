<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Clients',
]) . ' ' . $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->client_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="clients-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

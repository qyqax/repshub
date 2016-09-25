<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchases */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Purchases',
]) . ' ' . $model->purchase_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->purchase_id, 'url' => ['view', 'id' => $model->purchase_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="purchases-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'products' => $products,
    ]) ?>

</div>

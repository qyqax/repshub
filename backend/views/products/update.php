<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Products',
]) . ' ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->product_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="products-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Attributes */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Attributes',
]) . ' ' . $model->attribute_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->attribute_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="attributes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

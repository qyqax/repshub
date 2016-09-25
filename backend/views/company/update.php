<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = Yii::t('app', 'Update: ', [
    'modelClass' => 'Company',
]) . ' ' . $model->company_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Company'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="company-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

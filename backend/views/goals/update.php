<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Goals */

$this->title = 'Update '.$model->goal_type.' goal';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->goal_type.' goal', 'url' => ['view', 'id' => $model->goal_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="goals-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

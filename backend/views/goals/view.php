<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Goals */

$this->title = $model->goal_type." goal";
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goals-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->goal_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->goal_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'goal_id',
            'goal_type',
            'goal_value',
            //'account_id',
            [
                'value' => $model->time_of_receive == NULL ? 'not achieved' : $model->time_of_receive,
                'label' => 'Achieved',
            ]
           
        ],
    ]) ?>

</div>

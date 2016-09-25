<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\LevelsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Levels');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="levels-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Levels'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            [
                
                'label'=>'Upper bound',
                'value' =>  function ($model){

            return $model->levelsThresholds->threshold." ".Yii::$app->company->company->company_currency;
        },
            ],
            [
                //'attribute'=>'level_id',
                'value'=>'levelsThresholds.commision_percent',
                'label'=>'Commision percent',

            ]
            ,
            

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\GoalsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Goals');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goals-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Goals'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'goal_id',
            'goal_type',
            
            [
'attribute'=>'goal_value',
'value' => function ($data) {
    return $data->goal_value." \xE2\x82\xAc";
},
'label' => 'Goal value',
            ],
            //'account_id',
            [       
                'attribute'=> 'time_of_received',
                'value' => function ($data) {
                            return $data->time_of_receive == NULL ? 'not achieved' : $data->time_of_receive;
                        },
                'label' => 'Achieved',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

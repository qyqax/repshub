<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LoginAttemptsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Login Attempts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-attempts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Login Attempts'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'attempt_password',
            'attempt_status',
            'attempt_browser',
            // 'attempt_ip',
            // 'attempt_os',
            // 'attempt_device',
            // 'attempt_city',
            // 'attempt_country',
            // 'attempt_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

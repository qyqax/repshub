<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CompanySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Companies');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Company'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'company_name',
            'company_slug_name',
            'company_legal_name',
            'company_email:email',
            
            // 'company_url:url',
            // 'company_phone',
            // 'company_address',
            // 'company_postal_code',
            // 'company_vat',
            // 'status',
            // 'company_trial_end_time',
            // 'company_create_time',
            // 'company_update_time',
            // 'company_delete_time',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>

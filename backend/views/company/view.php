<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Company */

$this->title = $model->company_name;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="company-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->role->isOwner()) { ?>
              <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
              <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                  'class' => 'btn btn-danger',
                  'data' => [
                      'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                      'method' => 'post',
                  ],
              ]) ?>
        <?php } ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'company_name',
            'company_slug_name',
            'company_legal_name',
            'company_email:email',
            'company_url:url',
            'company_phone',
            'company_address',
            'company_postal_code',
            'company_vat',
            'company_currency',
            'status',
            'company_trial_end_time',
            'company_create_time',
            'company_update_time',
        ],
    ]) ?>

</div>

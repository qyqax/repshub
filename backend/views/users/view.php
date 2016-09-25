<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
$this->title = $model->user_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->user->identity->id == $model->id || Yii::$app->role->canUpdate('users')) { ?>
              <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php }
              if(Yii::$app->role->canDelete('users') && $model->id != Yii::$app->company->getCompanyOwner())
              { ?>
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
            [
              'attribute'=>'Photo',
              'value'=> 'http://localhost/repshub/common/images/'.$model->getPhoto(),
              'format' => ['image',['width'=>'50','height'=>'50']],
            ],
            'user_name',
            'user_email:email',
            [
                'label' => 'Role',
                'value' => ($model->id == Yii::$app->company->getCompanyOwner() ? 'Owner' : ($model->getRole(Yii::$app->company->getCompanyID()))),
            ],
            [
                'label' => 'Account status',
                'value' => $model->getVerifiedStatus(),
            ],
            'user_create_time',
            'user_update_time',
        ],
    ])
    ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
$this->title = $model->user_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile')];
?>
<div class="new-users-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update'], ['class' => 'btn btn-primary']) ?>
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
                'label' => 'Account status',
                'value' => $model->getVerifiedStatus(),
            ],
        ],
    ])
    ?>

</div>

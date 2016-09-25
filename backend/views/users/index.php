<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="new-users-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
      <?php
        if(Yii::$app->role->canCreate('users')) { ?>
          <?= Html::a(Yii::t('app', 'Create New Users'), ['create'], ['class' => 'btn btn-success']) ?>
        <?php } ?>
    </p>
    <?php
      $columntemplate = Yii::$app->role->getModuleQuickActions('users');
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label' => 'Photo',
                'format' => ['image',['width'=>'25','height'=>'25']],
                'value' => function ($data) {
                  return 'http://localhost/repshub/common/images/'.$data->getPhoto();
                },
            ],
            'user_name',
            'user_email:email',
            // 'status',
            // 'user_verified',
            // 'user_create_time',
            // 'user_update_time',
            [
                'label' => 'Role',
                'value' => function ($data) {
                  if($data->id == Yii::$app->company->getCompanyOwner())
                  {
                    return 'Owner';
                  }
                  return $data->getRole(Yii::$app->company->getCompanyID());
                },
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => $columntemplate, 'buttons' => ['delete' => function($url, $model, $key){
              if($model->id != Yii::$app->company->getCompanyOwner()){
                return Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-trash']), $url, ['data-method'=>'post', 'data-confirm' => 'Are you sure you want to delete this item?','data-pjax' => 0]);
              } else {
                return '';
              }
            }]],
        ],
    ]); ?>

</div>

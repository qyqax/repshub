<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Profile'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="new-users-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

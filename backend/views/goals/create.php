<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Goals */

$this->title = Yii::t('app', 'Create Goals');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Goals'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goals-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Levels */

$this->title = Yii::t('app', 'Create Levels');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="levels-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'threshold' =>$threshold,
    ]) ?>

</div>

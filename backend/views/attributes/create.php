<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Attributes */

$this->title = Yii::t('app', 'Create Attributes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'options' => $options,
    ]) ?>

</div>

<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = Yii::t('app', 'Create Clients');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'extra_fields' => $extra_fields,
					'attributes_array' => (empty($attributes_array)) ? [new PersonAttribute] : $attributes_array,
					'number_of_fields' => $number_of_fields,
    ]) ?>

</div>

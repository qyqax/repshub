<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LoginAttempts */

$this->title = Yii::t('app', 'Create Login Attempts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Login Attempts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-attempts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

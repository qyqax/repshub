<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Attributes */

$this->title = $model->attribute_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Attributes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="attributes-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'attribute_name',
            'attribute_type',
            /*[
                'value'=> $model->account->account_name == NULL ? " " : $model->account->account_name,
                'label' => "Created by account: ", 
               
            ],   */          
             
            [
                'value' => $model->option_tags,
                'visible' => $model->attribute_type == 'dropdown' ? true : false,
                'label' => 'Options',  
            ],
           
            [
                'value'=> $model->company->company_name,
                'label' => "Company: ", 
            ],
            
        ],
    ]) ?>

</div>

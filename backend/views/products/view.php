<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Settings;

/* @var $this yii\web\View */
/* @var $model backend\models\Products */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Products'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="products-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->product_id], [
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
            //'product_id',
            'product_name',
            'product_code',
            
            [
                'value'=>$model->product_price." ".Yii::$app->company->company->company_currency,
                'label'=>'Price',
            ],
            [
                'value'=>$model->category->category_name,
                'label'=>'Main Category',
            ],
            [
                'value'=>$model->subCategories,
                'label' => 'Subcategories',
               
            ],
            [
                'value'=>$model->itemsSold." items",
                'label' => 'Items sold',
               
            ],
             
            //'category_id',
            //'product_image',
            ['value'=>$model->expiry_date.' days','label'=>'Expecte to expire after'],
            
            ['value'=>$model->created_at,'label'=>'Product creation'],
            ['value'=>$model->updated_at,'label'=>'Last update'],
        ],
    ]) ?>

</div>

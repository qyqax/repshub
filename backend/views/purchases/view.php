<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\ArrayHelper;
use backend\models\Products;
use backend\models\Settings;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchases */

$this->title = 'Purchase details';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchases'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="purchases-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->purchase_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->purchase_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php 
        $amount_wihout_discounts=0;



        if($model->sum<=0){

             $purchaseProducts = $model->purchaseProducts;

            foreach ($purchaseProducts as $product) {
             $item= Products::findOne($product->product_id);
                                  
                                   $price=$item->product_price;
                                   $q=$product->quantity;
                                   $base_price=$q * $price;   


                                   
                                    if(!empty($product->discount) )
                                    {

                                       if($product->discount_type !== '%')
                                        {
                                            $product->total_amount= $base_price - $product->discount;
                                            

                                        }
                                        else
                                        {                                                                                      
                                             $product->total_amount= $base_price  - ($base_price * ($product->discount /100));                                          
                                        }
                                    }
                                    else
                                    {
                                        $product->discount = 0;
                                        $product->discount_type = "%";
                                        $product->total_amount= $base_price;
                                    }

                                
                                    if($product->total_amount<0)
                                    {
                                        $product->total_amount=0;
                                    }  
                                    $amount_wihout_discounts = $amount_wihout_discounts +  $product->total_amount;
                                    }                  
        }else{

            //#1 check discount for purchase
            if($model->discount_type !== '%')
            {
               $amount_wihout_discounts =  $model->sum + $model->discount;
            }
            else
            {
                $amount_wihout_discounts = $model->sum / ((100 - $model->discount)/100);
            }
            //#2 check discounts for every single product
            $purchaseProducts = $model->purchaseProducts;

            foreach ($purchaseProducts as $product) {
                if($product->total_amount<=0){

                    $item= Products::findOne($product->product_id);
                                  
                                   $price=$item->product_price;
                                   $q=$product->quantity;
                                   $base_price=$q * $price; 
                                   $amount_wihout_discounts =  $amount_wihout_discounts + $base_price;

                }else{
                     if($product->discount_type !== '%')
                        {
                           $amount_wihout_discounts =  $amount_wihout_discounts + $product->discount;
                        }
                        else
                        {
                            $amount_wihout_discounts = $amount_wihout_discounts / ((100 - $product->discount)/100);
                        }
                }
           
            }
        }

        
        


     ?> 

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'purchase_id',
            [
                'format' => 'raw',
                'value' => Html::a($model->client->client_name,['clients/view','id'=>$model->client->id])  
                ,
                'label' => 'Client',
            ],
            
            [
                'value' => $model->discount==NULL ? '-' : $model->discount.' '.$model->discount_type,
                'label' => "Purchase Discount",
            ],
            
            [   
                'value' => number_format($amount_wihout_discounts,2)." ".Yii::$app->company->company->company_currency,
                'label' => "Amount without discounts",
            ],
            [
                'value' => $model->sum." ".Yii::$app->company->company->company_currency,
                'label' => "Total amount with discounts",

            ],
            
            [
                'label' => 'Purchase created at',
                'value' => $model->created_at,
            ],
            [
               'label' => 'Last update',
             'value' => $model->updated_at,
            ],
            
            //'status',
            
            [
                'format' => 'raw',
                'value' => Html::a($model->user->user_name,['users/view','id'=>$model->user->id]),
                'label'=> 'User ',
            ],
            'purchaseStatuses.status',
        ],
    ]) ?>

     <?php 
    
    $products = $model->myproducts;
    $purchase = $model->purchase_id; ?>
    <h2>Products:</h2>
    <?php
    echo Yii::$app->controller->renderPartial('_expand-row-details',['products'=>$products,'purchase'=>$purchase]);
    ?>

</div>

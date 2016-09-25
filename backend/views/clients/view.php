<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\Attributes;
use backend\models\DropdownOptions;
use backend\models\Settings;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */

$this->title = $model->client_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Clients'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .mydetail{
       
        margin:0;
    }

</style>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php if(Yii::$app->role->canUpdate('clients')) { ?>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php }
              if(Yii::$app->role->canDelete('clients')) { ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
        <?php } ?>
    </p>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
              'attribute'=>'Photo',
              'value'=> 'http://localhost/repshub/common/images/'.$model->getPhoto(),
              'format' => ['image',['width'=>'50','height'=>'50']],
            ],
            'client_name',
            [
                'label' => 'Birthday',
                'value' => $model->getBirthdate(),
            ],
            'client_email:email',
            'client_phone',
            'client_city',
            'client_country',
            'client_address',
            'client_postal_code',
            

            [
                'label' => 'Gender',
                'value' => $model->getGender(),
            ],
            [
                 'label' => 'Created by',
                 'value' => Html::a($model->user->user_name, ['users/view', 'id' => $model->user->id]),
                 'format' => 'html',
            ],
            [
                'label' => 'Client created at',
                'value' => $model->client_create_time,
            ],
            [
                'label' => 'Client updated at',
                'value' => $model->client_update_time,
            ],


            [
               'label'=>'Lead client ?',
               'value'=> $model->is_client_lead == 0 ? 'NO' : "YES" ,
            ]
            
        ],
    ]) ?>
    <?php foreach ($attributes as $item) {
        $a = Attributes::find()->where(['id'=>$item->attribute_id])->one();
        
        switch ($a->attribute_type) {
             case 'textfield':
             case 'textarea':
                   echo DetailView::widget([
                    'model' => $item,
                    'options'=>['class' => 'mydetail table table-striped table-bordered detail-view'],
                    'attributes' =>[
                        [
                            'value' => $item->attribute_value,
                            'label' => $a->attribute_name,
                        ],

                    ],

                ]);
                 break;
            case 'checkbox':
              echo DetailView::widget([
                    'model' => $item,
                    'options'=>['class' => 'mydetail table table-striped table-bordered detail-view'],
                    'attributes' =>[
                        [
                            'value' => $item->attribute_value == 1 ? "yes" : "no" ,
                            'label' => $a->attribute_name,
                        ],

                    ],

                ]);
                 break;
            case 'dropdown':
                $label = DropdownOptions::find()->where(['id'=>$item->option_id])->one()->label;

                 echo DetailView::widget([
                    'model' => $item,
                    'options'=>['class' => 'mydetail table table-striped table-bordered detail-view'],
                    'attributes' =>[
                        [
                            'value' => $label ,
                            'label' => $a->attribute_name,
                        ],

                    ],

                ]);
                 break;
         } 


     }?>
  <br/>
  
  <br/>
     <?php
     if(!$model->is_client_lead){

       echo "<h2>Purchases</h2>";

      foreach ($model->purchases as $index => $purchase) { ?>
      <div class="row">
         <div class="col-md-4">
          <?php
          $i = $index + 1;
          echo  Html::a($i.".Purchase",["purchases/view",'id'=>$purchase->purchase_id]);

           ?>
        </div>
        <div class="col-md-4">
         <p><b>Current status:</b> <?= $purchase->purchaseStatuses->status ?></p> 
        </div>
        <div class="col-md-4">
         <p><b>Total amount:</b> <?= $purchase->sum." ".Yii::$app->company->company->company_currency; ?></p> 
        </div>

      </div>
     
    
     
        
      
      <?php }
        }
      

      ?>


      </div>

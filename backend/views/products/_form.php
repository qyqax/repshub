<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Categories;
use wbraganca\dynamicform\DynamicFormWidget;
use common\models\GlobalFunctions;
use yii\helpers\Url;
use kartik\file\FileInput;
use kartik\select2\Select2;
use kartik\slider\Slider;
use kartik\checkbox\CheckboxX;
/* @var $this yii\web\View */
/* @var $model backend\models\Products */
/* @var $form yii\widgets\ActiveForm */



?>
<style type="text/css">
    
    .items{
        float:left;
        width:40%;

        padding: 1em;
    }
    .fileinput{
        width:80%;
        padding: 1em;
    }
    .special{
        text-align: center;  
        margin:2em; 
    }
</style>

<div class="products-form" >
  

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form','options'=>['enctype'=>'multipart/form-data']]); ?>
    
    
    <div>
        <div class="items">
            <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="items">
            <?= $form->field($model, 'product_code')->textInput(['maxlength' => true]) ?>  
        </div>
        <div style="clear:both"></div>
    </div>
    
    <div>
        <div class="items">
          
    <?= $form->field($model, 'product_price')->textInput(['maxlength' => true]) ?>
        </div>
      
        <div style="clear:both"></div>
    </div>   
   

    
    <div>
        <div class="items">
           <?= $form->field($model, 'category_id')->widget(Select2::classname(), [
       'data' => ArrayHelper::map(Categories::findAll(['parent_id'=>NULL]),'category_id','category_name'),
       'options' =>
        [
        'prompt' => 'select category',
       
        'onChange' => '
            $.post( "../categories/list?id='.'"+$(this).val(),function ( data ){
                
                $( "#products-subcategories" ).select2("val" , "");
                $( "#products-subcategories" ).html( data );
                
            });',   

        ],  
        'pluginOptions' => [
        'allowClear' => true
    ],
    ])->label('Choose main category') ?>
       </div>
        <div class="items">
           <?= $form->field($model,'subcategories')->widget(Select2::classname(), [
    
    
    'data' => isset($model->category_id) ? ArrayHelper::map(Categories::find()->where(['parent_id'=>$model->category_id])->all(),'category_id','category_name') : [], 
  
    'options' => [
        'placeholder' => 'Select subcategories ...',
        'multiple' => true
    ],
]) ?>
       </div> 
        <div style="clear:both"></div>
    </div>

   
    <div class="fileinput">
        <?= $form->field($model, 'product_new_image')->widget(FileInput::classname(), [
            'options' => ['accept' => 'image/*'],
            'pluginOptions' => ['previewFileType' => 'image', 'showUpload' => false],
        ]);?> 
    </div>

    
    <div>
        <div class="items">
           <?= $form->field($model, 'expiry_date')->textInput() ?>
        </div>
        
        <div style="clear:both"></div>
    </div>
    


    
   

   
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use common\models\Company;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use backend\models\Attributes;
use backend\models\ClientAttributes;
use backend\models\DropdownOptions;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model backend\models\Clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?php $model->company_id =  Yii::$app->company->getCompanyID()?>

    <?= $form->field($model, 'company_id')->hiddenInput(array('value'=>Yii::$app->company->getCompanyID()))->label(false) ?>

    <?= $form->field($model, 'client_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'client_fb')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'client_tw')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'card_id_number')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'NIF')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_postal_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'client_new_photo')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]);?>

    <?= $form->field($model, 'client_gender')->dropDownList(['' => 'Choose one', 0 => 'Female', 1 => 'Male']) ?>

    <?= $form->field($model, 'client_birthdate')->widget(DatePicker::classname(), [
        'pluginOptions' => [
            'autoclose'=>true,

            'format' =>  'yyyy-mm-dd',
        ]
    ]);?>

    <?php
            for($i = 0; $i < $number_of_fields; $i++) {
                $attr[$i] = ClientAttributes::find()->where(['attribute_id' => $extra_fields[$i]->id, 'client_id' => $model->id])->one();
                echo Html::activeHiddenInput($attributes_array[$i], "[{$i}]attribute_id", ['value' => $extra_fields[$i]->id]);
                if($attr[$i]){
                    $attributes_array[$i]->attribute_value = $attr[$i]->attribute_value;
                    $attributes_array[$i]->option_id = $attr[$i]->option_id;
                }
                switch ($extra_fields[$i]->attribute_type) {
                    case 'textfield':
                            echo $form->field($attributes_array[$i], "[$i]attribute_value")->label($extra_fields[$i]->attribute_name);
                            break;

                    case 'textarea':
                            echo $form->field($attributes_array[$i], "[$i]attribute_value")->textArea(['rows' => '6'])->label($extra_fields[$i]->attribute_name);
                            break;

                    case 'dropdown':
                            
                            $options =DropdownOptions::find()->where(['attr_id' => $extra_fields[$i]->id ])->all(); 
                            $attributes_array[$i]->option_id=$options[0]->id;

                            echo $form->field($attributes_array[$i], "[$i]option_id")->dropDownList(ArrayHelper::map($options,'id','label'))->label($extra_fields[$i]->attribute_name);

                            break;
                    case 'checkbox':
                            echo $form->field($attributes_array[$i], "[$i]attribute_value")->label($extra_fields[$i]->attribute_name)->widget(SwitchInput::classname(), [
                                    'name' => '[$i]attribute_value',
                                    'pluginOptions' => [
                                        'state' => ($attributes_array[$i]->attribute_value),
                                        'size' => 'mini',
                                        'onText' => Yii::t('app', 'Yes'),
                                        'offText' => Yii::t('app', 'No')
                                    ]]);
                            break;
                    default:
                            break;
                }
            }
        ?>
    
  
         
   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Clients;
use backend\models\Products;
use backend\models\OffersProduct;
use backend\models\Offers;

use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\GlobalFunctions;
use kartik\select2\Select2;
use wbraganca\selectivity\SelectivityWidget;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\web\JsExpression;
use kartik\slider\Slider;
use kartik\checkbox\CheckboxX;

/* @var $this yii\web\View */
/* @var $model backend\models\Purchases */
/* @var $form yii\widgets\ActiveForm */
$data=ArrayHelper::map(Products::find()->all(),'product_id','product_name');
$firstProduct = ArrayHelper::map(Products::find()->one(),'product_id','product_name');
$productUrl = \yii\helpers\Url::to(['productlist']);
$clientUrl = \yii\helpers\Url::to(['clientlist']);
?>
<style type="text/css">
    .product-form-details{
        display:none !important;
    }
</style>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
  <script type="text/javascript">
    
    var sum = 0;

    //array of objects with attributes: product_id,total which comes from controller
    var items = new Array();

    //discount_type , discount
    var purchase_discount = {discount_type:"%",discount:0};


    function recalculateSum(){
        sum = 0;

        items.forEach(function(entry){
            sum = sum + parseInt(entry.total);           
            
          });
          
          if(purchase_discount.discount>=0 ){

          if(purchase_discount.discount_type=='%'){
            sum = sum - (sum * (purchase_discount.discount/100));
          }else{
            sum = sum - purchase_discount.discount;
          }
      }

          sum = Math.round(sum * 100) / 100;
          if(sum<0){
            sum = 0;
          }
          

         $('#total').html('<b>Total amount: </b>'+ sum +' Euro');
      
    }




   function addProduct(product_id,quantity,price,discount,discount_type){
        

                    total_amount = quantity * price;

                    if(discount>=0 ){
                        if(discount_type=="%"){
                            total_amount = total_amount - (total_amount * (discount/100));
                        }else{
                            total_amount = total_amount - discount;
                        }

                        if(total_amount<0){
                            total_amount=0;
                        }
                }

                    product_object = {product_id:product_id,total:total_amount};

                    
                    items.push(product_object); 
                

        recalculateSum();
        
       
    }


    window.onload = function() {

        //execute on update
        <?php if($model->isNewRecord){
            echo 'is_new_purchase = 1;';
        }else{
            echo 'is_new_purchase = 0;';
        }

         ?>
        if(!is_new_purchase)
        {

      
      <?php
      if(empty($model->discount)){

      echo 'purchase_discount = {discount_type:"%",discount:0};';
      
      }else{

      echo 'purchase_discount = {discount_type:"'.$model->discount_type.'",discount:'.$model->discount.'};';
      
      }
      foreach ($products as $key => $value) {

        echo 'product_object = {product_id:"'.$value['product_id'].'",total:"'.$value['total_amount'].'"};';
        echo 'items.push(product_object);';
       
      }
        ?>

     
         
        recalculateSum();
     
        }
    };

   

  var chosenValues = [];
    var values = '1';

     function chosen(id){
 

        if(id.oldvalue!=undefined){
            for(var i =0;i<chosenValues.length;i++)
            {
                
                if(chosenValues[i]===id.oldvalue)
                {
                  
                    chosenValues.splice(i,1);
                    
                    chosenValues.push(id.value); 
                    break;

                }
            }        
        }else
 
        {
           chosenValues.push(id.value); 
        } 

        values = chosenValues.join("','");
    }
    var clicked = false;

    function buildElementsId(element_id){

         

         

        var number_of_related_fields = 4;
        elements_id = new Array();

        pattern = element_id.substring(18);
        
        
           
           
            elements_id['quantity']=element_id.replace(pattern,'quantity');
            elements_id['discount']=element_id.replace(pattern,'discount');
            elements_id['discount_type']=element_id.replace(pattern,'discount_type');
            elements_id['send_alert']=element_id.replace(pattern,'send_alert');

           

            return elements_id;
       

        }

    function clearRelated(element_id,old_id){
        
       elements_to_clear = buildElementsId(element_id);
       
       for(var element in elements_to_clear){
       
        $('#'+elements_to_clear[element]).val('');
       }

       //remove product from items table
      
       
       for(var i =0;i<items.length;i++)
            {
                
                if(items[i].product_id===old_id)
                {
                     
                     
                    items.splice(i,1);

                    
                }
            }

            recalculateSum();        



       
       }

    function updateSum(element_id){
        parameters_to_pass = buildElementsId(element_id,'product_id');

         for(var element in parameters_to_pass){
            switch(element){
                case 'quantity':
                quantity=parameters_to_pass['quantity'];
                quantity = $('#'+quantity).val();
                break;
                case 'discount':
                discount=parameters_to_pass['discount'];
                discount = $('#'+discount).val();
                break;
                case 'discount_type':
                discount_type =parameters_to_pass['discount_type'];
                discount_type = $('#'+discount_type).val();
                break;
                


                default:break;
            }
         }
         product_id = element_id.replace(element_id.substring(18),'product_id');
        // oldvalue = $('#'+product_id).oldvalue;
         product_id = $('#'+product_id).val();


       for(var i =0;i<items.length;i++)
            {
                
                if(items[i].product_id===product_id)
                {
                     
                     
                    items.splice(i,1);

                    
                }
            }


         price = $('#detail'+product_id).find('.price');
         price = price.text().replace(/[^0-9]/g, "");

         addProduct(product_id,quantity,price,discount,discount_type);
     




    }

    function drawProductDetails(product_id,id)
    {      
        if($(".field-"+id ).next().attr('class')=='details'){
            $(".field-"+id ).next().remove();
            $(".field-"+id ).next().attr('style', 'display: block !important');
        }else{
             $(".field-"+id ).next().attr('style', 'display: block !important');
        }
        if(product_id != ""){
         
        $.ajax({
  url: <?="'".$productUrl."'"?>,
  data: {q:product_id},
  context: document.body
}).done(function(data) {
    product = data.items[0];
    var content = 
    '<div class="details" id="detail'+product_id+'">' + 
    '<div style="float:left" >' +
        '<img src="http://localhost/repshub/common/images/' + product["product_image"]+ '" class="img-rounded" style="width:100px" />' +
        
    '</div>' +
    '<div style="float:left" >'+

        '<b > <div> Product name: ' + product["product_name"] + '</div>' +
        '<div >Product code: ' + product["product_code"] + '</div>' +
        '<div class="price" >Product price: ' + product["product_price"] +' Euro'+ '</div>' +'</b>' + 
    '</div>'+
    
    '<div style="clear:both"></div>'+
'</div>'



    ;
    $(content).insertAfter($(".field-"+id ));

});

}else{
             $(".field-"+id ).next().attr('style', 'display: none !important');
        }


    }
$(document).ready(function(){

   
    $("#purchases-discount").change(function(){
        
        discount_type = $("#purchases-discount_type").val();
        purchase_discount = {discount_type:discount_type,discount:$(this).val()};
        recalculateSum();
    });

    $("#purchases-discount_type").change(function(){        
        discount = $("#purchases-discount").val();
        purchase_discount = {discount_type:$(this).val(),discount:discount};
        recalculateSum();
    });
    

    $('.dynamicform_wrapper').find('select').each(function(){
//drawProductDetails();
        if($(this).attr('class').indexOf('values')>-1){
            drawProductDetails($(this).val(),$(this).attr('id'));
           /*  console.log($(this).attr('id'));
            console.log($(this).val());*/
        }
        
        if($(this).hasClass("values"))
        {
             chosenValues.push($(this).find('option:selected').val());  
              values = chosenValues.join("','");
        }


      
    });

    


    $(".dynamicform_wrapper").on("afterInsert", function(e, item) {
 //console.log($(item).find('select'));
        $(item).find('select').each(function() {
                   $(this).select2("val",$("#target option:first").val());
                  // $(this).val('');
                   //console.log($("#target option:first").val());
                     
            });
            $(item).find('input[type="checkbox"]').each(function() {
                    $(this).prop( "checked", false );
            });

            //$(item).find('.details').remove();
    });



    $("#add").click(function(){
   // $(".field-purchases-client_id").fadeToggle("slow");
   if(clicked=!clicked){
    $("#find-client").attr("disabled", true);
    $("#addClient-panel").attr("disabled", false);
    $("#find-client").val('').change();
    $("#addClient-panel").fadeIn("slow");
    $(this).text('FIND CLIENT');
   }
   else{
    $("#find-client").attr("disabled", false);
    $("#addClient-panel").attr("disabled", true);
    $("#addClient-panel").fadeOut("slow");
    $(this).text('ADD NEW CLIENT');
    
   }
   // $("#find-client").val('').change();
   // $("#find-client").attr("disabled", true);

    
    //$(".client").prop('required',true);
});

    

   });
  </script>

<div class="box"></div>


<div class="purchases-form" >

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    
    
<?php 
    $clientFormatJs = <<< 'JS'
var formatClient = function (client) {
if (client.loading) {
        return client.client_name;
    }
if(client.client_photo == null){
    client.client_photo = "default.jpg" ;
}
var markup =
'<div class="row">' + 
    '<div class="col-sm-3">' +
        '<img src="http://localhost/repshub/common/images/' + client.client_photo+ '" class="img-rounded" style="width:30px" />' +
        '<b style="margin-left:5px">' + client.text + '</b>' + 
    '</div>' +
    '<div class="col-sm-2"> ' + client.client_email + '</div>' +
    '<div class="col-sm-1"> ' + client.client_city + '</div>' +
    '<div class="col-sm-4"> ' + client.client_address + '</div>' +
    '<div class="col-sm-2"> ' + client.client_phone + '</div>' +
    
'</div>';
   
    return '<div style="overflow:hidden;">' + markup + '</div>';
};
var formatClientSelection = function (client) {
    return client.text;
}
JS;
 
// Register the formatting script
$this->registerJs($clientFormatJs, yii\web\View::POS_HEAD);
 
// script to parse the results into the format expected by Select2
$clientResultsJs = <<< JS

function (data, params) {
    return {
        results: data.items
    };
}
JS;
?>
<?php if($model->isNewRecord){ ?>
     <?= $form->field($model, 'client_id')->widget(Select2::classname(), [
                           
                                'initValueText' => '',
                                'options' => [
                                    'placeholder' => 'Find the client...', 
                                    'id' => 'find-client',
                                    ],
                                'pluginOptions' => [

                                    'allowClear' => true, 
                                    'minimumInputLength' => 2,
                                    'ajax'=>[
                                        'url' => $clientUrl,
                                        'dataType' => 'json',
                                        'delay'=> 250,
                                        'data' => new JsExpression("function(params) { return {q:params.term};}"),
                                        'processResults' => new JsExpression($clientResultsJs),
                                        'cache' => true
                                    ], 
                                   'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('formatClient'),
                                    'templateSelection' => new JsExpression('formatClientSelection'),
                                    
                                ],
                            ]); ?>
<div>
    <button id='add' style="margin-bottom:1em;" class="btn btn-success" type='button'>ADD NEW CLIENT</button>
</div>
   <?php /*<!--div id='addClient-panel' style='display:none'>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($client, 'client_name')->textInput(['placeholder'=>'full name...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'client_email')->textInput(['placeholder'=>'email...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'client_phone')->textInput(['placeholder'=>'phone...','class'=>'client form-control'])->label(false) ?>  </div>  
        </div>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($client, 'client_country')->textInput(['placeholder'=>'country...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'client_city')->textInput(['placeholder'=>'city...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'client_address')->textInput(['placeholder'=>'address...','class'=>'client form-control'])->label(false) ?></div>
        </div>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($client, 'client_postal_code')->textInput(['placeholder'=>'postal code...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'NIF')->textInput(['placeholder'=>'NIF...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($client, 'card_id_number')->textInput(['placeholder'=>'the citizen card number...','class'=>'client form-control'])->label(false) ?>  </div> 
        </div>
    </div-->*/?> 
   
    <div id='addClient-panel' style='display:none'>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($model, 'client_name')->textInput(['placeholder'=>'full name...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'client_email')->textInput(['placeholder'=>'email...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'client_phone')->textInput(['placeholder'=>'phone...','class'=>'client form-control'])->label(false) ?>  </div>  
        </div>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($model, 'client_country')->textInput(['placeholder'=>'country...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'client_city')->textInput(['placeholder'=>'city...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'client_address')->textInput(['placeholder'=>'address...','class'=>'client form-control'])->label(false) ?></div>
        </div>
        <div class='row'>
            <div class="col-md-4"><?= $form->field($model, 'client_postal_code')->textInput(['placeholder'=>'postal code...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'NIF')->textInput(['placeholder'=>'NIF...','class'=>'client form-control'])->label(false) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'card_id_number')->textInput(['placeholder'=>'the citizen card number...','class'=>'client form-control'])->label(false) ?>  </div> 
        </div>
    </div>
<?php }?>

<div style='float: left; margin-right: 1em'>
    <?= $form->field($model, 'discount')->textInput() ?>
</div>
<div style='float: left; margin-right: 1em'>
     <?= $form->field($model, 'discount_type')->dropDownList(['%'=>'%',Yii::$app->company->company->company_currency=>Yii::$app->company->company->company_currency]) ?>
</div>
<div style='clear:both' ></div>
  



    

    <div class="panel panel-default">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-pencil"></i> Products</h4></div>
        <div class="panel-body">
             <?php  DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody' => '.container-items', // required: css class selector
                'widgetItem' => '.item', // required: css class
                //'limit' => 4, // the maximum times, an element can be cloned (default 999)
                'min' => 1, // 0 or 1 (default 1)
                'insertButton' => '.add-item', // css class
                'deleteButton' => '.remove-item', // css class
                'model' => $products[0],
                'formId' => 'dynamic-form',
                'formFields' => [
                    'product_id',
                    'quantity',              

                ],
            ]); ?>

            <div class="container-items">
            <?php foreach ($products as $i => $product): ?>
                <div class="item panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title pull-left">Product</h3>
                        <div class="pull-right">
                        <?php
                        $beforeDeleteEvent = <<< 'EVENT'
$(".dynamicform_wrapper").on("beforeDelete", function(e, item) {

valueToRemove = item.getElementsByClassName("values")[0].value;
for(var i =0;i<window.chosenValues.length;i++)
        {
          
            if(window.chosenValues[i]===valueToRemove)
            {
            
                window.chosenValues.splice(i,1);
                
                
                break;

            }
        }
values = chosenValues.join("','");


});

EVENT;
$this->registerJs($beforeDeleteEvent);
?>
                            <button type="button" class="add-item btn btn-success btn-xs" ><i class="glyphicon glyphicon-plus"></i></button>
                            <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                    <div id='remove' onclick="removeValue()" style="color:red"></div>
                        <?php
                            // necessary for update action.
                            if (isset($product->id)) {
                                echo Html::activeHiddenInput($product, "[{$i}]id");

                            }
                         
                        ?>
                        <?php
                        if(!$model->isNewRecord){
$preselected=Products::findOne([$product->product_id])->product_name;
//var_dump($product->product_id);die;
                           // echo Html::activeHiddenInput($product, "[{$i}]product_id");
                        }else{
                            $preselected = 'Select product...';
                            //    
                        }
                            
                      //  if($model->isNewRecord){
                       /* echo $form->field($product, "[{$i}]product_id")->dropDownList(
                            ArrayHelper::map(Products::find()->all(),'product_id','product_name')
                            ,['prompt'=>'Select product'] ); */
                        /*echo $form->field($product, '['.$i.']product_id')->widget(Select2::classname(), [
                           
                                'data' => $data,
                                'options' => ['placeholder' => 'Select a product ...'],
                                'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);*/
                          /*  echo $form->field($product, '['.$i.']product_id')->widget(Select2::classname(), [
                           
                                'initValueText' => $firstProduct,
                                'options' => [
                                    'placeholder' => 'Select a product ...',
                                    'onfocus'=>"this.oldvalue = this.value;",
                                    'onChange'=> new JsExpression('chosen(this);this.oldvalue = this.value;'),
                                    
                                ],
                                'pluginOptions' => [

                                    'allowClear' => true, 
                                    'minimumInputLength' => 3,
                                    'ajax'=>[
                                        'url' => $url,
                                        'dataType' => 'json',
                                        'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                                    ], 
                                   'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('function(product_id) { return product_id.text; }'),
                                    'templateSelection' => new JsExpression('function (product_id) { return product_id.text; }'),
                                    
                                ],
                            ]);*/
    $formatJs = <<< 'JS'
var formatProduct = function (product) {
if (product.loading) {
        return product.product_name;
    }

    var markup =
'<div class="row">' + 
    '<div class="col-sm-5">' +
        '<img src="http://localhost/repshub/common/images/' + product.product_image+ '" class="img-rounded" style="width:30px" />' +
        '<b style="margin-left:5px">' + product.product_name + '</b>' + 
    '</div>' +
    '<div class="col-sm-3"><i class=" "></i> ' + product.product_code + '</div>' +
    '<div class="col-sm-3"><i class=""></i> ' + product.product_price +' Euro'+ '</div>' +
    
'</div>';
  
    return '<div style="overflow:hidden;">' + markup + '</div>';
};



var formatProductSelection = function (product) {
    
    return product.product_name || product.text;
}



JS;
 
// Register the formatting script
$this->registerJs($formatJs, yii\web\View::POS_HEAD);
 
// script to parse the results into the format expected by Select2
$resultsJs = <<< JS
function (data, params) {
    return {
        results: data.items
    };
}
JS;

echo $form->field($product, '['.$i.']product_id')->widget(Select2::classname(), [
                           
                                'initValueText' => $preselected,
                                'options' => [
                                    'placeholder' => 'Select a product ...',
                                    'onfocus'=>"this.oldvalue = this.value;",
                                    'onChange'=> new JsExpression('chosen(this);this.oldvalue = this.value;drawProductDetails(this.value,this.id);'),
                                    'class' =>'values',
                                    
                                    
                                ],
                                'pluginOptions' => [

                                    'allowClear' => true, 
                                    'minimumInputLength' => 1,
                                    'ajax'=>[
                                        'url' => $productUrl,
                                        'dataType' => 'json',
                                        'delay'=> 250,
                                        'data' => new JsExpression("function(params) { return {q:params.term, arr:encodeURI(values).replace(/%5B/g, '[').replace(/%5D/g, ']')}; }"),
                                        'processResults' => new JsExpression($resultsJs),
                                        'cache' => true
                                    ], 
                                   'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                                    'templateResult' => new JsExpression('formatProduct'),
                                    'templateSelection' => new JsExpression('formatProductSelection'),
                                    
                                ],
                                'pluginEvents' => [
    "change" => "function() { clearRelated(this.id,this.oldvalue);}",
    "select2:opening" => "function() {this.oldvalue = this.value;}",

    ],
                            ]);
                          /*  echo $form->field($product, '['.$i.']product_id')->widget(DepDrop::classname(), [
                                        'type'=>DepDrop::TYPE_SELECT2,
                                        'options'=>['id'=>'subcat-id'],
                                        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                        'pluginOptions'=>[
                                            'depends'=> new JsExpression('')
                                            ,
                                            'placeholder'=>'Select...',
                                            'url'=>Url::to(['/site/subcat'])
                                        ]
                                    ]);*/
                        /*}else
                        {
                            echo Html::activeHiddenInput($product, "[{$i}]product_id");

                            echo "<div class='values' style='font-weight:bold;padding-down:10px'>".Products::findOne([$product->product_id])->product_name."</div>";
                        }*/
                        ?>
                        

                        <?php  echo '<div class="product-form-details"><div>'. $form->field($product,"[{$i}]quantity")->textInput(['onChange'=>'updateSum(this.id);']).'</div><div>'.
                            $form->field($product,"[{$i}]discount")->textInput(['onChange'=>'updateSum(this.id);']).'</div><div>' .
                            $form->field($product,"[{$i}]discount_type")->dropDownList(['%'=>'%',Yii::$app->company->company->company_currency=>Yii::$app->company->company->company_currency],['onChange'=>'updateSum(this.id);']).'</div><div>' .
                            $form->field($product,"[{$i}]send_alert")->checkBox(['onChange'=>'updateSum(this.id);']).'</div>'.

                            '</div>'?>

                        <div>
                            
                        </div>

                        


                      
                    </div>
                </div>
            <?php endforeach; ?>
            </div>
            <?php DynamicFormWidget::end(); ?>
        </div>
   </div>
    
 
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
   
   <div id='total'></div>
</div>

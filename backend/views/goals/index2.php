<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\ActiveForm;
use yii\bootstrap\Progress;
use common\models\StatsFunctions;


?>

<style type="text/css">
	#goal-container{
		margin-top:7em;
		margin-left: auto;
		margin-right: auto;
		font-family: serif;
		color:#606060;
	}
	.card{
		margin:10px;
		width:360px;
		height: 222px;
		float: left;
		border-radius: 25px;
	}
	.card h2{
		text-align: center;
	}
	.card p{
		float: left;
		font-size: 1.4em;
		margin-left: 0.5em;

	}
	#daily{
		background-color: #D2F973;
		position: relative;

	}
	#weekly{
		background-color: #F8CD5B;
		position: relative;

	}
	#monthly{
		background-color: #F8715B;
		position: relative;

	}
	.details{
		margin:1em 2.5em;
		
	}
	
	.value{
		width:60%;
	}
	.form input{
		width:30%;
		height: 1.5em;
		float: left;
		margin-left:10px;
		margin-top: 3px;
	}
	.form button{
		float: left;
		margin-left: 10px;
		margin-top: -3px;
	}

</style>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
	

     $( document ).ready(function() {

     	$('.form').hide();
     	
     	$("#daily").click(function(){
			$('.card').animate({
 				marginRight: 1,
 				marginLeft:1,
 			});
     		$('#monthly').animate({
		        width:360,
				height: 222,
				marginTop: 10,
		       

		    });
 			$('#monthly').find('.form').fadeOut();
 			$('#monthly').find('.value').delay(500).fadeIn();

 			$('#weekly').animate({
		        width:360,
				height: 222,
				marginTop: 10,
		       

		    });
 			$('#weekly').find('.form').fadeOut();
 			$('#weekly').find('.value').delay(500).fadeIn();


     		$("#daily").fadeIn();
			$('#daily').css('background-color','#C1E862');
    		$('#daily').animate({
		        width: 380,
		        height: 234,
		        marginTop: 5,
		       // top:"-=5px",
		        //left:10

		    });

 			
 			$('#daily').find('.value').fadeOut();
 			$('#daily').find('.form').delay(500).fadeIn();
     	});
     	$("#weekly").click(function(){
     		$('.card').animate({
 				marginRight: 1,
 				marginLeft:1,
 			});
     		$('#daily').animate({
		        width:360,
				height: 222,
				marginTop: 10,
		        

		    });
 			$('#daily').find('.form').fadeOut();
 			$('#daily').find('.value').delay(500).fadeIn();

 			$('#monthly').animate({
		        width:360,
				height: 222,
		       marginTop: 10,

		    });
 			$('#monthly').find('.form').fadeOut();
 			$('#monthly').find('.value').delay(500).fadeIn();



     		$("#weekly").fadeIn();
     		$('#weekly').css('background-color','#E7BC4A');
    		$('#weekly').animate({

		        width: 380,
		        height: 234,
		       marginTop: 5,

		    });
 		
 			$('#weekly').find('.value').fadeOut();
 			$('#weekly').find('.form').delay(500).fadeIn();
     	});
     	$("#monthly").click(function(){
     		$('.card').animate({
 				marginRight: 1,
 				marginLeft:1,
 			});
     		
			$('#weekly').animate({
		        width:360,
				height: 222,
				marginTop: 10,
		      

		    });
 			$('#weekly').find('.form').fadeOut();
 			$('#weekly').find('.value').delay(500).fadeIn();
 			
 			$('#daily').animate({
		        width:360,
				height: 222,
		     marginTop: 10,

		    });
 			$('#daily').find('.form').fadeOut();
 			$('#daily').find('.value').delay(500).fadeIn();

			$("#monthly").fadeIn();
     		$('#monthly').css('background-color','#E7614A');
    		$('#monthly').animate({
		        width: 380,
		        height: 234,
		         marginTop: 5,
		       

		    });
 			$('.card').animate({
 				marginRight: 1,
 				marginLeft:1,
 				
 			});

 			$('#monthly').find('.value').fadeOut();
 			$('#monthly').find('.form').delay(500).fadeIn();

     	});

     });


</script>


<h1 style="text-align: center;font-family: serif;
		color:#606060;">GOALS</h1>

<div id="goal-container">
	
	<div class='card' id='daily'>
		<h2>Daily Goal</h2>
		<div class="details">
			
			<p>Goal Value: </p> 
			<p class='value'><?= " ".$daily_value->goal_value." ".
			Yii::$app->company->company->company_currency; ?></p>
			<div class='form' style="display: none" > 
				<?php $form = ActiveForm::begin(); ?>	
				<?= $form->field($daily_value, 'goal_id')->hiddenInput()->label(false); ?>
				<?= $form->field($daily_value, 'goal_type')->hiddenInput()->label(false); ?>

			    <?= $form->field($daily_value, 'goal_value')->textInput()->label(false) ?>

				
			    <?= Html::submitButton(Yii::t('app', 'Save') , ['class' => 'btn btn-success']) ?>
			  

			    <?php ActiveForm::end(); ?>
	
			</div>


			
			<div style="clear:both"></div>
			
			 
			
			<?php
			
				?>
				
					<?php  
					
            

        $amount = StatsFunctions::currentDayRevenue();
       if($daily_value->goal_value!=0){
       	$percent = round(($amount * 100) / $daily_value->goal_value);
       }else{
       	$percent = round(($amount * 100));
       }
      


							
							$title="Goal Status: ".$percent."%";
						echo Progress::widget([
						    'percent' => $percent,
						  //  'label' => 'Status',
						   
						'barOptions'=>[
				'style'=>"color:black;
				width: ".$percent."%",
						],
						    'options' => [
						    	'data-toggle'=>"tooltip" ,
						    	'title'=> $title,
						    	
						    	
						    	
						    	'class'=> 'level',

						    	
						    ],
						]); 
					?>
				
				<p>You achieved <?= $amount." ".Yii::$app->company->company->company_currency ?> so far.</p>
				
				<?php
			
			if($daily_value->time_of_receive !== NULL){
			echo "<p>Achieved at: ".$daily_value->getReceiveTime()."</p>" ;
			}
			else{
				$to_achieve = $daily_value->goal_value - $amount;
			echo "<p>You need to earn ".$to_achieve." ".Yii::$app->company->company->company_currency." more</p>";
			}
		

			?>	
			
			<div style="clear:both"></div>
		</div>
	</div>
	<div class='card' id='weekly'>
		<h2>Weekly Goal</h2>

	<div class="details">
			<p>Goal Value: </p> 
			<p class='value'><?= " ".$weekly_value->goal_value." ".Yii::$app->company->company->company_currency?></p>
			<div class='form' style="display: none" > 
				<?php $form = ActiveForm::begin(); ?>	
				<?= $form->field($weekly_value, 'goal_id')->hiddenInput()->label(false); ?>
				<?= $form->field($weekly_value, 'goal_type')->hiddenInput()->label(false); ?>

			    <?= $form->field($weekly_value, 'goal_value')->textInput()->label(false) ?>

				
			    <?= Html::submitButton(Yii::t('app', 'Save') , ['class' => 'btn btn-success']) ?>
			  

			    <?php ActiveForm::end(); ?>
	
			</div>
			<div style="clear:both"></div>
			
			
			
			
				 
					<?php  
					
        $amount = StatsFunctions::currentWeekRevenue();
        if($weekly_value->goal_value!=0){
       	$percent = round(($amount * 100) / $weekly_value->goal_value);
       }else{
       	$percent = round(($amount * 100));
       }



							//$percent=60;
							$title="Goal Status: ".$percent."%";
						echo Progress::widget([
						    'percent' => $percent,
						  //  'label' => 'Status',
						   
						'barOptions'=>[
				'style'=>"color:black;
				width: ".$percent."%",
						],
						    'options' => [
						    	'data-toggle'=>"tooltip" ,
						    	'title'=> $title,
						    	
						    	
						    	
						    	'class'=> 'level',

						    	
						    ],
						]); 
					?>
				
				<p>You achieved <?= $amount." ".Yii::$app->company->company->company_currency ?> so far.</p>
				<?php
			
			if($weekly_value->time_of_receive !== NULL) 
			{
			echo "<p>Achieved at: ".$weekly_value->getReceiveTime()."</p>" ;
			}else{
				$to_achieve = $weekly_value->goal_value - $amount;
			echo "<p>You need to earn ".$to_achieve." ".Yii::$app->company->company->company_currency." more</p>";
			}
		

			?>		
			
			<div style="clear:both"></div>
		</div>
	</div>
	<div class='card' id='monthly'>
		<h2>Monthly Goal</h2>
		<div class="details">
			<p>Goal Value: </p> 
			<p class='value'><?= " ".$monthly_value->goal_value." ".Yii::$app->company->company->company_currency?></p>
			
			<div class='form' style="display: none" > 
				<?php $form = ActiveForm::begin(); ?>	
				<?= $form->field($monthly_value, 'goal_id')->hiddenInput()->label(false); ?>
				<?= $form->field($monthly_value, 'goal_type')->hiddenInput()->label(false); ?>

			    <?= $form->field($monthly_value, 'goal_value')->textInput()->label(false) ?>

				
			    <?= Html::submitButton(Yii::t('app', 'Save') , ['class' => 'btn btn-success']) ?>
			  

			  
	
			</div>
<div style="clear:both"></div>
			 
			
			<?php
			
				?>
				 
					<?php  
					
            $amount = StatsFunctions::currentMonthRevenue();
              if($monthly_value->goal_value!=0){
       	$percent = round(($amount * 100) / $monthly_value->goal_value);
       }else{
       	$percent = round(($amount * 100));
       }




							$title="Goal Status: ".$percent."%";
						echo Progress::widget([
						    'percent' => $percent,
						  //  'label' => '',
						   
						'barOptions'=>[
				'style'=>"color:black;
				width: ".$percent."%",
						],
						    'options' => [
						    	'data-toggle'=>"tooltip" ,
						    	'title'=> $title,
						    	
						    	
						    	
						    	'class'=> 'level',

						    	
						    ],
						]); 
					?>
				
				<p>You achieved <?= $amount." ".Yii::$app->company->company->company_currency ?> so far.</p>
				<?php
			
			if($monthly_value->time_of_receive !== NULL) 
			{
			echo "<p>Achieved at: ".$monthly_value->getReceiveTime()."</p>" ;
			}
			else{
				echo Html::hiddenInput('amount',$amount,['class'=>'form-control']);
				$to_achieve = $monthly_value->goal_value - $amount;
				echo "<p>You need to earn ".$to_achieve." ".Yii::$app->company->company->company_currency." more</p>";			
			}
		  ActiveForm::end(); 

			?>
			<div style="clear:both"></div>
		</div>
	</div>
	<div style="clear:both"></div>
</div>
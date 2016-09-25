<?php
//use backend\models\LevelsThresholds;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\export\ExportMenu;
use common\models\GlobalFunctions;	
use yii\bootstrap\Progress;
 

?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<style type="text/css">
	.panel{
		width: 1000px;
		margin-right: auto;
    	margin-left: auto;
    	font-family: serif;color:#606060;

	}
	.square{
		width: 50%;
		float: left;
	}
	.tiles{
		margin: 10px;
		width:229px;	
		height: 142px;
		float:left;
		text-align: center;
	}

	#account{
		width:480px;
		background-color: blue;
		height: 304px;
		float:left;
		background-color:#CCFF66;
		margin:10px;

	}

	#stats{
		
	
		background-color:#878F8E;


	}

	#stats:hover{
		background-color:#767E7D;
	}

	#goals{
		
		background-color:#F85E54;
	}

	#goals:hover{
		background-color:#E74D43;
	}

	#clients{
		
	background-color:#F9F755;
	}

	#clients:hover{
	background-color:#E8E644;
	}


	#products{
		
		background-color:#8A64AB;

	}

	#products:hover{
		
		background-color:#7A53AA;

	}

	#settings{
		
		background-color:#6488AB;

	}

	#settings:hover{
		
		background-color:#5377AA;

	}

	#client_attr{
	
		margin-left: 11px;
		background-color:#8A64AB;
	}

	#client_attr:hover{
	
		background-color:#7A53AA;
	}

	#purchase{
		width:478px;
		
		height:142px;
		float:left;
		margin: 10px;
		background-color: #F8B854;
		text-align: center;


	}

	#purchase:hover{

		background-color: #E7A743;
	}

	a.tilelink{
		  	font-family: serif;
			text-decoration: none;
		  	color:#606060;
		  	display: block;
	}

	.level{
		margin:5px 10px 10px 0 ;
		text-align: center;


	}


</style>
<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

 <p>
        <?= Html::a(Yii::t('app', 'Export Sold Products'), ['exportproducts'], ['class' => 'btn btn-primary','target'=>'_blank']) ?>
  </p>


<div class="panel">
	<div class='square'>
		<div  id='account' style='font-family: serif;color:#606060;'>
		<h2 style='margin-bottom:0px;text-align: center' >  <?= $model->company->company_name ?> Company</h2>
			<i style='color:white;font-size:9em;margin:40px;float:left' class="fa fa-user"></i>
			<div style="float:left;font-size:20px;margin:50px 10px;">
			
				
				<p style="float:left;margin:0 10px 10px 0"><?= $model->account_name ?></p>
				<p style="float:left;margin:0px 10px 10px 0">
					<?php  $level = GlobalFunctions::getLevel(); 
							$nextLevel = GlobalFunctions::getNextLevel();
							if(empty($nextLevel)){
								$title = "Congratulation you are on the highest level !";
								$percent=100;
							}else{

								$toEarn = $nextLevel->threshold - $total_amount;
								$title ="You are on the level: ". $level->level->name
								 ." To level up you need earn ".$toEarn." ".Yii::$app->company->company->company_currency." more.";
							
								$percent = ($total_amount * 100) / $nextLevel->threshold;
							}
						
						echo Progress::widget([
						    'percent' => $percent,
						    'label' => $level->level->name,
						   
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
				</p>
				<div style="clear:both"></div>
				<p >Commision percentage: <?= $level->commision_percent." % "?></p>
				<p >You have earned: <?= number_format((float)$total_amount,2,'.','')." ".Yii::$app->company->company->company_currency; ?> </p>
			
			</div>
			
		</div>
<div class="tiles" id='settings'>
			<a class="tilelink" href="settings/account">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-cog"></i>
				<p style="margin: 10px">ACCOUNT SETTINGS</p>
			</a>
		</div>
	
		<div class="tiles" id='goals'>
			<a class="tilelink" href="goals/index">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-crosshairs"></i>
				<p style="margin: 10px">OBJECTIVES</p>
			</a>
		</div>
		
		
		

		

		

	</div>
	
	<div class='square'>
	
	
	
		<div class="tiles" id='clients'>
			<a class="tilelink" href="clients/create">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-user-plus"></i>
				<p style="margin: 10px">CREATE A NEW CLIENT</p>
			</a>
		</div>

		<div class="tiles" id='client_attr'>
			<a class="tilelink" href="attributes">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-child"></i>
				<p style="margin: 10px">CLIENT ATTRIBUTES</p>
			</a>
		</div>

				<div class="tiles" id='stats' >
			<a class="tilelink" href="myaccount/stats">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-line-chart"></i>
				<p style="margin: 10px">STATISTICS</p>
			</a>
		</div>


		<div class="tiles" id='products'>
			<a class="tilelink" href="products/index">
				<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-diamond"></i>
				<p style="margin: 10px">VIEW PRODUCTS</p>
			</a>
		</div>
		




	</div>
	<div  id='purchase'>
		<a class="tilelink" href="purchases/create">
			<i style='margin-top: 20px;font-size: 5em;color:white' class="fa fa-cart-plus"></i>
			<p style="margin: 10px">MAKE A NEW PURCHASE</p>
		</a>
	</div>
	<div style="clear:both"></div>

	

</div>
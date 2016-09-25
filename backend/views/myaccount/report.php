 <?php
use backend\models\LevelsThresholds;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\models\StatsFunctions;




?>


	<div id='header'>
		<?= " <h1 style='text-align: center;padding:1em'>".$account->company->company_name." monthly report</h1>" ?>
		<div id='account'>
			<?= "<h2>".$account->account_name."</h2>" ?>
			<p><b>Current month trade: <?= StatsFunctions::currentMonthRevenue()." ".Yii::$app->company->company->company_currency ?> </b> </p>
			<p><b>Items sold: <?= StatsFunctions::numberOfProducts(); ?> units </b> </p>
		</div>
	</div>

    <div id='salesPerDay' style='padding:1em'>
    	<h3>1.Monthly takings</h3>
    	<?= "<img src='". $graphs['daily']."'> </img> "?>
    	<div>
    		
    		Aenean eros odio, hendrerit eu orci vitae, mollis blandit erat. Morbi sollicitudin fringilla blandit. Suspendisse tincidunt metus quis urna volutpat eleifend. Nulla porttitor libero arcu, at sodales libero hendrerit in. Aliquam risus velit, interdum in leo ac, imperdiet congue ante. Cras congue ligula augue, et facilisis diam elementum ut. Praesent sollicitudin, urna non dictum lobortis, nunc nibh dapibus nisi, vel iaculis mi ex non quam.
    	</div>

    </div>

    <div id='bestsellers' style='padding:1em'>
    	<h3>2.Products</h3>
    	<?= "<img src='". $graphs['products']."' style='width:70%'> </img> "?>
    	<div style='float: left'>
    		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur elementum, mi a cursus molestie, sem leo pellentesque tellus, et pulvinar velit justo sed justo. Nulla sed ultrices mi. Maecenas ultrices eget eros pharetra egestas. Vestibulum gravida nisi at mauris fermentum, a iaculis orci posuere. Vestibulum facilisis consectetur neque quis mattis
    	</div>
    </div>

 	<div id='clients' style='padding:1em'>
 		<h3>3.Clients</h3>
 		
 		<?= "<img src='". $graphs['clients']."'> </img> "?>
 		<div>
 			 Pellentesque commodo elit quis nisi maximus, nec placerat massa aliquam. Integer dolor nunc, suscipit ut magna eu, suscipit interdum lorem. Etiam et bibendum erat. Phasellus sollicitudin in nulla vehicula vestibulum. Duis eleifend risus turpis, vitae pellentesque felis egestas sed
 		</div>
 	</div>



    <div id= 'png'></div>

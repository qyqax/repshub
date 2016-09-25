<?php 

use common\models\StatsFunctions;

$monthName = date('F', mktime(0, 0, 0, date("m"), 10));
?>
<div id='header'>
		<?= " <h1 style='text-align: center;padding:1em'> Product sold ".$monthName."</h1>" ?>
		<div id='account'>
			<?= "<h2>".$account->account_name."</h2>" ?>
			<p><b>Current month trade: <?= StatsFunctions::currentMonthRevenue()." ".Yii::$app->company->company->company_currency ?> </b> </p>
			<p><b>Items sold: <?= StatsFunctions::numberOfProducts(); ?> units </b> </p>
		</div>
</div>
<div>
	<p>Name | Code | Price | Sold items</p>
	<?php foreach ($products as $key => $value): ?>
		<p><?=$value["name"]." | ".$value["code"]." | ".$value["price"]." ".Yii::$app->company->company->company_currency." | ".$value["sum"]." units"."\n" ?></p>
		
	<?php endforeach ?>
	
</div>
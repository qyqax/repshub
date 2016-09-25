<?php 
use backend\models\PurchaseProduct;


?>
<style>
	.item{
		margin: 1em;
	}
	.item-image{
		float:left;
		margin: 1em;

	}
	.item-details{
		float:left;
		margin: 1.5em;
	}
</style>

<?php
foreach ($products as $item) {
	$purchase_product= PurchaseProduct::find()->where(['product_id'=>$item->product_id])->andWhere(['purchase_id'=>$purchase])->one();
	?>

<div class='item'>
	<div class='item-image'>
		<div class="col-md-4">
			<?php echo '<img src="http://localhost/repshub/common/images/'.$item->product_image.'" class="img-rounded" style="max-height:100px;" />' ?>
		</div>
	</div>
	<div class='item-details' >
		<div >
			<p><b>Product Name: </b> <?= $item->product_name?></p>
		</div>
		<div >
			<p><b>Product Code: </b><?= $item->product_code?></p>
		</div>
		<div>
			<p><b>Product Price: </b><?= $item->product_price." ".Yii::$app->company->company->company_currency?> </p>
		</div>		
	</div>
	<div class='item-details' >
		<div >
			<p><b>Quantity: </b> <?= $purchase_product->quantity ?></p>
		</div>
		<div >
			<p><b>Discount: </b><?php echo empty($purchase_product->discount) ? "-" : $purchase_product->discount." ".$purchase_product->discount_type ?></p>
		</div>
		<div>
			<p><b>Amount: </b><?= number_format($purchase_product->total_amount,2)." ".Yii::$app->company->company->company_currency?></p>
		</div>		
	</div>
	<div style='clear:both'></div>
	

</div>

<?php }


?>
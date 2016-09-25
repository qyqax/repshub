<?php
use backend\models\Purchases;
use backend\models\Products;
?>

<div id='header'>
		<?= " <h1 style='text-align: center;padding:1em'>".$account->account_name.". Purchases realized.</h1>" ?>	
</div>

<div>

	<?php
		foreach ($purchases as $key => $value) {
			$purchase= Purchases::findOne(['purchase_id'=>$value["purchase_id"]]);
			echo "<p>".++$key.". ";
			echo in_array('client_name',$model->items) ? $purchase->client->client_name." " :  " ";
			echo in_array('client_email',$model->items) ? $purchase->client->client_email." " :  " ";
			echo in_array('total_amount',$model->items) ? $purchase->sum." Euro " :  " ";
			echo in_array('discount',$model->items) ? $purchase->discount." " :  " ";	
			echo in_array('status',$model->items) ? $purchase->purchaseStatuses->status." " :  " ";
			if(in_array('products_list',$model->items)){
				$products = $purchase->purchaseProducts;
				echo "<p style='margin-left:1em'>Products: </p>";
				foreach ($products as $key => $value) {

					echo "<p style='margin-left:1em'>Product name:".$value->product->product_name." Price ".$value->product->product_price." Quantity: ".$value->quantity." Discount ";
					echo empty($value->discount) ? "-" : $value->discount;
					echo " Total amount: ".$value->total_amount."</p>";
				}
			}
		}
	?>

</div>
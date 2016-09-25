<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

class Order extends \yii\base\Model
{
	public $id;
	public $product_id;
	public $quantity;
	public $purchase_id;
	public $total_amount;

}
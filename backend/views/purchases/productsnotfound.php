<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>
<div>
	
	<h1>Upss it seems that there is no single product...</h1>
	 <?= Html::a(Yii::t('app', 'Create Product'), ['products/create'], ['class' => 'btn btn-success']) ?>
</div>
<?php

namespace backend\models;

use Yii;

class PurchaseExport extends Reports{

	
	public $is_delivery;
	public $is_purchase;
	public $is_contact;

	public function rules()
    {
        return [
                   ['items','required','when'=> function ($model) {
                     return $model->items==NULL;
                 }],
            [['date_range'], 'required'],
                   [['title'], 'string', 'max' => 50] ,
                   [['is_contact','is_delivery','is_purchase'],'number']
            ];
    }


    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Export title'),
            'start_date' => Yii::t('app', 'Export From'),
            'end_date' => Yii::t('app', 'Export To'),
            'items' => Yii::t('app', 'Select Export Elements'),
            'is_delivery' => Yii::t('app', 'Delivery'),
            'is_purchase' => Yii::t('app', 'Purchase'),
            'is_contact' => Yii::t('app', 'Contact'),
            
            
        ];
    }
}
<?php

namespace backend\models;

use Yii;

class PurchaseExportCSV extends CSV{

    public $is_delivery;
    public $is_purchase;
    public $is_contact;
    public $date_range;
    public $file_name;

	
    public $items =
        [
        'client_email'=>['content' => 'Client Email'],
        'total_amount'=>['content' => 'Total amount'],
        'discount'=>['content' => 'Discount'],
        'status'=>['content' => 'Purchase status'],
        
        ];	

    public function rules()
    {
        return [
                   ['items','required','when'=> function ($model) {
                     return $model->items==NULL;
                 }],
            [['date_range','columns','delimiter','file_name'], 'required'],
                   [['title'], 'string', 'max' => 50] ,
                   [['is_contact','is_delivery','is_purchase'],'number']
            ];
    }

    public function attributeLabels()
    {
        return [
            'csv_file' => Yii::t('app', 'Choose CSV File'),            
        ];
    }

}
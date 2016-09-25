<?php

namespace backend\models;

use Yii;

class CSV extends yii\base\Model{
	public $csv_file;
    public $delimiter;
    public $columns;
   
	public function rules()
    {
        return [
            [['csv_file','delimiter','columns'], 'required'],
            [['delimiter'],'string'],
            [['csv_file'], 'file'] 
            ];
    }

    public function attributeLabels()
    {
        return [
            'csv_file' => Yii::t('app', 'Choose CSV File'),            
        ];
    }

}
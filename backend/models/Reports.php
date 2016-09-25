<?php

namespace backend\models;

use Yii;

class Reports extends yii\base\Model{


	public $title;
	public $date_range;
    public $add_comparision;

	public $items = [];

	public function rules()
    {
        return [
                   ['items','required','when'=> function ($model) {
                     return $model->items==NULL;
                 }],
            [['title','date_range','add_comparision'], 'required'],
                   [['title'], 'string', 'max' => 50] ,
            ];
    }


    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Report title'),
            'start_date' => Yii::t('app', 'Report From'),
            'end_date' => Yii::t('app', 'Report To'),
            'items' => Yii::t('app', 'Report Elements'),
            
        ];
    }
}
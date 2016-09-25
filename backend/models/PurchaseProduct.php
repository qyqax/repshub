<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_product".
 *
 * @property string $product_id
 * @property string $purchase_id
 * @property integer $quantity
 * @property double $total_amount
 *
 * @property Products $product
 * @property Purchases $purchase
 */
class PurchaseProduct extends \yii\db\ActiveRecord
{
    public $id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'quantity'], 'required'],
            [['quantity'], 'integer' , 'min' => 1],
            [['send_alert'],'integer'],
            [['total_amount'], 'number'],

            [['product_id', 'purchase_id','discount_type'], 'string', 'max' => 50],
            [['discount'], 'integer', 'min'=>0,'max'=>100,'when' => function ($model) {
                                     
                    return $model->discount_type == "%";
                },'whenClient' => "function (attribute, value) {
                     var type_id = attribute.id+'_type';
                   
                   return $('#'+type_id).val() == '%';
                    }"
                ],
                [['discount'], 'number', 'min'=>0,'when' => function ($model) {
                         
                    return $model->discount_type != "%";
                },'whenClient' => "function (attribute, value) {
                    
                    var type_id = attribute.id+'_type';
                   
                    return $('#'+type_id).val() != '%';
                    }"
                ],
                [['discount_type'], 'required','when' => function ($model) {
                    return !empty($model->discount);
                },'whenClient' => "function (attribute, value) {
                  
                    return $('#'+attribute.id).value;
                    }"
                ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => Yii::t('app', 'Product Name'),
            'purchase_id' => Yii::t('app', 'Purchase'),
            'quantity' => Yii::t('app', 'Quantity'),
            'total_amount' => Yii::t('app', 'Total Amount'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Products::className(), ['product_id' => 'product_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchases::className(), ['purchase_id' => 'purchase_id']);
    }
}

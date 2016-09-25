<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_statuses".
 *
 * @property string $purchase_id
 * @property string $status
 * @property string $status_date
 *
 * @property Purchases $purchase
 */
class PurchaseStatuses extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchase_statuses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'status', 'status_date'], 'required'],
            [['status'], 'string'],
            [['status_date'], 'safe'],
            [['purchase_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchase_id' => Yii::t('app', 'Purchase ID'),
            'status' => Yii::t('app', 'Status'),
            'status_date' => Yii::t('app', 'Status Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchase()
    {
        return $this->hasOne(Purchases::className(), ['purchase_id' => 'purchase_id']);
    }
}

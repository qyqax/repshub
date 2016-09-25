<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "client_attributes".
 *
 * @property string $id
 * @property string $client_id
 * @property string $attribute_id
 * @property integer $option_id
 * @property string $attribute_value
 *
 * @property Attributes $attribute
 * @property Clients $client
 * @property DropdownOptions $option
 */
class ClientAttributes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'client_attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attribute_id'], 'required'],
            
            [[ 'client_id', 'attribute_id','option_id'], 'string', 'max' => 50],
            [['attribute_value'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
         
            'client_id' => Yii::t('app', 'Client ID'),
            'attribute_id' => Yii::t('app', 'Attribute ID'),
            'option_id' => Yii::t('app', 'Option ID'),
            'attribute_value' => Yii::t('app', 'Attribute Value'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOneAttribute()
    {
        return $this->hasOne(Attributes::className(), ['id' => 'attribute_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOption()
    {
        return $this->hasOne(DropdownOptions::className(), ['id' => 'option_id']);
    }
}

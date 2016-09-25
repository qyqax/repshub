<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dropdown_options".
 *
 * @property integer $id
 * @property string $attr_id
 * @property string $label
 *
 * @property ClientAttributes[] $clientAttributes
 * @property Attributes $attr
 */
class DropdownOptions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dropdown_options';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attr_id', 'label'], 'required'],
            [['attr_id'], 'string', 'max' => 50],
            [['label'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'attr_id' => Yii::t('app', 'Attr ID'),
            'label' => Yii::t('app', 'Label'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAttributes()
    {
        return $this->hasMany(ClientAttributes::className(), ['option_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(Attributes::className(), ['id' => 'attr_id']);
    }
}

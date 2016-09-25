<?php

namespace backend\models;
use common\models\Account;

use Yii;

/**
 * This is the model class for table "attributes".
 *
 * @property string $id
 * @property string $attribute_type
 * @property string $attribute_name
 * @property string $account_id
 * @property string $company_id
 *
 * @property Companies $company
 * @property Account $account
 * @property ClientAttributes[] $clientAttributes
 * @property DropdownOptions[] $dropdownOptions
 */
class Attributes extends \yii\db\ActiveRecord
{

    public $option_tags;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'attributes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attribute_type', 'attribute_name', 'company_id'], 'required'],
            [['attribute_type'], 'string'],
            [['id', 'account_id', 'company_id'], 'string', 'max' => 50],
            [['attribute_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'attribute_type' => Yii::t('app', 'Attribute Type'),
            'attribute_name' => Yii::t('app', 'Attribute Name'),
            'account_id' => Yii::t('app', 'Account ID'),
            'company_id' => Yii::t('app', 'Company ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientAttributes()
    {
        return $this->hasMany(ClientAttributes::className(), ['attribute_id' => 'id']);
    }

    public function setDropdownOptionTags()
    {
        $options = DropdownOptions::find()->where(['attr_id' => $this->id])->all();
        $this->option_tags = "";
        foreach($options as $opt)
        {
          $this->option_tags .= $opt->label.", ";
        }
        $this->option_tags = rtrim($this->option_tags, ", ");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDropdownOptions()
    {
        return $this->hasMany(DropdownOptions::className(), ['attr_id' => 'id']);
    }
}

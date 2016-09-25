<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property string $id
 * @property string $company_name
 * @property string $company_slug_name
 * @property string $company_legal_name
 * @property string $company_email
 * @property string $company_url
 * @property string $company_phone
 * @property string $company_address
 * @property string $company_postal_code
 * @property string $company_vat
 * @property integer $status
 * @property string $company_trial_end_time
 * @property string $company_create_time
 * @property string $company_update_time
 * @property string $company_delete_time
 *
 * @property Clients[] $clients
 * @property Users[] $users
 */
class Company extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_TRIALENDED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'company_slug_name', 'company_legal_name', 'status', 'company_create_time'], 'required'],
            [['status'], 'integer'],
            [['company_currency'], 'string', 'max' => 5],
            [['company_trial_end_time', 'company_create_time', 'company_update_time', 'company_delete_time'], 'safe'],
            [['company_name', 'company_slug_name', 'company_legal_name', 'company_email', 'company_url', 'company_phone', 'company_address', 'company_postal_code'], 'string', 'max' => 50],
            [['company_vat'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_name' => Yii::t('app', 'Company Name'),
            'company_slug_name' => Yii::t('app', 'Company Slug Name'),
            'company_legal_name' => Yii::t('app', 'Company Legal Name'),
            'company_email' => Yii::t('app', 'Company Email'),
            'company_url' => Yii::t('app', 'Company Url'),
            'company_phone' => Yii::t('app', 'Company Phone'),
            'company_address' => Yii::t('app', 'Company Address'),
            'company_postal_code' => Yii::t('app', 'Company Postal Code'),
            'company_vat' => Yii::t('app', 'Company Vat'),
            'status' => Yii::t('app', 'Company Status'),
            'company_trial_end_time' => Yii::t('app', 'Company Trial End Time'),
            'company_create_time' => Yii::t('app', 'Company Create Time'),
            'company_update_time' => Yii::t('app', 'Company Update Time'),
            'company_delete_time' => Yii::t('app', 'Company Delete Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['company_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
         return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('companies_users', ['company_id' => 'id']);
    }
    /*
    public function getCompanyProperties()
    {
        return $this->hasMany(CompanyProperties::className(), ['company_id' => 'id']);
    }
    */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['company_id' => 'id']);
    }

     /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getProducts() 
    { 
        return $this->hasMany(Products::className(), ['company_id' => 'id']);
    } 
}

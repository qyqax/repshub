<?php

namespace common\models;

use Yii;

class CompanyMinified extends \yii\db\ActiveRecord
{
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
			[['id', 'company_name', 'company_slug_name', 'company_type'], 'required'],
			[['company_type'], 'string'],
			[['id', 'owner_id', 'company_name', 'company_slug_name', 'company_color'], 'string', 'max' => 50],
			[['company_logo'], 'string', 'max' => 250],
			[['company_language'], 'string', 'max' => 5],
		];
	}

	public function getStatus() {
		switch ($this->company_status) {
			case $this::STATUS_INACTIVE:
				return Yii::t('app', 'Inactive');
				break;

			case $this::STATUS_ACTIVE:
				return Yii::t('app', 'Active');
				break;

			case $this::STATUS_TRIALENDED:
				return Yii::t('app', 'Trial ended');
				break;

			default:
				return Yii::t('app', 'Unkown status');
				break;
		}
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getActivePeopleProperties()
	{
		return $this->hasMany(ActivePeopleProperties::className(), ['company_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	 /*
	public function getAttributes()
	{
		return $this->hasMany(Attributes::className(), ['company_id' => 'id']);
	}
*/
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
	public function getOwner()
	{
		return $this->hasOne(Users::className(), ['id' => 'owner_id']);
	}

	

	/**
	 * @return \yii\db\ActiveQuery
	 */
	 public function getUsers()
    {
         return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('companies_users', ['company_id' => 'id']);
    }

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getPeoples()
	{
		return $this->hasMany(People::className(), ['company_id' => 'id']);
	}

}

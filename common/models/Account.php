<?php

namespace common\models;
use backend\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property string $account_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $account_name
 * @property string $level_id
 * @property string $company_id
 *
 * @property Companies $company
 * @property Levels $level
 * @property Attributes[] $attributes
 * @property Goals[] $goals
 * @property UserAccount[] $userAccounts
 * @property Users[] $users
 * @property UserRoles[] $userRoles
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'created_at', 'account_name', 'level_id'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['account_id', 'level_id', 'company_id'], 'string', 'max' => 50],
            [['account_name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => Yii::t('app', 'Account ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'account_name' => Yii::t('app', 'Account Name'),
            'level_id' => Yii::t('app', 'Level ID'),
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
    public function getLevel()
    {
        return $this->hasOne(Levels::className(), ['level_id' => 'level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttributes()
    {
        return $this->hasMany(Attributes::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGoals()
    {
        return $this->hasMany(Goals::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAccounts()
    {
        return $this->hasMany(UserAccount::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['id' => 'user_id'])->viaTable('user_account', ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserRoles()
    {
        return $this->hasMany(UserRoles::className(), ['account_id' => 'account_id']);
    }
}

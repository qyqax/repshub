<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "companies_users".
 *
 * @property string $company_id
 * @property string $user_id
 * @property string $user_role_id
 *
 * @property UserRoles $userRole
 * @property Companies $company
 * @property Users $user
 */
class CompaniesUsers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'user_id'], 'required'],
            [['company_id', 'user_id', 'user_role_id'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => Yii::t('app', 'Company ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_role_id' => Yii::t('app', 'User Role ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRoles::className(), ['id' => 'user_role_id']);
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

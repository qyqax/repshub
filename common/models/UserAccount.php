<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_account".
 *
 * @property string $user_id
 * @property string $account_id
 * @property string $user_role_id
 *
 * @property Account $account
 * @property UserRoles $userRole
 * @property Users $user
 */
class UserAccount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'account_id'], 'required'],
            [['user_id', 'account_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'account_id' => Yii::t('app', 'Account ID'),
            
        ];
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
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

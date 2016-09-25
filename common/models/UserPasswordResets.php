<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_password_resets".
 *
 * @property string $id
 * @property string $user_id
 * @property string $upr_old_password
 * @property string $upr_token
 * @property integer $status
 * @property string $upr_request_time
 * @property string $upr_reset_time
 *
 * @property Users $user
 */
class UserPasswordResets extends \yii\db\ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_IGNORED = 2;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_password_resets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'upr_token', 'status', 'upr_request_time'], 'required'],
            [['status'], 'integer'],
            [['upr_request_time', 'upr_reset_time'], 'safe'],
            [['id', 'user_id'], 'string', 'max' => 250],
            [['upr_old_password', 'upr_token'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'upr_old_password' => Yii::t('app', 'Upr Old Password'),
            'upr_token' => Yii::t('app', 'Upr Token'),
            'status' => Yii::t('app', 'Status'),
            'upr_request_time' => Yii::t('app', 'Upr Request Time'),
            'upr_reset_time' => Yii::t('app', 'Upr Reset Time'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}

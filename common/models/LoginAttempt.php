<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_attempts".
 *
 * @property string $id
 * @property string $user_id
 * @property string $attempt_password
 * @property integer $attempt_status
 * @property string $attempt_browser
 * @property string $attempt_ip
 * @property string $attempt_os
 * @property string $attempt_device
 * @property string $attempt_city
 * @property string $attempt_country
 * @property string $attempt_time
 *
 * @property Users $user
 */
class LoginAttempt extends \yii\db\ActiveRecord
{
    const STATUS_FAIL = 0;
    const STATUS_SUCCESS = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_attempts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['attempt_status'], 'integer'],
            [['attempt_password', 'attempt_status', 'attempt_time'], 'required'],
            [['attempt_time'], 'safe'],
            [['user_id', 'attempt_password', 'attempt_browser', 'attempt_ip', 'attempt_os', 'attempt_device', 'attempt_city', 'attempt_country'], 'string', 'max' => 250]
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
            'attempt_password' => Yii::t('app', 'Attempt Password'),
            'attempt_status' => Yii::t('app', 'Attempt Status'),
            'attempt_browser' => Yii::t('app', 'Attempt Browser'),
            'attempt_ip' => Yii::t('app', 'Attempt Ip'),
            'attempt_os' => Yii::t('app', 'Attempt Os'),
            'attempt_device' => Yii::t('app', 'Attempt Device'),
            'attempt_city' => Yii::t('app', 'Attempt City'),
            'attempt_country' => Yii::t('app', 'Attempt Country'),
            'attempt_time' => Yii::t('app', 'Attempt Time'),
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

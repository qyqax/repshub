<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "goals".
 *
 * @property integer $goal_id
 * @property string $goal_type
 * @property integer $goal_value
 * @property string $account_id
 * @property string $time_of_receive
 *
 * @property Account $account
 */


class Goals extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goals';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal_id', 'goal_type', 'goal_value', 'account_id'], 'required'],
            [['goal_value'], 'integer'],
            [['goal_type'], 'string'],
           // [['time_of_receive'], 'safe'],
            [['goal_id','account_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'goal_id' => Yii::t('app', 'Goal ID'),
            'goal_type' => Yii::t('app', 'Goal Type'),
            'goal_value' => Yii::t('app', 'Goal Value'),
            'account_id' => Yii::t('app', 'Account'),
            'time_of_receive' => Yii::t('app', 'Time Of Receive'),
            'start_date' => Yii::t('app', 'Start from'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'account_id']);
    }

    public function getReceiveTime()
    {       
        return Settings::parseDateTime($this->time_of_receive);
    }
}

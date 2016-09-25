<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "levels".
 *
 * @property string $level_id
 * @property string $name
 * @property string $company_id
 *
 * @property Account[] $accounts
 * @property Companies $company
 * @property LevelsTresholds $levelsTresholds
 */
class Levels extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'levels';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_id', 'name', 'company_id'], 'required'],
            [['level_id', 'company_id'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => Yii::t('app', 'Level'),
            'name' => Yii::t('app', 'Name'),
            'company_id' => Yii::t('app', 'Company'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccounts()
    {
        return $this->hasMany(Account::className(), ['level_id' => 'level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Companies::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevelsThresholds()
    {
        return $this->hasOne(LevelsThresholds::className(), ['level_id' => 'level_id']);
    }
}

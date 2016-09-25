<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "levels_tresholds".
 *
 * @property string $level_id
 * @property integer $threshold
 * @property integer $commision_percent
 *
 * @property Levels $level
 */
class LevelsThresholds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'levels_thresholds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_id', 'threshold', 'commision_percent'], 'required'],
            [['threshold', 'commision_percent'], 'number'],
            [['level_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level_id' => Yii::t('app', 'Level ID'),
            'threshold' => Yii::t('app', 'Threshold'),
            'commision_percent' => Yii::t('app', 'Commision Percent'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLevel()
    {
        return $this->hasOne(Levels::className(), ['level_id' => 'level_id']);
    }
}

<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "role_permissions".
 *
 * @property string $user_role_id
 * @property string $module
 * @property string $crud
 *
 * @property UserRoles $userRole
 */
class RolePermissions extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_permissions';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_role_id', 'module', 'crud'], 'required'],
            [['user_role_id', 'module'], 'string', 'max' => 250],
            [['crud'], 'string', 'max' => 4],
            [['user_role_id', 'module'], 'unique', 'targetAttribute' => ['user_role_id', 'module'], 'message' => 'The combination of User Role ID and Module has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_role_id' => Yii::t('app', 'User Role ID'),
            'module' => Yii::t('app', 'Module'),
            'crud' => Yii::t('app', 'Crud'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(UserRoles::className(), ['id' => 'user_role_id']);
    }
}

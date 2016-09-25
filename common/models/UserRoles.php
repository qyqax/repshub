<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_roles".
 *
 * @property string $id
 * @property string $user_role_name
 *
 * @property Users[] $users
 */
class UserRoles extends \yii\db\ActiveRecord
{
    public $module_clients = 0;
    public $clients_create = 0;
    public $clients_read = 0;
    public $clients_update = 0;
    public $clients_delete = 0;
    public $module_users = 0;
    public $users_create = 0;
    public $users_read = 0;
    public $users_update = 0;
    public $users_delete = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'user_role_name'], 'required'],
            [['id', 'company_id', 'user_role_name'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_role_name' => Yii::t('app', 'User Role Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['company_id' => 'id']);
    }

    public function getPermissions()
    {
        return $this->hasMany(RolePermissions::className(), ['user_role_id' => 'id']);
    }
}

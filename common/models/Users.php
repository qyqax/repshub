<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use common\models\Users;
use common\models\RolePermissions;
use backend\models\Clients;
use backend\models\Settings;

/**
 * This is the model class for table "users".
 *
 * @property string $id
 * @property string $user_name
 * @property string $user_email
 * @property string $user_password
 * @property string $user_photo
 * @property integer $status
 * @property integer $user_verified
 * @property string $user_create_time
 * @property string $user_update_time
 *
 * @property LoginAttempts[] $loginAttempts
 * @property UserPasswordResets[] $userPasswordResets
 * @property Companies[] $company
 */
class Users extends ActiveRecord  implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;
    const USER_UNVERIFIED = 0;
    const USER_VERIFIED = 1;
    public $new_password = "";
    public $user_new_photo = "";
    public $user_role_id;
 
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_name', 'user_email', 'user_password', 'status', 'user_verified', 'user_create_time'], 'required'],
            [['status', 'user_verified'], 'integer'],
            [/*['user_photo'],*/ ['user_create_time', 'user_update_time'], 'safe'],
            [['user_name', 'user_email', 'user_auth_key'], 'string', 'max' => 50],
            [['user_password', 'new_password', 'user_photo'], 'string', 'max' => 250],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['user_verified', 'default', 'value' => self::USER_UNVERIFIED],
            //[['user_photo'], 'file', 'extensions'=>'jpg, gif, png']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'user_email' => Yii::t('app', 'User Email'),
            'user_password' => Yii::t('app', 'User Password'),
            'user_photo' => Yii::t('app', 'User Photo'),
            'status' => Yii::t('app', 'Status'),
            'user_verified' => Yii::t('app', 'User Verified'),
            'user_auth_key' => Yii::t('app', 'User Authentication Key'),
            'user_create_time' => Yii::t('app', 'User Create Time'),
            'user_update_time' => Yii::t('app', 'User Update Time'),
        ];
    }

    public function getRole($cid)
    {
        $size = count($this->companies);
        
        for($i = 0; $i < $size; $i++)
        {
          if($this->companies[$i]->company_id == $cid)
          {

            return (isset($this->companies[$i]->role) ? $this->companies[$i]->role->user_role_name : '');
          }
        }
        return '';
    }

    public function getPhoto()
    {
      return($this->user_photo == '' || !isset($this->user_photo)) ? 'default.jpg' : $this->user_photo;
    }

    public function isVerified()
    {
      return ($this->user_verified == 1) ? 'Verified' : 'Pending Verification';
    }

    public function getVerifiedStatus()
    {
      return ($this->isVerified()) ? 'Verified' : 'Pending Verification';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLoginAttempts()
    {
        return $this->hasMany(LoginAttempts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPasswordResets()
    {
        return $this->hasMany(UserPasswordResets::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(CompaniesUsers::className(), ['user_id' => 'id']);
    }

    public static function isBlocked($email)
    {
      return static::findOne(['user_email' => $email, 'status' => self::STATUS_BLOCKED]);
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by id
     *
     * @param string $id
     * @return static|null
     */
    public static function findByid($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['user_username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['user_email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByAuthkey($authkey)
    {
        return static::findOne(['user_auth_key' => $authkey, 'user_verified' => self::USER_UNVERIFIED]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->user_auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->user_password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->user_password = Yii::$app->security->generatePasswordHash($password);
    }

    public function getNewPassword()
    {
       return Yii::$app->security->generatePasswordHash($this->new_password);
    }
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->user_auth_key = Yii::$app->security->generateRandomString();
    }

    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['user_id' => 'id']);
    }

    public function getPurchases()
    {
        return $this->hasMany(Purchases::className(), ['user_id' => 'id']);
    }

    public function getUserAccounts()
    {
        return $this->hasMany(UserAccount::className(), ['user_id' => 'id']);
    }

    public function getAccounts()
    {
       // return $this->hasMany(Account::className(), ['account_id' => 'account_id'])->viaTable('user_account', ['user_id' => 'id']);
        return $this->hasOne(Account::className(), ['account_id' => 'account_id'])->viaTable('user_account', ['user_id' => 'id']);
    }

    public function getSettings()
    {        
        $settings = Settings::findOne(['user_id'=>$this->id]);
                
        if(empty($settings)){
            $settings = new Settings();
            $settings->user_id = $this->id;
            $settings->save();
            return $settings;
        }else{
            return $settings;
        }

            
    }

}

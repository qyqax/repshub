<?php
namespace common\models;

use Yii;
use yii\base\Model;
/**
 * Login form
 */
class LoginForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;
    public $ip;
    public $country;
    public $city;
    private $_user = false;
    private $_company = false;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
            // checks if input is an email
            ['email', 'email'],
            [['ip', 'country', 'city'], 'string', 'max' => 250],

        ];
    }

    /**
     * Saves login attempt information.
     *
     */
    public function getLoginAttempt()
    {
            //$user = $this->getUser();
            $login_attempt = new LoginAttempt();
            //$login_attempt->user_id = $user->id;
            $login_attempt->id = GlobalFunctions::generateUniqueId();
            $login_attempt->attempt_password = $this->password;
            $login_attempt->attempt_browser = GlobalFunctions::getBrowser();
            $login_attempt->attempt_os = GlobalFunctions::getOS();
            $login_attempt->attempt_device = GlobalFunctions::getDevice();
            $login_attempt->attempt_ip = $this->ip;
            $login_attempt->attempt_city =  $this->country;
            $login_attempt->attempt_country =  $this->city;
            $login_attempt->attempt_time = date('Y-m-d H:i:s');
            return $login_attempt;
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if($user) {
                $login_attempt = $this->getLoginAttempt();
                $login_attempt->user_id = $user->id;
                if (!$user->validatePassword($this->password)) {
                    $login_attempt->attempt_status = LoginAttempt::STATUS_FAIL;
                    $login_attempt->save();
                    $this->addError("$attribute", 'Incorrect password.');
                }
                else {
                  $login_attempt->attempt_status = LoginAttempt::STATUS_SUCCESS;
                  $login_attempt->save();
                }
            } else {
                $this->addError("email", 'Incorrect email.');
            }
        }

    }

    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        $user = Users::findByEmail($this->email);
         
          if(empty($user)){
            return false;
          }
          elseif(Users::isBlocked($this->email))
          {
            if(!$this->checkTimeOut())
            {
              $this->addError("email", 'Account temporarily blocked.');
            } else {
              $this->login();
            }
        }
        else {
          
          if($this->getLoginTries())
          {
            if ($this->validate()) {
                $user = Users::findByEmail($this->email);
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            } else {
                return false;
            }
          } else {
              $this->addError("email", 'Account temporarily blocked.');
          }
        }
    }

    public function checkTimeOut()
    {
      $now = date('Y-m-d H:i:s');
      $minus = date("Y-m-d H:i:s", strtotime("-30 minutes",strtotime($now)));
      $loginfails = LoginAttempt::find()->where(['attempt_status' => 0])->andWhere(['>=', 'attempt_time', $minus])->orderBy('attempt_time')->all();
      $size = count($loginfails);
      if($size == 0)
      {
        $user = Users::isBlocked($this->email);
        $user->status = Users::STATUS_ACTIVE;
        $user->save();
        return true;
      }
      else {
        return false;
      }
    }

    public function getLoginTries()
    {
        $user = $this->getUser();
        $now = date('Y-m-d H:i:s');
        $minus = date("Y-m-d H:i:s",strtotime("-30 minutes",strtotime($now)));
        $loginsuccesses = LoginAttempt::find()->where(['attempt_status' => 1])->andWhere(['>=', 'attempt_time', $minus])->orderBy('attempt_time')->all();
        $size = count($loginsuccesses);
        if($size > 0 )
        {
            $minus = date("Y-m-d H:i:s",strtotime($loginsuccesses[0]->attempt_time));
        }
        $logintries = LoginAttempt::find()->where(['user_id' => $user->id ,'attempt_status' => 0])->andWhere(['>=', 'attempt_time', $minus])->all();
        $sizefails = count($logintries);
        if($sizefails >= 5)
        {
          $user->status = Users::STATUS_BLOCKED;
          $user->save();
          return false;
        }
        return true;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::findByEmail($this->email);
        }
        return $this->_user;
    }
}

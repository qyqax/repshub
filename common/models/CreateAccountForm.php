<?php
namespace common\models;

use yii\base\Model;
use Yii;
use backend\models\Levels;

/**
 * Signup form
 */
class CreateAccountForm extends Model
{
    //public $company_name;
   // public $company_legal_name;
    public $user_name;
    public $user_email;
    public $user_password;
    public $repeat_user_email;
    public $repeat_user_password;

    public $company_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [/*
            ['company_name', 'filter', 'filter' => 'trim'],
            ['company_name', 'required'],
            ['company_name', 'string', 'min' => 2, 'max' => 50],

            ['company_legal_name', 'filter', 'filter' => 'trim'],
            ['company_legal_name', 'required'],
            ['company_legal_name', 'string', 'min' => 2, 'max' => 50],
*/
           
            ['company_id', 'filter', 'filter' => 'trim'],
            ['company_id', 'required'],
            ['company_id', 'string', 'min' => 2, 'max' => 50],

            ['user_name', 'filter', 'filter' => 'trim'],
            ['user_name', 'required'],
            ['user_name', 'string', 'min' => 2, 'max' => 50],

            ['user_email', 'filter', 'filter' => 'trim'],
            ['user_email', 'required'],
            ['user_email', 'email'],
            [['user_email'], 'string', 'max' => 250],
            ['user_email', 'unique', 'targetClass' => '\common\models\Users', 'message' => 'This email address has already been taken.'],

            ['repeat_user_email', 'filter', 'filter' => 'trim'],
            ['repeat_user_email', 'required'],
            ['repeat_user_email', 'email'],
            ['repeat_user_email', 'compare', 'compareAttribute'=>'user_email', 'message'=>"Emails don't match"],

            ['user_password', 'required'],
            ['user_password', 'string', 'min' => 6],

            ['repeat_user_password', 'required'],
            ['repeat_user_password', 'compare', 'compareAttribute'=>'user_password', 'message'=>"Passwords don't match"],
            ['repeat_user_password', 'string', 'min' => 6]

        ];
    }
/*
    public function createCompany()
    {
      $company = new Company();
      $company->id = GlobalFunctions::generateUniqueId();
      $company->company_name = $this->company_name;
      $company->company_slug_name = GlobalFunctions::slugify($this->company_name);
      $company->company_legal_name = $this->company_legal_name;
      $company->status = Company::STATUS_ACTIVE;
      $company->company_create_time = date('Y-m-d H:i:s');
      return $company;
    }
*/
    public function createAccount()
    {
      $account = new Account();
      $account->account_id = GlobalFunctions::generateUniqueId();
      $account->created_at = date('Y-m-d H:i:s');
      $account->account_name = $this->user_name;
      $account->level_id = GlobalFunctions::getLevel();
      //var_dump($account->level_id);die;
      $account->company_id=$this->company_id;
      return $account;
    }

    public function createUser()
    {
      $user = new Users();
      $user->id = GlobalFunctions::generateUniqueId();
      $user->user_name = $this->user_name;
      $user->user_email = $this->user_email;
      $user->setPassword($this->user_password);
      $user->status = Users::STATUS_ACTIVE;
      $user->user_verified = 0;
      $user->user_create_time = date('Y-m-d H:i:s');
      $user->generateAuthKey();
      return $user;
    }

    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
          if ($this->validate()) {
              $account = $this->createAccount();
              if ($account->save()) {
                $user = $this->createUser();
                //$company->owner_id = $user->id;
                if ($user->save()) {
                    $relation = new UserAccount();
                    $relation->account_id = $account->account_id;
                    $relation->user_id = $user->id;
                    $relation2 = new CompaniesUsers();
                    $relation2->company_id = $account->company_id;
                    $relation2->user_id = $user->id;
                    if($relation->save()&&$relation2->save())
                    {
                      if($account->save())
                      {
                        $authUrl="http://localhost/repshub/backend/web/site/authenticate?email=".$user->user_email."&authkey=".$user->user_auth_key;
                        //Mailer::sendSignupEmail($user, $authUrl);
                        return $user;
                      }
                      else {
                        $relation->delete();
                        $relation2->delete();
                        $account->delete();
                        $user->delete();
                        $this->addError($attribute, 'There was an error while processing your data');
                      }
                    } else {
                      $account->delete();
                      $this->addError($attribute, 'There was an error while processing your data');
                    }
                } else {
                  $account->delete();
                  $this->addError($attribute, 'There was an error while processing your data');
                }
            } else {
              $account->delete();
              $this->addError($attribute, 'There was an error while processing your data');
            }
          }

        return null;
    }
}

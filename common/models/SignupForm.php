<?php
namespace common\models;

use yii\base\Model;
use Yii;
use backend\models\Levels;
use backend\models\LevelsThresholds;
use common\models\UserRoles;
use common\models\RolePermissions;
use backend\models\Categories;
/**
 * Signup form
 */
class SignupForm extends Model
{
    public $company_name;
    public $company_legal_name;    
    public $user_name;
    public $user_email;
    public $user_password;
    public $repeat_user_email;
    public $repeat_user_password;
    public $user_auth_key;
    /****/

    public $company_type;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['company_name', 'filter', 'filter' => 'trim'],
            ['company_name', 'required'],
            ['company_name', 'string', 'min' => 2, 'max' => 50],

            ['company_legal_name', 'filter', 'filter' => 'trim'],
            ['company_legal_name', 'required'],
            ['company_legal_name', 'string', 'min' => 2, 'max' => 50],

   
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


    public function createLevels($company_id)
    {
      $threshold_sum = 0;
      $commision_percent =5;
      for ($i=1; $i <= 3 ; $i++,$threshold_sum+=1000,$commision_percent+=3) { 
     
        $level = new Levels();
        $level->level_id = GlobalFunctions::generateUniqueId();
        $level->name = "Level ".$i;
        $level->company_id = $company_id;
        $level->save();
        $threshold = new levelsThresholds();
        $threshold->level_id = $level->level_id;
        $threshold->threshold = $threshold_sum;
        $threshold->commision_percent = $commision_percent;
        $threshold->save();
      }
    }

    public function createRoles($company_id)
    {
      $user_role = new UserRoles();
      $user_role->id = GlobalFunctions::generateUniqueId();
      $user_role->company_id = $company_id;
      $user_role->user_role_name = 'Resseler';
      $user_role->save();

      $role_perm = new RolePermissions();
      $role_perm->user_role_id = $user_role->id;
      $role_perm->module ='clients';
      $role_perm->crud = '1111';
      $role_perm->save();

    }

    public function createCategories($company_id)
    {
      $category = new Categories();
      $category->category_id = GlobalFunctions::generateUniqueId();
      $category->category_name = 'Products';
      $category->parent_id = NULL;
      $category->company_id = $company_id;
      $category->save();
    }


    
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

          if ($this->validate()) {
              $company = $this->createCompany();
              
              if ($company->save()) {
                $company_id = $company->id;
                $this->createLevels($company_id);
                $this->createRoles($company_id);
                $this->createCategories($company_id);
                $user = $this->createUser();
                $company->owner_id = $user->id;
                if ($user->save()) {
                    $relation = new CompaniesUsers();
                    $relation->company_id = $company->id;
                    $relation->user_id = $user->id;
                    if($relation->save())
                    {
                      if($company->save())
                      {
                       
                        $this->user_auth_key = $user->user_auth_key;
                        // $authUrl="http://localhost/repshub/backend/web/site/authenticate?email=".$user->user_email."&authkey=".$user->user_auth_key;
                        // Mailer::sendSignupEmail($user, $authUrl);
                        return $user;
                      }
                      else {
                        $relation->delete();
                        $company->delete();
                        $user->delete();
                        $this->addError($attribute, 'There was an error while processing your data');
                      }
                    } else {
                      $company->delete();
                      $this->addError($attribute, 'There was an error while processing your data');
                    }
                } else {
                  $company->delete();
                  $this->addError($attribute, 'There was an error while processing your data');
                }
            } else {
             
              $company->delete();
              $this->addError($attribute, 'There was an error while processing your data');
            }
          }

        return null;
    }
}

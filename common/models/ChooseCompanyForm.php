<?php
namespace common\models;

use Yii;
use yii\base\Model;
/**
 * Login form
 */
class ChooseCompanyForm extends Model
{
    public $company_id;
    public $companies;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id'], 'required'],

        ];
    }

    public function getUserCompanies()
    {
      $this->companies = CompaniesUsers::find()->where(['user_id' => Yii::$app->user->identity->id])->joinWith('company')->all();
    }
    /**
     * Logs in a user using the provided email and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function chooseCompany()
    {
      Yii::$app->session['companies'] = count($this->companies);
      $relation = CompaniesUsers::find()->where(['company_id' => $this->company_id, 'user_id' => Yii::$app->user->identity->id])->one();
      Yii::$app->company->setCompany($this->company_id);
      Yii::$app->role->setRole($relation->user_role_id);
      return true;
    }
}

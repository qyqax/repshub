<?php

namespace common\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use common\models\Users;
use common\models\RolePermissions;
use common\models\UserRoles;
use common\models\CompaniesUsers;

class RoleComponent extends Component
{
  private $rolepermissions;

  public function setRole($id)
  {
    Yii::$app->session['role'] = UserRoles::find()->where(['id' => $id, 'company_id' => Yii::$app->session['companyID']])->joinWith('permissions')->one();
    if(isset(Yii::$app->session['companyID']))
    {
      $this->rolepermissions = array();
      if(Yii::$app->session['role'])
      {
        $size = count(Yii::$app->session['role']->permissions);
        for($i = 0; $i < $size; $i++)
        {
          $this->rolepermissions[Yii::$app->session['role']->permissions[$i]->attributes['module']] = Yii::$app->session['role']->permissions[$i]->attributes['crud'];
        }
        Yii::$app->session['permissions'] = $this->rolepermissions;
      }
    } else {
      Yii::$app->session['permissions'] = null;
    }
    if(Yii::$app->company->isCompanyOwner())
    {
      Yii::$app->session['isOwner'] = true;
    } else {
      Yii::$app->session['isOwner'] = false;
    }
  }

  public function getPermissions()
  {
    if(isset(Yii::$app->session['permissions']))
    {
      return Yii::$app->session['permissions'];
    } else {
      return null;
    }

  }

  public function isOwner()
  {
    if(isset(Yii::$app->session['isOwner']))
    {
      return Yii::$app->session['isOwner'];
    } else {
      return false;
    }
  }

  public function hasModule($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return true;
      }
      if(isset(Yii::$app->session['permissions'][$module]))
      {
        return true;
      } else {
        return false;
      }
  }

  public function getModuleQuickActions($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return '{view}{update}{delete}';
      }
      $columntemplate = "";
      if($this->canRead($module))
      {
        $columntemplate .= "{view}";
      }
      if($this->canUpdate($module))
      {
        $columntemplate .= "{update}";
      }
      if($this->canDelete($module))
      {
        $columntemplate .= "{delete}";
      }
      return $columntemplate;
  }

  public function canCreate($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return true;
      }
      if(isset(Yii::$app->session['permissions'][$module]))
      {
        return (Yii::$app->session['permissions'][$module][0] == 1 ? true : false);
      } else {
        return false;
      }
  }

  public function canRead($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return true;
      }
      if(isset(Yii::$app->session['permissions'][$module]))
      {
        return (Yii::$app->session['permissions'][$module][1] == 1 ? true : false);
      } else {
        return false;
      }
  }

  public function canUpdate($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return true;
      }
      if(isset(Yii::$app->session['permissions'][$module]))
      {
        return (Yii::$app->session['permissions'][$module][2] == 1 ? true : false);
      } else {
        return false;
      }
  }

  public function canDelete($module)
  {
      if(Yii::$app->session['isOwner'])
      {
        return true;
      }
      if(isset(Yii::$app->session['permissions'][$module]))
      {
        return (Yii::$app->session['permissions'][$module][3] == 1 ? true : false);
      } else {
        return false;
      }
  }
}

?>

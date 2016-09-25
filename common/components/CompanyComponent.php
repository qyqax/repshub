<?php

namespace common\components;

use common\models\CompanyMinified;
use Yii;
use yii\base\Component;

class CompanyComponent extends Component
{
    public function setCompany($id)
    {
        Yii::$app->session['companyID'] = $id;
        Yii::$app->session['company'] = CompanyMinified::findOne(['id' => Yii::$app->session['companyID']]);
    }

    public function getCompanyID()
    {
        if (isset(Yii::$app->session['companyID'])) {
            return Yii::$app->session['companyID'];
        } else {
            return null;
        }
    }

    public function getCompany()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company'];
        } else {
            return null;
        }
    }

    public function getCompanyLogo()
    {
        if (is_readable(Yii::$app->params['uploadPath'] . Yii::$app->session['company']->company_logo_cropped)
            && is_file(Yii::$app->params['uploadPath'] . Yii::$app->session['company']->company_logo_cropped)
        ) {
            return Yii::$app->params['uploadUrl'] . Yii::$app->session['company']->company_logo_cropped;
        }

        return Yii::$app->params['assetImages'] . 'default_company.png';
    }

    public function hasChosen()
    {
        return isset(Yii::$app->session['companyID']);
    }

    public function getCompanyName()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company']->company_name;
        } else {
            return null;
        }
    }

    public function getCompanySlug()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company']->company_slug_name;
        } else {
            return null;
        }
    }

    public function getCompanyLanguage()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company']->company_language;
        } else {
            return 'en-en';
        }
    }

    public function getCompanyCreateDate($format)
    {
        if (isset(Yii::$app->session['company'])) {
            return date($format, strtotime(Yii::$app->session['company']->company_create_time));
        } else {
            return null;
        }
    }

    public function getCompanyType()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company']->company_type;
        } else {
            return null;
        }
    }

    public function getCompanyOwner()
    {
        if (isset(Yii::$app->session['company'])) {
            return Yii::$app->session['company']->owner_id;
        } else {
            return null;
        }
    }

    public function isCompanyOwner()
    {
        if (isset(Yii::$app->session['company'])) {
            return $this->getCompanyOwner() == Yii::$app->user->identity->id;
        } else {
            return false;
        }
    }
}
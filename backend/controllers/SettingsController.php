<?php

namespace backend\controllers;
use common\models\Users;
use Yii;
use yii\helpers\Html;
use backend\models\ChangePasswordForm;
use backend\models\Attributes;
use backend\models\Settings;

class SettingsController extends \yii\web\Controller
{
    // public function actionIndex()
    // {
    //     return $this->render('index');
    // }

    public function actionAccount()
    {
    		$user_id = Yii::$app->user->id;
	    	$model = Users::findOne($user_id);
	       
            $settings = Settings::findOne(['user_id'=>$model->id]);
       
	    
    	if ($model->load(Yii::$app->request->post())  && $settings->load(Yii::$app->request->post()) && $settings->save() ) {
          
	   		 
             $account = $model->accounts;
	   		
	   		 $model->save();
	   		 $account->account_name = $model->user_name;
	   		 $account->save();



	   		 Yii::$app->getSession()->setFlash('success', [
                                            'type' => 'success',
                                            'duration' => 12000,
                                            'icon' => 'fa fa-thumbs-up',
                                            'message' => Yii::t('app',Html::encode('Account has been updated correctly.')),
                                            'title' => Yii::t('app', Html::encode('Good job !')),
                                            'positonY' => 'top',
                                            'positonX' => 'right'
                                        ]);

	        return $this->redirect(['/myaccount']);
	    }else{
	    	return $this->render('account',['model'=>$model,'settings'=>$settings]);	
	    }
	}

    public function actionPassword()    
    {	
    	$user = Users::findOne(Yii::$app->user->id);
    	$model = new ChangePasswordForm;
    	if ($model->load(Yii::$app->request->post())) {

    		$user->setPassword($model->newpass);
    		$user->save();

    		 Yii::$app->getSession()->setFlash('success', [
                                            'type' => 'success',
                                            'duration' => 12000,
                                            'icon' => 'fa fa-thumbs-up',
                                            'message' => Yii::t('app',Html::encode('Password has been changed correctly.')),
                                            'title' => Yii::t('app', Html::encode('Good job !')),
                                            'positonY' => 'top',
                                            'positonX' => 'right'
                                        ]);

    		 return $this->redirect(['/myaccount']);
    	}else{
    			return $this->render('password',['model'=>$model,'user'=>$user]);	
    	}
    }

    public function actionClients()    
    {
    	return $this->redirect(['/attributes']);
    }

}

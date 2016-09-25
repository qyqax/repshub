<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UserPasswordResets;
use common\models\UserPasswordResetsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use sendwithus\API;

/**
 * ResetController implements the CRUD actions for UserPasswordResets model.
 */
class ResetController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all UserPasswordResets models.
     * @return mixed
     */
    public function actionIndex($id, $token)
    {
        $request = $this->findModel($id, $token);
        $model = Users::findById($request->user_id);
        $oldpassword = $model->user_password;
        if ($model->load(Yii::$app->request->post())) {
            $model->user_password = $model->getNewPassword();
            $model->user_update_time = date('Y-m-d H:i:s');
            if($model->status != Users::STATUS_INACTIVE)
            {
              $model->status = Users::STATUS_ACTIVE;
            }
            if($model->save())
            {
              $request->upr_old_password = $oldpassword;
              $request->status = UserPasswordResets::STATUS_INACTIVE;
              $request->upr_reset_time = date('Y-m-d H:i:s');
              if($request->save())
              {
                //sendPasswordChangedEmail();
                return $this->redirect(\Yii::$app->urlManager->createUrl("site/login"));
              }
              else {
                $model->password = $oldpassword;
                if($model->save())
                {
                  return $this->redirect(\Yii::$app->urlManager->createUrl("site/error"));
                }
                return $this->redirect(\Yii::$app->urlManager->createUrl("site/error"));
              }
            }
            else {
              return $this->redirect(\Yii::$app->urlManager->createUrl("site/error"));
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionIgnore($id, $token)
    {
        $request = $this->findModel($id, $token);
        $request->status = UserPasswordResets::STATUS_IGNORED;
        $request->upr_reset_time = date('Y-m-d H:i:s');
        if($request->save())
        {
          return $this->redirect(\Yii::$app->urlManager->createUrl("site"));
        }
        else {
          return $this->redirect(\Yii::$app->urlManager->createUrl("site/error"));
        }
    }
    /**
     * Finds the UserPasswordResets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserPasswordResets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $token)
    {
        if (($model = UserPasswordResets::find()->where(['id' => $id, 'upr_token' => $token, 'status' => UserPasswordResets::STATUS_ACTIVE])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

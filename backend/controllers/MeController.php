<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UsersSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;

/**
 * MeController implements the Read and Update actions for Users model for the user that is logged in.
 */
class MeController extends Controller
{
    public function behaviors()
    {
        if(!isset(Yii::$app->user->identity->id))
        {
          $this->redirect(\Yii::$app->urlManager->createUrl("site/index"));
        }
        if(isset(Yii::$app->user->identity) && !Yii::$app->user->identity->isVerified())
        {
          $this->redirect(\Yii::$app->urlManager->createUrl("site/verification"));
        }
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
     * Displays the logged in User's model.
     * @return mixed
     */

    public function actionIndex()
    {
        return $this->render('view', [
            'model' => $this->findMe(),
        ]);
    }

    /**
     * Updates the logged in User's model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionUpdate()
    {
        $model = $this->findMe();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
              $file = UploadedFile::getInstance($model, 'user_new_photo');
              if(is_object($file))
              {
                $images_path = $_SERVER['DOCUMENT_ROOT'].'repshub/common/images/';
                $model->user_photo = $file->name;
                $model->save();
                $file->saveAs($images_path.'/'.$file->name);
              }
              return $this->render('view', [
                  'model' => $model,
              ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the logged in User's model.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findMe()
    {
        if (($model = Users::find()->where(['users.id' => Yii::$app->user->identity->id, 'status' => Users::STATUS_ACTIVE])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

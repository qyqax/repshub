<?php

namespace backend\controllers;

use Yii;
use common\models\Company;
use backend\models\CompanySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
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
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        return  $this->actionView(Yii::$app->company->getCompanyID());
    }

    /**
     * Displays a single Company model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);

    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(Yii::$app->role->isOwner()){
          $model = $this->findModel($id);
          if ($model->load(Yii::$app->request->post()) && $model->save()) {
              return $this->redirect(['view', 'id' => $model->id]);
          } else {
              return $this->render('update', [
                  'model' => $model,
              ]);
          }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->role->isOwner()){
          $model = $this->findModel($id);
          $model->status = Company::STATUS_INACTIVE;
          $model->company_delete_time = date('Y-m-d H:i:s');
          $model->save();

          return $this->redirect(['index']);

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne(['id' => $id, 'status' => Company::STATUS_ACTIVE])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace backend\controllers;

use Yii;
use backend\models\Levels;
use backend\models\LevelsThresholds;
use backend\models\LevelsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;

/**
 * LevelsController implements the CRUD actions for Levels model.
 */
class LevelsController extends Controller
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
     * Lists all Levels models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LevelsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->company->getCompanyID());

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }

    /**
     * Displays a single Levels model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $threshold = $model->levelsThresholds;
        
        return $this->render('view', [
            'model' => $model,
            'threshold' => $threshold,
        
        ]);
    }

    /**
     * Creates a new Levels model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Levels();
        $threshold = new LevelsThresholds();

        if ($model->load(Yii::$app->request->post()) && $threshold->load(Yii::$app->request->post())) {

            $model->level_id = GlobalFunctions::generateUniqueId();
            $model->company_id= Yii::$app->company->getCompanyID();
             if($model->save())
             {
                $threshold->level_id = $model->level_id;
                $threshold->save();
             }
             else {
                return $this->render('create', [
                'model' => $model,
                'threshold' =>$threshold,
            ]);}
            return $this->redirect(['view', 'id' => $model->level_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                 'threshold' =>$threshold,
            ]);
        }
    }

    /**
     * Updates an existing Levels model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $threshold = $model->levelsThresholds;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->level_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'threshold' => $threshold,
            ]);
        }
    }

    /**
     * Deletes an existing Levels model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Levels model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Levels the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Levels::find()->where(['level_id'=>$id,'company_id'=>Yii::$app->company->getCompanyID()])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

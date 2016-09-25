<?php

namespace backend\controllers;

use Yii;
use backend\models\Goals;
use backend\models\GoalsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\GlobalFunctions;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\StatsFunctions;

/**
 * GoalsController implements the CRUD actions for Goals model.
 */
class GoalsController extends Controller
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
     * Lists all Goals models.
     * @return mixed
     */
    public function actionIndex2()
    {
        $searchModel = new GoalsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
     public function actionIndex()
    {

        $account_id= Yii::$app->user->identity->accounts->account_id;
        $daily_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'daily'])->one();
        $weekly_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'weekly'])->one();
        $monthly_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'monthly'])->one();
        $user_id = Yii::$app->user->id;
        if(isset($_POST['Goals'])){
           
            
            $id= $_POST['Goals']['goal_id'];
            $goal = Goals::findOne($id);

            $out = Json::encode(['output'=>'','message'=>'']);
            $post = [];
            $posted = current($_POST['Goals']);
            $post['Goals'] = $posted;
            if($goal->load($post))
            {
                $goal->goal_value = $_POST['Goals']['goal_value'];
                $amount=0;
                switch($goal->goal_type){
                    case 'daily':
                    $amount=StatsFunctions::currentDayRevenue();
                    break;
                    case 'monthly':
                    $amount = StatsFunctions::currentWeekRevenue();
                    break;
                    case 'weekly':
                    $amount = StatsFunctions::currentMonthRevenue();
                    break;
                    default:break;
                }

                if($goal->goal_value <= $amount){
                    $goal->time_of_receive = date('Y-m-d H:i:s');;
                }else{
                    $goal->time_of_receive = NULL;
                }
                
                $goal->save();
                $output = $goal->goal_value;
                $out = Json::encode(['output'=>$output,'message'=>'']);
            }
           // echo $out;
            
            $daily_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'daily'])->one();
            $weekly_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'weekly'])->one();
            $monthly_value = Goals::find()->where(['account_id'=>$account_id])->andWhere(['goal_type'=>'monthly'])->one();
            
            return $this->render('index2', [
            'daily_value' => $daily_value,
            'weekly_value' => $weekly_value,
            'monthly_value' => $monthly_value,
            'user_id' => $user_id,
        ]);
;
        }

        return $this->render('index2', [
            'daily_value' => $daily_value,
            'weekly_value' => $weekly_value,
            'monthly_value' => $monthly_value,
            'user_id' => $user_id,
        ]);

    }

    /**
     * Displays a single Goals model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goals model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goals();

        if ($model->load(Yii::$app->request->post())) {
           //if goal exist update otherwise create new
            $goal = Goals::Find()->where(['account_id'=>Yii::$app->user->identity->accounts->account_id])->andWhere(['goal_type'=>$model->goal_type])->one();
            //var_dump($goal);die;
           $flag=0;
           if(!empty($goal))
           {
            $goal->goal_value = $model->goal_value;
            $goal->time_of_receive = NULL;
            $flag=$goal->save();
           }
           else
           {
            $model->goal_id = GlobalFunctions::generateUniqueId();
            $model->account_id = Yii::$app->user->identity->accounts->account_id;
            $flag=$model->save();
           }
            
            
            //$model->time_of_receive = NULL;

            if($flag){

            return $this->redirect(['view', 'id' => empty($model->goal_id) ? $goal->goal_id : $model->goal_id ]);
        }else{
            // var_dump($model->validate());die;
            return $this->render('create', [
                'model' => $model,
            ]);
        }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Goals model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->goal_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Goals model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goals model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goals the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goals::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

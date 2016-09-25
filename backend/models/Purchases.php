<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
use common\models\Users;
use common\models\GlobalFunctions;
use yii\helpers\Html;
use common\models\StatsFunctions;


/**
 * This is the model class for table "purchases".
 *
 * @property string $purchase_id
 * @property string $client_id
 * @property integer $discount
 * @property string $brochure_id
 * @property integer $total_amount
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $user_id
 *
 * @property PurchaseProduct[] $purchaseProducts
 * @property Brochures $brochure
 * @property Clients $client
 * @property Users $user
 */
class Purchases extends \yii\db\ActiveRecord
{

    const EVENT_NEW_PURCHASE = 'new-purchase';

    public $products = [];

    public $client_name;
    public $client_email;
    public $client_phone;
    public $client_country;
    public $client_city;
    public $client_address;
    public $client_postal_code;
    public $NIF;
    public $card_id_number;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'sum', 'created_at'], 'required'],
            [['client_name','client_address','client_city','client_country',
            'client_phone','client_email','client_postal_code','NIF','card_id_number'],
            'required','when' => function ($model) {
                    return $model->client_id == '';
                }, 'whenClient' => "function (attribute, value) {
                    return $('#find-client').val() == '';
                }"],

            [['sum'],'number'],
            
            [['created_at', 'updated_at','client_id'], 'safe'],
            [['purchase_id', 'client_id',  'user_id','discount_type'], 'string', 'max' => 50],
            [['discount'], 'integer', 'min'=>0,'max'=>100,'when' => function ($model) {                    
                    return $model->discount_type == "%";
                },'whenClient' => "function (attribute, value) {
                    return $('#purchases-discount_type').val() == '%';
                    }"
                ],
                [['discount'], 'number', 'min'=>0,'when' => function ($model) {
                    return $model->discount_type != "%";
                },'whenClient' => "function (attribute, value) {
                    return $('#purchases-discount_type').val() != '%';
                    }"
                ],
                [['discount_type'], 'required','when' => function ($model) {
                    return !empty($model->discount);
                },'whenClient' => "function (attribute, value) {
                    return $('#purchases-discount').value;
                    }"
                ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'purchase_id' => Yii::t('app', 'Purchase'),
            'client_id' => Yii::t('app', 'Client'),
            'discount' => Yii::t('app', 'Discount'),
            'discount_type' => Yii::t('app', 'Discount Type'),
         
            'sum' => Yii::t('app', 'Total Amount'),
            
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'user_id' => Yii::t('app', 'User'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::className(), ['purchase_id' => 'purchase_id']);
    }



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    public function getMyproducts()
    {
        return $this->hasMany(Products::className(),['product_id'=>'product_id'])
            ->viaTable('purchase_product',['purchase_id'=>'purchase_id']);
    }

    public function getdropProducts()
    {
    $data = Products::find()->asArray()->all();
    return ArrayHelper::map($data, 'product_id', 'product_name');
    }

    public function getPurchaseStatuses()
    {
     
        return $this->hasOne(PurchaseStatuses::className(), ['purchase_id' => 'purchase_id'])->orderBy(['status_date'=>SORT_DESC]);
        
    }

    /*public function getStatus()
    {
        $status = PurchaseStatuses::find()->where(['purchase_id' => 'purchases.purchase_id'])->orderBy('status_date','desc')->one();
        
        return $status->status;
    }*/

    public function checkGoal()
    {
        $user = Yii::$app->user->identity;
        $account = $user->accounts;

        $dayAmount = StatsFunctions::currentDayRevenue();
        $monthAmount = StatsFunctions::currentMonthRevenue();
        $weekAmount = StatsFunctions::currentWeekRevenue();
  
        $goals= Goals::find()->where(['account_id'=>$account->account_id])->all();

        foreach ($goals as $goal) {
            if(empty($goal->time_of_receive))
            {

           switch ($goal->goal_type) {
               case 'daily':
                   if($goal->goal_value <= $dayAmount)
                   {
                     Yii::$app->getSession()->setFlash('dailyGoal', [
                            'type' => 'warning',
                            'duration' => 12000,
                            'icon' => 'fa fa-futbol-o',
                            'message' => Yii::t('app',Html::encode('You achieved your daily goal!')),
                            'title' => Yii::t('app', Html::encode('Good Job! '.$user->user_name)),
                            'positonY' => 'top',
                            'positonX' => 'right'
                        ]);
                     $goal->time_of_receive = date('Y-m-d H:i:s');
                     $goal->save();
                   }
                   break;
                case 'weekly':
                   if($goal->goal_value <= $weekAmount)
                   {
                    Yii::$app->getSession()->setFlash('weeklyGoal', [
                            'type' => 'warning',
                            'duration' => 12000,
                            'icon' => 'fa fa-futbol-o',
                            'message' => Yii::t('app',Html::encode('You achieved your weekly goal!')),
                            'title' => Yii::t('app', Html::encode('Good Job! '.$user->user_name)),
                            'positonY' => 'top',
                            'positonX' => 'right'
                        ]);
                    $goal->time_of_receive = date('Y-m-d H:i:s');
                     $goal->save();
                   }
                   break; 
                case 'monthly':
                   if($goal->goal_value <= $monthAmount)
                   {
                    Yii::$app->getSession()->setFlash('monthlyGoal', [
                            'type' => 'warning',
                            'duration' => 12000,
                            'icon' => 'fa fa-futbol-o',
                            'message' => Yii::t('app',Html::encode('You achieved your monthly goal!')),
                            'title' => Yii::t('app', Html::encode('Good Job! '.$user->user_name)),
                            'positonY' => 'top',
                            'positonX' => 'right'
                        ]);
                    $goal->time_of_receive = date('Y-m-d H:i:s');
                     $goal->save();
                   }
                   break;
               default:                   
                   break;
           }
        }
    }

    }

    public function checkLevel()
    {
        $user = Yii::$app->user->identity;

        $level=GlobalFunctions::getLevel();
        $level_before_update = LevelsThresholds::findOne($user->accounts->level_id);

        
       /* if($level_before_update != $level->level_id)
        {
            if($level_before_update->commision_percent < $level->commision_percent)
                                            {
                                               
                                                 Yii::$app->getSession()->setFlash('success', [
                                                    'type' => 'success',
                                                    'duration' => 12000,
                                                    'icon' => 'fa fa-users',
                                                    'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                                                    'title' => Yii::t('app', Html::encode('Congratulation.'.$user->user_name.' You leveled up!')),
                                                    'positonY' => 'top',
                                                    'positonX' => 'right'
                                                ]);
                                             }
                                             else{
                                                Yii::$app->getSession()->setFlash('danger', [
                                                    'type' => 'danger',
                                                    'duration' => 12000,
                                                    'icon' => 'fa fa-users',
                                                    'message' => Yii::t('app',Html::encode('Now you can achieve '.$level->commision_percent.'% commision!')),
                                                    'title' => Yii::t('app', Html::encode('Unfortunately your level has changed.')),
                                                    'positonY' => 'top',
                                                    'positonX' => 'right'
                                                ]);
                                             }

        }*/
                                         
    }

    public function init(){
        $this->on(self::EVENT_NEW_PURCHASE, [$this,'checkGoal']);  
    }
}

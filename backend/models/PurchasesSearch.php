<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Purchases;
use backend\models\PurchaseStatuses;
use yii\db\Query;
/**
 * PurchasesSearch represents the model behind the search form about `backend\models\Purchases`.
 */
class PurchasesSearch extends Purchases
{

    public $client_name;
    public $client_email;
    public $status;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['purchase_id', 'client_id',  'created_at', 'updated_at', 'user_id','client_name','client_email','status'], 'safe'],
            [['discount', 'sum'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $user = Yii::$app->user->identity;
        if(empty($user->accounts))
        {

            $company_users= Yii::$app->company->company->users;
            $users_ids=array();
            
            foreach ($company_users as $key => $value) {
               array_push($users_ids,$value->id);
            }
            $users_ids = "('".implode("','",$users_ids)."')";
            
            $query = Purchases::find()->where(' purchases.user_id in'.$users_ids);
         
           
        }else{
           $query = Purchases::find()->where(['purchases.user_id'=>$user->id]);
        } 

       

       


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                'sum',
                'client_name' =>[
                        'asc' => ['client_name' => SORT_ASC],
                        'desc' => ['client_name' => SORT_DESC],
                        'default' => SORT_DESC
                   ],
                 'client_email' =>[
                      'asc' => ['client_email' => SORT_ASC],
                      'desc' => ['client_email' => SORT_DESC],
                      'default' => SORT_DESC
                 ],
                 'status' =>[
                      'asc' => ['status' => SORT_ASC],
                      'desc' => ['status' => SORT_DESC],
                      'default' => SORT_DESC
                 ],
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->joinWith('client');
      
//        $query->joinWith('purchaseStatuses');

        $query->andFilterWhere([
            'discount' => $this->discount,
            'sum' => $this->sum,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'purchase_id', $this->purchase_id])
            ->andFilterWhere(['like', 'clients.client_name', $this->client_name])
            ->andFilterWhere(['like', 'clients.client_email', $this->client_email]); 
            
            // if(isset($params['PurchasesSearch']["purchaseStatuses"]) ){
if(isset($this->status)){
           
            $command = Yii::$app->db->createCommand("select * from purchase_statuses 
              where status_date in 
              (SELECT max(status_date) FROM `purchase_statuses` group by purchase_id ORDER by status_date DESC ) 
              and status = '"./*$params['PurchasesSearch']["purchaseStatuses"]*/$this->status."'");
           
            $rows=$command->queryAll();
            $result=[];
            foreach ($rows as $row) {
             
              array_push($result,$row['purchase_id']);
            }
      
            $query->andFilterWhere(['purchases.purchase_id'=>$result]);
}

        return $dataProvider;
    }
}

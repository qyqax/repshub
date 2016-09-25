<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Attributes;

/**
 * AttributesSearch represents the model behind the search form about `backend\models\Attributes`.
 */
class AttributesSearch extends Attributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'attribute_type', 'attribute_name', 'account_id', 'company_id'], 'safe'],
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
       // var_dump($params);die;
        $query = Attributes::find()->where(['account_id'=>NULL])->orWhere(['account_id'=>Yii::$app->user->identity->accounts->account_id]);//where(['account_id'=>Yii::$app->user->identity->accounts->account_id])->orWhere(['account_id'=>NULL]);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'attribute_type', $this->attribute_type])
            ->andFilterWhere(['like', 'attribute_name', $this->attribute_name])
            ->andFilterWhere(['like', 'account_id', $this->account_id])
            ->andFilterWhere(['like', 'company_id', $this->company_id]);

            /*search created by company*/
        
        if(isset($params['AttributesSearch']["account_id"]) ){
            
            if($params['AttributesSearch']["account_id"]=="Company"){
                 $query->orWhere(['account_id'=>NULL]);
            }
        

        }
        return $dataProvider;
    }
}

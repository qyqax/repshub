<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Account;

/**
 * AccountSearch represents the model behind the search form about `backend\models\Account`.
 */
class AccountSearch extends Account
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account_id', 'created_at', 'updated_at', 'account_name', 'level_id', 'company_id'], 'safe'],
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
        $query = Account::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'account_id', $this->account_id])
            ->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'level_id', $this->level_id])
            ->andFilterWhere(['like', 'company_id', $this->company_id]);

        return $dataProvider;
    }
}

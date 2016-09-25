<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Goals;

/**
 * GoalsSearch represents the model behind the search form about `backend\models\Goals`.
 */
class GoalsSearch extends Goals
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goal_id', 'goal_value'], 'integer'],
            [['goal_type', 'account_id', 'time_of_receive'], 'safe'],
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
        $query = Goals::find()->where(['account_id'=>Yii::$app->user->identity->accounts->account_id]);;

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
            'goal_id' => $this->goal_id,
            'goal_value' => $this->goal_value,
            'time_of_receive' => $this->time_of_receive,
        ]);

        $query->andFilterWhere(['like', 'goal_type', $this->goal_type])
            ->andFilterWhere(['like', 'account_id', $this->account_id]);

        return $dataProvider;
    }
}

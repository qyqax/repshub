<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LoginAttempts;

/**
 * LoginAttemptsSearch represents the model behind the search form about `common\models\LoginAttempts`.
 */
class LoginAttemptsSearch extends LoginAttempts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'attempt_status'], 'integer'],
            [['attempt_password', 'attempt_browser', 'attempt_ip', 'attempt_os', 'attempt_device', 'attempt_city', 'attempt_country', 'attempt_time'], 'safe'],
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
        $query = LoginAttempts::find();

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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'attempt_status' => $this->attempt_status,
            'attempt_time' => $this->attempt_time,
        ]);

        $query->andFilterWhere(['like', 'attempt_password', $this->attempt_password])
            ->andFilterWhere(['like', 'attempt_browser', $this->attempt_browser])
            ->andFilterWhere(['like', 'attempt_ip', $this->attempt_ip])
            ->andFilterWhere(['like', 'attempt_os', $this->attempt_os])
            ->andFilterWhere(['like', 'attempt_device', $this->attempt_device])
            ->andFilterWhere(['like', 'attempt_city', $this->attempt_city])
            ->andFilterWhere(['like', 'attempt_country', $this->attempt_country]);

        return $dataProvider;
    }
}

<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserPasswordResets;

/**
 * UserPasswordResetsSearch represents the model behind the search form about `common\models\UserPasswordResets`.
 */
class UserPasswordResetsSearch extends UserPasswordResets
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'upr_old_password', 'upr_token', 'upr_request_time', 'upr_reset_time'], 'safe'],
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
        $query = UserPasswordResets::find();

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
            'upr_request_time' => $this->upr_request_time,
            'upr_reset_time' => $this->upr_reset_time,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'user_id', $this->user_id])
            ->andFilterWhere(['like', 'upr_old_password', $this->upr_old_password])
            ->andFilterWhere(['like', 'upr_token', $this->upr_token]);

        return $dataProvider;
    }
}

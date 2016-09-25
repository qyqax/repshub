<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Users;

/**
 * UsersSearch represents the model behind the search form about `common\models\Users`.
 */
class UsersSearch extends Users
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_name', 'user_email', 'user_password', 'user_photo', 'user_auth_key', 'user_create_time', 'user_update_time'], 'safe'],
            [['status', 'user_verified'], 'integer'],
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
    public function search($params, $cid)
    {
        $query = Users::find()->joinWith('companies')->joinWith('companies.role')->where(['companies_users.company_id' => $cid , 'status' => Users::STATUS_ACTIVE]);
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
            'status' => $this->status,
            'user_verified' => $this->user_verified,
            'user_create_time' => $this->user_create_time,
            'user_update_time' => $this->user_update_time,
        ]);

        $query->andFilterWhere(['like', 'id', $this->id])
            ->andFilterWhere(['like', 'user_name', $this->user_name])
            ->andFilterWhere(['like', 'user_email', $this->user_email])
            ->andFilterWhere(['like', 'user_password', $this->user_password])
            ->andFilterWhere(['like', 'user_photo', $this->user_photo])
            ->andFilterWhere(['like', 'user_auth_key', $this->user_auth_key]);

        return $dataProvider;
    }
}

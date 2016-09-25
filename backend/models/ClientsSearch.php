<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Clients;

/**
 * ClientsSearch represents the model behind the search form about `backend\models\Clients`.
 */
class ClientsSearch extends Clients
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'client_gender', 'status'], 'integer'],
            [['client_name', 'client_email', 'client_phone', 'client_city', 'client_country', 'client_address', 'client_postal_code', 'client_photo', 'client_birthdate', 'client_create_time', 'client_update_time'], 'safe'],
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
    public function searchAll($params, $cid)
    {
        $query = Clients::find()->where(['company_id' => $cid, 'status' => Clients::STATUS_ACTIVE]);
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
            'client_gender' => $this->client_gender,
            'client_birthdate' => $this->client_birthdate,
            'client_create_time' => $this->client_create_time,
            'client_update_time' => $this->client_update_time,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'client_name', $this->client_name])
            ->andFilterWhere(['like', 'client_email', $this->client_email])
            ->andFilterWhere(['like', 'client_phone', $this->client_phone])
            ->andFilterWhere(['like', 'client_city', $this->client_city])
            ->andFilterWhere(['like', 'client_country', $this->client_country])
            ->andFilterWhere(['like', 'client_address', $this->client_address])
            ->andFilterWhere(['like', 'client_postal_code', $this->client_postal_code])
            ->andFilterWhere(['like', 'client_photo', $this->client_photo]);

        return $dataProvider;
    }

    
      
}

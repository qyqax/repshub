<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ClientAttributes;

/**
 * ClientAttributesSearch represents the model behind the search form about `backend\models\ClientAttributes`.
 */
class ClientAttributesSearch extends ClientAttributes
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'client_id', 'attribute_id', 'attribute_value'], 'safe'],
            [['option_id'], 'integer'],
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
        $query = ClientAttributes::find();

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
            'option_id' => $this->option_id,
        ]);

        $query->andFilterWhere(['like', 'client_id', $this->client_id])
            ->andFilterWhere(['like', 'attribute_id', $this->attribute_id])
            ->andFilterWhere(['like', 'attribute_value', $this->attribute_value]);

        return $dataProvider;
    }
}

<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Categories;

/**
 * CategoriesSearch represents the model behind the search form about `backend\models\Categories`.
 */
class SubCategoriesSearch extends Categories
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'category_name', 'parent_id'], 'safe'],
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
        $query = Categories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'category_name', $this->category_name])
            ->andFilterWhere(['like', 'parent_id', $this->parent_id]);

        return $dataProvider;
    }
}

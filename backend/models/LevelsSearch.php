<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Levels;

/**
 * LevelsSearch represents the model behind the search form about `backend\models\Levels`.
 */
class LevelsSearch extends Levels
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level_id', 'name', 'company_id'], 'safe'],
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
    public function search($params,$cid)
    {
        $query = Levels::find()->where(['company_id' =>$cid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'level_id', $this->level_id])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'company_id', $this->company_id]);

        return $dataProvider;
    }
}

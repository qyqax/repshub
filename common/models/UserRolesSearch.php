<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserRoles;

/**
 * UserRolesSearch represents the model behind the search form about `common\models\UserRoles`.
 */
class UserRolesSearch extends UserRoles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'user_role_name'], 'safe'],
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
        $query = UserRoles::find()->joinWith('permissions')->where(['company_id' => $cid]);

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
            ->andFilterWhere(['like', 'company_id', $this->company_id])
            ->andFilterWhere(['like', 'user_role_name', $this->user_role_name]);

        return $dataProvider;
    }
}

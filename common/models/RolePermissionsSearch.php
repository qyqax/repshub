<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RolePermissions;

/**
 * RolePermissionsSearch represents the model behind the search form about `common\models\RolePermissions`.
 */
class RolePermissionsSearch extends RolePermissions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_role_id', 'module', 'crud'], 'safe'],
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
        $query = RolePermissions::find()->where(['company_id' => $cid]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'user_role_id', $this->user_role_id])
            ->andFilterWhere(['like', 'module', $this->module])
            ->andFilterWhere(['like', 'crud', $this->crud]);

        return $dataProvider;
    }
}

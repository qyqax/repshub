<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Company;

/**
 * CompanySearch represents the model behind the search form about `common\models\Company`.
 */
class CompanySearch extends Company
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['company_name', 'company_slug_name', 'company_legal_name', 'company_email', 'company_url', 'company_phone', 'company_address', 'company_postal_code', 'company_vat', 'company_trial_end_time', 'company_create_time', 'company_update_time', 'company_delete_time'], 'safe'],
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
        $query = Company::find()->where(['id' => $cid, 'status' => Company::STATUS_ACTIVE]);

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
            'status' => $this->status,
            'company_trial_end_time' => $this->company_trial_end_time,
            'company_create_time' => $this->company_create_time,
            'company_update_time' => $this->company_update_time,
            'company_delete_time' => $this->company_delete_time,
        ]);

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'company_slug_name', $this->company_slug_name])
            ->andFilterWhere(['like', 'company_legal_name', $this->company_legal_name])
            ->andFilterWhere(['like', 'company_email', $this->company_email])
            ->andFilterWhere(['like', 'company_url', $this->company_url])
            ->andFilterWhere(['like', 'company_phone', $this->company_phone])
            ->andFilterWhere(['like', 'company_address', $this->company_address])
            ->andFilterWhere(['like', 'company_postal_code', $this->company_postal_code])
            ->andFilterWhere(['like', 'company_vat', $this->company_vat]);

        return $dataProvider;
    }
}

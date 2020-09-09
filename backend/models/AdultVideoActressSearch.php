<?php

namespace backend\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use common\models\AdultVideoActress;


/**
 * AdultVideoActressSearch represents the model behind the search form of `common\models\AdultVideoActress`.
 */
class AdultVideoActressSearch extends AdultVideoActress
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'raw_name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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

        $query = AdultVideoActress::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['per-page']) ? $params['per-page'] : Yii::$app->params['perPage'],
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', trim($this->name)]);

        $query->andFilterWhere(['like', 'raw_name', trim($this->raw_name)]);

        $query->andFilterWhere(['=', 'is_delete', 0]);

        return $dataProvider;

    }


}

<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdultVideoActressWork;

/**
 * AdultVideoActressWorkSearch represents the model behind the search form of `common\models\AdultVideoActressWork`.
 */
class AdultVideoActressWorkSearch extends AdultVideoActressWork
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'designation'], 'safe'],
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
        $query = AdultVideoActressWork::find();

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

        $query->andFilterWhere(['like', 'title', trim($this->title)]);

        $query->andFilterWhere(['like', 'designation', trim($this->designation)]);

        $query->andFilterWhere(['=', 'is_delete', 0]);

        return $dataProvider;

    }


}

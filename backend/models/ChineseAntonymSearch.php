<?php

namespace backend\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;
use common\models\ChineseAntonym;


/**
 * ChineseAntonymSearch represents the model behind the search form of `common\models\ChineseAntonym`.
 */
class ChineseAntonymSearch extends ChineseAntonym
{


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['front_word','back_word'], 'safe'],
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

        $query = ChineseAntonym::find();

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

        $query->andFilterWhere(['like', 'front_word', trim($this->front_word)]);

        $query->andFilterWhere(['like', 'back_word', trim($this->back_word)]);

        $query->andFilterWhere(['=', 'is_delete', 0]);

        return $dataProvider;

    }


}

<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
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
            [['id', 'is_delete'], 'integer'],
            [['front', 'back', 'create_datetime', 'update_datetime'], 'safe'],
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
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_delete' => $this->is_delete,
            'create_datetime' => $this->create_datetime,
            'update_datetime' => $this->update_datetime,
        ]);

        $query->andFilterWhere(['like', 'front', $this->front])
            ->andFilterWhere(['like', 'back', $this->back]);

        return $dataProvider;
    }
}

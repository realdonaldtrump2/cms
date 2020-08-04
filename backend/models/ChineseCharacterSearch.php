<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChineseCharacter;

/**
 * ChineseCharacterSearch represents the model behind the search form of `common\models\ChineseCharacter`.
 */
class ChineseCharacterSearch extends ChineseCharacter
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_delete'], 'integer'],
            [['word', 'oldword', 'strokes', 'pinyin', 'radicals', 'explain', 'more_explain', 'create_datetime', 'update_datetime'], 'safe'],
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
        $query = ChineseCharacter::find();

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

        $query->andFilterWhere(['like', 'word', $this->word])
            ->andFilterWhere(['like', 'oldword', $this->oldword])
            ->andFilterWhere(['like', 'strokes', $this->strokes])
            ->andFilterWhere(['like', 'pinyin', $this->pinyin])
            ->andFilterWhere(['like', 'radicals', $this->radicals])
            ->andFilterWhere(['like', 'explain', $this->explain])
            ->andFilterWhere(['like', 'more_explain', $this->more_explain]);

        return $dataProvider;
    }
}

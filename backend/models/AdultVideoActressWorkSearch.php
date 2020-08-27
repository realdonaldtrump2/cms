<?php

namespace backend\models;

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
            [['id', 'adult_video_actress_id', 'duration', 'is_delete'], 'integer'],
            [['title', 'cover', 'cover_url', 'designation', 'information', 'publish_datetime', 'create_datetime', 'update_datetime'], 'safe'],
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
            'adult_video_actress_id' => $this->adult_video_actress_id,
            'publish_datetime' => $this->publish_datetime,
            'duration' => $this->duration,
            'is_delete' => $this->is_delete,
            'create_datetime' => $this->create_datetime,
            'update_datetime' => $this->update_datetime,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'cover_url', $this->cover_url])
            ->andFilterWhere(['like', 'designation', $this->designation])
            ->andFilterWhere(['like', 'information', $this->information]);

        return $dataProvider;
    }
}

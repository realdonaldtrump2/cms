<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;


/**
 * ArticleSearch represents the model behind the search form about `backend\models\Article`.
 */
class RbacAuthItemSearch extends RbacAuthItem
{


    public $type = 0;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
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
    public function search($params)
    {

        $query = RbacAuthItem::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => isset($params['per-page']) ? $params['per-page'] : Yii::$app->params['perPage'],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->type === 2) {
            $query->andFilterWhere(['=', 'type', 2]);
        } else if ($this->type === 1) {
            $query->andFilterWhere(['=', 'type', 1]);
        } else {
            $query->andFilterWhere(['=', 'type', 0]);
        }

        $query->andFilterWhere(['like', 'name', trim($this->name)]);

        $query->andFilterWhere(['like', 'description', trim($this->description)]);

        return $dataProvider;

    }


}
<?php

namespace common\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;


/**
 * UserAuthenticationLogSearch represents the model behind the search form of `common\models\UserAuthenticationLog`.
 */
class UserAuthenticationLogSearch extends UserAuthenticationLog
{


    public $create_datetime_start;


    public $create_datetime_end;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['create_datetime_start', 'create_datetime_end', 'type'], 'safe'],
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

        $query = UserAuthenticationLog::find()
            ->joinWith('user');

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

        $query->andFilterWhere(['=', '{{%user_authentication_log}}.type', $this->type]);

        if ($this->create_datetime_start && $this->create_datetime_end) {

            $query->andFilterWhere(['between', '{{%user_authentication_log}}.create_datetime', $this->create_datetime_start . ' 00:00:00', $this->create_datetime_end . ' 23:59:59']);

        } else if ($this->create_datetime_start && !$this->create_datetime_end) {

            $query->andFilterWhere(['>=', '{{%user_authentication_log}}.create_datetime', $this->create_datetime_start . ' 00:00:00']);

        } else if (!$this->create_datetime_start && $this->create_datetime_end) {

            $query->andFilterWhere(['<=', '{{%user_authentication_log}}.create_datetime', $this->create_datetime_end . ' 23:59:59']);

        }

        $query->andFilterWhere(['=', '{{%user_authentication_log}}.is_delete', 0]);

        return $dataProvider;

    }


}

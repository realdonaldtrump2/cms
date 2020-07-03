<?php

namespace common\models;


use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;


/**
 * UserSmsSearch represents the model behind the search form of `common\models\UserSms`.
 */
class UserSmsSearch extends UserSms
{


    public $create_datetime_start;


    public $create_datetime_end;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'create_datetime_start', 'create_datetime_end'], 'safe'],
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

        $query = UserSms::find();

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

        $query->andFilterWhere(['like', '{{%user_sms}}.phone', trim($this->phone)]);

        if ($this->create_datetime_start && $this->create_datetime_end) {

            $query->andFilterWhere(['between', '{{%user_sms}}.create_datetime', $this->create_datetime_start, $this->create_datetime_end]);

        } else if ($this->create_datetime_start && !$this->create_datetime_end) {

            $query->andFilterWhere(['>=', '{{%user_sms}}.create_datetime', $this->create_datetime_start]);

        } else if (!$this->create_datetime_start && $this->create_datetime_end) {

            $query->andFilterWhere(['<=', '{{%user_sms}}.create_datetime', $this->create_datetime_end]);

        }

        return $dataProvider;

    }


}

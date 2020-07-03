<?php

namespace common\data;

use Yii;


class AdvancedQueryFilter
{


    public $query;


    public $field;


    public function __construct($query, $field)
    {
        $this->query = $query;
        $this->field = $field;
        foreach ($this->field as $single) {
            if ($single['type'] === 'equal-range') {
                $this->computeEqualRange($single);
            } else if ($single['type'] === 'datetime') {
                $this->computeDatetime($single);
            } else if ($single['type'] === 'equal-in') {
                $this->computeEqualIn($single);
            }
        }
    }


    /**
     * type = in:1, 2, 3
     * ['in', 'type', [1, 2, 3]]
     * type = 3
     * ['=', 'type', 3]
     *
     * @param $single
     */
    public function computeEqualIn($single)
    {
        $rawValue = $single['value'];
        if ($rawValue !== null) {
            if (strpos($rawValue, 'in:') !== false) {
                $this->query->andFilterWhere(['in', $single['key'], explode(',', substr($rawValue, 3))]);
            } else {
                $this->query->andFilterWhere(['=', $single['key'], $rawValue]);
            }
        }
    }


    /**
     * update_datetime 时间只能进行范围搜素
     * update_datetime=2019-09-17~2019-09-18
     *
     * @param $single
     */
    public function computeDatetime($single)
    {
        $rawDatetime = $single['value'];
        if ($rawDatetime !== null) {
            $rawDatetimeRange = explode("~", $rawDatetime);
            if (count($rawDatetimeRange) === 1) {
                $rawDatetimeRange[] = '';
            }
            $this->query->andFilterWhere(['between', $single['key'], (string)date('Y-m-d H:i:s', strtotime($rawDatetimeRange[0])), (string)date('Y-m-d H:i:s', strtotime($rawDatetimeRange[1]))]);
        }
    }


    /**
     * price 可以进行等于搜素 可以进行范围搜索
     * 大于等于 more_than_equal
     * 大于 more_than
     * 小于等于 less_than_equal
     * 小于 less_than
     * ?price=1 =1
     * ?price=more_than_equal:1,less_than:5
     *
     * @param $single
     */
    public function computeEqualRange($single)
    {
        $rawValue = $single['value'];
        if ($rawValue !== null) {
            if (Yii::$app->verifyField->number($rawValue)) {
                $this->query->andFilterWhere(['=', $single['key'], (int)$rawValue]);
            } else {
                $rawValueRange = explode(",", $rawValue);
                if (count($rawValueRange) === 1) {
                    $rawValueRangeStart = explode(":", $rawValueRange[0]);
                    if ($rawValueRangeStart[0] === 'more_than_equal') {
                        $this->query->andFilterWhere(['>=', $single['key'], (int)$rawValueRangeStart[1]]);
                    } else if ($rawValueRangeStart[0] === 'more_than') {
                        $this->query->andFilterWhere(['>', $single['key'], (int)$rawValueRangeStart[1]]);
                    } else if ($rawValueRangeStart[0] === 'less_than_equal') {
                        $this->query->andFilterWhere(['<=', $single['key'], (int)$rawValueRangeStart[1]]);
                    } else if ($rawValueRangeStart[0] === 'less_than') {
                        $this->query->andFilterWhere(['<', $single['key'], (int)$rawValueRangeStart[1]]);
                    }
                } else {
                    $rawValueRangeStart = explode(":", $rawValueRange[0]);
                    $rawValueRangeEnd = explode(":", $rawValueRange[1]);
                    if ($rawValueRangeStart[0] === 'more_than_equal' && $rawValueRangeEnd[0] === 'less_than_equal') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeStart[1], (int)$rawValueRangeEnd[1]]);
                    }
                    if ($rawValueRangeStart[0] === 'more_than_equal' && $rawValueRangeEnd[0] === 'less_than') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeStart[1], (int)$rawValueRangeEnd[1] - 1]);
                    }
                    if ($rawValueRangeStart[0] === 'more_than' && $rawValueRangeEnd[0] === 'less_than_equal') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeStart[1] + 1, (int)$rawValueRangeEnd[1]]);
                    }
                    if ($rawValueRangeStart[0] === 'more_than' && $rawValueRangeEnd[0] === 'less_than') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeStart[1] + 1, (int)$rawValueRangeEnd[1] - 1]);
                    }
                    if ($rawValueRangeStart[0] === 'less_than_equal' && $rawValueRangeEnd[0] === 'more_than_equal') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeEnd[1], (int)$rawValueRangeStart[1]]);
                    }
                    if ($rawValueRangeStart[0] === 'less_than_equal' && $rawValueRangeEnd[0] === 'more_than') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeEnd[1] + 1, (int)$rawValueRangeStart[1]]);
                    }
                    if ($rawValueRangeStart[0] === 'less_than' && $rawValueRangeEnd[0] === 'more_than_equal') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeEnd[1], (int)$rawValueRangeStart[1] - 1]);
                    }
                    if ($rawValueRangeStart[0] === 'less_than' && $rawValueRangeEnd[0] === 'more_than') {
                        $this->query->andFilterWhere(['between', $single['key'], (int)$rawValueRangeEnd[1] + 1, (int)$rawValueRangeStart[1] - 1]);
                    }
                }
            }
        }
    }

}

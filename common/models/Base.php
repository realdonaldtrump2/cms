<?php

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


class Base extends ActiveRecord
{


    /**
     * 未删除
     *
     * @param $id
     * @return array|Base|ActiveRecord|null
     */
    public static function findOneUnDelete($id)
    {

        return static::find()
            ->andFilterWhere(['=', 'id', $id])
            ->andFilterWhere(['=', 'is_delete', 0])
            ->one();

    }


    /**
     * 已删除
     *
     * @param $id
     * @return array|Base|ActiveRecord|null
     */
    public static function findOneDelete($id)
    {

        return static::find()
            ->andFilterWhere(['=', 'id', $id])
            ->andFilterWhere(['=', 'is_delete', 1])
            ->one();

    }


    /**
     * 司机配送路线范围内的订货商
     *
     * @param null $purchaser_shop_name
     * @return array
     */
    public function getPurchaserShopIdList($purchaser_shop_name = null)
    {

        $villageIdList = array_column(Yii::$app->user->identity->userDriver->driver->operatorDistributionLine->operatorDistributionLineVillage, 'village_id');

        if ($purchaser_shop_name) {

            $shopModelList = Shop::find()
                ->select('id')
                ->andFilterWhere(['like', 'shop_name', $this->purchaser_shop_name])
                ->andFilterWhere(['in', 'village_id', empty($villageIdList) ? [-1] : $villageIdList])
                ->andFilterWhere(['=', 'shop_type', 2])
                ->andFilterWhere(['=', 'is_delete', 0])
                ->asArray()
                ->all();

        } else {

            $shopModelList = Shop::find()
                ->select('id')
                ->andFilterWhere(['in', 'village_id', empty($villageIdList) ? [-1] : $villageIdList])
                ->andFilterWhere(['=', 'shop_type', 2])
                ->andFilterWhere(['=', 'is_delete', 0])
                ->asArray()
                ->all();

        }

        return array_column($shopModelList, 'id');

    }


    /**
     *  订货商获取供货商id
     *
     * @return array
     */
    public function getShopIdList()
    {

        $districtIdList = array_column(Yii::$app->util->checkApiAuthorization()->userShop->shop->operatorArea->operator->operatorArea, 'district_id');

        return array_column(Shop::find()
            ->select('id')
            ->andFilterWhere(['!=', 'id', Yii::$app->params['xinyulouShopId']])
            ->andFilterWhere(['=', 'shop_type', 1])
            ->andFilterWhere(['in', 'district_id', empty($districtIdList) ? [-1] : $districtIdList])
            ->andFilterWhere(['=', 'is_review', 1])
            ->andFilterWhere(['=', 'is_delete', 0])
            ->asArray()
            ->all(), 'id');

    }


    public function getOperatorDistributionLineList()
    {

        $operatorDistributionLineModelList = OperatorDistributionLine::find()
            ->andFilterWhere(['=', 'operator_id', Yii::$app->user->identity->userOperator->operator_id])
            ->andFilterWhere(['=', 'is_delete', 0])
            ->all();

        $operatorDistributionLineList = [];
        foreach ($operatorDistributionLineModelList as $operatorDistributionLineModel) {
            $operatorDistributionLineList[$operatorDistributionLineModel->id] = $operatorDistributionLineModel->distribution_line_show_name . '  ' . $operatorDistributionLineModel->distribution_line_name;
        }
        return $operatorDistributionLineList;

    }


    public function getMemberModel()
    {

        if (isset(Yii::$app->request->headers['authorization']) && is_string(Yii::$app->request->headers['authorization'])) {
            $authorization = Yii::$app->request->headers['authorization'];
            $authorization = explode(' ', $authorization);
            if (isset($authorization[1])) {

                return Member::find()
                    ->andFilterWhere(['=', 'token', $authorization[1]])
                    ->one();

            }

            return null;

        }

        return null;

    }


}
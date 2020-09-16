<?php

namespace backend\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use common\models\AreaProvince;
use common\models\AreaCity;
use common\models\AreaDistrict;
use common\models\AreaTown;
use common\models\AreaVillage;


class AreaController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $behaviors = parent::behaviors();
        return $behaviors;

    }


    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        return true;

    }


    /**
     * 省
     *
     * @return array|AreaProvince[]|\yii\db\ActiveRecord[]
     */
    public function actionProvince()
    {

        return ArrayHelper::map(AreaProvince::find()->all(), 'province_id', 'province_name');

    }


    /**
     * 市
     *
     * @return array|AreaCity[]|AreaProvince[]|\yii\db\ActiveRecord[]
     */
    public function actionCity()
    {

        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if (!$depdropParents) {
            return ['output' => [], 'selected' => ''];
        }
        $province_id = $depdropParents[0];
        $cityListRaw = ArrayHelper::map(AreaCity::find()->where(['province_id' => $province_id])->all(), 'city_id', 'city_name');
        $cityList = [];
        foreach ($cityListRaw as $key => $value) {
            $cityList[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return ['output' => $cityList, 'selected' => ''];

    }


    /**
     * 区县
     *
     * @return array|AreaCity[]|AreaProvince[]|\yii\db\ActiveRecord[]
     */
    public function actionDistrict()
    {

        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if (!$depdropParents) {
            return ['output' => [], 'selected' => ''];
        }
        $city_id = $depdropParents[1];
        $districtListRaw = ArrayHelper::map(AreaDistrict::find()->where(['city_id' => $city_id])->all(), 'district_id', 'district_name');
        $districtList = [];
        foreach ($districtListRaw as $key => $value) {
            $districtList[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return ['output' => $districtList, 'selected' => ''];

    }


    /**
     * 乡镇
     *
     * @return array|AreaCity[]|AreaDistrict[]|AreaProvince[]|\yii\db\ActiveRecord[]
     */
    public function actionTown()
    {

        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if (!$depdropParents) {
            return ['output' => [], 'selected' => ''];
        }
        $district_id = $depdropParents[2];
        $townListRaw = ArrayHelper::map(AreaTown::find()->where(['district_id' => $district_id])->all(), 'town_id', 'town_name');
        $townList = [];
        foreach ($townListRaw as $key => $value) {
            $townList[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return ['output' => $townList, 'selected' => ''];

    }


    /**
     * 村社区
     *
     * @return array|AreaCity[]|AreaDistrict[]|AreaProvince[]|AreaTown[]|AreaVillage[]|\yii\db\ActiveRecord[]
     */
    public function actionVillage()
    {

        $depdropParents = Yii::$app->request->post('depdrop_parents');
        if (!$depdropParents) {
            return ['output' => [], 'selected' => ''];
        }
        $town_id = $depdropParents[3];
        $villageListRaw = ArrayHelper::map(AreaVillage::find()->where(['town_id' => $town_id])->all(), 'village_id', 'village_name');
        $villageList = [];
        foreach ($villageListRaw as $key => $value) {
            $villageList[] = [
                'id' => $key,
                'name' => $value
            ];
        }
        return ['output' => $villageList, 'selected' => ''];

    }


}
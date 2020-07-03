<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'area_village'.
 *
 * @property int $id 编号ID
 * @property string $town_id 乡镇ID
 * @property string $village_id 村社区ID--唯一
 * @property string $village_name 村社区名
 * @property double $lng 经度
 * @property double $lat 纬度
 * @property string $zimu 首字母
 * @property string $pinyin 拼音
 * @property string $status 是否转换
 */
class AreaVillage extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'area_village';
    }


}

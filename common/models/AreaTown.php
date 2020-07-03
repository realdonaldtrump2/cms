<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'area_town'.
 *
 * @property int $id 编号ID
 * @property string $county_id 县级ID
 * @property string $town_id 乡镇级ID
 * @property string $town_name 乡镇名称
 * @property double $lng 经度
 * @property double $lat 纬度
 * @property string $zimu 首字母
 * @property string $pinyin 拼音
 * @property string $status 是否转换
 */
class AreaTown extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'area_town';
    }


}

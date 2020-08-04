<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "chinese_idiom".
 *
 * @property int $id 主键
 * @property string $word 词
 * @property string $pinyin 拼音
 * @property string $abbreviation 拼音缩写
 * @property string $derivation 来源
 * @property string $explain 解释
 * @property string $example 实例
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class ChineseIdiom extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chinese_idiom';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'word' => '词',
            'pinyin' => '拼音',
            'abbreviation' => '拼音缩写',
            'derivation' => '来源',
            'explain' => '解释',
            'example' => '实例',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['word', 'pinyin', 'abbreviation', 'derivation', 'explain', 'example'],
            'update' => ['word', 'pinyin', 'abbreviation', 'derivation', 'explain', 'example'],
            'recover' => [],
        ];
    }


    /**
     * @inheritdoc
     * 软删除
     */
    public function beforeSoftDelete()
    {
        $this->update_datetime = date('Y-m-d H:i:s');
        return true;
    }


    /**
     * @inheritdoc
     * 软恢复
     */
    public function softRecover()
    {
        $this->scenario = 'recover';
        $this->is_delete = 0;
        $this->update_datetime = date('Y-m-d H:i:s');
        $this->save();
    }


    /**
     * @inheritdoc
     * 行为
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_datetime',
                'updatedAtAttribute' => 'update_datetime',
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_delete' => 1
                ],
            ]
        ];
    }


}

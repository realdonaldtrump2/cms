<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "adult_video_actress".
 *
 * @property int $id 编号
 * @property string $name 名称
 * @property string $raw_name 原名称
 * @property string $avatar 头像
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class AdultVideoActress extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adult_video_actress';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['avatar'], 'required'],
            [['avatar'], 'string'],
            [['is_delete'], 'integer'],
            [['create_datetime', 'update_datetime'], 'safe'],
            [['name', 'raw_name'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'name' => '名称',
            'raw_name' => '原名称',
            'pinyin' => '拼音',
            'avatar' => '头像',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
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


    public function getAdultVideoActressDetail()
    {
        return $this->hasOne(AdultVideoActressDetail::className(), ['adult_video_actress_id' => 'id']);
    }


}

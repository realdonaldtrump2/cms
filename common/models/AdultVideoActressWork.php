<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "adult_video_actress_work".
 *
 * @property int $id 主键
 * @property int $adult_video_actress_id adult_video_actress表id
 * @property string $title 标题
 * @property string $cover 封面
 * @property string $cover_url 封面图片
 * @property string $designation 番号
 * @property string $information 信息
 * @property string $publish_datetime 发布时间
 * @property int $duration 时长
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class AdultVideoActressWork extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adult_video_actress_work';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adult_video_actress_id', 'duration', 'is_delete'], 'integer'],
            [['cover'], 'required'],
            [['cover'], 'string'],
            [['publish_datetime', 'create_datetime', 'update_datetime'], 'safe'],
            [['designation'], 'string', 'max' => 255],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'adult_video_actress_id' => 'adult_video_actress表id',
            'title' => '标题',
            'cover' => '封面',
            'designation' => '番号',
            'publish_datetime' => '发布时间',
            'duration' => '时长',
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


}

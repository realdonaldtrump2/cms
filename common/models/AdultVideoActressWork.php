<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adult_video_actress_work".
 *
 * @property int $id 主键
 * @property int $adult_video_actress_id adult_video_actress表id
 * @property string $cover 封面
 * @property string $designation 番号
 * @property string $publish_datetime 发布时间
 * @property int $duration 时长
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class AdultVideoActressWork extends \yii\db\ActiveRecord
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
            'id' => '主键',
            'adult_video_actress_id' => 'adult_video_actress表id',
            'cover' => '封面',
            'designation' => '番号',
            'publish_datetime' => '发布时间',
            'duration' => '时长',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }
}

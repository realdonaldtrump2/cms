<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "adult_video_actress_detail".
 *
 * @property int $id 主键
 * @property int $adult_video_actress_id adult_video_actress表id
 * @property string $describe 描述
 * @property string $information 信息
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class AdultVideoActressDetail extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'adult_video_actress_detail';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['adult_video_actress_id', 'is_delete'], 'integer'],
            [['information'], 'required'],
            [['information', 'create_datetime', 'update_datetime'], 'safe'],
            [['describe'], 'string', 'max' => 2000],
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
            'describe' => '描述',
            'information' => '信息',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }
}

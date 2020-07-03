<?php

namespace common\models;

use Yii;




/**
 * This is the model class for table "adult_video_actress".
 *
 * @property int $id 主键
 * @property string $name 名称
 * @property string $raw_name 原名称
 * @property string $avatar 头像
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class AdultVideoActress extends \yii\db\ActiveRecord
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
            'id' => '主键',
            'name' => '名称',
            'raw_name' => '原名称',
            'avatar' => '头像',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }
}

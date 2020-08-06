<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "chinese_antonym".
 *
 * @property int $id 编号
 * @property string $front_word 正面
 * @property string $back_word 反面
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class ChineseAntonym extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chinese_antonym';
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
            'id' => '编号',
            'front_word' => '正面',
            'back_word' => '反面',
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
            'create' => ['front_word', 'back_word'],
            'update' => ['front_word', 'back_word'],
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

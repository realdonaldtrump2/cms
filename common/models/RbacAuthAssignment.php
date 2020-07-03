<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'rbac_auth_assignment'.
 *
 * @property string $item_name
 * @property string $user_id
 * @property int $created_at
 */
class RbacAuthAssignment extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_auth_assignment';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['item_name', 'required', 'message' => '不能为空'],
            ['user_id', 'required', 'message' => '不能为空'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'item_name' => '角色名称',
            'user_id' => '用户id',
            'created_at' => '创建时间',
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return [
            'create' => ['item_name', 'user_id']
        ];
    }


    /**
     * @inheritdoc
     * 行为
     */
    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'created_at',
                ],
                'value' => function ($event) {
                    return time();
                },
            ],
        ];
    }


}

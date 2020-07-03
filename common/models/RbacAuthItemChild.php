<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'rbac_auth_item_child'.
 *
 * @property string $parent
 * @property string $child
 */
class RbacAuthItemChild extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_auth_item_child';
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
            'parent' => '角色',
            'child' => '权限',
        ];
    }


    /**
     * @inheritdoc
     * 场景
     */
    public function scenarios()
    {
        return [
            'create' => ['parent', 'child'],
        ];
    }


    /**
     * 角色-权限关联
     * @return \yii\db\ActiveQuery
     */
    public function getPermission()
    {
        return $this->hasOne(RbacAuthItem::className(), ['name' => 'child']);
    }

}
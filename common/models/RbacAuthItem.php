<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 *
 * @property mixed $rolePermission
 */
class RbacAuthItem extends Base
{


    public $module;


    public $controller;


    public $action;


    public $permission;


    /**
     * @inheritdoc
     * 表名
     */
    public static function tableName()
    {
        return 'rbac_auth_item';
    }


    /**
     * @inheritdoc
     * 字段验证规则
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['name', 'required', 'message' => '不能为空'],
            ['name', 'unique', 'targetClass' => '\common\models\RbacAuthItem', 'targetAttribute' => 'name', 'message' => '已被占用'],
            ['description', 'required', 'message' => '不能为空'],
            ['module', 'required', 'message' => '不能为空'],
            ['module', 'match', 'pattern' => '/^[a-zA-Z]{1,}$/', 'message' => '只能是英文'],
            ['controller', 'required', 'message' => '不能为空'],
            ['controller', 'match', 'pattern' => '/^[a-zA-Z\-]{1,}$/', 'message' => '只能是英文或-'],
            ['action', 'required', 'message' => '不能为空'],
            ['action', 'match', 'pattern' => '/^[a-zA-Z\-]{1,}$/', 'message' => '只能是英文或-'],
        ];
    }


    /**
     * @inheritdoc
     * label命名
     */
    public function attributeLabels()
    {
        return [
            'name' => '名称',
            'description' => '描述',
            'module' => '权限模块',
            'controller' => '权限控制器',
            'action' => '权限方法',
            'permission' => '权限名称'
        ];
    }


    /**
     * @inheritdoc
     * 场景
     */
    public function scenarios()
    {
        return [
            'create-role' => ['name', 'description'],
            'update-role' => ['name', 'description'],
            'create-permission' => ['description', 'module', 'controller', 'action'],
            'update-permission' => ['description', 'module', 'controller', 'action'],
            'role-permission' => ['permission']
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
                    Base::EVENT_BEFORE_INSERT => 'name',
                    Base::EVENT_BEFORE_UPDATE => 'name',
                ],
                'value' => function ($event) {
                    if ($this->scenario === 'create-permission') {
                        return $this->module . '/' . $this->controller . '/' . $this->action;
                    }

                    return $this->name;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'type',
                ],
                'value' => function ($event) {
                    if ($this->scenario === 'create-permission') {
                        return 2;
                    }

                    if ($this->scenario === 'create-role') {
                        return 1;
                    }

                    return 0;
                },
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => time(),
            ],
        ];
    }


    public function transactions()
    {
        return [
            'role-permission' => self::OP_INSERT | self::OP_UPDATE | self::OP_DELETE,
        ];
    }


    /**
     *
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {

        parent::afterSave($insert, $changedAttributes);

        if ($this->scenario === 'role-permission') {

            $role = $this->name;
            $permissionList = $this->permission;
            RbacAuthItemChild::deleteAll(['parent' => $role]);
            if ($permissionList) {
                foreach ($permissionList as $permission) {
                    $model = new RbacAuthItemChild();
                    $model->scenario = 'create';
                    $model->parent = $role;
                    $model->child = $permission;
                    $model->save();
                }
            }

        }

    }


    public function getRolePermission()
    {
        return $this->hasMany(RbacAuthItemChild::className(), ['parent' => 'name']);
    }


    public static function findRoleByName($name)
    {
        return static::find()->where(['name' => $name, 'type' => 1])->one();
    }


    public static function findPermissionByName($name)
    {
        return static::find()->where(['name' => $name, 'type' => 2])->one();
    }


    public static function getAllPermission()
    {
        return static::find()->where(['type' => 2])->all();
    }


    public static function getPermission($parent)
    {
        return RbacAuthItemChild::find()->where(['parent' => $parent])->asArray()->all();
    }


}

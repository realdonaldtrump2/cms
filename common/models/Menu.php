<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'menu'.
 *
 * @property int $id 编号
 * @property int $parent_id 菜单父级 一级菜单为0
 * @property int $order 排序
 * @property string $icon 菜单图标
 * @property string $title 菜单名称
 * @property string $describe 菜单描述
 * @property string $module 模块
 * @property string $controller 控制器
 * @property string $action 方法
 * @property string $module_controller_action 模块/控制器/方法
 * @property int $is_delete 是否删除 0为未删除 1为删除 默认为0
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 编辑时间
 */
class Menu extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rbac_menu';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['parent_id', 'required', 'message' => '菜单父级不能为空'],
            ['parent_id', 'integer', 'message' => '菜单父级格式错误'],
            ['parent_id', 'compare', 'compareValue' => 0, 'operator' => '>=', 'message' => '菜单父级必须是自然数'],
            ['order', 'required', 'message' => '菜单排序不能为空'],
            ['order', 'integer', 'message' => '菜单排序格式错误'],
            ['order', 'compare', 'compareValue' => 0, 'operator' => '>=', 'message' => '菜单排序必须是自然数'],
            ['icon', 'required', 'message' => '菜单图标不能为空'],
            ['title', 'required', 'message' => '菜单名称不能为空'],
            ['title', 'unique', 'targetClass' => '\common\models\Menu', 'targetAttribute' => 'title', 'message' => '菜单名称已存在'],
            ['module', 'required', 'message' => '不能为空'],
            ['module', 'match', 'pattern' => '/^[a-zA-Z]{1,}$/', 'message' => '只能是英文'],
            ['controller', 'required', 'message' => '不能为空'],
            ['controller', 'match', 'pattern' => '/^[a-zA-Z\-]{1,}$/', 'message' => '只能是英文或-'],
            ['action', 'required', 'message' => '不能为空'],
            ['action', 'match', 'pattern' => '/^[a-zA-Z\-]{1,}$/', 'message' => '只能是英文或-'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'parent_id' => '菜单父级',
            'order' => '排序',
            'icon' => '菜单图标',
            'title' => '菜单名称',
            'describe' => '菜单描述',
            'module' => '模块',
            'controller' => '控制器',
            'action' => '方法',
            'param' => '参数',
            'is_delete' => '是否删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '编辑时间',
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['parent_id', 'order', 'icon', 'title', 'describe', 'module', 'controller', 'action'],
            'update' => ['parent_id', 'order', 'icon', 'title', 'describe', 'module', 'controller', 'action'],
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
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'module',
                    Base::EVENT_BEFORE_UPDATE => 'module',
                ],
                'value' => function ($event) {
                    return 'backend';
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'controller',
                    Base::EVENT_BEFORE_UPDATE => 'controller',
                ],
                'value' => function ($event) {
                    return strtolower($this->controller);
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'action',
                    Base::EVENT_BEFORE_UPDATE => 'action',
                ],
                'value' => function ($event) {
                    return strtolower($this->action);
                },
            ],
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


    /**
     * 树
     *
     * @return array
     */
    public function tree()
    {

        return $this->treeCalculate($this->find()->where(['is_delete' => 0])->orderBy('order asc')->asArray()->all());

    }


    /**
     * @return array
     */
    public function treeLevel()
    {

        $allPermissionList = Yii::$app->user->identity ? Yii::$app->user->identity->getAllPermissionList() : [];
        $treeList = $this->tree();

        $firstLevelList = [];
        foreach ($treeList as $tree) {
            if ($tree['level'] === 1) {
                $firstLevelList[] = array_merge($tree, ['data' => []]);
            }
        }

        foreach ($firstLevelList as $key => $treeLevel) {
            foreach ($treeList as $k => $tree) {
                if ($tree['level'] === 2 && $tree['parent_id'] === $treeLevel['id'] && in_array($tree['module'] . '/' . $tree['controller'] . '/' . $tree['action'], $allPermissionList, true)) {
                    $firstLevelList[$key]['data'][] = $tree;
                }
            }
        }

        foreach ($firstLevelList as $key => $treeLevel) {
            if (empty($treeLevel['data'])) {
                unset($firstLevelList[$key]);
            }
        }

        return $firstLevelList;

    }


    /**
     * @param $data
     * @param string $parent_id
     * @param int $level
     * @return array
     */
    protected function treeCalculate($data, $parent_id = '0', $level = 1)
    {

        $result = [];

        foreach ($data as $key => $value) {
            if ($value['parent_id'] === $parent_id) {
                $menu = $value;
                $menu['level'] = $level;
                $result[] = $menu;
                $parent_id_two = $value['id'];
                $result = array_merge($result, $this->treeCalculate($data, $parent_id_two, $level + 1));
            }
        }

        return $result;

    }


    /**
     * @param bool $withOutRoot
     * @return array
     */
    public function getParentIdList($withOutRoot = false)
    {

        $parentIdList = $withOutRoot ? [] : ['0' => '一级菜单'];

        $parentList = Menu::find()
            ->where(['parent_id' => 0, 'is_delete' => 0])
            ->orderBy('order asc')
            ->asArray()
            ->all();

        foreach ($parentList as $parent) {
            $parentIdList[$parent['id']] = $parent['title'];
        }

        return $parentIdList;

    }


}

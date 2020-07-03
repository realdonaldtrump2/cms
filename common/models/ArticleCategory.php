<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use kartik\tree\models\Tree;


/**
 * This is the model class for table "article_category".
 *
 * @property int $id 编号
 * @property int|null $root Tree root identifier
 * @property int $lft Nested set left property
 * @property int $rgt Nested set right property
 * @property int $lvl Nested set level / depth
 * @property string $name The tree node name / label
 * @property string|null $icon The icon to use for the node
 * @property int $icon_type Icon Type: 1 = CSS Class, 2 = Raw Markup
 * @property int $active Whether the node is active (will be set to false on deletion)
 * @property int $selected Whether the node is selected/checked by default
 * @property int $disabled Whether the node is enabled
 * @property int $readonly Whether the node is read only (unlike disabled - will allow toolbar actions)
 * @property int $visible Whether the node is visible
 * @property int $collapsed Whether the node is collapsed by default
 * @property int $movable_u Whether the node is movable one position up
 * @property int $movable_d Whether the node is movable one position down
 * @property int $movable_l Whether the node is movable to the left (from sibling to parent)
 * @property int $movable_r Whether the node is movable to the right (from sibling to child)
 * @property int $removable Whether the node is removable (any children below will be moved as siblings before deletion)
 * @property int $removable_all Whether the node is removable along with descendants
 * @property int $child_allowed Whether to allow adding children to the node
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class ArticleCategory extends Tree
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_category';
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
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'default' => ['name', 'icon'],
        ];
    }


    /**
     * @return array
     */
    public function tree()
    {

        $list = $this->find()
            ->select(['id', 'lft as order', 'name as category_name', 'icon as category_image', 'root as fid', 'lvl as level'])
            ->where(['active' => 1])
            ->orderBy('lft asc')
            ->asArray()
            ->all();

        foreach ($list as $key => $value) {
            $list[$key]['id'] = (int)$value['id'];
            $list[$key]['order'] = (int)$value['order'];
            $list[$key]['fid'] = (int)$value['fid'];
            $list[$key]['level'] = (int)$value['level'];
        }

        return $this->treeCalculate($list);

    }


    /**
     * @param $data
     * @return array
     */
    protected function treeCalculate($data)
    {

        $result = [];

        foreach ($data as $key => $value) {
            if ($value['level'] == 0) {
                $value['son'] = [];
                $result[] = $value;
            }
        }

        foreach ($result as $k => $v) {
            foreach ($data as $key => $value) {
                if ($value['level'] != 0) {
                    if ($v['id'] === $value['fid']) {
                        $result[$k]['son'][] = $value;
                    }
                }
            }
        }

        return $result;

    }


}

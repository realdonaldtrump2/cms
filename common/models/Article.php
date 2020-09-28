<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table "article".
 *
 * @property int $id 主键
 * @property int $user_id 文章作者
 * @property int $article_category_id 文章分类id
 * @property string $article_tag_id 文章标签id
 * @property string $title 文章标题
 * @property string $describe 文章简介
 * @property string $image_url 文章图片
 * @property string $file_url 文章附件
 * @property string $video_url 文章视频
 * @property int $click_count 文章点击数
 * @property int $sort 排序 越小越靠前 默认为0
 * @property int $is_recommend 是否推荐 0为不推荐 1为推荐 默认为0
 * @property int $is_show 是否显示 0为不显示 1为显示 默认为0
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class Article extends Base
{


    // 文章内容(大屏幕)
    public $detail;

    // 文章内容(小屏幕)
    public $detail_phone;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['title', 'required', 'message' => '文章标题不能为空'],
            ['title', 'string', 'min' => 1, 'tooShort' => '文章标题至少填写1位'],
            ['title', 'string', 'max' => 30, 'tooLong' => '文章标题最多填写30位'],
            ['describe', 'required', 'message' => '文章简介不能为空'],
            ['describe', 'string', 'min' => 1, 'tooShort' => '文章简介至少填写1位'],
            ['describe', 'string', 'max' => 255, 'tooLong' => '文章简介最多填写255位'],
            ['detail', 'required', 'message' => '文章内容(大屏幕)不能为空'],
            ['detail', 'string', 'min' => 1, 'tooShort' => '文章内容(大屏幕)至少填写1位'],
            ['detail', 'string', 'max' => 100000, 'tooLong' => '文章内容(大屏幕)最多填写100000位'],
            ['detail_phone', 'required', 'message' => '文章内容(大屏幕)不能为空'],
            ['detail_phone', 'string', 'min' => 1, 'tooShort' => '文章内容(大屏幕)至少填写1位'],
            ['detail_phone', 'string', 'max' => 100000, 'tooLong' => '文章内容(大屏幕)最多填写100000位'],
            ['sort', 'required', 'message' => '排序不能为空'],
            ['sort', 'integer', 'message' => '排序必须是整数'],
            ['sort', 'compare', 'compareValue' => 0, 'operator' => '>=', 'message' => '排序必须是整数'],
            ['is_recommend', 'boolean'],
            ['is_show', 'boolean'],
            ['category', 'required', 'message' => '文章分类不能为空'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'user_id' => '文章作者',
            'article_category_id' => '文章分类',
            'article_tag_id' => '文章标签',
            'title' => '文章标题',
            'describe' => '文章简介',
            'image_url' => '文章图片',
            'file_url' => '文章附件',
            'video_url' => '文章视频',
            'click_count' => '文章点击数',
            'sort' => '排序',
            'is_recommend' => '是否推荐',
            'is_show' => '是否显示',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
            'detail' => '文章内容(大屏幕)',
            'detail_phone' => '文章内容(小屏幕)',
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'create' => ['title', 'describe', 'sort', 'is_recommend', 'is_show', 'detail', 'detail_phone', 'article_category_id', 'article_tag_id'],
            'update' => ['title', 'describe', 'sort', 'is_recommend', 'is_show', 'detail', 'detail_phone', 'article_category_id', 'article_tag_id'],
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
                    Base::EVENT_BEFORE_INSERT => 'user_id',
                ],
                'value' => function ($event) {
                    return Yii::$app->user->id;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'image_url',
                    Base::EVENT_BEFORE_UPDATE => 'image_url',
                ],
                'value' => function ($event) {
                    return [];
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'file_url',
                    Base::EVENT_BEFORE_UPDATE => 'file_url',
                ],
                'value' => function ($event) {
                    return [];
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'video_url',
                    Base::EVENT_BEFORE_UPDATE => 'video_url',
                ],
                'value' => function ($event) {
                    return [];
                }
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
     * @return array
     */
    public function getArticleTagIdDataList()
    {

        $articleTagModelList = ArticleTag::find()
            ->where([
                'is_delete' => 0,
            ])
            ->all();

        $articleTagIdDataList = [];
        foreach ($articleTagModelList as $articleTagModel) {
            $articleTagIdDataList[$articleTagModel->id] = $articleTagModel->title;
        }

        return $articleTagIdDataList;

    }


}

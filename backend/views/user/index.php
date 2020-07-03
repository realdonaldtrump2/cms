<?php


use yii\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户列表';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="function-button-container">

    <a class="btn btn-primary searchFormSwitch"><i class="fa fa-search"></i> 筛选</a>

    <div class="pull-right">
        <?= Html::dropDownList(
            'per-page',
            isset(Yii::$app->request->get()['per-page']) ? Yii::$app->request->get('per-page') : $dataProvider->getPagination()->pageSize,
            [20 => '20条/页', 50 => '50条/页', 100 => '100条/页', 1000 => '1000条/页'],
            ['class' => 'form-control', 'style' => 'width: 120px;']
        ); ?>
    </div>
</div>

<?php echo $this->render('_search', ['model' => $searchModel]); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterSelector' => 'select[name="per-page"]',
    'emptyText' => '<span>当前没有内容</span>',
    'layout' => '<div class="table-responsive">{items}</div><div class="row" ><div class="col-xs-12 col-sm-12 col-md-8" >{pager}</div> <div class="col-xs-12 col-sm-12 col-md-4" ><div class="pull-right" ><ul class="pagination" >{summary}</ul></div></div></div>',
    'tableOptions' => ['class' => 'table table-striped table-bordered table-hover table-responsive'],
    'columns' => [
        [
            'class' => \yii\grid\CheckboxColumn::className(),
        ],
        'id',
        'phone',
        [
            'label' => '后台角色',
            'format' => 'raw',
            'value' => function ($model) {
                if ($model->role) {
                    return $model->role[0]->item_name;
                }
                return '无后台角色';
            }
        ],
        'create_datetime',
        [
            'attribute' => 'is_delete',
            'value' => 'isDeleteText',
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {frozen}',
            'buttons' => [
                'view' => function ($url, $model, $key) {

                    if (Yii::$app->user->can('backend/user/view')) {
                        return Html::a('查看', ['view', 'id' => $model->id], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }

                },
                'frozen' => function ($url, $model, $key) {

                    if (Yii::$app->user->can('backend/user/frozen')) {
                        if ($model->is_delete === 0) {
                            $options = [
                                'data-confirm' => '确认注销此手机号吗？注销后该手机号【' . $model->phone . '】不能进行在手机客户端与后台进行任何操作，立即生效。',
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'btn btn-outline btn-xs btn-primary',
                            ];
                            return Html::a('注销', ['frozen', 'id' => $model->id], $options);
                        }

                        $options = [
                            'data-confirm' => '确认解冻此手机号吗？解冻后该手机号【' . $model->phone . '】能进行在手机客户端与后台进行原有操作，立即生效。',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-outline btn-xs btn-primary',
                        ];
                        return Html::a('解冻', ['frozen', 'id' => $model->id, 'melt' => 'melt'], $options);
                    }

                },
            ]
        ],
    ],
    'pager' => [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'maxButtonCount' => 3
    ],
]); ?>

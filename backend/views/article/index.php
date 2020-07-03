<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '文章列表';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="function-button-container">

    <a class="btn btn-primary searchFormSwitch"><i class="fa fa-search"></i> 筛选</a>

    <?php if (Yii::$app->user->can('backend/article/create')): ?>
        <?= Html::a('<i class="fa fa-plus" ></i> 文章创建', ['create'], ['class' => 'btn btn-primary']) ?>
    <?php else: ?>
    <?php endif; ?>

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
        'title',
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/article/view')) {
                        return Html::a('查看', ['view', 'id' => $model->id], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }
                },
                'update' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/article/update')) {
                        return Html::a('编辑', ['update', 'id' => $model->id], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }
                },
                'delete' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/article/delete')) {
                        $options = [
                            'data-confirm' => '确认删除【' . $model->title . '】吗？',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-outline btn-xs btn-primary',
                        ];
                        return Html::a('删除', ['article/delete', 'id' => $model->id], $options);
                    }
                }
            ]
        ],
    ],
]); ?>

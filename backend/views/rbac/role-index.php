<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '角色列表';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="function-button-container">

    <a class="btn btn-primary searchFormSwitch"><i class="fa fa-search"></i> 筛选</a>

    <?php if (Yii::$app->user->can('backend/rbac/role-create')): ?>
        <?= Html::a('<i class="fa fa-plus" ></i> 创建角色', ['role-create'], ['class' => 'btn btn-primary']) ?>
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

<?php echo $this->render('_search-role-index', ['model' => $searchModel]); ?>

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
        [
            'attribute' => 'name',
            'label' => '角色名称'
        ],
        [
            'attribute' => 'description',
            'label' => '角色描述'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => '{view} {update} {role-permission}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/rbac/role-view')) {
                        return Html::a('查看', ['role-view', 'name' => $model->name], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }
                },
                'update' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/rbac/role-update')) {
                        return Html::a('编辑', ['role-update', 'name' => $model->name], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }
                },
                'role-permission' => function ($url, $model, $key) {
                    if (Yii::$app->user->can('backend/rbac/role-permission')) {
                        return Html::a('权限管理', ['role-permission', 'name' => $model->name], ['class' => 'btn btn-outline btn-xs btn-primary']);
                    }
                }
            ]
        ],
    ],
    'pager' => [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'maxButtonCount' => 3
    ],
]) ?>

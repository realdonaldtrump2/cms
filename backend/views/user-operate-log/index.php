<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserOperateLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户操作日志列表';
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
        [
            'attribute' => 'user_id',
            'format' => 'raw',
            'value' => function ($model) {
                return $model->user ? $model->user->phone : '';
            },
        ],
        'ip',
        'agent',
        'type',
        'module',
        'controller',
        'action',
        'create_datetime',
    ],
    'pager' => [
        'firstPageLabel' => '首页',
        'lastPageLabel' => '尾页',
        'maxButtonCount' => 3
    ],
]); ?>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use nullref\datatable\DataTable;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = '角色详情';
$this->params['breadcrumbs'][] = ['url' => ['role-index'], 'label' => '角色列表'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$rolePermission = [];
foreach ($model->rolePermission as $key => $permission) {
    $rolePermission[] = [
        'child' => $permission->child,
        'child_name' => $permission->permission->description
    ];
}

?>

<?= DetailView::widget([
    'model' => $model,
    'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
    'attributes' => [
        'name',
        'description',
    ],
]) ?>

<br>
<h4 class="text-center">角色权限</h4>

<?= DataTable::widget([
    'data' => $rolePermission,
    'tableOptions' => [
        'class' => 'table table-striped table-bordered table-hover table-responsive',
    ],
    // 'paging' => false,
    'language' => [
        'search' => '关键字',
        'processing' => '正在加载中',
        'zeroRecords' => '无数据',
        'info' => '显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项',
        'infoEmpty' => '无数据',
        'infoFiltered' => '(数据表中共 _MAX_ 条数据)',
        'lengthMenu' => '每页显示 _MENU_ 项',
        'paginate' => [
            'first' => '首页',
            'last' => '尾页',
            'next' => '下一页',
            'previous' => '上一页',
        ]
    ],
    'columns' => [
        [
            'title' => '权限url',
            'data' => 'child',
        ],
        [
            'title' => '权限地址',
            'data' => 'child_name',
        ],
    ],
]) ?>


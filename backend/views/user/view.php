<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = '用户详情';
$this->params['breadcrumbs'][] = ['url' => ['index'], 'label' => '用户列表'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="table-responsive">

    <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><td width="20%" ><label>{label}</label></td><td width="80%" >{value}</td></tr>',
        'attributes' => [
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
                'value' => function ($model) {
                    return $model->isDeleteText;
                },
            ],
        ],
    ]) ?>

</div>

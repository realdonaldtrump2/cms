<?php


use yii\helpers\Html;

$this->title = '菜单列表';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div class="function-button-container">

    <?php if (Yii::$app->user->can('backend/menu/create')): ?>
        <?= Html::a('<i class="fa fa-plus" ></i> 创建菜单', ['create'], ['class' => 'btn btn-primary']) ?>
    <?php else: ?>
    <?php endif; ?>

</div>

<div class="table-responsive">

    <table class="table table-striped table-bordered table-hover table-responsive">
        <thead>
        <tr>
            <th width="50" >排序</th>
            <th>菜单名称</th>
            <th>菜单链接</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>

        <?php foreach ($menuTree as $menu): ?>
            <tr>
                <td><?= $menu['order'] ?></td>
                <td>
                    <?php if ($menu['parent_id'] !== '0') {
                        echo ' │--- ';
                    } else {
                        echo "<i class='{$menu['icon']}' ></i>";
                    } ?>&nbsp;<?= $menu['title'] ?>
                </td>
                <td>
                    <?php if ($menu['parent_id'] !== '0') {
                        echo $menu['module'] ?>/<?= $menu['controller'] ?>/<?= $menu['action'];
                    } ?>
                </td>
                <td>
                    <?php if (Yii::$app->user->can('backend/menu/update')): ?>
                        <?= Html::a('编辑', ['update', 'id' => $menu['id']], ['class' => 'btn btn-outline btn-xs btn-primary']) ?>
                    <?php else: ?>
                    <?php endif; ?>

                    <?php if (Yii::$app->user->can('backend/menu/delete')): ?>
                        <?= Html::a('删除', ['delete', 'id' => $menu['id']], [
                            'data-confirm' => '确认删除【' . $menu['title'] . '】吗？',
                            'data-method' => 'post',
                            'data-pjax' => '0',
                            'class' => 'btn btn-outline btn-xs btn-primary',
                        ]) ?>
                    <?php else: ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>

</div>

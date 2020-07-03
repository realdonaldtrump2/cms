<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\multiselect\MultiSelectListBox;

$this->title = '角色权限管理';
$this->params['breadcrumbs'][] = ['url' => ['role-index'], 'label' => '角色列表'];
$this->params['breadcrumbs'][] = ['label' => $this->title];

$model->permission = ArrayHelper::getColumn($model->getPermission($model->name), 'child');
$allPermission = $model->getAllPermission();
$permissionValue = ArrayHelper::getColumn($allPermission, 'name');
$permissionData = [];
foreach ($allPermission as $permission) {
    $permissionData[$permission->name] = $permission->description . '(' . $permission->name . ')';
}

/* @var $this yii\web\View */
/* @var $model backend\models\User */

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'name')->textInput(['readonly' => 'readonly'])->label('角色名称') ?>

<?= $form->field($model, 'description')->textarea(['readonly' => 'readonly', 'rows' => 3])->label('角色名称') ?>

<?= $form->field($model, 'permission')->widget(MultiSelectListBox::className(), [
    'options' => ['multiple' => 'multiple'],
    'data' => $permissionData, // data as array
    'value' => $permissionValue, // if preselected
]) ?>

<div class="form-group">
    <div class='col-xs-12 col-sm-2'></div>
    <div class='col-xs-12 col-sm-10'>
        <?= Html::submitButton($model->isNewRecord ? '添加' : '编辑', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

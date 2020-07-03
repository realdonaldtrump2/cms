<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Menu */
/* @var $form yii\widgets\ActiveForm */

$model->module = 'backend';
if ($model->isNewRecord || $model->parent_id === 0) {
    $model->controller = 'controller';
    $model->action = 'action';
}

?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?php if ($model->isNewRecord): ?>

    <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
        'data' => $model->getParentIdList(),
        'options' => ['placeholder' => '请选择'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]) ?>

<?php else: ?>

    <?php if ($model->parent_id === 0): ?>

        <?= $form->field($model, 'parent_id')->dropDownList($model->getParentIdList(), ['disabled' => 'disabled']) ?>

    <?php else: ?>

        <?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
            'data' => $model->getParentIdList(true),
            'options' => ['placeholder' => '请选择'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]) ?>

    <?php endif; ?>

<?php endif; ?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'describe')->textarea(['rows' => 3]) ?>

<?= $form->field($model, 'module')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>

<?= $form->field($model, 'controller')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'order')->textInput(['type' => 'number', 'min' => 0]) ?>

<div class="form-group">
    <div class='col-xs-12 col-sm-2'></div>
    <div class='col-xs-12 col-sm-10'>
        <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

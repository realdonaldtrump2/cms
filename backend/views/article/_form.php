<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use kartik\tree\TreeViewInput;
use common\widgets\cropper\Cropper;
use common\widgets\richtext\Richtext;

use common\models\ArticleCategory;


/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'title')->textInput() ?>

<?= $form->field($model, 'category')->widget(TreeViewInput::className(), [
    'query' => ArticleCategory::find()->addOrderBy('root, lft'),
    'multiple' => false,
]) ?>

<?= $form->field($model, 'describe')->textarea() ?>

<?= $form->field($model, 'detail')->widget(Richtext::className(), [
    'id' => 'article-detail',
    'name' => 'Article[detail]',
    'value' => $model->detail,
    'scenario' => 'computer',
]) ?>

<?= $form->field($model, 'detail_phone')->widget(Richtext::className(), [
    'id' => 'article-detail_phone',
    'name' => 'Article[detail_phone]',
    'value' => $model->detail_phone,
    'scenario' => 'phone',
]) ?>

<?= $form->field($model, 'sort')->textInput(['type' => 'number', 'min' => 0]) ?>

<?= $form->field($model, 'is_recommend')->widget(SwitchInput::classname(), [
    'pluginOptions' => [
        'onText' => '是',
        'offText' => '否',
    ]
]) ?>

<?= $form->field($model, 'is_show')->widget(SwitchInput::classname(), [
    'pluginOptions' => [
        'onText' => '是',
        'offText' => '否',
    ]
]) ?>

<div class="form-group">
    <div class='col-xs-12 col-sm-2'></div>
    <div class='col-xs-12 col-sm-10'>
        <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


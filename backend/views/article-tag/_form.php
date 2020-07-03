<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ArticleTag */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'options' => ['class' => 'form-horizontal'],
    'fieldConfig' => [
        'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
    ]
]); ?>

<?= $form->field($model, 'title')->textInput() ?>

<div class="form-group">
    <div class='col-xs-12 col-sm-2'></div>
    <div class='col-xs-12 col-sm-10'>
        <?= Html::submitButton('确认', ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>


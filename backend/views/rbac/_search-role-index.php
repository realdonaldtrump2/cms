<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;


?>

<div class="operator-search well searchForm" hidden>

    <?php $form = ActiveForm::begin([
        'action' => ['role-index'],
        'method' => 'get',
        'options' => ['class' => 'form-horizontal'],
        'fieldConfig' => [
            'template' => "<div class='col-xs-12 col-sm-2 response-form-label'>{label}</div><div class='col-xs-12 col-sm-7'>{input}</div><div class='col-xs-12 col-sm-3 col-sm-offset-0'>{error}</div>",
        ]
    ]); ?>

    <?= $form->field($model, 'name')->label('角色名称') ?>

    <div class="form-group">
        <div class='col-xs-12 col-sm-2'></div>
        <div class='col-xs-12 col-sm-10'>
            <?= Html::submitButton('<i class="fa fa-search" ></i> 搜索', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('<i class="fa fa-refresh" ></i> 重置', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fa fa-reply" ></i> 清空', ['role-index'], ['class' => 'btn btn-primary search-form-clear']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


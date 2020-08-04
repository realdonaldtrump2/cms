<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ChineseCharacterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Chinese Characters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chinese-character-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Chinese Character', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'word',
            'oldword',
            'strokes',
            'pinyin',
            //'radicals',
            //'explain',
            //'more_explain',
            //'is_delete',
            //'create_datetime',
            //'update_datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>

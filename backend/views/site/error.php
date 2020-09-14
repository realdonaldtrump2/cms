<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '错误';
$this->context->layout = 'function';

?>

<div class="login_wrapper">
    <div class="animate form login_form">

        <h1 class="error-number text-center">500</h1>

        <h4 class="text-center">
            <?php echo Html::encode($message); ?>
        </h4>

        <h4 class="text-center">
            <a href="<?= Url::to(['site/index']); ?>">返回主页</a>
        </h4>

    </div>
</div>

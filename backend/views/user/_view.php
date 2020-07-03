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
                'label' => '类型',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->id === 1) {
                        return '【超级管理员】';
                    }

                    if ($model->userOperator) {
                        return '【运营商】' . $model->userOperator->operator->operator_name;
                    }

                    if ($model->userOperatorArea) {
                        return '【运营商区域】' .
                            $model->userOperatorArea->operator->operator_name . ' - ' .
                            $model->userOperatorArea->operatorArea->province_name . ' - ' .
                            $model->userOperatorArea->operatorArea->city_name . ' - ' .
                            $model->userOperatorArea->operatorArea->district_name;
                    }

                    if ($model->userShop) {
                        if ($model->userShop->shop_type === 1) {
                            if ($model->userShop->shop_id !== 0) {
                                return '【供货商】' .
                                    $model->userShop->shop->province_name . ' - ' .
                                    $model->userShop->shop->city_name . ' - ' .
                                    $model->userShop->shop->district_name . ' - ' .
                                    $model->userShop->shop->town_name . ' - ' .
                                    $model->userShop->shop->village_name . ' - ' .
                                    $model->userShop->shop->shop_name;
                            } else {
                                return '【供货商】未填写信息';
                            }
                        } else {
                            if ($model->userShop->shop_id !== 0) {
                                return '【订货商】' .
                                    $model->userShop->shop->province_name . ' - ' .
                                    $model->userShop->shop->city_name . ' - ' .
                                    $model->userShop->shop->district_name . ' - ' .
                                    $model->userShop->shop->town_name . ' - ' .
                                    $model->userShop->shop->village_name . ' - ' .
                                    $model->userShop->shop->shop_name;
                            } else {
                                return '【订货商】未填写信息';
                            }
                        }
                    }

                    if ($model->userDriver) {
                        $html = '';
                        $html .= '【司机】';
                        $html .= $model->userDriver->operator->operator_name;
                        $html .= ' - 配送线路：';
                        $html .= $model->userDriver->driver->operatorDistributionLine->distribution_line_show_name;
                        $html .= '   ';
                        $html .= $model->userDriver->driver->operatorDistributionLine->distribution_line_name;
                        return $html;
                    }
                }
            ],
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

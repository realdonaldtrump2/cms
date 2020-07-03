<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'user_operate_log'.
 *
 * @property int $id 编号
 * @property int $user_id 用户id
 * @property string $ip ip
 * @property string $agent 浏览器代理商
 * @property string $type 请求类型
 * @property string $module 模块
 * @property string $controller 控制器
 * @property string $action 方法
 * @property string $module_controller_action 模块/控制器/方法
 * @property array $param 参数
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 * @property mixed $user
 */
class UserOperateLog extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_operate_log';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'user_id' => '用户',
            'ip' => 'ip',
            'agent' => '浏览器代理商',
            'type' => '请求类型',
            'module' => '模块',
            'controller' => '控制器',
            'action' => '方法',
            'param' => '参数',
            'create_datetime' => '操作时间',
        ];
    }


    public static function record()
    {

        $model = new UserOperateLog();
        $model->user_id = Yii::$app->user->id ? Yii::$app->user->id : 0;
        $model->ip = Yii::$app->request->userIP;
        $model->agent = Yii::$app->request->headers->has('User-Agent') ? Yii::$app->request->headers->get('User-Agent') : '';
        $model->type = Yii::$app->request->method;
        $model->module = Yii::$app->controller->module->id;
        $model->controller = Yii::$app->controller->id;
        $model->action = Yii::$app->controller->action->id;
        $model->param = array_merge(Yii::$app->request->get(), Yii::$app->request->post());
        $model->save();

    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    /**
     * @inheritdoc
     * 软删除
     */
    public function beforeSoftDelete()
    {
        $this->update_datetime = date('Y-m-d H:i:s');
        return true;
    }


    /**
     * @inheritdoc
     * 软恢复
     */
    public function softRecover()
    {
        $this->scenario = 'recover';
        $this->is_delete = 0;
        $this->update_datetime = date('Y-m-d H:i:s');
        $this->save();
    }


    /**
     * @inheritdoc
     * 行为
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_datetime',
                'updatedAtAttribute' => 'update_datetime',
                'value' => date('Y-m-d H:i:s'),
            ],
            [
                'class' => SoftDeleteBehavior::className(),
                'softDeleteAttributeValues' => [
                    'is_delete' => 1
                ],
            ]
        ];
    }

}

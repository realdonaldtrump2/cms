<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'user_authentication_log'.
 *
 * @property int $id 编号
 * @property int $user_id 用户id
 * @property string $ip ip
 * @property string $agent 浏览器代理商
 * @property string $type 类型 0为未知  1为登录 2为退出
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 * @property mixed $user
 */
class UserAuthenticationLog extends Base
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_authentication_log';
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
            'type' => '类型',
            'create_datetime' => '操作时间',
        ];
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



    /**
     * 登录退出记录
     *
     * @param $type
     */
    public static function record($type)
    {
        try {
            $model = new UserAuthenticationLog();
            $model->user_id = Yii::$app->user->id;
            $model->ip = Yii::$app->request->userIP;
            $model->agent = Yii::$app->request->headers->has('User-Agent') ? Yii::$app->request->headers->get('User-Agent') : '';
            $model->type = $type;
            $model->save();
        } catch (\Exception $e) {
        }
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


}

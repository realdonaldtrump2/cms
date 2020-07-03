<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


/**
 * This is the model class for table 'user_sms'.
 *
 * @property int $id 编号
 * @property string $phone 手机号
 * @property string $scenario 场景
 * @property string $code 验证码
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class UserSms extends Base
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sms';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['phone', 'required', 'message' => '手机号不可以为空'],
            ['phone', 'string', 'min' => 11, 'tooShort' => '手机号至少填写11位'],
            ['phone', 'string', 'max' => 11, 'tooLong' => '手机号最多填写11位'],
            ['phone', 'match', 'pattern' => '/^1[3|4|7|5|8|9][0-9]\d{4,8}$/', 'message' => '手机号格式错误'],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = User::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if ($userModel) {
                        $this->addError($attribute, '手机号已存在');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-register']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = User::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if (!$userModel) {
                        $this->addError($attribute, '手机号不存在，不能获取验证码');
                        return false;
                    }

                    if ($userModel->is_delete !== 0) {
                        $this->addError($attribute, '该手机号已注销，不能获取验证码');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-find-password']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = User::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if ($userModel) {
                        $this->addError($attribute, '该手机号已存在，不能作为您的新手机号');
                        return false;
                    }

                    $userModel = Yii::$app->util->checkApiAuthorization();
                    if (!$userModel) {
                        $this->addError($attribute, '尚未登录');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-modify-phone']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $memberModel = Member::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if ($memberModel) {
                        $this->addError($attribute, '手机号已存在');
                        return false;
                    }

                }
            }, 'on' => ['api-mall-register']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $memberModel = Member::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if (!$memberModel) {
                        $this->addError($attribute, '手机号不存在，不能获取验证码');
                        return false;
                    }

                    if ($memberModel->is_delete !== 0) {
                        $this->addError($attribute, '该手机号已注销，不能获取验证码');
                        return false;
                    }

                }
            }, 'on' => ['api-mall-find-password']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $memberModel = Member::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->one();

                    if ($memberModel) {
                        $this->addError($attribute, '该手机号已存在，不能作为您的新手机号');
                        return false;
                    }

                }
            }, 'on' => ['api-mall-modify-phone']],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'phone' => '手机号',
            'type' => '类型',
            'code' => '验证码',
            'is_delete' => '删除状态 0正常 1删除',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'api-shop-register' => ['phone'],
            'api-shop-find-password' => ['phone'],
            'api-shop-modify-phone' => ['phone'],
            'api-shop-modify-bank' => ['phone'],
            'api-mall-register' => ['phone'],
            'api-mall-find-password' => ['phone'],
            'api-mall-bind-phone-password' => ['phone'],
            'api-mall-modify-phone' => ['phone'],
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
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'type',
                ],
                'value' => function ($event) {
                    return $this->scenario;
                }
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'code',
                ],
                'value' => function ($event) {
                    return Yii::$app->util->createSmsCode();
                }
            ],
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

<?php

namespace common\models;


use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;


class BackendUser extends Base
{


    private $_user;


    // 记住密码
    public $remember_me = true;


    // 手机号
    public $phone;


    // 密码
    public $password;


    // 新密码
    public $new_password;


    // 重复新密码
    public $confirm_password;


    // 找回密码短信验证码
    public $sms_code;


    // 验证码
    public $verify_code;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'password'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['phone', 'required', 'message' => '手机号不能为空'],
            ['phone', 'string', 'min' => 11, 'tooShort' => '手机号至少填写11位'],
            ['phone', 'string', 'max' => 11, 'tooLong' => '手机号最多填写11位'],
            ['phone', 'match', 'pattern' => '/^1[3|4|7|5|8|9][0-9]\d{4,8}$/', 'message' => '手机号格式错误'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'phone', 'message' => '手机号已存在', 'on' => ['register']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = $this->getUser();
                    if (!$userModel) {
                        $this->addError($attribute, '手机号不存在');
                        return false;
                    }

                }
            }, 'on' => ['reset-info']],
            ['password', 'required', 'message' => '密码不可以为空'],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码至少填写6位'],
            ['password', 'string', 'max' => 30, 'tooLong' => '密码最多填写30位'],
            ['password', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = $this->getUser();
                    if (!$userModel || !$userModel->validatePassword($this->password)) {
                        $this->addError($attribute, '手机号或密码错误');
                        return false;
                    }

                    $allRoleModelList = RbacAuthAssignment::find()
                        ->andFilterWhere(['=', 'user_id', $userModel->id])
                        ->all();

                    if (empty($allRoleModelList)) {
                        $this->addError($attribute, '没有权限，无法登录');
                        return false;
                    }

                }
            }, 'on' => ['login']],
            [['new_password', 'confirm_password'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['new_password', 'required', 'message' => '新密码不可以为空'],
            ['new_password', 'string', 'min' => 6, 'tooShort' => '新密码至少填写6位'],
            ['new_password', 'string', 'max' => 30, 'tooLong' => '新密码最多填写30位'],
            ['confirm_password', 'required', 'message' => '重复新密码不可以为空'],
            ['confirm_password', 'string', 'min' => 6, 'tooShort' => '重复新密码至少填写6位'],
            ['confirm_password', 'string', 'max' => 30, 'tooLong' => '重复新密码最多填写30位'],
            ['new_password', 'compare', 'compareAttribute' => 'confirm_password', 'message' => '两次新密码不一致'],
            ['sms_code', 'required', 'message' => '短信验证码不能为空'],
            ['sms_code', 'string', 'min' => 4, 'tooShort' => '短信验证码错误'],
            ['sms_code', 'string', 'max' => 4, 'tooLong' => '短信验证码错误'],
            ['sms_code', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $this->addError($attribute, '短信验证码错误');

                }
            }, 'on' => ['reset-info']],
            ['verify_code', 'required', 'message' => '验证码不能为空'],
            ['verify_code', 'captcha', 'message' => '验证码错误'],
            ['remember_me', 'boolean'],
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'phone' => '手机号',
            'password' => '密码',
            'new_password' => '新密码',
            'confirm_password' => '重复新密码',
            'remember_me' => '30天内免登录',
            'verify_code' => '验证码',
            'sms_code' => '短信验证码',
        ];
    }


    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return [
            'login' => ['phone', 'password', 'verify_code', 'remember_me'],
            'register' => ['phone', 'password'],
            'modify-info' => ['new_password', 'confirm_password'],
            'reset-info' => ['phone', 'password', 'sms_code'],
        ];
    }


    /**
     * Finds user by [[phone]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->phone);
        }
        return $this->_user;
    }


    /**
     * 登录
     *
     * @return bool
     */
    public function signIn()
    {

        if ($this->validate()) {
            if (Yii::$app->user->login($this->getUser(), $this->remember_me ? 2592000 : 0)) {
                return true;
            }
            return false;
        }

        return false;

    }


    /**
     * 注册
     *
     * @return bool|null
     * @throws \yii\base\Exception
     */
    public function signUp()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->phone = $this->phone;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save(false);

    }


    /**
     * 修改密码
     *
     * @return bool|null
     * @throws \yii\base\Exception
     */
    public function modifyInfo()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = User::findOne(Yii::$app->user->getId());
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($this->new_password);
        return $user->save(false);

    }


}

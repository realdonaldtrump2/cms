<?php

namespace common\models;


use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii2tech\ar\softdelete\SoftDeleteBehavior;
use yii\filters\RateLimitInterface;


/**
 * This is the model class for table 'user'.
 *
 * @property int $id 编号
 * @property string $phone 手机号
 * @property string $password 密码
 * @property string $old_md5_password 原密码(md5)
 * @property string $token token
 * @property string $recommend_code 推荐码
 * @property string $allowance allowance
 * @property string $allowance_datetime allowance_datetime
 * @property int $is_delete 删除状态 0正常 1删除
 * @property string $create_datetime 创建时间
 * @property string $update_datetime 最后更新时间
 */
class User extends ActiveRecord implements IdentityInterface
{


    private $_user;

    // 短信验证码
    public $sms_code;

    // 原密码
    public $old_password;

    // 新密码
    public $new_password;

    // 确认新密码
    public $confirm_new_password;

    // 新手机号
    public $new_phone;

    // 新手机号短信验证码
    public $new_sms_code;

    // 该用户所有角色
    public $allRoleList;


    /**
     * @inheritdoc
     * 表名
     */
    public static function tableName()
    {
        return 'user';
    }


    /**
     * @inheritdoc
     * 对数据的校验规则
     */
    public function rules()
    {
        return [
            [['phone', 'new_phone', 'password', 'sms_code', 'new_sms_code', 'old_password', 'new_password', 'confirm_new_password'], 'filter', 'filter' => 'trim', 'skipOnArray' => true],
            ['phone', 'required', 'message' => '手机号不可以为空'],
            ['phone', 'string', 'min' => 11, 'tooShort' => '手机号至少填写11位'],
            ['phone', 'string', 'max' => 11, 'tooLong' => '手机号最多填写11位'],
            ['phone', 'match', 'pattern' => '/^1[0|3|4|7|5|8|9][0-9]\d{4,8}$/', 'message' => '手机号格式错误'],
            ['phone', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'phone', 'message' => '手机号已存在', 'on' => ['api-shop-register', 'driver-create', 'operator-create']],
            ['phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = $this->getUser();

                    if (!$userModel) {
                        $this->addError($attribute, '手机号不存在');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-find-password']],
            ['new_phone', 'required', 'message' => '新手机号不可以为空'],
            ['new_phone', 'string', 'min' => 11, 'tooShort' => '新手机号至少填写11位'],
            ['new_phone', 'string', 'max' => 11, 'tooLong' => '新手机号最多填写11位'],
            ['new_phone', 'match', 'pattern' => '/^1[3|4|7|5|8|9][0-9]\d{4,8}$/', 'message' => '新手机号格式错误'],
            ['new_phone', 'unique', 'targetClass' => '\common\models\User', 'targetAttribute' => 'phone', 'message' => '手机号已存在', 'on' => ['api-shop-modify-phone']],
            ['new_phone', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    if ($this->new_phone === $this->phone) {
                        $this->addError($attribute, '新手机号不能与原手机号相同');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-modify-phone']],
            ['password', 'required', 'message' => '密码不可以为空'],
            ['password', 'string', 'min' => 6, 'tooShort' => '密码至少填写6位'],
            ['password', 'string', 'max' => 30, 'tooLong' => '密码最多填写30位'],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]{6,30}$/', 'message' => '密码由大小写英文字母与数字组成'],
            ['password', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    $userModel = $this->getUser();

                    if (!$userModel || !$userModel->validatePassword($this->password)) {
                        $this->addError($attribute, '手机号密码错误');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-login']],
            ['sms_code', 'required', 'message' => '短信验证码不能为空'],
            ['sms_code', 'string', 'min' => 4, 'tooShort' => '短信验证码错误'],
            ['sms_code', 'string', 'max' => 4, 'tooLong' => '短信验证码错误'],
            ['sms_code', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    // api注册短信验证码验证
                    $userSmsModel = UserSms::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->andFilterWhere(['=', 'type', 'api-shop-register'])
                        ->orderBy('id DESC')
                        ->one();

                    if (!$userSmsModel) {
                        $this->addError($attribute, '短信验证码错误');
                        return false;
                    }

                    if ($userSmsModel->code !== $this->sms_code) {
                        $this->addError($attribute, '短信验证码错误');
                        return false;
                    }

                    if (time() - strtotime($userSmsModel->create_datetime) > Yii::$app->params['aliSmsExpirationSecond']) {
                        $this->addError($attribute, '短信验证码已失效，请获取新的短信验证码');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-register']],
            ['sms_code', function ($attribute, $params) {
                // api重置密码短信验证码验证
                if (!$this->hasErrors()) {

                    $userSmsModel = UserSms::find()
                        ->andFilterWhere(['=', 'phone', $this->phone])
                        ->andFilterWhere(['=', 'type', 'api-shop-find-password'])
                        ->orderBy('id DESC')
                        ->one();

                    if (!$userSmsModel) {
                        $this->addError($attribute, '短信验证码错误');
                        return false;
                    }

                    if ($userSmsModel->code !== $this->sms_code) {
                        $this->addError($attribute, '短信验证码错误');
                        return false;
                    }

                    if (time() - strtotime($userSmsModel->create_datetime) > Yii::$app->params['aliSmsExpirationSecond']) {
                        $this->addError($attribute, '短信验证码已失效，请获取新的短信验证码');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-find-password']],
            ['new_sms_code', 'required', 'message' => '新手机短信验证码不能为空'],
            ['new_sms_code', 'string', 'min' => 4, 'tooShort' => '新手机短信验证码错误'],
            ['new_sms_code', 'string', 'max' => 4, 'tooLong' => '新手机短信验证码错误'],
            ['new_sms_code', function ($attribute, $params) {
                // api重置密码短信验证码验证
                if (!$this->hasErrors()) {

                    $userSmsModel = UserSms::find()
                        ->andFilterWhere(['=', 'phone', $this->new_phone])
                        ->andFilterWhere(['=', 'type', 'api-shop-modify-phone'])
                        ->orderBy('id DESC')
                        ->one();

                    if (!$userSmsModel) {
                        $this->addError($attribute, '新手机短信验证码错误');
                        return false;
                    }

                    if ($userSmsModel->code !== $this->new_sms_code) {
                        $this->addError($attribute, '新手机短信验证码错误');
                        return false;
                    }

                    if (time() - strtotime($userSmsModel->create_datetime) > Yii::$app->params['aliSmsExpirationSecond']) {
                        $this->addError($attribute, '新手机短信验证码已失效，请获取新的短信验证码');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-modify-phone']],
            ['old_password', 'required', 'message' => '原密码不可以为空'],
            ['old_password', 'string', 'min' => 6, 'tooShort' => '原密码至少填写6位'],
            ['old_password', 'string', 'max' => 30, 'tooLong' => '原密码最多填写30位'],
            ['old_password', 'match', 'pattern' => '/^[a-zA-Z0-9]{6,30}$/', 'message' => '原密码由大小写英文字母与数字组成'],
            ['old_password', function ($attribute, $params) {
                if (!$this->hasErrors()) {

                    // 检测原密码是否相等
                    if (Yii::$app->security->validatePassword($this->old_password, $this->password)) {
                    } else {
                        $this->addError($attribute, '原密码错误');
                        return false;
                    }

                }
            }, 'on' => ['api-shop-modify-password']],
            ['new_password', 'required', 'message' => '新密码不可以为空'],
            ['new_password', 'string', 'min' => 6, 'tooShort' => '新密码至少填写6位'],
            ['new_password', 'string', 'max' => 30, 'tooLong' => '新密码最多填写30位'],
            ['new_password', 'match', 'pattern' => '/^[a-zA-Z0-9]{6,30}$/', 'message' => '新密码由大小写英文字母与数字组成'],
            ['new_password', 'compare', 'compareAttribute' => 'confirm_new_password', 'message' => '两次新密码不相等'],
            ['confirm_new_password', 'required', 'message' => '确认新密码不可以为空'],
            ['confirm_new_password', 'string', 'min' => 6, 'tooShort' => '确认新密码至少填写6位'],
            ['confirm_new_password', 'string', 'max' => 30, 'tooLong' => '确认新密码最多填写30位'],
            ['confirm_new_password', 'match', 'pattern' => '/^[a-zA-Z0-9]{6,30}$/', 'message' => '确认新密码由大小写英文字母与数字组成'],
        ];
    }


    /**
     * @inheritdoc
     * label命名
     */
    public function attributeLabels()
    {
        return [
            'id' => '编号',
            'phone' => '手机号',
            'password' => '密码',
            'token' => '密钥',
            'allowance' => '接口速率',
            'allowance_datetime' => '接口速率',
            'is_delete' => '状态',
            'create_datetime' => '创建时间',
            'update_datetime' => '最后更新时间',
        ];
    }


    public function getIsDeleteText()
    {
        switch ($this->is_delete) {
            case 0:
                $text = '正常';
                break;
            case 1:
                $text = '已注销';
                break;
            default:
                $text = '未知';
                break;
        }
        return $text;
    }


    /**
     * @inheritdoc
     * 场景
     */
    public function scenarios()
    {
        return [
            'recover' => []
        ];
    }


    public function transactions()
    {
        return [
        ];
    }


    public static function findOneUnDelete($id)
    {
        return static::find()->where(['id' => $id, 'is_delete' => 0])->one();
    }


    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {

        if ($this->_user === null) {
            $this->_user = static::findOne(['phone' => $this->phone, 'is_delete' => 0]);
        }

        return $this->_user;

    }


    /**
     * 用户-角色关联
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {

        return $this->hasMany(RbacAuthAssignment::className(), ['user_id' => 'id']);

    }


    /**
     * @return array
     */
    public function getAllRoleList()
    {

        if (!Yii::$app->user->identity) {
            return [];
        }

        if ($this->allRoleList === null) {

            $this->allRoleList = array_column(RbacAuthAssignment::find()
                ->andFilterWhere(['=', 'user_id', Yii::$app->user->id])
                ->asArray()
                ->all(), 'item_name');

        }

        return $this->allRoleList;

    }


    public function getAllPermissionList()
    {

        $allRoleList = $this->getAllRoleList();

        $allPermissionList = array_column(RbacAuthItemChild::find()
            ->andFilterWhere(['in', 'parent', empty($allRoleList) ? [-1] : $allRoleList])
            ->all(), 'child');

        return array_unique($allPermissionList);

    }


    /**
     * 检测是否是超级管理员
     *
     * @return bool
     */
    public function checkIsAdmin()
    {

        $allRoleList = $this->getAllRoleList();

        if (in_array(Yii::$app->params['backendLevel']['admin'], $allRoleList, TRUE)) {
            return true;
        }

        return false;

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
                    Base::EVENT_BEFORE_INSERT => 'recommend_code',
                ],
                'value' => function ($event) {

                    return Yii::$app->util->createUuid();

                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'password',
                ],
                'value' => function ($event) {
                    if (in_array($this->scenario, ['mall-shop-create'])) {
                        return Yii::$app->security->generatePasswordHash($this->password);
                    }

                    return $this->password;
                },
            ],
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    Base::EVENT_BEFORE_INSERT => 'token',
                ],
                'value' => function ($event) {
                    if (in_array($this->scenario, ['mall-shop-create'])) {
                        return Yii::$app->security->generateRandomString();
                    }

                    return $this->token;
                },
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


    /**
     *
     * 根据指定的用户ID查找 认证模型类的实例，当你需要使用session来维持登录状态的时候会用到这个方法
     *
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'is_delete' => 0]);
    }


    /**
     *
     * 根据指定的存取令牌查找 认证模型类的实例，该方法用于 通过单个加密令牌认证用户的时候（比如无状态的RESTful应用）。
     *
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['token' => $token, 'is_delete' => 0]);
    }


    /**
     * Finds user by phone
     *
     * @param string $phone
     * @return static|null
     */
    public static function findByUsername($phone)
    {
        return static::findOne(['phone' => $phone, 'is_delete' => 0]);
    }


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => 0,
        ]);
    }


    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }


    /**
     * 获取该认证实例表示的用户的ID
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }


    //获取基于 cookie 登录时使用的认证密钥。 认证密钥储存在 cookie 里并且将来会与服务端的版本进行比较以确保 cookie的有效性。

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->token;
    }


    //是基于 cookie 登录密钥的 验证的逻辑的实现。

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }


    /**
     * Generates 'remember me' authentication key
     * @throws \yii\base\Exception
     */
    public function generateAuthKey()
    {
        $this->token = Yii::$app->security->generateRandomString();
    }


    /**
     * Generates new password reset token
     * @throws \yii\base\Exception
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


}

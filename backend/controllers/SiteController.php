<?php

namespace backend\controllers;


use Yii;
use yii\filters\AccessControl;
use common\models\BackendUser;


class SiteController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['offline'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                    ],
                    [
                        'actions' => ['captcha'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get', 'post'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['post'],
                    ],
                    [
                        'actions' => ['error'],
                        'allow' => true,
                        'roles' => ['?', '@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['get'],
                    ],
                    [
                        'actions' => ['modify-info'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['get', 'post'],
                    ],
                    [
                        'actions' => ['modify-info'],
                        'allow' => true,
                        'roles' => ['@'],
                        'verbs' => ['get', 'post'],
                    ],
                ]
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'backColor' => 0x000000, //背景颜色
                'foreColor' => 0xffffff, //字体颜色
                'maxLength' => 6, //最大显示个数
                'minLength' => 6, //最少显示个数
                'padding' => 5, //间距
                'height' => 34, //高度
                'width' => 130, //宽度
                'offset' => 4, //设置字符偏移量 有效果
            ],
        ];

    }


    /**
     * 验证码
     */
    public function actionCaptcha()
    {

        $this->layout = false;

    }


    /**
     * 主页
     *
     * @return string
     */
    public function actionIndex()
    {

        return $this->render('index');

    }


    /**
     *  登录
     *
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new BackendUser();
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post()) && $model->signIn()) {
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);

    }


    /**
     * 注册
     *
     * @return string|\yii\web\Response
     */
//    public function actionRegister()
//    {
//
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new BackendUser();
//        $model->scenario = 'register';
//        if ($model->load(Yii::$app->request->post()) && $model->signUp()) {
//            return $this->redirect(['login']);
//        }
//        return $this->render('register', [
//            'model' => $model,
//        ]);
//
//    }


    /**
     * 退出
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();
        return $this->redirect(['login']);

    }


    /**
     * 修改个人信息
     *
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionModifyInfo()
    {

        $model = new BackendUser();
        $model->scenario = 'modify-info';
        if ($model->load(Yii::$app->request->post()) && $model->modifyInfo()) {
            return $this->goHome();
        }

        return $this->renderAjax('modify-info', [
            'model' => $model,
        ]);

    }


    /**
     * 重置个人信息
     *
     * @return string|\yii\web\Response
     */
//    public function actionResetInfo()
//    {
//
//        $model = new BackendUser();
//        $model->scenario = 'reset-info';
//        if ($model->load(Yii::$app->request->post()) && $model->modifyInfo()) {
//            return $this->goHome();
//        } else {
//            return $this->render('reset-info', [
//                'model' => $model,
//            ]);
//        }
//
//    }


    /**
     * 维护
     *
     * @return string
     */
    public function actionOffline()
    {

        return $this->render('offline');

    }


}

<?php

namespace frontend\controllers;


use Yii;
use yii\filters\AccessControl;


class ArticleController extends BaseController
{


    public $layout = 'article';


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');

    }


    /**
     * @return mixed
     */
    public function actionList()
    {

        return $this->render('list');

    }


    /**
     * @return mixed
     */
    public function actionView()
    {

        return $this->render('view');

    }


    /**
     * @return mixed
     */
    public function actionAbout()
    {

        return $this->render('about');

    }


    /**
     * @return mixed
     */
    public function actionContact()
    {

        return $this->render('contact');

    }


}

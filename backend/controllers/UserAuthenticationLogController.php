<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\UserAuthenticationLog;
use common\models\UserAuthenticationLogSearch;


/**
 * UserAuthenticationLogController implements the CRUD actions for UserAuthenticationLog model.
 */
class UserAuthenticationLogController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }


    public function beforeAction($action)
    {

        if (!parent::beforeAction($action)) {
            return false;
        }

        $module = Yii::$app->controller->module->id;
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;

        if (Yii::$app->user->can($module . '/' . $controller . '/' . $action) && Yii::$app->user->identity->checkIsAdmin()) {
            return true;
        }

        throw new UnauthorizedHttpException('没有操作权限');

    }


    /**
     * Lists all UserAuthenticationLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAuthenticationLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


}

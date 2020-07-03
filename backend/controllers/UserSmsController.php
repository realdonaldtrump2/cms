<?php

namespace backend\controllers;


use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\UserSms;
use common\models\UserSmsSearch;


/**
 * UserSmsController implements the CRUD actions for UserSms model.
 */
class UserSmsController extends BaseController
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
     * Lists all UserSms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Finds the UserSms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserSms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = UserSms::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在');

    }


}

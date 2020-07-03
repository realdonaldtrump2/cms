<?php

namespace backend\controllers;


use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\User;
use backend\models\UserSearch;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        if (Yii::$app->request->isAjax) {
            return $this->renderPartial('_view', [
                'model' => $this->findModel($id),
            ]);
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }


    /**
     * 运营商级别账号创建
     *
     * @return string|\yii\web\Response
     */
    public function actionOperatorCreate()
    {

        $model = new User();
        $model->scenario = 'operator-create';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('operator-create', [
            'model' => $model,
        ]);

    }


    /**
     * 运营商管理区域级别账号创建
     *
     * @return string|\yii\web\Response
     */
    public function actionOperatorAreaCreate()
    {

        $model = new User();
        $model->scenario = 'operator-area-create';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('operator-area-create', [
            'model' => $model,
        ]);

    }


    /**
     * 注销账号/解冻账号
     *
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionFrozen($id)
    {

        $melt = Yii::$app->request->get('melt');

        $model = $this->findModel($id);

        if ($melt === 'melt') {

            if ($model->is_delete !== 1) {
                throw new NotFoundHttpException('页面不存在');
            }
            $model->token = Yii::$app->security->generateRandomString();
            $model->is_delete = 0;
            $model->save(false);
            return $this->redirect(['index']);

        }

        if ($model->is_delete !== 0) {
            throw new NotFoundHttpException('页面不存在');
        }
        $model->token = Yii::$app->security->generateRandomString();
        $model->is_delete = 1;
        $model->save(false);
        return $this->redirect(['index']);

    }


    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在');

    }


}

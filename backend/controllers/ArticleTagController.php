<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\ArticleTag;
use backend\models\ArticleTagSearch;


/**
 * ArticleTagController implements the CRUD actions for ArticleTag model.
 */
class ArticleTagController extends BaseController
{


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }


    /**
     * @param \yii\base\Action $action
     * @return bool
     * @throws UnauthorizedHttpException
     */
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
     * Lists all ArticleTag models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleTagSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single ArticleTag model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new ArticleTag model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleTag();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    /**
     * Updates an existing ArticleTag model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


    /**
     * Deletes an existing ArticleTag model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->softDelete();
        return $this->redirect(['index']);

    }


    /**
     * Finds the ArticleTag model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleTag the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleTag::findOneUnDelete($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在');
    }


}

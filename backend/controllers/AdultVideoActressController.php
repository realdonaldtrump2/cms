<?php

namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;
use common\models\AdultVideoActress;
use common\models\AdultVideoActressWork;
use backend\models\AdultVideoActressSearch;
use backend\models\AdultVideoActressWorkSearch;


/**
 * AdultVideoActressController implements the CRUD actions for AdultVideoActress model.
 */
class AdultVideoActressController extends BaseController
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
     * Lists all AdultVideoActress models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new AdultVideoActressSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//        dd($dataProvider->pagination);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdultVideoActress model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
//        $data = AdultVideoActressWork::find();  //User为model层,在控制器刚开始use了field这个model,这儿可以直接写Field,开头大小写都可以,为了规范,我写的是大写
//        $pages = new Pagination(['totalCount' => $data->count(), 'pageSize' => '10']);    //实例化分页类,带上参数(总条数,每页显示条数)
//
//        dd($pages);

        return $this->render('view', [
            'pages' => $pages,
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new AdultVideoActress model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AdultVideoActress();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AdultVideoActress model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AdultVideoActress model.
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
     * Finds the AdultVideoActress model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AdultVideoActress the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdultVideoActress::findOneUnDelete($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('页面不存在');
    }


}

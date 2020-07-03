<?php

namespace backend\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\UnauthorizedHttpException;

use common\models\RbacAuthItem;
use common\models\RbacAuthRule;
use common\models\RbacAuthAssignment;
use common\models\RbacAuthItemChild;
use common\models\RbacAuthItemSearch;


class RbacController extends BaseController
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
     * 权限列表
     *
     * @return string
     */
    public function actionPermissionIndex()
    {
        $searchModel = new RbacAuthItemSearch();
        $searchModel->type = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(false);
        return $this->render('permission-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 权限创建
     *
     * @return string|\yii\web\Response
     */
    public function actionPermissionCreate()
    {
        $model = new RbacAuthItem();
        $model->scenario = 'create-permission';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['permission-index']);
        } else {
            return $this->render('permission-create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * 权限编辑
     *
     * @param $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionPermissionUpdate($name)
    {
        $model = $this->findPermissionModel($name);
        $model->scenario = 'update-role';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['permission-index']);
        } else {
            return $this->render('permission-update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * 角色权限管理
     *
     * @param $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRolePermission($name)
    {
        $model = $this->findRoleModel($name);
        $model->scenario = 'role-permission';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['role-index']);
        } else {
            return $this->render('role-permission', [
                'model' => $model,
            ]);
        }
    }


    /**
     * 角色列表
     *
     * @return string
     */
    public function actionRoleIndex()
    {
        $searchModel = new RbacAuthItemSearch();
        $searchModel->type = 1;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('role-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * 角色创建
     *
     * @return string|\yii\web\Response
     */
    public function actionRoleCreate()
    {
        $model = new RbacAuthItem();
        $model->scenario = 'create-role';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['role-index']);
        } else {
            return $this->render('role-create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * 角色编辑
     *
     * @param $name
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionRoleUpdate($name)
    {
        $model = $this->findRoleModel($name);
        $model->scenario = 'update-role';
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['role-index']);
        } else {
            return $this->render('role-update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * 角色详情
     *
     * @param $name
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionRoleView($name)
    {
        return $this->render('role-view', [
            'model' => $this->findRoleModel($name),
        ]);
    }


    protected function findRoleModel($name)
    {
        if (($model = RbacAuthItem::findRoleByName($name)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('页面不存在');
    }


    protected function findPermissionModel($name)
    {
        if (($model = RbacAuthItem::findPermissionByName($name)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('页面不存在');
    }


    /**
     * 扫描
     *
     * @return \yii\web\Response
     */
    public function actionPermissionScan()
    {

        $rawControllerAndAction = $this->getControllerAndAction();
        $controllerAndAction = [];
        foreach ($rawControllerAndAction as $controller => $actionList) {
            foreach ($actionList as $action) {
                $controllerAndAction[] = [
                    'backend',
                    Yii::$app->formatField->bigUpperToMiddleLine($controller),
                    Yii::$app->formatField->bigUpperToMiddleLine($action),
                ];
            }
        }

        foreach ($controllerAndAction as $value) {
            $model = RbacAuthItem::find()
                ->andFilterWhere(['=', 'name', $value[0] . '/' . $value[1] . '/' . $value[2]])
                ->andFilterWhere(['=', 'type', 2])
                ->one();
            if (!$model) {
                $model = new RbacAuthItem();
                $model->isNewRecord = true;
                $model->name = $value[0] . '/' . $value[1] . '/' . $value[2];
                $model->type = 2;
                $model->description = '未设置';
                $model->save(false);
            }
        }

        return $this->redirect(['permission-index']);

    }


    /**
     *  getControllerAndAction
     *
     * @return array
     */
    protected function getControllerAndAction()
    {

        $controllerList = [];
        if ($handle = opendir('../controllers')) {
            while (false !== ($file = readdir($handle))) {
                if ($file != "." && $file != ".." && substr($file, strrpos($file, '.') - 10) == 'Controller.php') {
                    $controllerList[] = $file;
                }
            }
            closedir($handle);
        }
        asort($controllerList);
        $fullList = [];
        foreach ($controllerList as $controller):
            $handle = fopen('../controllers/' . $controller, "r");
            if ($handle) {
                while (($line = fgets($handle)) !== false) {
                    if (preg_match('/public function action(.*?)\(/', $line, $display)):
                        if (strlen($display[1]) > 2):
                            $fullList[substr($controller, 0, -14)][] = $display[1];
                        endif;
                    endif;
                }
            }
            fclose($handle);
        endforeach;
        return $fullList;

    }


}


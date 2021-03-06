<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\RestaurantTables;
use common\models\RestaurantTablesSearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantTablesController implements the CRUD actions for RestaurantTables model.
 */
class RestaurantTablesController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /* public function behaviors()
    {
    return [
    'verbs' => [
    'class' => VerbFilter::className(),
    'actions' => [
    'delete' => ['POST'],
    ],
    ],
    ];
    }*/

    /**
     * Lists all RestaurantTables models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");
        if ((($user->role_id == Yii::$app->params['userroles']['manager']) && ($user->restaurant_id == $snRestaurantId)) || (($user->role_id == Yii::$app->params['userroles']['admin']) || ($user->role_id == Yii::$app->params['userroles']['super_admin']))) {
            $snLayoutId = ($_GET['lid'] > 0) ? $_GET['lid'] : 0;
            $snRestaurantName = Common::get_name_by_id($snRestaurantId, $flag = "Restaurants");
            $snLayoutName = Common::get_name_by_id($snLayoutId, $flag = "RestaurantFloors");
            $searchModel = new RestaurantTablesSearch();

            $dataProvider = $searchModel->backendsearch(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'snRestaurantName' => $snRestaurantName,
                'snLayoutName' => $snLayoutName,
            ]);
        } else {
            throw new BadRequestHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single RestaurantTables model.
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
     * Creates a new RestaurantTables model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "popup";
        $model = new RestaurantTables();
        $model->restaurant_id = !empty($_GET['rid']) ? $_GET['rid'] : 0;
        $model->floor_id = !empty($_GET['lid']) ? $_GET['lid'] : 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_table_add_message'));
            return Common::closeColorBox();
            return $this->redirect(['index', 'rid' => $model->restaurant_id, 'lid' => $model->floor_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing RestaurantTables model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $this->layout = "popup";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_table_update_message'));
            return Common::closeColorBox();
            return $this->redirect(['index', 'rid' => $model->restaurant_id, 'lid' => $model->floor_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RestaurantTables model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_table_delete_message'));
        return $this->redirect(['index', 'rid' => $model->restaurant_id, 'lid' => $model->floor_id]);
    }

    /**
     * Finds the RestaurantTables model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantTables the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantTables::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

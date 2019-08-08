<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\components\Common;
use common\models\RestaurantFloors;
use common\models\RestaurantFloorsSearch;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * RestaurantFloorsController implements the CRUD actions for RestaurantFloors model.
 */
class RestaurantFloorsController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
/*    public function behaviors()
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
     * Lists all RestaurantFloors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $user = Common::get_user_role(Yii::$app->user->id, $flag = "1");
        if ((($user->role_id == Yii::$app->params['userroles']['manager']) && ($user->restaurant_id == $snRestaurantId)) || (($user->role_id == Yii::$app->params['userroles']['admin']) || ($user->role_id == Yii::$app->params['userroles']['super_admin']))) {
            $snRestaurantName = Common::get_name_by_id($snRestaurantId, $flag = "Restaurants");
            $searchModel = new RestaurantFloorsSearch();
            $dataProvider = $searchModel->backendSearch(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'snRestaurantName' => $snRestaurantName,
            ]);
        } else {
            throw new BadRequestHttpException('The requested page does not exist.');

        }
    }

    /**
     * Displays a single RestaurantFloors model.
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
     * Creates a new RestaurantFloors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*  public function actionCreate()
    {
    $this->layout = "popup";
    $model = new RestaurantFloors();
    $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
    $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
    $model->restaurant_id = $_GET['rid'];

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
    Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_layout_add_message' ) );
    return Common::closeColorBox();
    return $this->redirect(['index', 'rid' => $model->restaurant_id]);
    }

    return $this->render('create', [
    'model' => $model,
    'snRestaurantName' => $snRestaurantName,
    ]);
    }*/

    /**
     * Updates an existing RestaurantFloors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*  public function actionUpdate($id)
    {
    $this->layout = 'popup';
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
    Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_layout_update_message'));
    return Common::closeColorBox();
    return $this->redirect(['menu-categories/index']);
    }

    return $this->render('update', [
    'model' => $model,
    ]);
    }*/

    /**
     * Deletes an existing RestaurantFloors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionDelete($id)
    {
    $this->findModel($id)->delete();

    Yii::$app->session->setFlash('success', Yii::getAlias('@restaurant_layout_delete_message'));
    return $this->redirect(['index', 'rid' => $model->restaurant_id]);
    }*/

    /**
     * Finds the RestaurantFloors model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantFloors the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantFloors::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

<?php

namespace backend\controllers;

use Yii;
use common\models\RestaurantLayout;
use common\models\RestaurantLayoutSearch;
use yii\web\Controller;
use backend\components\AdminCoreController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Common;
/**
 * RestaurantLayoutController implements the CRUD actions for RestaurantLayout model.
 */
class RestaurantLayoutController extends AdminCoreController
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
     * Lists all RestaurantLayout models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
        $searchModel = new RestaurantLayoutSearch();
        $dataProvider = $searchModel->backendSearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snRestaurantName' => $snRestaurantName,
        ]);
    }

    /**
     * Displays a single RestaurantLayout model.
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
     * Creates a new RestaurantLayout model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = "popup";
        $model = new RestaurantLayout();
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
    }

    /**
     * Updates an existing RestaurantLayout model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    { 
        $this->layout = 'popup';
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_layout_update_message' ) );
            return Common::closeColorBox();
            return $this->redirect( ['menu-categories/index'] );
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing RestaurantLayout model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_layout_delete_message' ) );
        return $this->redirect(['index', 'rid' => $model->restaurant_id]);
    }

    /**
     * Finds the RestaurantLayout model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantLayout the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantLayout::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

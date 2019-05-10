<?php

namespace backend\controllers;

use Yii;
use common\models\MenuCategories;
use common\models\MenuCategoriesSearch;
use yii\web\Controller;
use backend\components\AdminCoreController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\components\Common;

/**
 * MenuCategoriesController implements the CRUD actions for MenuCategories model.
 */
class MenuCategoriesController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
  /*  public function behaviors()
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
     * Lists all MenuCategories models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuCategoriesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MenuCategories model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $this->layout = 'popup';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MenuCategories model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'popup';
        $model = new MenuCategories();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->session->setFlash( 'success', Yii::getAlias( '@menu_category_add_message' ) );
            return Common::closeColorBox();
            return $this->redirect( ['menu-categories/index'] );
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MenuCategories model.
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
             Yii::$app->session->setFlash( 'success', Yii::getAlias( '@menu_category_update_message' ) );
            return Common::closeColorBox();
            return $this->redirect( ['menu-categories/index'] );
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MenuCategories model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $snDeleteStatus = $this->findModel( $id )->delete();
        if ( !empty( $snDeleteStatus ) && $snDeleteStatus=='1' ) {
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@menu_category_delete_message' ) );
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the MenuCategories model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MenuCategories the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuCategories::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

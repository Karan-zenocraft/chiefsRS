<?php

namespace backend\controllers;

use backend\components\AdminCoreController;
use common\models\Tags;
use common\models\TagsSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TagsController implements the CRUD actions for Tags model.
 */
class TagsController extends AdminCoreController
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
     * Lists all Tags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TagsSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (Yii::$app->request->isPjax) {

            return $this->renderPartial('index', [

                'searchModel' => $searchModel,

                'dataProvider' => $dataProvider,

            ]);

        } else {

            return $this->render('index', [

                'searchModel' => $searchModel,

                'dataProvider' => $dataProvider,

            ]);

        }
    }

    /**
     * Displays a single Tags model.
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
     * Creates a new Tags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Tags();
        $model->scenario = "create";
        if ($model->load(Yii::$app->request->post())) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image');
            if (!empty($file)) {
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;
                $model->image = $file_name;
                if ($model->validate()) {
                    $model->save();
                    $file->saveAs(Yii::getAlias('@root') . '/frontend/web/uploads/' . $file_name);

                }
                Yii::$app->session->setFlash('success', Yii::getAlias('@tag_add_message'));
                return $this->redirect(['tags/index']);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // $this->layout = 'popup';
        $model = $this->findModel($id);
        $old_image = $model->image;
        if ($model->load(Yii::$app->request->post())) {
            $file = \yii\web\UploadedFile::getInstance($model, 'image');

            if (!empty($file)) {
                $delete = $model->oldAttributes['image'];
                $file_name = $file->basename . "_" . uniqid() . "." . $file->extension;

                $model->image = $file_name;
                if (!empty($old_image) && file_exists(Yii::getAlias('@root') . '/frontend/web/uploads/' . $old_image)) {
                    unlink(Yii::getAlias('@root') . '/frontend/web/uploads/' . $old_image);
                }
                $file->saveAs(Yii::getAlias('@root') . '/frontend/web/uploads/' . $file_name, false);
                $model->image = $file_name;
                $model->save();
            } else {
                $model->image = $old_image;
                $model->save(false);
            }
            Yii::$app->session->setFlash('success', Yii::getAlias('@tag_update_message'));
            return $this->redirect(['tags/index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tags model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $snDeleteStatus = $this->findModel($id)->delete();
        if (!empty($snDeleteStatus) && $snDeleteStatus == '1') {
            Yii::$app->session->setFlash('success', Yii::getAlias('@tag_delete_message'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Tags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Tags::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

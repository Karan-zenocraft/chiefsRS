<?php

namespace backend\controllers;

use Yii;
use common\models\RestaurantMenu;
use common\models\RestaurantMenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\AdminCoreController;
use common\components\Common;
use common\models\MenuCategories;
use yii\helpers\ArrayHelper;


/**
 * RestaurantMenuController implements the CRUD actions for RestaurantMenu model.
 */
class RestaurantMenuController extends AdminCoreController
{
    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
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
     * Lists all RestaurantMenu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
        $searchModel = new RestaurantMenuSearch();
        $dataProvider = $searchModel->backendSearch(Yii::$app->request->queryParams);
        $MenuCategories = MenuCategories::MenuCategoriesDropdown();
    
      //  p($MenuCategories);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snRestaurantName' => $snRestaurantName,
            'MenuCategories' => $MenuCategories,
        ]);
    }

    /**
     * Displays a single RestaurantMenu model.
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
     * Creates a new RestaurantMenu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RestaurantMenu();
        $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
        $model->restaurant_id = $_GET['rid'];
        $MenuCategoriesDropdown = MenuCategories::MenuCategoriesDropdown();
        
        if ($model->load(Yii::$app->request->post())) {
             $file = \yii\web\UploadedFile::getInstance($model, 'photo');
            if (!empty($file)){   
                $file_name = $file->basename."_".uniqid().".".$file->extension;
                $model->photo = $file_name;
                if($model->validate()){
                    $model->save();
                    $file->saveAs( Yii::getAlias('@root') .'/frontend/web/uploads/' . $file_name);

                }
                Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_menu_add_message' ) );
                return $this->redirect(['index', 'rid' => $model->restaurant_id]);
            }else{
                return $this->render('create', ['model' => $model,'snRestaurantName' => $snRestaurantName,'MenuCategoriesDropdown'=>$MenuCategoriesDropdown]);
            }
        }
        return $this->render('create', [
            'model' => $model,
            'snRestaurantName' => $snRestaurantName,
            'MenuCategoriesDropdown'=>$MenuCategoriesDropdown,
        ]);
    }

    /**
     * Updates an existing RestaurantMenu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
         $snRestaurantId = ($_GET['rid'] > 0) ? $_GET['rid'] : 0;
        $old_image = $model->photo;
        $snRestaurantName = Common::get_name_by_id($snRestaurantId,$flag = "Restaurants");
         $MenuCategoriesDropdown = MenuCategories::MenuCategoriesDropdown();
        if ($model->load(Yii::$app->request->post())) {
             $file = \yii\web\UploadedFile::getInstance($model, 'photo');
      
           if (!empty($file)){
                 $delete = $model->oldAttributes['photo'];
                 $file_name = $file->basename."_".uniqid().".".$file->extension;

                 $model->photo = $file_name; 
                 unlink(Yii::getAlias('@root') .'/frontend/web/uploads/'.$old_image);
                 $file->saveAs( Yii::getAlias('@root') .'/frontend/web/uploads/' . $file_name,false);
                 $model->photo = $file_name;
                 $model->save();
            }
            else{
                $model->photo  = $old_image;
                $model->save(false);
            }
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_menu_update_message' ) );
            return $this->redirect(['index','rid' => $model->restaurant_id]);
        }else{
            return $this->render('update', ['model' => $model,'snRestaurantName' => $snRestaurantName,'MenuCategoriesDropdown'=>$MenuCategoriesDropdown]);
        }

        return $this->render('update', [
            'model' => $model,
            'snRestaurantName' => $snRestaurantName,
            'MenuCategoriesDropdown'=>$MenuCategoriesDropdown,
        ]);
    }

    /**
     * Deletes an existing RestaurantMenu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
       $model = $this->findModel($id);
       $snDeleteStatus = $model->delete();
        if ( !empty( $snDeleteStatus ) && $snDeleteStatus=='1' ) {
            if(file_exists(Yii::getAlias('@root') . '/frontend/web/uploads/'. $model->photo))
            unlink(Yii::getAlias('@root') . '/frontend/web/uploads/'. $model->photo);
            $model->delete(); 
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@restaurant_menu_delete_message' ) );
        }
        return $this->redirect(['index','rid' => $model->restaurant_id]);
    }

    /**
     * Finds the RestaurantMenu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RestaurantMenu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestaurantMenu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

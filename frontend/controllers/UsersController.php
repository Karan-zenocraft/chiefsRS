<?php

namespace frontend\controllers;

use Yii;

use frontend\components\FrontCoreController;
use yii\helpers\ArrayHelper; // Load array helper
use common\models\Users;
use common\models\Restaurants;
//use common\models\Reservations;
use common\components\Common;
use common\models\EmailFormat;
use yii\web\BadRequestHttpException;


class UsersController extends FrontCoreController {

    public function beforeAction( $action ) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction( $action );
    }


    public function actionBook() {
        $this->layout = "booking";
        return $this->render( 'book_restaurant' );
    }

    public function actionMyBookings() {
        $searchModel = new ProjectsSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->getQueryParams() );
        /* if(empty($_REQUEST['ProjectsSearch']))
        {
            $dataProvider->query->andFilterWhere(['=','status',Yii::$app->params['in_process_status']]);
        }
        else{*/
        //$dataProvider->query->andFilterWhere(['=','assigsn_to_all',Yii::$app->params['assign_to_all']]);
        //$dataProvider->query->where("status != '5' && status != 0 AND (user_projects.user_id = '10' OR assign_to_all = '1')");
        $dataProvider->query->andFilterWhere( ['!=', 'status', Yii::$app->params['archived_status']] );
        $dataProvider->query->andFilterWhere( ['!=', 'status', Yii::$app->params['new_status']] );
        /* }*/

        return $this->render( 'myProjects', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            ] );
    }
}

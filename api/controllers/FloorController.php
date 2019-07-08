<?php

namespace api\controllers;

use Yii;
use yii\helpers\Json;
use common\components\Common;
use yii\web\Controller;
use api\components\ApiCoreController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\UploadedFile;
use yii\db\Query;

/* USE COMMON MODELS */
use common\models\Users;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use common\models\DeviceDetails;
use common\models\EmailFormat;
use common\models\RestaurantTables;
use common\models\RestaurantLayout;
/**
 * MainController implements the CRUD actions for APIs.
 */
class FloorController extends \yii\base\Controller
{
        /*
     * Function :
     * Description : Add Guest
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
       public function actionAddFloor(){

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('floor_name','user_id','table_data');
        $amParamsResult   = Common::checkRequestParameterKeyArray( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
       
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){
                $floorModel = new RestaurantLayout();
                $floorModel->restaurant_id = $restaurant_id;
                $floorModel->name = $requestParam['floor_name'];
                $floorModel->status = Yii::$app->params['user_status_value']['active'];
                $floorModel->created_by = $requestParam['user_id'];
                $floorModel->created_at = date('Y-m-d H:i:s');
                if($floorModel->save()){
                        $amResponseFloor = $floorModel;
                    //$amReponseParamPrepare['floor_data'] = $floorModel;
                    if(!empty($requestParam['table_data'])){
                        foreach ($requestParam['table_data'] as $key => $table) {
                            $tableModel = new RestaurantTables();
                            $tableModel->restaurant_id = $restaurant_id;
                            $tableModel->layout_id = $floorModel->id;
                            $tableModel->name = $table['name'];
                            $tableModel->width = $table['width'];
                            $tableModel->height = $table['height'];
                            $tableModel->x_cordinate = $table['x_cordinate'];
                            $tableModel->y_cordinate = $table['y_cordinate'];
                            $tableModel->shape = $table['shape'];
                            $tableModel->min_capacity = $table['min_cap'];
                            $tableModel->max_capacity = $table['max_cap'];
                            $tableModel->status = Yii::$app->params['user_status_value']['active'];
                            $tableModel->created_by = $requestParam['user_id'];
                            $tableModel->created_at = date('Y-m-d H:i:s');
                            $tableModel->save(false);     
                            $amReponseParamTable[]  = $tableModel;

                        }

                        $amReponseParam['floor_data'] = $amResponseFloor;
                        $amReponseParam['table_data'] = $amReponseParamTable;


                        $ssMessage                  = 'Floor is successfully created.';
                       // $amReponseParam             = $amReponseParam;
                        $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

                    }

                }

            }else{
                 $ssMessage  = 'You have not assigned any restaurant yet.';
                 $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid Manager.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }
    protected function matchUserStatus( $id ) {
       
        if ( ( $model = Users::findOne( $id ) ) !== null ) {
            if ( $model->status == Yii::$app->params['user_status_value']['in_active'] ) {
                $ssMessage     = 'User has been deactivated by admin.';
                $WholeMealData = Common::negativeResponse( $ssMessage );
                Common::encodeResponseJSON( $WholeMealData );
            }
        }
        else {
            $ssMessage     = 'User is not available';
            $WholeMealData = Common::negativeResponse( $ssMessage );
            Common::encodeResponseJSON( $WholeMealData );
        }
    }


}

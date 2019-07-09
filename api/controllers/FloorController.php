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
     * Description : Add Floor
     * Request Params :'floor_name','user_id','table_data'
     * Response Params : floor_data array and tables data array
     * Author :Rutusha Joshi
     */
       public function actionAddFloor(){

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('floor_data','user_id','table_data');
        $amParamsResult   = Common::checkRequestParameterKeyArray( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
       
        //Check User Status//
        Common::matchUserStatus( $requestParam['user_id'] );
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
                $floorModel->name = $requestParam['floor_data']['name'];
                $floorModel->status = $requestParam['floor_data']['status'];
                $floorModel->created_by = $requestParam['user_id'];
                $floorModel->created_at = date('Y-m-d H:i:s');
                if($floorModel->save()){
                    if(!empty($requestParam['table_data'])){
                        foreach ($requestParam['table_data'] as $key => $table) {
                            $tableModel = new RestaurantTables();
                            $tableModel->restaurant_id = $restaurant_id;
                            $tableModel->layout_id = $floorModel->id;
                            $tableModel->name = !empty($table['name']) ? $table['name'] : "";
                            $tableModel->width = !empty($table['width']) ? $table['width'] : "";
                            $tableModel->height = !empty($table['height']) ? $table['height'] : "";
                            $tableModel->x_cordinate = !empty($table['x_cordinate']) ? $table['x_cordinate'] : "";
                            $tableModel->y_cordinate = !empty($table['y_cordinate']) ? $table['y_cordinate'] : "";
                            $tableModel->shape = !empty($table['shape']) ? $table['shape'] : "" ;
                            $tableModel->min_capacity = !empty($table['min_cap']) ? $table['min_cap'] : "";
                            $tableModel->max_capacity = !empty($table['max_cap']) ? $table['max_cap'] : "";
                            $tableModel->status = $table['status'];
                            $tableModel->created_by = $requestParam['user_id'];
                            $tableModel->created_at = date('Y-m-d H:i:s');
                            $tableModel->save(false);     
                            $amReponseParamTable[]  = $tableModel;
                        }

                        $amReponseParam['floor_data'] = $floorModel;
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

      /*
     * Function :
     * Description : Update Floor
     * Request Params :'user_id','auth_token'
     * Response Params : Updated floor_data array and tables data array
     * Author :Rutusha Joshi
     */
       public function actionUpdateFloor(){

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('floor_data','user_id','table_data');
        $amParamsResult   = Common::checkRequestParameterKeyArray( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
       
        //Check User Status//
        Common::matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if(!empty($restaurant_id)){

                if(!empty($requestParam['floor_data']['id'])){
                    
                    $floorModel = RestaurantLayout::findOne(["id"=>$requestParam['floor_data']['id']]);
                    if(!empty($floorModel)){
                        $floorModel->restaurant_id = $restaurant_id;
                        $floorModel->name = !empty($requestParam['floor_data']['name']) ? $requestParam['floor_data']['name'] : $floorModel->name;
                        $floorModel->status = $requestParam['floor_data']['status'];
                        $floorModel->updated_by = $snUserId;
                        $floorModel->updated_at = date('Y-m-d H:i:s');
                        if($floorModel->save()){

                        foreach ($requestParam['table_data'] as $key => $table) {
                            $tableModel = RestaurantTables::findOne(['id'=>$table['id']]);
                            $tableModel->restaurant_id = $restaurant_id;
                            $tableModel->layout_id = !empty($table['layout_id']) ? $table['layout_id'] : $tableModel->layout_id;
                            $tableModel->name = !empty($table['name']) ? $table['name'] : $tableModel->name;
                            $tableModel->width =!empty($table['width']) ? $table['width'] : $tableModel->width;
                            $tableModel->height = !empty($table['height']) ? $table['height'] : $tableModel->height;
                            $tableModel->x_cordinate = !empty($table['x_cordinate']) ? $table['x_cordinate'] : $tableModel->x_cordinate;
                            $tableModel->y_cordinate = !empty($table['y_cordinate']) ? $table['y_cordinate'] : $tableModel->y_cordinate;
                            $tableModel->shape = !empty($table['shape']) ? $table['shape'] : $tableModel->shape;
                            $tableModel->min_capacity = !empty($table['min_cap']) ? $table['min_cap'] : $tableModel->min_cap;
                            $tableModel->max_capacity = !empty($table['max_cap']) ? $table['max_cap'] : $tableModel->max_cap;
                            $tableModel->status = $table['status'];
                            $tableModel->updated_by = $snUserId;
                            $tableModel->updated_at = date('Y-m-d H:i:s');
                            $tableModel->save(false);     
                            $amReponseParamTable[]  = $tableModel;
                        }

                        $amReponseParam['floor_data'] = $floorModel;
                        $amReponseParam['table_data'] = $amReponseParamTable;
                        $ssMessage                  = 'Floor is successfully Updated.';
                        $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

                    }
                    }
                    }else{
                        $ssMessage  = 'Please pass valid floor id';
                        $amResponse = Common::errorResponse( $ssMessage );
                    }

            }else{
                 $ssMessage  = 'You have not assigned any restaurant yet.';
                 $amResponse = Common::errorResponse( $ssMessage );
            }
        }else{
            $ssMessage  = 'Invalid Manager.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


}

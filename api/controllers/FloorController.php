<?php

namespace api\controllers;

use common\components\Common;
use common\models\RestaurantFloors;
use common\models\RestaurantTables;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\web\Controller;

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
    public function actionAddFloor()
    {

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('floor_data', 'user_id', 'table_data');
        $amParamsResult = Common::checkRequestParameterKeyArray($amData['request_param'], $amRequiredParams);
        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        if (!empty($amData['request_param']['floor_data'])) {
            $amRequiredParamsFloor = array("name", "status");
            $amParamsResultFloor = Common::checkRequestParameterKeyArray($amData['request_param']['floor_data'], $amRequiredParamsFloor);
            if (!empty($amParamsResultFloor['error'])) {
                $amResponse = Common::errorResponse($amParamsResultFloor['error']);
                $amResponse['message'] = $amResponse['message'] . " in floor_data's array.";
                Common::encodeResponseJSON($amResponse);
            }
        } else {
            $amResponse = Common::errorResponse("floor_data can not be blank");
            Common::encodeResponseJSON($amResponse);
        }
        if (!empty($amData['request_param']['table_data'])) {

            $amRequiredParamsTable = array("name", "width", "height", "min_cap", "max_cap", "x_cordinate", "y_cordinate", "shape", "status");

            foreach ($amData['request_param']['table_data'] as $key => $table_data) {
                $amParamsResultTable = Common::checkRequestParameterKeyArray($table_data, $amRequiredParamsTable);
                if (!empty($amParamsResultTable['error'])) {
                    $amResponse = Common::errorResponse($amParamsResultTable['error']);
                    $amResponse['message'] = $amResponse['message'] . " in " . $key . " table_data's array.";
                    Common::encodeResponseJSON($amResponse);
                }
            }
        }
        $requestParam = $amData['request_param'];

        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);
                $floorModel = new RestaurantFloors();
                $floorModel->restaurant_id = $restaurant_id;
                $floorModel->name = $requestParam['floor_data']['name'];
                $floorModel->status = $requestParam['floor_data']['status'];
                $floorModel->created_by = $snUserId;
                $floorModel->created_at = date('Y-m-d H:i:s');
                if ($floorModel->save()) {
                    $floorModel->id = "$floorModel->id";
                    $floorModel->restaurant_id = "$restaurant_id";
                    $floorModel->created_by = "$snUserId";

                    if (!empty($requestParam['table_data'])) {
                        foreach ($requestParam['table_data'] as $key => $table) {
                            $tableModel = new RestaurantTables();
                            $tableModel->restaurant_id = $restaurant_id;
                            $tableModel->floor_id = $floorModel->id;
                            $tableModel->name = !empty($table['name']) ? $table['name'] : "";
                            $tableModel->width = !empty($table['width']) ? $table['width'] : "";
                            $tableModel->height = !empty($table['height']) ? $table['height'] : "";
                            $tableModel->x_cordinate = !empty($table['x_cordinate']) ? $table['x_cordinate'] : "";
                            $tableModel->y_cordinate = !empty($table['y_cordinate']) ? $table['y_cordinate'] : "";
                            $tableModel->shape = !empty($table['shape']) ? $table['shape'] : "";
                            $tableModel->min_capacity = !empty($table['min_cap']) ? $table['min_cap'] : "";
                            $tableModel->max_capacity = !empty($table['max_cap']) ? $table['max_cap'] : "";
                            $tableModel->status = !empty($table['status']) ? $table['status'] : "";
                            $tableModel->created_by = $snUserId;
                            $tableModel->created_at = date('Y-m-d H:i:s');
                            $tableModel->save(false);
                            $tableModel->id = "$tableModel->id";
                            $tableModel->created_by = "$snUserId";
                            $tableModel->restaurant_id = "$restaurant_id";
                            $tableModel->floor_id = "$floorModel->id";

                            $amReponseParamTable['table_data'][] = $tableModel;
                        }

                        $amReponseParam['floor_data'] = $floorModel;
                        $amReponseParam['table_data'] = $amReponseParamTable;
                        $ssMessage = 'Floor is successfully created.';
                        // $amReponseParam             = $amReponseParam;
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                    } else {
                        $amReponseParam['floor_data'] = $floorModel;
                        $amReponseParam['table_data'] = [];
                        $ssMessage = 'Floor is successfully created.';
                        // $amReponseParam             = $amReponseParam;
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                    }
                }

            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid Manager.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Update Floor
     * Request Params :'user_id','auth_token'
     * Response Params : Update floor_data array and tables data array
     * Author :Rutusha Joshi
     */
    public function actionUpdateFloor()
    {

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('floor_data', 'user_id', 'table_data');
        $amParamsResult = Common::checkRequestParameterKeyArray($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }
        if (!empty($amData['request_param']['floor_data'])) {
            $amRequiredParamsFloor = array("name", "status", "id");
            $amParamsResultFloor = Common::checkRequestParameterKeyArray($amData['request_param']['floor_data'], $amRequiredParamsFloor);
            if (!empty($amParamsResultFloor['error'])) {
                $amResponse = Common::errorResponse($amParamsResultFloor['error']);
                $amResponse['message'] = $amResponse['message'] . " in floor_data's array.";
                Common::encodeResponseJSON($amResponse);
            }
        } else {
            $amResponse = Common::errorResponse("floor_data can not be blank");
            Common::encodeResponseJSON($amResponse);
        }
        if (!empty($amData['request_param']['table_data'])) {
            $amRequiredParamsTable = array("name", "width", "height", "min_cap", "max_cap", "x_cordinate", "y_cordinate", "shape", "status");

            foreach ($amData['request_param']['table_data'] as $key => $table_data) {
                $amParamsResultTable = Common::checkRequestParameterKeyArray($table_data, $amRequiredParamsTable);
                if (!empty($amParamsResultTable['error'])) {
                    $amResponse = Common::errorResponse($amParamsResultTable['error']);
                    $amResponse['message'] = $amResponse['message'] . " in " . $key . " table_data's array.";
                    Common::encodeResponseJSON($amResponse);
                }
            }
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);
                $floorModel = RestaurantFloors::findOne(["id" => $requestParam['floor_data']['id']]);
                if (!empty($floorModel)) {
                    if ($floorModel->is_deleted == "1") {
                        $ssMessage = "This floor is deleted. You can not update this table";
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);
                    } else {
                        $floorModel->restaurant_id = $restaurant_id;
                        $floorModel->name = !empty($requestParam['floor_data']['name']) ? $requestParam['floor_data']['name'] : $floorModel->name;
                        $floorModel->status = $requestParam['floor_data']['status'];
                        $floorModel->updated_by = $snUserId;
                        $floorModel->updated_at = date('Y-m-d H:i:s');
                        if ($floorModel->save()) {
                            $floorModel->id = "$floorModel->id";
                            $floorModel->restaurant_id = "$restaurant_id";
                            $floorModel->created_by = "$floorModel->created_by";
                            $floorModel->updated_by = "$snUserId";
                            $amReponseParamTable = $table_id = [];
                            $table_ids = "";
                            if (!empty($requestParam['table_data'])) {
                                foreach ($requestParam['table_data'] as $key => $table) {
                                    $tableModelsObj = "";
                                    if (!empty($table['id'])) {
                                        $tableModel = RestaurantTables::findOne(['id' => $table['id'], "floor_id" => $floorModel->id]);

                                        if (!empty($tableModel)) {
                                            if ($tableModel->is_deleted == "1") {
                                                $ssMessage = "Table of " . $key . " table_data is deleted. You can not update this table";
                                                $amResponse = Common::errorResponse($ssMessage);
                                                Common::encodeResponseJSON($amResponse);
                                            }
                                            $tableModel->updated_by = $snUserId;
                                            $tableModel->updated_at = date('Y-m-d H:i:s');

                                        } else {
                                            $ssMessage = "table's id is invalid in " . $key . " table_data array or this id is belongs to some other floor.";
                                            $amResponse = Common::errorResponse($ssMessage);
                                            Common::encodeResponseJSON($amResponse);
                                        }
                                    } else {
                                        $tableModel = new RestaurantTables();
                                        $tableModel->created_by = "$snUserId";
                                        $tableModel->created_at = date('Y-m-d H:i:s');
                                    }
                                    $tableModel->restaurant_id = $restaurant_id;
                                    $tableModel->floor_id = $floorModel->id;
                                    $tableModel->name = $table['name'];
                                    $tableModel->width = $table['width'];
                                    $tableModel->height = $table['height'];
                                    $tableModel->x_cordinate = $table['x_cordinate'];
                                    $tableModel->y_cordinate = $table['y_cordinate'];
                                    $tableModel->shape = $table['shape'];
                                    $tableModel->min_capacity = $table['min_cap'];
                                    $tableModel->max_capacity = $table['max_cap'];
                                    $tableModel->status = $table['status'];
                                    $tableModel->save(false);
                                    $tableModelsObj = $tableModel;

                                    $tableModelsObj->id = "$tableModelsObj->id";
                                    $tableModelsObj->restaurant_id = "$restaurant_id";
                                    $floor_id = $floorModel->id;
                                    $tableModelsObj->floor_id = "$floor_id";

                                    $amReponseParamTable[] = $tableModelsObj;
                                    $table_id[] = $tableModelsObj->id;

                                }
                            }
                            if (!empty($requestParam['table_data'])) {

                                $table_ids = implode(",", $table_id);
                                $connection = Yii::$app->db;
                                $query = "UPDATE restaurant_tables SET is_deleted = '1' WHERE floor_id = '" . $floorModel->id . "' AND id NOT IN (" . $table_ids . ")";
                                $data = $connection->createCommand($query)->execute();
                            } else {
                                $connection = Yii::$app->db;
                                $query = "UPDATE restaurant_tables SET is_deleted = '1' WHERE floor_id = '" . $floorModel->id . "'";
                                $data = $connection->createCommand($query)->execute();
                            }

                            $amReponseParam['floor_data'] = $floorModel;
                            $amReponseParam['table_data'] = $amReponseParamTable;
                            $ssMessage = 'Floor is successfully Updated.';
                            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                        }
                    }
                } else {
                    $ssMessage = "Floor's id is invalid please pass valid foor id";
                    $amResponse = Common::errorResponse($ssMessage);
                }

            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid Manager.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }
    /*
     * Function :
     * Description : Delete Floor
     * Request Params :'user_id','floor_id'
     * Response Params : Updated floor_data array and tables data array
     * Author :Rutusha Joshi
     */
    public function actionDeleteFloor()
    {

        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'floor_id');
        $amParamsResult = Common::checkRequestParameterKeyArray($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];

        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);

                if (!empty($requestParam['floor_id'])) {

                    $floorModel = RestaurantFloors::findOne(["id" => $requestParam['floor_id']]);
                    if (!empty($floorModel)) {
                        if ($floorModel->is_deleted == "1") {
                            $ssMessage = 'This floor is already deleted';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);
                        } else {
                            $floorModel->is_deleted = "1";
                            $floorModel->save(false);
                            $tableModel = RestaurantTables::find()->where(['floor_id' => $floorModel->id])->all();
                            if (!empty($tableModel)) {
                                foreach ($tableModel as $key => $table) {
                                    $table->is_deleted = "1";
                                    $table->save(false);
                                }
                            }
                            $ssMessage = 'Floor is deleted successfully.';
                            $amReponseParam = "";
                            $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                        }
                    } else {
                        $ssMessage = 'Please pass valid floor id';
                        $amResponse = Common::errorResponse($ssMessage);
                    }
                }

            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid Manager.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Delete Table
     * Request Params :'user_id','table_id'
     * Response Params : Updated floor_data array and tables data array
     * Author :Rutusha Joshi
     */
    /*public function actionDeleteTable()
    {

    //Get all request parameter
    $amData = Common::checkRequestType();
    $amResponse = $amReponseParam = [];

    // Check required validation for request parameter.
    $amRequiredParams = array('user_id', 'table_id');
    $amParamsResult = Common::checkRequestParameterKeyArray($amData['request_param'], $amRequiredParams);

    // If any getting error in request paramter then set error message.
    if (!empty($amParamsResult['error'])) {
    $amResponse = Common::errorResponse($amParamsResult['error']);
    Common::encodeResponseJSON($amResponse);
    }

    $requestParam = $amData['request_param'];

    //Check User Status//
    Common::matchUserStatus($requestParam['user_id']);
    //VERIFY AUTH TOKEN
    $authToken = Common::get_header('auth_token');
    Common::checkAuthentication($authToken);
    $snUserId = $requestParam['user_id'];
    $model = Users::findOne(["id" => $snUserId]);
    if (!empty($model)) {
    $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
    if (!empty($restaurant_id)) {

    if (!empty($requestParam['table_id'])) {

    $tableModel = RestaurantTables::findOne(["id" => $requestParam['table_id']]);
    if (!empty($tableModel)) {
    if ($tableModel->is_deleted == "1") {
    $ssMessage = 'This table is already deleted';
    $amResponse = Common::errorResponse($ssMessage);
    Common::encodeResponseJSON($amResponse);
    } else {
    $tableModel->is_deleted = "1";
    $tableModel->save(false);
    $ssMessage = 'Table is deleted successfully.';
    $amReponseParam = "";
    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
    }

    } else {
    $ssMessage = 'Please pass valid table id';
    $amResponse = Common::errorResponse($ssMessage);
    }
    }

    } else {
    $ssMessage = 'You have not assigned any restaurant yet.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    } else {
    $ssMessage = 'Invalid Manager.';
    $amResponse = Common::errorResponse($ssMessage);
    }
    // FOR ENCODE RESPONSE INTO JSON //
    Common::encodeResponseJSON($amResponse);
    }*/

    /*
     * Function :
     * Description : Get List of Floors and tables
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionGetFloors()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);

                $floors = RestaurantFloors::find()->select("restaurant_floors.id,restaurant_floors.restaurant_id,restaurant_floors.name,restaurant_floors.status,restaurant_floors.is_deleted")->with(['restaurantTables' => function ($q) {
                    return $q->select("restaurant_tables.id,restaurant_tables.name,restaurant_tables.restaurant_id,restaurant_tables.floor_id,restaurant_tables.width,restaurant_tables.height,restaurant_tables.x_cordinate,restaurant_tables.y_cordinate,restaurant_tables.min_capacity,restaurant_tables.max_capacity,restaurant_tables.shape,restaurant_tables.status")
                        ->where(['restaurant_tables.status' => Yii::$app->params['user_status_value']['active'], "restaurant_tables.is_deleted" => "0"]);}])
                    ->where(['restaurant_id' => $restaurant_id, 'restaurant_floors.status' => Yii::$app->params['user_status_value']['active'], "restaurant_floors.is_deleted" => "0"])->asArray()->all();

                if (!empty($floors)) {
                    $ssMessage = 'User Floors Details.';

                    $amReponseParam = $floors;

                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'There is no any floors added to your restaurant';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

    /*
     * Function :
     * Description : Get floor's reservation details
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :Rutusha Joshi
     */
    public function actionGetFloorReservationDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'date');
        $amParamsResult = Common::checkRequestParameterKey($amData['request_param'], $amRequiredParams);

        // If any getting error in request paramter then set error message.
        if (!empty($amParamsResult['error'])) {
            $amResponse = Common::errorResponse($amParamsResult['error']);
            Common::encodeResponseJSON($amResponse);
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        Common::matchUserStatus($requestParam['user_id']);
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header('auth_token');
        Common::checkAuthentication($authToken);
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne(["id" => $snUserId]);
        if (!empty($model)) {
            $restaurant_id = !empty($model->restaurant_id) ? $model->restaurant_id : "";
            if (!empty($restaurant_id)) {
                Common::checkRestaurantIsDeleted($restaurant_id);

                $floors = RestaurantFloors::find()->select("restaurant_floors.id,restaurant_floors.restaurant_id,restaurant_floors.name,restaurant_floors.status,restaurant_floors.is_deleted")->with(['restaurantTables' => function ($q) use ($requestParam) {
                    return $q->select("restaurant_tables.id,restaurant_tables.name,restaurant_tables.restaurant_id,restaurant_tables.floor_id,restaurant_tables.width,restaurant_tables.height,restaurant_tables.x_cordinate,restaurant_tables.y_cordinate,restaurant_tables.min_capacity,restaurant_tables.max_capacity,restaurant_tables.shape,restaurant_tables.status")->with(['bookReservations' => function ($qu) use ($requestParam) {
                        return $qu->select("book_reservations.reservation_id,book_reservations.floor_id,book_reservations.table_id,reservations.status,reservations.date,reservations.booking_start_time,reservations.total_stay_time,reservations.no_of_guests,reservations.special_comment,reservations.tag_id,users.first_name,users.last_name")->leftjoin("reservations", "reservations.id=book_reservations.reservation_id")->leftjoin("users", "users.id=reservations.user_id")->where(["reservations.date" => $requestParam['date']]);
                    }])
                        ->where(['restaurant_tables.status' => Yii::$app->params['user_status_value']['active'], "restaurant_tables.is_deleted" => "0"]);}])
                    ->where(['restaurant_id' => $restaurant_id, 'restaurant_floors.status' => Yii::$app->params['user_status_value']['active'], "restaurant_floors.is_deleted" => "0"])->asArray()->all();

                if (!empty($floors)) {
                    $ssMessage = 'User Floors Details.';

                    $amReponseParam = $floors;

                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'There is no any floors added to your restaurant';
                    $amResponse = Common::errorResponse($ssMessage);
                }
            } else {
                $ssMessage = 'You have not assigned any restaurant yet.';
                $amResponse = Common::errorResponse($ssMessage);
            }
        } else {
            $ssMessage = 'Invalid User.';
            $amResponse = Common::errorResponse($ssMessage);
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON($amResponse);
    }

}

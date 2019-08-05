<?php

namespace api\controllers;

use common\components\Common;
use common\models\BookReservations;
use common\models\Reservations;
use common\models\RestaurantFloors;
use common\models\RestaurantTables;
use common\models\Users;
use Yii;

/* USE COMMON MODELS */
use yii\helpers\ArrayHelper;
use yii\web\Controller;

/**
 * MainController implements the CRUD actions for APIs.
 */
class ReservationsController extends \yii\base\Controller
{
    /*
     * Function :
     * Description : List of requested reservations
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionGetReservationList()
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
                Common::checkRestaurantStatus($restaurant_id);
                $arrReservationsList = Reservations::find()
                    ->select(["reservations.id AS reservation_id", "users.id AS user_id", "users.first_name", "users.last_name", "users.email", "users.address", "users.contact_no", "users.status", "users.created_at", "reservations.id as reservation_id", "reservations.date", "reservations.booking_start_time", "reservations.booking_end_time", "reservations.total_stay_time", "reservations.no_of_guests", "reservations.pickup_drop", "reservations.pickup_location", "reservations.pickup_time", "reservations.drop_location", "reservations.drop_time", "reservations.tag_id", "reservations.special_comment", "reservations.role_id", "reservations.status", "table_id" => BookReservations::find()->select(["GROUP_CONCAT(book_reservations.table_id)"])->where("book_reservations.reservation_id = reservations.id"), "floor_id" => BookReservations::find()->select(["GROUP_CONCAT(DISTINCT book_reservations.floor_id)"])->where("book_reservations.reservation_id = reservations.id")])
                    ->leftJoin('users', 'reservations.user_id=users.id')
                    ->where(["reservations.restaurant_id" => $restaurant_id, "reservations.date" => $requestParam['date']])
                    ->orderBy('reservations.created_at')
                    ->asArray()
                    ->all();
                /*  $countQuery = clone $arrReservationsList;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => 20]);
                $totalCount = $pages->totalCount;

                for ($i = 0; $i < $totalCount; $i++) {
                //$links[] = "http://".$_SERVER['HTTP_HOST'].$pages->createUrl($i-1);
                $page_no[] = $i + 1;
                }

                $models = $arrReservationsList->offset((isset($requestParam['page_no']) && !empty($requestParam['page_no'])) ? $requestParam['page_no'] : $pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();*/

                if (!empty($arrReservationsList)) {
                    foreach ($arrReservationsList as $key => $reservation) {
                        unset($reservation['pickup_lat']);
                        unset($reservation['pickup_long']);
                        unset($reservation['drop_lat']);
                        unset($reservation['drop_long']);
                        $arrReservation[] = array_map('strval', $reservation);
                    }
                    $amReponseParam['reservations'] = $arrReservation;
                    //$amReponseParam['pages'] = $page_no;
                    $ssMessage = 'User Reservations Details.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $ssMessage = 'No reservations found.';
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
     * Description : Book table for requested reservations
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionBookTable()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'reservation_id', "floor_id", "table_id");
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
                Common::checkRestaurantStatus($restaurant_id);
                $reservation = Reservations::findOne($requestParam['reservation_id']);
                if (!empty($reservation)) {
                    $matchReservationValues = Reservations::find()
                        ->where("date = '" . $reservation->date . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (booking_start_time >= '" . $reservation->booking_start_time . "'
                                            AND booking_end_time <= '" . $reservation->booking_end_time . "')
                                        OR (('" . $reservation->booking_start_time . "' > booking_start_time) AND ('" . $reservation->booking_start_time . "' < booking_end_time))
                                        OR (('" . $reservation->booking_end_time . "' > booking_start_time) AND ('" . $reservation->booking_end_time . "' < booking_end_time)))")->asArray()->all();

                    if (!empty($matchReservationValues)) {
                        foreach ($matchReservationValues as $match) {
                            $match_tables[] = BookReservations::find()->where("reservation_id = '" . $match['id'] . "' AND floor_id = '" . $requestParam['floor_id'] . "' AND table_id IN ('" . $requestParam['table_id'] . "')")->asArray()->all();
                        }
                        if (!empty($match_tables) && count($match_tables) > 0) {
                            $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        }
                    } else {
                        $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();

                        if ($capacity[0]['max_capacity'] < $reservation->no_of_guests) {

                            $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        } else {
                            $table_array = explode(",", $requestParam['table_id']);
                            foreach ($table_array as $key => $oneTable) {
                                $bookReservation = new BookReservations;
                                $bookReservation->reservation_id = $requestParam['reservation_id'];
                                $bookReservation->floor_id = $requestParam['floor_id'];
                                $bookReservation->table_id = $oneTable;
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->save(false);

                                $reservation->status = Yii::$app->params['reservation_status_value']['booked'];
                                $reservation->save();
                            }
                            $reservation->floor_id = $requestParam['floor_id'];
                            $reservation->table_id = $requestParam['table_id'];
                            $amReponseParam = ArrayHelper::toArray($reservation);
                            $ssMessage = 'Table booked successfully.';
                            $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                            /*}*/

                        }
                    }
                } else {
                    $ssMessage = 'Please pass valid reservation_id';
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
     * Description : Book table for requested reservations
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionBookTableForGuest()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'guest_id', "floor_id", "table_id", "date", "booking_time", "total_stay_time", "tags", "special_comment", "no_of_guests");
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
                Common::checkRestaurantStatus($restaurant_id);
                $floorModel = RestaurantFloors::findOne(["id" => $requestParam['floor_id'], "status" => Yii::$app->params['user_status_value']['active']]);
                if (!empty($floorModel)) {
                    if ($floorModel->is_deleted == "1") {
                        $ssMessage = "This floor is deleted. You can not assign this table.";
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);
                    } else {
                        $table_array = explode(",", $requestParam['table_id']);
                        foreach ($table_array as $key => $value) {
                            $tableModel = RestaurantTables::findOne(['id' => $value, "floor_id" => $floorModel->id, "status" => Yii::$app->params['user_status_value']['active']]);

                            if (!empty($tableModel)) {
                                if ($tableModel->is_deleted == "1") {
                                    $ssMessage = "Table is deleted. You can not assign this table";
                                    $amResponse = Common::errorResponse($ssMessage);
                                    Common::encodeResponseJSON($amResponse);
                                }

                            } else {
                                $ssMessage = "table's id is invalid or this id is belongs to some other floor.";
                                $amResponse = Common::errorResponse($ssMessage);
                                Common::encodeResponseJSON($amResponse);
                            }

                            # code...
                        }

                        $booking_end_time = date("H:i:s", strtotime('+' . $requestParam['total_stay_time'] . ' minutes', strtotime($requestParam['booking_time'])));

                        $matchReservationValues = Reservations::find()
                            ->where("date = '" . $requestParam['date'] . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (booking_start_time >= '" . $requestParam['booking_time'] . "'
                                            AND booking_end_time <= '" . $booking_end_time . "')
                                        OR (('" . $requestParam['booking_time'] . "' > booking_start_time) AND ('" . $requestParam['booking_time'] . "' < booking_end_time))
                                        OR (('" . $booking_end_time . "' > booking_start_time) AND ('" . $booking_end_time . "' < booking_end_time)))")->asArray()->all();
                        if (!empty($matchReservationValues)) {
                            foreach ($matchReservationValues as $match) {
                                $match_tables[] = BookReservations::find()->where("reservation_id = '" . $match['id'] . "' AND floor_id = '" . $requestParam['floor_id'] . "' AND table_id IN ('" . $requestParam['table_id'] . "')")->asArray()->all();
                            }
                            if (!empty($match_tables) && count($match_tables) > 0) {
                                $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                                $amResponse = Common::errorResponse($ssMessage);
                                Common::encodeResponseJSON($amResponse);

                            }
                        } else {
                            $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();

                            if ($capacity[0]['max_capacity'] < $requestParam['no_of_guests']) {

                                $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                                $amResponse = Common::errorResponse($ssMessage);
                                Common::encodeResponseJSON($amResponse);

                            } else {
                                $reservation = new Reservations();
                                $reservation->user_id = $requestParam['guest_id'];
                                $reservation->restaurant_id = $restaurant_id;
                                $reservation->date = $requestParam['date'];
                                $reservation->booking_start_time = $requestParam['booking_time'];
                                $reservation->booking_end_time = $booking_end_time;
                                $reservation->total_stay_time = $requestParam['total_stay_time'];
                                $reservation->no_of_guests = $requestParam['no_of_guests'];
                                $reservation->special_comment = $requestParam['special_comment'];
                                $reservation->status = Yii::$app->params['reservation_status_value']['booked'];
                                $reservation->role_id = Yii::$app->params['userroles']['walk_in'];
                                $reservation->save(false);

                                $table_array = explode(",", $requestParam['table_id']);
                                foreach ($table_array as $key => $oneTable) {
                                    $bookReservation = new BookReservations;
                                    $bookReservation->reservation_id = $reservation['id'];
                                    $bookReservation->floor_id = $requestParam['floor_id'];
                                    $bookReservation->table_id = $oneTable;
                                    $bookReservation->created_at = date('Y-m-d H:i:s');
                                    $bookReservation->created_at = date('Y-m-d H:i:s');
                                    $bookReservation->save(false);
                                }
                                $reservation->floor_id = $requestParam['floor_id'];
                                $reservation->table_id = $requestParam['table_id'];
                                $amReponseParam = ArrayHelper::toArray($reservation);
                                $ssMessage = 'Table booked successfully.';
                                $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                                /*}*/

                            }
                        }
                    }
                } else {
                    $ssMessage = 'Invalid floor_id Or Floor is not active';
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

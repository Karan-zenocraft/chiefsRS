<?php

namespace api\controllers;

use common\components\Common;
use common\models\BookReservations;
use common\models\EmailFormat;
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
        $amRequiredParams = array('user_id', 'date', 'status');
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
                Common::checkRestaurantStatus($restaurant_id);
                $query = Reservations::find()
                    ->select(["reservations.id AS reservation_id", "users.id AS user_id", "users.first_name", "users.last_name", "users.email", "users.address", "users.contact_no", "users.status", "users.created_at", "reservations.id as reservation_id", "reservations.date", "reservations.booking_start_time", "reservations.booking_end_time", "reservations.total_stay_time", "reservations.no_of_guests", "reservations.pickup_drop", "reservations.pickup_location", "reservations.pickup_time", "reservations.drop_location", "reservations.drop_time", "reservations.tag_id", "reservations.special_comment", "reservations.role_id", "reservations.status", "reservations.created_at", "reservations.updated_at", "table_id" => BookReservations::find()->select(["GROUP_CONCAT(book_reservations.table_id)"])->where("book_reservations.reservation_id = reservations.id"), "floor_id" => BookReservations::find()->select(["GROUP_CONCAT(DISTINCT book_reservations.floor_id)"])->where("book_reservations.reservation_id = reservations.id")])
                    ->leftJoin('users', 'reservations.user_id=users.id')
                    ->where(["reservations.restaurant_id" => $restaurant_id, "reservations.date" => $requestParam['date']]);
                if (($requestParam['status'] != "") || ($requestParam['status'] == "0")) {
                    $query->andWhere(['reservations.status' => $requestParam['status']]);
                } else {
                    $query->andWhere("reservations.status != '" . Yii::$app->params['reservation_status_value']['requested'] . "'");
                }
                $arrReservationsList = $query->orderBy('reservations.created_at')->asArray()->all();
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
                $amReponseParam['reservations'] = [];
                if (!empty($arrReservationsList)) {
                    foreach ($arrReservationsList as $key => $reservation) {
                        $reservation['created_at'] = date('Y-m-d h:i A', strtotime($reservation['created_at']));
                        $reservation['updated_at'] = date('Y-m-d h:i A', strtotime($reservation['updated_at']));
                        unset($reservation['pickup_lat']);
                        unset($reservation['pickup_long']);
                        unset($reservation['drop_lat']);
                        unset($reservation['drop_long']);
                        if (!empty($reservation['table_id'])) {
                            $tableNames = RestaurantTables::find()->select(["GROUP_CONCAT(name) AS table_name"])->where("id IN (" . $reservation['table_id'] . ")")->asArray()->all();
                        }
                        $reservation['table_names'] = !empty($tableNames) ? $tableNames[0]['table_name'] : "";
                        //$arrReservation[] = $reservation;

                        $arrReservation[] = array_map('strval', $reservation);
                    }
                    $amReponseParam['reservations'] = $arrReservation;
                    //$amReponseParam['pages'] = $page_no;
                    $ssMessage = 'User Reservations Details.';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);

                } else {
                    $ssMessage = 'No Reservation found.';
                    $amResponse = Common::successResponseBlank($ssMessage, $amReponseParam);
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
                Common::checkRestaurantIsDeleted($restaurant_id);
                Common::checkRestaurantStatus($restaurant_id);
                $reservation = Reservations::findOne($requestParam['reservation_id']);
                if (!empty($reservation)) {
                    $valid1 = $valid2 = 0;
                    $user_details = Users::findOne($reservation->user_id);
                    $matchReservationValues = Reservations::find()
                        ->where("date = '" . $reservation->date . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (booking_start_time >= '" . $reservation->booking_start_time . "'
                                            AND booking_end_time <= '" . $reservation->booking_end_time . "')
                                        OR (('" . $reservation->booking_start_time . "' > booking_start_time) AND ('" . $reservation->booking_start_time . "' < booking_end_time))
                                        OR (('" . $reservation->booking_end_time . "' > booking_start_time) AND ('" . $reservation->booking_end_time . "' < booking_end_time)))")->asArray()->all();

                    if (!empty($matchReservationValues)) {
                        foreach ($matchReservationValues as $match) {
                            $match_tables = BookReservations::find()->where("reservation_id = " . $match['id'] . " AND floor_id = " . $requestParam['floor_id'] . " AND table_id IN (" . $requestParam['table_id'] . ")")->one();
                            if (!empty($match_tables)) {

                                $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                                $amResponse = Common::errorResponse($ssMessage);
                                Common::encodeResponseJSON($amResponse);

                            } else {

                                $valid1 = 1;
                            }
                        }

                    } else {
                        $valid1 = 1;
                    }
                    $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();
                    //  if() {

                    if ($capacity[0]['max_capacity'] < $reservation->no_of_guests) {

                        $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);

                    } else {
                        $valid2 = 3;
                    }
                    if (($valid1 == "1") && ($valid2 == "3")) {

                        $table_array = explode(",", $requestParam['table_id']);
                        foreach ($table_array as $key => $oneTable) {
                            $bookReservation = new BookReservations();
                            $bookReservation->reservation_id = $requestParam['reservation_id'];
                            $bookReservation->floor_id = $requestParam['floor_id'];
                            $bookReservation->table_id = $oneTable;
                            $bookReservation->created_at = date('Y-m-d H:i:s');
                            $bookReservation->created_at = date('Y-m-d H:i:s');
                            $bookReservation->save(false);

                            $reservation->status = Yii::$app->params['reservation_status_value']['booked'];
                            $reservation->save();
                        }

                        if (!empty($user_details)) {
                            $emailformatemodel = EmailFormat::findOne(["title" => 'welcome', "status" => '1']);
                            if ($emailformatemodel) {
                                $message = "Your tables '" . $requestParam['table_id'] . "' in the floor '" . $requestParam['floor_id'] . "' is booked successfully.";
                                //create template file
                                $AreplaceString = array('{username}' => $user_details->first_name . " " . $user_details->last_name, '{message}' => $message);

                                $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                                $ssSubject = $emailformatemodel->subject;
                                //send email for new generated password
                                $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                            }
                        }
                        /*        $device_details = DeviceDetails::find()->where(["user_id" => $snUserId])->one();
                        $device_token = $device_details['device_tocken'];
                        $restaurantName = Common::get_name_by_id($restaurant_id, "Restaurants");
                        $floorName = Common::get_name_by_id($requestParam['floor_id'], "RestaurantFloors");

                        $notificationArray = [
                        "device_token" => $device_token,
                        "message" => "Your table '" . $requestParam['table_id'] . "' of the floor '" . $floorName . "' in the '" . $restaurantName . "' restaurant is booked successfully.",
                        "notification_type" => 'Restaurant Booking',
                        "user_id" => $snUserId,
                        ];
                        if ($device_token != '') {
                        Common::SendNotification($notificationArray);
                        }*/
                        $reservation->floor_id = $requestParam['floor_id'];
                        $reservation->table_id = $requestParam['table_id'];
                        $amReponseParam = ArrayHelper::toArray($reservation);
                        $ssMessage = 'Table booked successfully.';
                        $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                        /*}*/

                    }
                    // }
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

    public function actionBookTableForGuest_old()
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
                Common::checkRestaurantIsDeleted($restaurant_id);
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
                        $valid1 = $valid2 = 0;
                        $booking_end_time = date("H:i:s", strtotime('+' . $requestParam['total_stay_time'] . ' minutes', strtotime($requestParam['booking_time'])));

                        $matchReservationValues = Reservations::find()
                            ->where("date = '" . $requestParam['date'] . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND (
                                        (binary booking_start_time >= 'binary " . $requestParam['booking_time'] . "'
                                            AND binary booking_end_time <= 'binary " . $booking_end_time . "')
                                        OR (('" . $requestParam['booking_time'] . "' > binary booking_start_time) AND ('binary " . $requestParam['booking_time'] . "' < binary booking_end_time))
                                        OR ((' binary" . $booking_end_time . "' > binary booking_start_time) AND ('binary " . $booking_end_time . "' < binary booking_end_time)))")->asArray()->all();
                        if (!empty($matchReservationValues)) {
                            $matchValues = array_column($matchReservationValues, "id");
                            $matchingsId = implode(",", $matchValues);
                            // foreach ($matchReservationValues as $match) {
                            $match_tables = BookReservations::find()->where("reservation_id IN (" . $matchingsId . ") AND floor_id = " . $requestParam['floor_id'] . " AND table_id IN (" . $requestParam['table_id'] . ")")->asArray()->all();
                            if (!empty($match_tables) && count($match_tables) > 0) {
                                $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                                $amResponse = Common::errorResponse($ssMessage);
                                Common::encodeResponseJSON($amResponse);

                            } else {
                                $valid1 = 1;
                            }
                        } else {
                            $valid1 = 1;
                        }
                        $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();

                        if ($capacity[0]['max_capacity'] < $requestParam['no_of_guests']) {

                            $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);

                        } else {
                            $valid2 = 3;
                        }
                        if (($valid1 == 1) && ($valid2 == 3)) {
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
                                $bookReservation = new BookReservations();
                                $bookReservation->reservation_id = $reservation['id'];
                                $bookReservation->floor_id = $requestParam['floor_id'];
                                $bookReservation->table_id = $oneTable;
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->created_at = date('Y-m-d H:i:s');
                                $bookReservation->save(false);
                            }
                            $user_details = Users::findOne($requestParam['guest_id']);
                            if (!empty($user_details)) {
                                $emailformatemodel = EmailFormat::findOne(["title" => 'welcome', "status" => '1']);
                                if ($emailformatemodel) {
                                    $message = "Your tables '" . $requestParam['table_id'] . "' in the floor '" . $requestParam['floor_id'] . "' is booked successfully.";
                                    //create template file
                                    $AreplaceString = array('{username}' => $user_details->first_name . " " . $user_details->last_name, '{message}' => $message);

                                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                                    $ssSubject = $emailformatemodel->subject;
                                    //send email for new generated password
                                    $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                                }
                            }
                            /*        $device_details = DeviceDetails::find()->where(["user_id" => $snUserId])->one();
                            $device_token = $device_details['device_tocken'];
                            $restaurantName = Common::get_name_by_id($restaurant_id, "Restaurants");
                            $floorName = Common::get_name_by_id($requestParam['floor_id'], "RestaurantFloors");

                            $notificationArray = [
                            "device_token" => $device_token,
                            "message" => "Your table '" . $requestParam['table_id'] . "' of the floor '" . $floorName . "' in the '" . $restaurantName . "' restaurant is booked successfully.",
                            "notification_type" => 'Restaurant Booking',
                            "user_id" => $snUserId,
                            ];
                            if ($device_token != '') {
                            Common::SendNotification($notificationArray);
                            }*/
                            $reservation->floor_id = $requestParam['floor_id'];
                            $reservation->table_id = $requestParam['table_id'];
                            $amReponseParam = ArrayHelper::toArray($reservation);
                            $ssMessage = 'Table booked successfully.';
                            $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                            /*}*/

                        }
                        //}
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

    /*
     * Function :
     * Description : Update reservation table means assign reservation to another table.
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionUpdateReservationTable()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', 'reservation_id', "floor_id", "old_table_id", "table_id");
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
                Common::checkRestaurantStatus($restaurant_id);
                $reservation = Reservations::findOne($requestParam['reservation_id']);
                if (!empty($reservation)) {
                    $valid1 = $valid2 = 0;
                    $user_details = Users::findOne($reservation->user_id);
                    $matchReservationValues = Reservations::find()
                        ->where("date = '" . $reservation->date . "'
                                AND status = '" . Yii::$app->params['reservation_status_value']['booked'] . "' AND id != '" . $requestParam['reservation_id'] . "' AND (
                                        (booking_start_time >= '" . $reservation->booking_start_time . "'
                                            AND booking_end_time <= '" . $reservation->booking_end_time . "')
                                        OR (('" . $reservation->booking_start_time . "' > booking_start_time) AND ('" . $reservation->booking_start_time . "' < booking_end_time))
                                        OR (('" . $reservation->booking_end_time . "' > booking_start_time) AND ('" . $reservation->booking_end_time . "' < booking_end_time)))")->asArray()->all();
                    if (!empty($matchReservationValues)) {
                        $matchValues = array_column($matchReservationValues, "id");
                        $matchingsId = implode(",", $matchValues);
                        //  foreach ($matchReservationValues as $match) {
                        $match_tables = BookReservations::find()->where("reservation_id IN (" . $matchingsId . ") AND floor_id = " . $requestParam['floor_id'] . " AND table_id IN (" . $requestParam['table_id'] . ")")->asArray()->all();
                        if (!empty($match_tables) && (count($match_tables) > 0)) {
                            $ssMessage = 'You can not book this table as this table is already booked by another customer.';
                            $amResponse = Common::errorResponse($ssMessage);
                            Common::encodeResponseJSON($amResponse);
                        } else {
                            $valid1 = 1;
                        }
                    } else {
                        $valid1 = 1;
                    }
                    $capacity = RestaurantTables::find()->select(["SUM(max_capacity) as max_capacity"])->where("id IN (" . $requestParam['table_id'] . ")")->asArray()->all();
                    //  if() {

                    if ($capacity[0]['max_capacity'] < $reservation->no_of_guests) {

                        $ssMessage = 'You can not book this table as table capacity is less than your total guests.';
                        $amResponse = Common::errorResponse($ssMessage);
                        Common::encodeResponseJSON($amResponse);

                    } else {
                        $valid2 = 3;
                    }
                    if (($valid1 == "1") && ($valid2 == "3")) {
                        $booking = BookReservations::find()->where(['reservation_id' => $requestParam['reservation_id'], "table_id" => $requestParam['old_table_id']])->one();
                        $booking->table_id = $requestParam['table_id'];
                        $booking->save(false);
                    }
                    if (!empty($user_details)) {
                        $emailformatemodel = EmailFormat::findOne(["title" => 'welcome', "status" => '1']);
                        if ($emailformatemodel) {
                            $message = "Your tables '" . $requestParam['table_id'] . "' in the floor '" . $requestParam['floor_id'] . "' is booked successfully.";
                            //create template file
                            $AreplaceString = array('{username}' => $user_details->first_name . " " . $user_details->last_name, '{message}' => $message);

                            $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                            $ssSubject = $emailformatemodel->subject;
                            //send email for new generated password
                            $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                        }
                    }
                    /*        $device_details = DeviceDetails::find()->where(["user_id" => $snUserId])->one();
                    $device_token = $device_details['device_tocken'];
                    $restaurantName = Common::get_name_by_id($restaurant_id, "Restaurants");
                    $floorName = Common::get_name_by_id($requestParam['floor_id'], "RestaurantFloors");

                    $notificationArray = [
                    "device_token" => $device_token,
                    "message" => "Your table '" . $requestParam['table_id'] . "' of the floor '" . $floorName . "' in the '" . $restaurantName . "' restaurant is booked successfully.",
                    "notification_type" => 'Restaurant Booking',
                    "user_id" => $snUserId,
                    ];
                    if ($device_token != '') {
                    Common::SendNotification($notificationArray);
                    }*/
                    $reservation->floor_id = $requestParam['floor_id'];
                    $reservation->table_id = $requestParam['table_id'];
                    $amReponseParam = ArrayHelper::toArray($reservation);
                    $ssMessage = 'Table booked successfully.';
                    $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));
                    /*}*/

                    // }
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
     * Description : Get reservation history of table
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionTableHistory()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = $list = [];

        // Check required validation for request parameter.
        $amRequiredParams = array('user_id', "table_id", "date");
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
                //Common::checkRestaurantIsDeleted($restaurant_id);
                //Common::checkRestaurantStatus($restaurant_id);
                $validateTable = RestaurantTables::findOne(['id' => $requestParam['table_id']]);
                if (!empty($validateTable)) {

                    $query = Reservations::find()
                        ->select("reservations.id as reservation_id,users.first_name,users.last_name,users.role_id,reservations.date,reservations.booking_start_time,reservations.total_stay_time,reservations.no_of_guests,reservations.pickup_drop,reservations.pickup_location,reservations.pickup_time,reservations.drop_location,reservations.drop_time,reservations.tag_id,reservations.special_comment,reservations.status,book_reservations.floor_id,book_reservations.floor_id,book_reservations.table_id,reservations.created_at,reservations.updated_at")
                        ->leftjoin("book_reservations", "book_reservations.reservation_id = reservations.id")
                        ->leftjoin("users", "users.id = reservations.user_id")
                        ->where(["book_reservations.table_id" => $requestParam['table_id']]);
                    if (($requestParam['date'] != "")) {
                        $query->andWhere(['reservations.date' => $requestParam['date']]);
                    }
                    $tableReservationHistory = $query->orderBy('reservations.created_at')->asArray()->all();
                    foreach ($tableReservationHistory as $key => $value) {
                        $list[] = array_map("strval", $value);
                    }
                    $amReponseParam = $list;
                    $ssMessage = 'Table History';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                } else {
                    $ssMessage = 'Please pass valid table id';
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
     * Description :Update details of reservation
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionUpdateReservationDetails()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = $list = [];

        // Check required validation for request parameter.
        $amRequiredParams = array("user_id", "reservation_id", "date", "booking_start_time", "total_stay_time", "no_of_guests", "pickup_drop", "pickup_location", "pickup_time", "drop_location", "drop_time", "tag_id", "special_comment");
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
                //Common::checkRestaurantIsDeleted($restaurant_id);
                //Common::checkRestaurantStatus($restaurant_id);
                $validateReservation = Reservations::findOne(['id' => $requestParam['reservation_id']]);
                if (!empty($validateReservation)) {
                    /*   if ($validateReservation->status != Yii::$app->params['reservation_status_value']['requested']) {*/
                    $validateReservation->date = !empty($requestParam['date']) ? $requestParam['date'] : $validateReservation->date;

                    $validateReservation->booking_start_time = !empty($requestParam['booking_start_time']) ? $requestParam['booking_start_time'] : $validateReservation->booking_start_time;

                    $validateReservation->total_stay_time = !empty($requestParam['total_stay_time']) ? $requestParam['total_stay_time'] : $validateReservation->total_stay_time;

                    $validateReservation->booking_end_time = date("H:i:s", strtotime('+' . $validateReservation->total_stay_time . ' minutes', strtotime($validateReservation->booking_start_time)));

                    $validateReservation->no_of_guests = !empty($requestParam['no_of_guests']) ? $requestParam['no_of_guests'] : $validateReservation->no_of_guests;

                    $validateReservation->pickup_drop = !empty($requestParam['pickup_drop']) ? $requestParam['pickup_drop'] : $validateReservation->pickup_drop;

                    $validateReservation->special_comment = !empty($requestParam['special_comment']) ? $requestParam['special_comment'] : $validateReservation->special_comment;
                    if ($validateReservation->pickup_drop == 1) {

                        $validateReservation->pickup_location = !empty($requestParam['pickup_location']) ? $requestParam['pickup_location'] : $validateReservation->pickup_location;

                        $validateReservation->pickup_time = !empty($requestParam['pickup_time']) ? $requestParam['pickup_time'] : $validateReservation->pickup_time;

                        $validateReservation->drop_location = !empty($requestParam['drop_location']) ? $requestParam['drop_location'] : $validateReservation->drop_location;

                        $validateReservation->drop_time = !empty($requestParam['drop_time']) ? $requestParam['drop_time'] : $validateReservation->drop_time;

                        $validateReservation->tag_id = !empty($requestParam['tag_id']) ? $requestParam['tag_id'] : $validateReservation->tag_id;
                        $validateReservation->status = !empty($requestParam['status']) ? $requestParam['status'] : $validateReservation->status;

                    } else {
                        $validateReservation->pickup_location = $validateReservation->pickup_time = $validateReservation->drop_location = $validateReservation->drop_time = "";
                    }
                    $validateReservation->save();
                    $amReponseParam = array_map("strval", ArrayHelper::toArray($validateReservation));
                    $ssMessage = 'Reservation has been updated successfully';
                    $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                    /* } else {
                $ssMessage = 'You can not update this reservation because this reservation is' . $validateReservation->status . '';
                $amResponse = Common::errorResponse($ssMessage);
                }*/
                } else {
                    $ssMessage = 'Please pass valid reservation id';
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
     * Description :Update details of reservation
     * Request Params :'user_id','date'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionDeleteReservation()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = $list = [];

        // Check required validation for request parameter.
        $amRequiredParams = array("user_id", "reservation_id");
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
                //Common::checkRestaurantIsDeleted($restaurant_id);
                //Common::checkRestaurantStatus($restaurant_id);
                $validateReservation = Reservations::findOne(['id' => $requestParam['reservation_id']]);
                if (!empty($validateReservation)) {
                    if ($validateReservation->restaurant_id == $restaurant_id) {
                        $validateReservation->status = Yii::$app->params['reservation_status_value']['deleted'];
                        $validateReservation->save(false);
                        $ssMessage = 'Reservation has been deleted successfully';
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                    } else {
                        $ssMessage = 'You can not delete this reservation because this reservation is npot for your restaurant';
                        $amResponse = Common::errorResponse($ssMessage);
                    }
                } else {
                    $ssMessage = 'Please pass valid reservation id';
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
     * Description :Get list of status
     * Request Params :'user_id'
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionUpdateReservationStatus()
    {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = $list = [];

        // Check required validation for request parameter.
        $amRequiredParams = array("user_id", "reservation_id", "status");
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
                //Common::checkRestaurantIsDeleted($restaurant_id);
                //Common::checkRestaurantStatus($restaurant_id);
                $validateReservation = Reservations::findOne(['id' => $requestParam['reservation_id']]);
                if (!empty($validateReservation)) {
                    if ($validateReservation->restaurant_id == $restaurant_id) {
                        $validateReservation->status = $requestParam['status'];
                        $validateReservation->save(false);
                        $ssMessage = 'Reservation status has been updated successfully';
                        $amResponse = Common::successResponse($ssMessage, $amReponseParam);
                    } else {
                        $ssMessage = 'You can not delete this reservation because this reservation is not for your restaurant';
                        $amResponse = Common::errorResponse($ssMessage);
                    }
                } else {
                    $ssMessage = 'Please pass valid reservation id';
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
                Common::checkRestaurantIsDeleted($restaurant_id);
                Common::checkRestaurantStatus($restaurant_id);
                $booking_end_time = date("H:i:s", strtotime('+' . $requestParam['total_stay_time'] . ' minutes', strtotime($requestParam['booking_time'])));
                $reservation = new Reservations();
                $reservation->user_id = $requestParam['guest_id'];
                $reservation->restaurant_id = $restaurant_id;
                $reservation->date = $requestParam['date'];
                $reservation->booking_start_time = $requestParam['booking_time'];
                $reservation->booking_end_time = $booking_end_time;
                $reservation->total_stay_time = $requestParam['total_stay_time'];
                $reservation->no_of_guests = $requestParam['no_of_guests'];
                $reservation->special_comment = $requestParam['special_comment'];
                $reservation->status = Yii::$app->params['reservation_status_value']['requested'];
                $reservation->role_id = Yii::$app->params['userroles']['walk_in'];
                $reservation->save(false);

                $user_details = Users::findOne($requestParam['guest_id']);
                if (!empty($user_details)) {
                    $emailformatemodel = EmailFormat::findOne(["title" => 'welcome', "status" => '1']);
                    if ($emailformatemodel) {
                        $message = "Your tables '" . $requestParam['table_id'] . "' in the floor '" . $requestParam['floor_id'] . "' is booked successfully.";
                        //create template file
                        $AreplaceString = array('{username}' => $user_details->first_name . " " . $user_details->last_name, '{message}' => $message);

                        $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);
                        $ssSubject = $emailformatemodel->subject;
                        //send email for new generated password
                        $ssResponse = Common::sendMail($model->email, Yii::$app->params['adminEmail'], $ssSubject, $body);

                    }
                }
                /*        $device_details = DeviceDetails::find()->where(["user_id" => $snUserId])->one();
                $device_token = $device_details['device_tocken'];
                $restaurantName = Common::get_name_by_id($restaurant_id, "Restaurants");
                $floorName = Common::get_name_by_id($requestParam['floor_id'], "RestaurantFloors");

                $notificationArray = [
                "device_token" => $device_token,
                "message" => "Your table '" . $requestParam['table_id'] . "' of the floor '" . $floorName . "' in the '" . $restaurantName . "' restaurant is booked successfully.",
                "notification_type" => 'Restaurant Booking',
                "user_id" => $snUserId,
                ];
                if ($device_token != '') {
                Common::SendNotification($notificationArray);
                }*/
                $reservation->floor_id = $requestParam['floor_id'];
                $reservation->table_id = $requestParam['table_id'];
                $amReponseParam = ArrayHelper::toArray($reservation);
                $ssMessage = 'Guest reservation added successfully.';
                $amResponse = Common::successResponse($ssMessage, array_map("strval", $amReponseParam));

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

<?php

namespace api\controllers;

use Yii;
use yii\helpers\Json;
use yii\db\Query;
/* USE COMMON MODELS */
use common\components\Common;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\DateTime;
use common\models\Users;
use common\models\UserEvents;
use common\models\EventParticipants;
use common\models\Devicedetails;

/**
 * MainController implements the CRUD actions for APIs.
 */
class CronController extends \yii\base\Controller
{
   public function actionBeforeHourEventNotification(){

   	$snNextHourEvents = UserEvents::find()->where("event_status != '".Yii::$app->params['event_status']['completed']."' AND event_status != '".Yii::$app->params['event_status']['cancelled']."' AND event_start_date = DATE_ADD(DATE_FORMAT(NOW(),'%Y-%m-%d %H:%i'), INTERVAL 1 HOUR)")->asArray()->all();
   //	p($snNextHourEvents);
   	if(!empty($snNextHourEvents)){
   		foreach ($snNextHourEvents as $key => $event) {
   			$snEventParticipants = EventParticipants::find()->where(['event_id'=> $event['id'],'participant_status'=> Yii::$app->params['participant_status']['active']])->asArray()->all();
   			if(!empty($snEventParticipants)){
   				foreach ($snEventParticipants as $key => $participant) {
   					$snDeviceDetails = Devicedetails::find()->where(["userid"=>$participant['user_id']])->one();
   					$snDeviceToken = $snDeviceDetails['device_tocken'];
   					$notificationArray = [
                              "device_token"   => $snDeviceToken,
                              "message"               => "Your session will start in next hour.",
                              "notification_type"     => 'Before Hour Notification',
                              "user_id"   => $participant['user_id'],
                              ];    
			          if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64') {

			              Common::SendNotification( $notificationArray );
			          }

   				}
   			}
   		}
   	}

   		/*$ssMessage  = " updated successfully.";
        $amResponse = Common::successResponse( $ssMessage );
        Common::encodeResponseJSON( $amResponse );*/
   }
}

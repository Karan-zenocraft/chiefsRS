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
use backend\controllers\SiteController;
use common\models\UserActivities;
use common\models\EmailFormat;

/**
 * MainController implements the CRUD actions for APIs.
 */
class UsersController extends \yii\base\Controller
{
    /*
     * Function : Login()
     * Description : The register user can login from application.
     * Request Params :mail address and password.
     * Response Params :
     * Author :Ankit Patel
     */

    public function actionLogin() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_email', 'password', 'device_id', 'device_type' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );
    

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        if ( ( $model = Users::findOne( ['email' => $requestParam['user_email'], 'password' => md5( $requestParam['password'] ), 'role_id' => "5"] ) ) !== null ) {
               
            if ( ( $model1 = Users::findOne( ['email' => $requestParam['user_email'], 'password' => md5( $requestParam['password'] ), 'status' => "0", 'role_id' => "5"] ) ) !== null ) {
                $ssMessage  = ' User has been deactivated. Please contact admin.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
            else {
                if ( ( $device_model = DeviceDetails::findOne( ['type' => $amData['request_param']['device_type'], 'user_id' => $model->id] ) ) === NULL ) {
                    $device_model = new DeviceDetails;
                }

                $device_model->setAttributes( $amData['request_param'] );
                $device_model->device_tocken = $requestParam['device_id'];
                $device_model->type          = $requestParam['device_type'];
                $device_model->gcm_id        = !empty( $requestParam['gcm_registration_id'] ) ? $requestParam['gcm_registration_id'] : "";
                $device_model->user_id        = $model->id;
              //  $device_model->created_at    = date( 'Y-m-d H:i:s' );
                $device_model->save( false );
                $ssAuthToken = Common::generateToken( $model->id );
             //   $model->auth_token = $ssAuthToken;
                $model->save( false );

                $ssMessage                                = 'successfully login.';
                $amReponseParam['user_email']             = $model->email;
                $amReponseParam['user_id']                = $model->id;
                $amReponseParam['first_name']             = $model->first_name;
                $amReponseParam['last_name']              = $model->last_name;
                $amReponseParam['address']         = !empty( $model->address ) ? $model->address : "";
              //  $amReponseParam['country_code']           = $model->country_code;
               // $amReponseParam['phone']                  = $model->phone;
             //   $amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $model->birth_date ) );
              //  $amReponseParam['gender']                 = Yii::$app->params['gender_value'][$model->gender];
              //  $amReponseParam['is_mobile_verified']     = !empty( $model->is_code_verified ) && ( $model->is_code_verified > 0 ) ? $model->is_code_verified : 0;
               // $amReponseParam['user_initial_longitude'] = !empty( $model->user_initial_longitude ) ? $model->user_initial_longitude : "";
                //$amReponseParam['user_initial_latitude']  = !empty( $model->user_initial_latitude ) ? $model->user_initial_latitude : "";
                //$amReponseParam['event_radious_range']    = !empty( $model->event_radious_range ) ? $model->event_radious_range : "";
                $amReponseParam['device_token']           = $device_model->device_tocken;
               // $amReponseParam['device_type']            = Yii::$app->params['device_type_value'][$device_model->type];
                $amReponseParam['gcm_registration_id']    = !empty( $device_model->gcm_id ) ? $device_model->gcm_id : "";
               // $amReponseParam['image']                  = !empty( $model->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$model->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $model->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                $amReponseParam['auth_token']             = $ssAuthToken;




                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid email OR password.';
            $amResponse = Common::errorResponse( $ssMessage );
        }

        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : SignUp()
     * Description : new user singup.
     * Request Params : university_id,first_name,last_name,email address,password,profile_pic
     * Response Params : user_id,firstname,email,last_name, email,status,created_at
     * Author : Ankit
     */

    public function actionSignUp() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'first_name', 'last_name', 'user_email', 'password', 'device_id', 'device_type', 'country_code', 'phone', 'birth_date', 'gender' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $requestFileparam = $amData['file_param'];

        if ( empty( $requestParam['user_id'] ) ) {
            if ( !empty( Users::findOne( ["email" => $requestParam['user_email']] ) ) ) {
                $amResponse = Common::errorResponse( "This Email id is already registered." );
                Common::encodeResponseJSON( $amResponse );
            }
            if ( !empty( Users::findOne( ["phone" => $requestParam['phone']] ) ) ) {
                $amResponse = Common::errorResponse( "Phone you entered is already registered by other user." );
                Common::encodeResponseJSON( $amResponse );
            }
            $model = new Users;
        } else {
            $snUserId = $requestParam['user_id'];
            $model = Users::findOne( ["id" => $snUserId] );
            if ( !empty( $model ) ) {
                $ssEmail = $model->email;
                $modelUser = Users::find()->where( "id != '" . $snUserId . "' AND email = '" . $requestParam['user_email'] . "'" )->all();
                if ( !empty( $modelUser ) ) {
                    $amResponse = Common::errorResponse( "Email you entered is already registred by other user." );
                    Common::encodeResponseJSON( $amResponse );
                }
                $modelUserr = Users::find()->where( "id != '" . $snUserId . "' AND phone = '" . $requestParam['phone'] . "'" )->all();
                if ( !empty( $modelUserr ) ) {
                    $amResponse = Common::errorResponse( "Phone you entered is already registered by other user." );
                    Common::encodeResponseJSON( $amResponse );
                }
            }
        }

        $SnRandomNumber = rand( 1111, 9999 );
        $Textmessage    = "Your verification code is : " . $SnRandomNumber;
        // Common::sendSms( $Textmessage, "$requestParam[phone]" );
        // Database field
        $model->first_name             = $requestParam['first_name'];
        $model->last_name              = $requestParam['last_name'];
        $model->email                  = $requestParam['user_email'];
        $model->password               = md5( $requestParam['password'] );
        $model->address_line_1         = !empty( $requestParam['address_line_1'] ) ? $requestParam['address_line_1'] : "";
        $model->country_code           = $requestParam['country_code'];
        $model->phone                  = Common::clean_special_characters( $requestParam['phone'] );
        $model->gender                 = Yii::$app->params['gender'][$requestParam['gender']];
        $model->verification_code      = $SnRandomNumber;
        $model->birth_date             = date( "Y-m-d", strtotime( $requestParam['birth_date'] ) );
        $model->user_initial_longitude = !empty( $requestParam['user_initial_longitude'] ) ? $requestParam['user_initial_longitude'] : "";
        $model->user_initial_latitude  = !empty( $requestParam['user_initial_latitude'] ) ? $requestParam['user_initial_latitude'] : "";
        $model->event_radious_range    = !empty( $requestParam['event_radious_range'] ) ? $requestParam['event_radious_range'] : 20;
        $model->role_id                = Yii::$app->params['userroles']['application_users'];
        $model->notification_status    = Yii::$app->params['notification_status']['active'];
        $model->created_at             = date( 'Y-m-d H:i:s' );
        $model->updated_at             = date( 'Y-m-d H:i:s' );
        $model->status                 = Yii::$app->params['status']['active'];
        $ssAuthToken                   = Common::generateToken( $model->id );
        $model->auth_token             = $ssAuthToken;


        if ( isset( $requestFileparam['image']['name'] ) ) {

            $model->user_image = UploadedFile::getInstanceByName( 'image' );
            $Modifier          = md5( ( $model->user_image ) );
            $OriginalModifier  = $Modifier . rand( 11111, 99999 );
            $Extension         = $model->user_image->extension;
            $model->user_image->saveAs( Yii::$app->params['upload_user_image'] . $OriginalModifier . '.' . $model->user_image->extension );
            $model->user_image = $OriginalModifier . '.' . $Extension;
        }
        if ( $model->save( false ) ) {
            // Device Registration
            if ( ( $device_model = Devicedetails::findOne( [/*'gcm_id' => $amData['request_param']['gcm_registration_id'], */'type' => $amData['request_param']['device_type'], 'userid' => $model->id] ) ) === NULL ) {
                $device_model = new Devicedetails;
            }

            $device_model->setAttributes( $amData['request_param'] );
            $device_model->device_tocken = $requestParam['device_id'];
            $device_model->type          = $requestParam['device_type'];
            $device_model->gcm_id        = !empty( $requestParam['gcm_registration_id'] ) ? $requestParam['gcm_registration_id'] : "";
            $device_model->userid        = $model->id;
            $device_model->created_at    = date( 'Y-m-d H:i:s' );
            $device_model->save( false );

            ///////////////////////////////////////////////////////////
            //Get email template from database for sign up WS
            ///////////////////////////////////////////////////////////
            if ( empty( $ssEmail ) ) {
                $ssEmail = $model->email;
            }
            if ( empty( $requestParam['user_id'] ) || ( $ssEmail != $requestParam['user_email'] ) ) {
                $emailformatemodel = EmailFormat::findOne( ["title"=>'welcome', "status"=>'1'] );
                if ( $emailformatemodel ) {

                    //create template file
                    $AreplaceString = array( '{password}' => $requestParam['password'], '{username}' => $model->first_name." ".$model->last_name, '{email}' => $model->email );

                    $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );
                    $ssSubject = $emailformatemodel->subject;
                    //send email for new generated password
                    $ssResponse = Common::sendMail( $model->email, Yii::$app->params['adminEmail'], $ssSubject, $body );

                }
            }

            $ssMessage                                = 'You are successfully registered.';
            $amReponseParam['user_email']             = $model->email;
            $amReponseParam['user_id']                = $model->id;
            $amReponseParam['first_name']             = $model->first_name;
            $amReponseParam['last_name']              = $model->last_name;
            $amReponseParam['address_line_1']         = !empty( $model->address_line_1 ) ? $model->address_line_1 : "";
            $amReponseParam['country_code']           = $model->country_code;
            $amReponseParam['phone']                  = $model->phone;
            $amReponseParam['verification_code']      = $model->verification_code;
            $amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $model->birth_date ) );
            $amReponseParam['gender']                 = Yii::$app->params['gender_value'][$model->gender];
            $amReponseParam['user_initial_longitude'] = !empty( $model->user_initial_longitude ) ? $model->user_initial_longitude : "";
            $amReponseParam['user_initial_latitude']  = !empty( $model->user_initial_latitude ) ? $model->user_initial_latitude : "";
            $amReponseParam['event_radious_range']    = !empty( $model->event_radious_range ) ? $model->event_radious_range : '';
            $amReponseParam['is_mobile_verified']     = !empty( $model->is_code_verified ) && ( $model->is_code_verified > 0 ) ? $model->is_code_verified : 0;
            $amReponseParam['image']                  = !empty( $model->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$model->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $model->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
            $amReponseParam['device_token']           = $device_model->device_tocken;
            $amReponseParam['device_type']            = Yii::$app->params['device_type_value'][$device_model->type];
            $amReponseParam['gcm_registration_id']    = !empty( $device_model->gcm_id ) ? $device_model->gcm_id : "";
            $amReponseParam['auth_token']             = $ssAuthToken;

            $amResponse                               = Common::successResponse( $ssMessage, $amReponseParam );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : verifyEmail()
     * Description : email verification
     * Request Params : verification_code,user_id
     * Author : Rutusha Joshi
     */

    public function actionVerifyCode() {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'verification_code', 'user_id' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        $ssCode = $requestParam['verification_code'];

        $modelUsers = Users::findOne( ["id" => $snUserId, "verification_code" => $ssCode] );
        if ( !empty( $modelUsers ) ) {
            $modelUsers->is_code_verified = 1;
            $modelUsers->save( false );
            $amResponseData = [
            'is_mobile_verified' => '1',
            ];
            $amResponse = Common::successResponse( "Code verified successfully.", $amResponseData );
        } else {
            $amResponseData = [
            'is_mobile_verified' => '0',
            ];
            $amResponse = Common::successResponse( "Invalid verification code.", $amResponseData );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ResendVerificationCode()
     * Description : Re send verification code
     * Request Params : 'user_id', 'phone','country_code'
     * Author : Rutusha Joshi
     */

    public function actionResendVerificationCode() {
        $amResponse = $amResponseData = [];
        //Get all request parameter
        $amData = Common::checkRequestType();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'phone' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        $snUserId     = $requestParam['user_id'];
        $ssPhone      = $requestParam['phone'];

        $modelUsers = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $modelUsers ) ) {
            $SnRandomNumber = rand( 1111, 9999 );
            $Textmessage    = "Your verification code is : " . $SnRandomNumber;
            // Common::sendSms( $Textmessage, "$requestParam[phone]" );
            $modelUsers->verification_code = $SnRandomNumber;
            $modelUsers->save( false );
            $amResponseData['Verification_code'] = $modelUsers->verification_code;
            $amResponse = Common::successResponse( "Code sent successfully.", $amResponseData );
        }   else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ChangePassword()
     * Description : user can change password
     * Request Params : user_id,old_password, new_password
     * Response Params : success or error message
     * Author : Ankit
     */

    public function actionChangePassword() {


        $amData = Common::checkRequestType();

        $amResponse       = array();
        $ssMessage        = '';
        // Check required validation for request parameter.
        $amRequiredParams = array( 'old_password', 'new_password', 'user_id' );

        $amParamsResult = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {

            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        // Check User Status
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        if ( ( $model = Users::findOne( ['id' => $requestParam['user_id'], 'password' => md5( $requestParam['old_password'] ), 'status' => '1'] ) ) !== null ) {

            $model->password = md5( $amData['request_param']['new_password'] );
            if ( $model->save() ) {
                $ssMessage                    = 'Your password has been changed successfully.';
                $amReponseParam['user_id']    = $model->id;
                $amReponseParam['user_email'] = $model->email;
                $amResponse                   = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Old Password is wrong';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : ForgotPassword()
     * Description : if user can forgot passord so send password by mail.
     * Request Params : email,auth_token
     * Response Params : success or error message
     * Author : Ankit
     */

    public function actionForgotPassword() {

        $amData     = Common::checkRequestType();
        $amResponse = array();

        $ssMessage        = '';
        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_email' );

        $amParamsResult = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        // Check User Status


        if ( ( $omUsers = Users::findOne( ['email' => $requestParam['user_email'], 'status' => Yii::$app->params['user_status_value']['active']] ) ) !== null ) {

            // $ssEmail = 'rutusha@inheritx.com';
            if (!Users::isPasswordResetTokenValid($omUsers->password_reset_token)) {
            $token = $omUsers->generatePasswordResetToken();
            $omUsers->password_reset_token = $token;
            if (!$omUsers->save()) {
                return false;
            }
        }
        $resetLink = Yii::$app->params['root_url']."frontend/web/site/reset-password?token=".$omUsers->password_reset_token;

          $emailformatemodel = EmailFormat::findOne(["title"=>'reset_password',"status"=>'1']);
                if($emailformatemodel){
                    
                    //create template file
                    $AreplaceString = array('{resetLink}' => $resetLink, '{username}' => $omUsers->first_name);
                    $body = Common::MailTemplate($AreplaceString, $emailformatemodel->body);

                    //send email for new generated password
                  $mail =  Common::sendMailToUser($omUsers->email,Yii::$app->params['adminEmail'] , $emailformatemodel->subject,$body );
                }
            if ( $mail == 1 ) {
                $amReponseParam['user_email'] = $omUsers->email;
                $ssMessage                    = 'Email has been sent successfully please check your email. ';
                $amResponse                   = Common::successResponse( $ssMessage, $amReponseParam );
            }
            else {
                $ssMessage  = 'Email could not be sent successfully try again later.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }
        else {
            $ssMessage  = 'Please enter valid email address which is provided during sign up.';
            $amResponse = Common::errorResponse( $ssMessage );
        }



        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : Logout()
     * Description : Log out
     * Request Params : user_id,auth_token
     * Response Params :
     * Author : Ankit
     */

    // For Geting Daily data by date
    public function actionLogout() {
        $amData           = Common::checkRequestType();
        $amResponse       = array();
        $ssMessage        = '';
        $amRequiredParams = array( 'user_id', 'device_id', 'device_type' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );
        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        if ( ( $device_model = Devicedetails::findOne( ['device_tocken' => $amData['request_param']['device_id'], 'type' => $amData['request_param']['device_type'], 'userid' => $requestParam['user_id']] ) ) !== NULL ) {
            $device_model->delete();
            $ssMessage      = 'Logout successfully';
            $amResponse     = Common::successResponse( $ssMessage, $amReponseParam = '' );
        }
        else {
            $ssMessage  = 'Your deivce token is invalid.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        Common::encodeResponseJSON( $amResponse );
    }

    // User Status Match. Either its deactive or Deleted
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

    /*
     * Function : AddUserContacts()
     * Description : User can add his/her contacts from AddressBook
     * Request Params :'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionAddUserContacts_new() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $multipleNumbers = '';

        $amResponse = $oModel =  array();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'contact_from', 'contacts' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        $this->matchUserStatus( $requestParam['user_id'] );

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            foreach ( $requestParam['contacts'] as $key => $contactDetails ) {
                if ( empty( $contactDetails['contact_email'] ) && !empty( $contactDetails['contact_number'] ) ) {
                    if ( empty( strpos( $contactDetails['contact_number'], ',' ) ) ) {
                        $oModel  = UserContactDetails::find()->where( ['user_id' =>$requestParam['user_id'], 'contact_number' => Common::clean_special_characters( $contactDetails['contact_number'] )] )->one();
                    }else {
                        $ArrContacts = explode( ',', $contactDetails['contact_number'] );
                        foreach ( $ArrContacts as $key => $value ) {
                            $Contacts[] = Common::clean_special_characters( $value );
                        }
                        $multiNos = implode( ',', $Contacts );
                        $oModel  = UserContactDetails::find()->where( "user_id = '".$requestParam['user_id']."' AND contact_number IN (".$multiNos.")" )->one();
                    }
                }else if ( empty( $contactDetails['contact_number'] ) && !empty( $contactDetails['contact_email'] ) ) {
                        $oModel  = UserContactDetails::find()->where( ['user_id' =>$requestParam['user_id'], 'contact_email' => $contactDetails['contact_email']] )->one();
                    }else {
                    if ( empty( strpos( $contactDetails['contact_number'], ',' ) ) ) {
                        $oModel  = UserContactDetails::find()->where( "user_id = '".$requestParam['user_id']."' AND (contact_number = '".Common::clean_special_characters( $contactDetails['contact_number'] )."' OR contact_email = '".$contactDetails['contact_email']."')" )->one();
                    }else {
                        $ArrConts = explode( ',', $contactDetails['contact_number'] );
                        foreach ( $ArrConts as $key => $value ) {
                            $conts[] = Common::clean_special_characters( $value );
                        }
                        $multiNumbers = implode( ',', $conts );
                        $oModel  = UserContactDetails::find()->where( "user_id = '".$requestParam['user_id']."' AND (contact_number IN (".$multiNumbers.") OR contact_email = '".$contactDetails['contact_email']."')" )->one();
                    }
                }
                if ( !empty( $contactDetails['contact_number'] ) ) {
                    if ( empty( strpos( $contactDetails['contact_number'], ',' ) ) ) {
                        $multipleNumbers = $contactDetails['contact_number'];
                    }else {
                        $contacts = explode( ',', $contactDetails['contact_number'] );
                        foreach ( $contacts as $key => $value ) {
                            $snContacts[] = Common::clean_special_characters( $value );
                        }
                        $multipleNumbers = implode( ',', $snContacts );
                    }

                }
                if ( empty( $oModel ) ) {
                    $oModelUserContacts = new UserContactDetails();
                    $oModelUserContacts->user_id = $requestParam['user_id'];
                    $oModelUserContacts->contact_number = $multipleNumbers;
                    $oModelUserContacts->contact_email = !empty( $contactDetails['contact_email'] ) ? $contactDetails['contact_email'] : "";
                    $oModelUserContacts->contact_name = $contactDetails['contact_name'];
                    $oModelUserContacts->contact_from = $requestParam['contact_from'];
                    $oModelUserContacts->created_at = date( "Y-m-d H:i:s" );
                    $oModelUserContacts->save( false );
                }else {
                    $oModel->user_id = $requestParam['user_id'];
                    $oModel->contact_number = $multipleNumbers;
                    $oModel->contact_email = !empty( $contactDetails['contact_email'] ) ? $contactDetails['contact_email'] : "";
                    $oModel->contact_name = $contactDetails['contact_name'];
                    $oModel->contact_from = $requestParam['contact_from'];
                    $oModel->created_at = date( "Y-m-d H:i:s" );
                    $oModel->save( false );
                }
            }
            //  $Details = UserContactDetails::find()->where( ['user_id'=>$requestParam['user_id']] )->asArray()->all();
            $ssMessage = "Contact Details saved successfully.";
            $amReponseParam = [];
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    public function actionAddUserContacts() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $multipleNumbers = '';

        $amResponse = $oModel =  array();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'contact_from', 'contacts' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        $this->matchUserStatus( $requestParam['user_id'] );

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            foreach ( $requestParam['contacts'] as $key => $contactDetails ) {
                if ( empty( $contactDetails['contact_email'] ) && !empty( $contactDetails['contact_number'] ) ) {
                    $oModel  = UserContactDetails::find()->where( ['user_id' =>$requestParam['user_id'], 'contact_number' => Common::clean_special_characters( $contactDetails['contact_number'] )] )->one();
                }else if ( empty( $contactDetails['contact_number'] ) && !empty( $contactDetails['contact_email'] ) ) {
                        $oModel  = UserContactDetails::find()->where( ['user_id' =>$requestParam['user_id'], 'contact_email' => $contactDetails['contact_email']] )->one();
                    }else {
                    $oModel  = UserContactDetails::find()->where( "user_id = '".$requestParam['user_id']."' AND (contact_number = '".Common::clean_special_characters( $contactDetails['contact_number'] )."' AND contact_email = '".$contactDetails['contact_email']."')" )->one();
                }
              /*  if ( !empty( $contactDetails['contact_number'] ) ) {
                    if ( empty( strpos( $contactDetails['contact_number'], ',' ) ) ) {
                        $multipleNumbers = $contactDetails['contact_number'];
                    }else {
                        $contacts = explode( ',', $contactDetails['contact_number'] );
                        foreach ( $contacts as $key => $value ) {
                            $snContacts[] = Common::clean_special_characters( $value );
                        }
                        $multipleNumbers = implode( ',', $snContacts );
                    }

                }*/
                if ( empty( $oModel ) ) {
                    $oModelUserContacts = new UserContactDetails();
                    $oModelUserContacts->user_id = $requestParam['user_id'];
                    $oModelUserContacts->contact_number = !empty($contactDetails['contact_number']) ? Common::clean_special_characters($contactDetails['contact_number']) : "";
                    $oModelUserContacts->contact_email = !empty( $contactDetails['contact_email'] ) ? $contactDetails['contact_email'] : "";
                    $oModelUserContacts->contact_name = $contactDetails['contact_name'];
                    $oModelUserContacts->contact_from = $requestParam['contact_from'];
                    $oModelUserContacts->created_at = date( "Y-m-d H:i:s" );
                    $oModelUserContacts->save( false );
                }else {
                    $oModel->user_id = $requestParam['user_id'];
                    $oModel->contact_number = !empty($contactDetails['contact_number']) ? Common::clean_special_characters($contactDetails['contact_number']) : "";
                    $oModel->contact_email = !empty( $contactDetails['contact_email'] ) ? $contactDetails['contact_email'] : "";
                    $oModel->contact_name = $contactDetails['contact_name'];
                    $oModel->contact_from = $requestParam['contact_from'];
                    $oModel->created_at = date( "Y-m-d H:i:s" );
                    $oModel->save( false );
                }
            }
            //  $Details = UserContactDetails::find()->where( ['user_id'=>$requestParam['user_id']] )->asArray()->all();
            $ssMessage = "Contact Details saved successfully.";
            $amReponseParam = [];
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : ListOfFavouritePlaces()
     * Description : User can view his/her favourite places list.
     * Request Params :user_id
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionListOfFavouritePlaces() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = $user_places = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];

        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $oModelUserFavPlaces = UserFavouritePlaces::find()->where( ['user_id'=>$requestParam['user_id']] )->asArray()->all();
            if ( !empty( $oModelUserFavPlaces ) ) {
                foreach ( $oModelUserFavPlaces as $key => $place ) {
                    unset( $place['updated_at'] );
                    unset( $place['user_id'] );
                    $user_places[] = $place;
                }
                $ssMessage = "User Favourite Places List";
                $amReponseParam = $user_places ;
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

            }else {
                $ssMessage = "No Record Found";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : ListOfUserContacts()
     * Description : User can see his/her contacts details with details wheather user is app user or not.
     * Request Params :'user_id'
     * Response Params : 'user_id',contacts details array
     * Author :Rutusha Joshi
     */

    public function actionListOfUserContacts() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $oModelUserContacts = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $oModelUserContacts  = UserContactDetails::find()->where( ['user_id'=> $requestParam['user_id']] )->asArray()->all();
            $oModelRegisteredUsers = Users::find()->where( "id != '".$requestParam['user_id']."' AND role_id = '".Yii::$app->params['userroles']['application_users']."'" )->asArray()->all();
            if ( !empty( $oModelUserContacts ) ) {
                foreach ( $oModelUserContacts as $key => $user_contact ) {
                    foreach ( $oModelRegisteredUsers as $key => $user ) {

                        if ( !empty( $user_contact['contact_number'] ) && !empty( $user_contact['contact_email'] ) ) {
                            if ( ( $user_contact['contact_number'] == $user['phone'] ) && ( $user_contact['contact_email'] == $user['email'] ) ) {
                                $user_contact['is_application_user'] = 'Yes';
                                $user_contact['app_user_id']   = $user['id'];
                                $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                break;
                            }
                            if ( ( $user_contact['contact_number'] == $user['phone'] ) && ( $user_contact['contact_email'] != $user['email'] ) ) {
                                $user_contact['is_application_user'] = 'Yes';
                                $user_contact['app_user_id']   = $user['id'];
                                $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                break;
                            }
                            if ( ( $user_contact['contact_number'] != $user['phone'] ) && ( $user_contact['contact_email'] == $user['email'] ) ) {
                                $user_contact['is_application_user'] = 'Yes';
                                $user_contact['app_user_id']   = $user['id'];
                                $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                break;
                            }
                            if ( ( $user_contact['contact_number'] != $user['phone'] ) && ( $user_contact['contact_email'] != $user['email'] ) ) {
                                if ( $user_contact['contact_number'] == Common::clean_special_characters( $user['country_code'].$user['phone'] ) ) {
                                    $user_contact['is_application_user'] = 'Yes';
                                    $user_contact['app_user_id']   = $user['id'];
                                    $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                    $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                    break;
                                }
                                $user_contact['is_application_user'] = 'No';
                                $user_contact['app_user_id'] = "";
                                $user_contact['app_user_image'] = "";
                                $user_contact['app_user_name'] = "";

                            }
                        }
                        if ( empty( $user_contact['contact_number'] ) && !empty( $user_contact['contact_email'] ) ) {
                            if ( ( $user_contact['contact_email'] == $user['email'] ) ) {
                                $user_contact['is_application_user'] = 'Yes';
                                $user_contact['app_user_id']   = $user['id'];
                                $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                            }else if ( ( $user_contact['contact_email'] != $user['email'] ) ) {
                                    if ( $user_contact['contact_number'] == Common::clean_special_characters( $user['country_code'].$user['phone'] ) ) {
                                        $user_contact['is_application_user'] = 'Yes';
                                        $user_contact['app_user_id']   = $user['id'];
                                        $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                        $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                        break;
                                    }
                                    $user_contact['is_application_user'] = 'No';
                                    $user_contact['app_user_id'] = "";
                                    $user_contact['app_user_image'] = "";
                                    $user_contact['app_user_name'] = "";

                                }
                        }
                        if ( empty( $user_contact['contact_email'] ) && !empty( $user_contact['contact_number'] ) ) {
                            if ( ( $user_contact['contact_number'] == $user['phone'] ) ) {
                                $user_contact['is_application_user'] = 'Yes';
                                $user_contact['app_user_id']   = $user['id'];
                                $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                break;
                            }else if ( ( $user_contact['contact_number'] != $user['phone'] ) ) {

                                    if ( $user_contact['contact_number'] == Common::clean_special_characters( $user['country_code'].$user['phone'] ) ) {
                                        $user_contact['is_application_user'] = 'Yes';
                                        $user_contact['app_user_id']   = $user['id'];
                                        $user_contact['app_user_image'] = !empty( $user['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$user['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $user['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                                        $user_contact['app_user_name'] = $user['first_name'].' '.$user['last_name'];
                                        break;
                                    }
                                    $user_contact['is_application_user'] = 'No';
                                    $user_contact['app_user_id'] = "";
                                    $user_contact['app_user_image'] = "";
                                    $user_contact['app_user_name'] = "";
                                }
                        }
                        if ( empty( $user_contact['contact_email'] ) && empty( $user_contact['contact_number'] ) ) {
                            $user_contact['is_application_user'] = 'No';
                            $user_contact['app_user_id'] = "";
                            $user_contact['app_user_image'] = "";
                            $user_contact['app_user_name'] = "";
                        }

                    }
                    unset( $user_contact['created_at'] );
                    unset( $user_contact['updated_at'] );
                    unset( $user_contact['user_id'] );
                    $data[] = $user_contact;
                }
                $amReponseParam = $data;
                $ssMessage = "Contact Details";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage = "No contacts found.";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


/*    public function actionListOfUserContacts_new() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $oModelUserContacts = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
                $oModelUserContacts  = UserContactDetails::find()->where("user_id = $snUserId  AND (contact_number IN (SELECT replace(phone,'+','') FROM users WHERE id != $snUserId) OR contact_email IN (SELECT email FROM users WHERE id != $snUserId) OR contact_number IN (SELECT CONCAT_WS('', REPLACE(country_code,'+',''), REPLACE(phone,'+','')) FROM users WHERE id != $snUserId))")->asArray()->all();
                
            if(!empty($oModelUserContacts)){
                array_walk( $oModelUserContacts, function( $arr ) use( &$amResponseData ) {
                            $ttt                       = $arr;
                            $oModelUsers       = Users::find()->where( ['id'=>$ttt['user_id']] )->one();
                            $ttt['is_application_user'] = "Yes"
                            $ttt['app_user_id']     = !empty( $oModelUsers ) ? $oModelUsers->id : "";
                            $ttt['app_user_name']     = !empty( $oModelUsers ) ? $oModelUsers->first_name.' '.$oModelUsers->last_name : "";
                            $ttt['app_user_image']     =  !empty( $oModelUsers->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$oModelUsers->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $oModelUsers->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                            $ttt['is_joined'] = !empty( $ttt['participant_status'] ) && ( $ttt['participant_status'] == $active_status ) ? "Yes" : "No";
                            $ttt['invited_by'] = !empty( $ttt['invited_by'] ) ? $ttt['invited_by'] : "";
                            unset( $ttt['id'] );
                            unset( $ttt['created_at'] );
                            unset( $ttt['updated_at'] );
                            $amResponseData[]          = $ttt;
                            return $amResponseData;
                        } );
                $amReponseParam['Application Users Details'] = $oModelUserContacts;
             //  $amReponseParam['Other Contacts'] = ;
                $ssMessage = "Contact Details";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage = "No contacts found.";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }*/
    /*
     * Function : AddUserEvent()
     * Description : User can add new event (optional to invite participants)
     * Request Params :'user_id','activity_id','event_startpoint_longitude','event_startpoint_latitude','event_endpoint_longitude','event_endpoint_latitude','event_start_date','event_duration','event_description','event_intensity','is_recurring'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionAddUserEvent() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $oModelParticipatedUsers = array();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'activity_id', 'event_longitude', 'event_latitude', 'event_start_date', 'event_duration', 'event_description', 'event_intensity', 'is_recurring' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status ////
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {


            if ( $requestParam['is_recurring'] == 1 ) {

                for ( $i=0; $i <10 ; $i++ ) {
                    $ParentSelfId = "";
                    $EventStartDate = date( 'Y-m-d H:i:s', strtotime( "+$i week", strtotime( $requestParam['event_start_date'] ) ) );
                    $EventStartDateArr[] = date( 'Y-m-d H:i:s', strtotime( "+$i week", strtotime( $requestParam['event_start_date'] ) ) );
                    $EventEndDate = date( "Y-m-d H:i:s", strtotime( $EventStartDate.$requestParam['event_duration']." minutes" ) );

                    if ( empty( $requestParam['event_id'] ) ) {

                        $oModelUserEvents                             = new UserEvents();
                    }else {
                        $oModelUserEvents                             = UserEvents::find()->where( ['user_id'=>$requestParam['user_id'], 'id'=>$requestParam['event_id']] )->one();
                        $oParticipants = EventParticipants::find()->where( ['event_id'=>$requestParam['event_id']] )->asArray()->all();
                        $oParticipantsId = array_column( $oParticipants, 'user_id' );

                    }
                    $oModelUserEvents->user_id                    = $requestParam['user_id'];
                    $oModelUserEvents->name                       = !empty( $requestParam['name'] ) ? $requestParam['name'] : "";
                    $oModelUserEvents->activity_id                = $requestParam['activity_id'];
                    $oModelUserEvents->event_startpoint_longitude = $requestParam['event_longitude'];
                    $oModelUserEvents->event_startpoint_latitude  = $requestParam['event_latitude'];
                    $oModelUserEvents->event_endpoint_longitude   = !empty( $requestParam['event_endpoint_longitude'] ) ? $requestParam['event_endpoint_longitude'] : "";
                    $oModelUserEvents->event_endpoint_latitude    = !empty( $requestParam['event_endpoint_latitude'] ) ? $requestParam['event_endpoint_latitude'] : "";
                    $oModelUserEvents->event_start_date           = $EventStartDate;
                    $oModelUserEvents->event_duration             = $requestParam['event_duration'];
                    $oModelUserEvents->event_location             = !empty( $requestParam['event_location'] ) ? $requestParam['event_location'] : "";
                    $oModelUserEvents->event_end_date             = $EventEndDate;
                    $oModelUserEvents->event_description          = $requestParam['event_description'];
                    $oModelUserEvents->event_intensity            = $requestParam['event_intensity'];
                    $oModelUserEvents->is_recurring               = $requestParam['is_recurring'];
                    $oModelUserEvents->event_status               = Yii::$app->params['event_status']['in_process'];
                    $oModelUserEvents->created_at                 = date( "Y-m-d H:i:s" );

                    $oModelUserEvents->save( false );
                    $snActivityName = !empty( $oModelUserEvents->activity ) ? $oModelUserEvents->activity->activity_name : "";

                    if ( $i==0 ) {
                        $ParentSelfId = $oModelUserEvents->recurring_parent_id = $oModelUserEvents->id;
                        $oModelUserEvents->save( false );
                        $snEventId = $oModelUserEvents->id;
                    }else {
                        $ParentSelfId = $oModelUserEvents->recurring_parent_id = $oModelUserEvents->id-$i;
                        $oModelUserEvents->save( false );
                    }
                }
                if ( !empty( $requestParam['participants'] ) ) {
                    $ArrParticipants = explode( ',', $requestParam['participants'] );
                    if ( !empty( $oParticipantsId ) ) {
                        $oParticipantsToBeDeletd = array_diff( $oParticipantsId, $ArrParticipants );
                        if ( !empty( $oParticipantsToBeDeletd ) ) {
                            foreach ( $oParticipantsToBeDeletd as $key => $value ) {
                                $oDelete = EventParticipants::find()->where( ['event_id'=>$oModelUserEvents->id, 'user_id'=>$value] )->one();
                                $oDelete->delete();
                            }
                        }
                    }
                    foreach ( $ArrParticipants as $key => $participant ) {
                        $oModel = EventParticipants::find()->where( ['user_id'=> $participant, 'event_id'=>$oModelUserEvents->id] )->one();
                        if ( !empty( $oModel ) ) {
                            $oModelParticipats = $oModel;
                        }else {
                            $oModelParticipats = new EventParticipants;
                        }
                        $oModelParticipats->is_forwarded = 0;
                        $oModelParticipats->invited_by =  !empty( $requestParam['user_id'] ) ? $requestParam['user_id'] : "";
                        $oModelParticipats->event_id = !empty( $snEventId ) ? $snEventId : "";
                        $oModelParticipats->user_id  = $participant;
                        $oModelParticipats->created_at = date( "Y-m-d H:i:s" );
                        $oModelParticipats->participant_status = Yii::$app->params['participant_status']['pending'];
                        $oModelParticipats->save( false );
                        $oModelParticipatedUsers[] = $oModelParticipats;
                        $device_details = Devicedetails::find()->where( ["userid"=>$oModelParticipats->user_id] )->one();
                        $device_token = $device_details['device_tocken'];
                        //ankit
                        $notificationArray = [
                        "device_token"      => $device_token,
                        "message"           => "You are invited in ".$snActivityName." session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $requestParam['event_start_date'] ) ),
                        "notification_type" => 'Event Invitation',
                        "user_id"           => $oModelParticipats->user_id,
                        "event_id"          => !empty( $snEventId ) ? $snEventId : "",
                        ];
                        if ( $device_token != '' && strlen( $device_token ) == '64' ) {

                            Common::SendNotification( $notificationArray );
                        }

                    }
                }else {
                    if ( !empty( $oParticipantsId ) ) {
                        foreach ( $oParticipantsId as $key => $value ) {
                            $oDelete = EventParticipants::find()->where( ['event_id'=>$oModelUserEvents->id, 'user_id'=>$value] )->one();
                            $oDelete->delete();
                        }
                    }
                }


            } else {
                if ( empty( $requestParam['event_id'] ) ) {
                    $oModelUserEvents                             = new UserEvents();
                }else {
                    $oModelUserEvents                             = UserEvents::find()->where( ['user_id'=>$requestParam['user_id'], 'id'=>$requestParam['event_id']] )->one();
                    $oParticipants = EventParticipants::find()->where( ['event_id'=>$requestParam['event_id']] )->asArray()->all();
                    $oParticipantsId = array_column( $oParticipants, 'user_id' );
                }
                $oModelUserEvents->user_id                    = $requestParam['user_id'];
                $oModelUserEvents->name                       = !empty( $requestParam['name'] ) ? $requestParam['name'] : "";
                $oModelUserEvents->activity_id                = $requestParam['activity_id'];
                $oModelUserEvents->event_startpoint_longitude = $requestParam['event_longitude'];
                $oModelUserEvents->event_startpoint_latitude  = $requestParam['event_latitude'];
                $oModelUserEvents->event_endpoint_longitude   = !empty( $requestParam['event_endpoint_longitude'] ) ? $requestParam['event_endpoint_longitude'] : "";
                $oModelUserEvents->event_endpoint_latitude    = !empty( $requestParam['event_endpoint_latitude'] ) ? $requestParam['event_endpoint_latitude'] : "";
                $oModelUserEvents->event_start_date           = date( "Y-m-d H:i:s", strtotime( $requestParam['event_start_date'] ) );
                $oModelUserEvents->event_duration             = $requestParam['event_duration'];
                $oModelUserEvents->event_location             = !empty( $requestParam['event_location'] ) ? $requestParam['event_location'] : "";
                $oModelUserEvents->event_end_date             = date( "Y-m-d H:i:s", strtotime( $oModelUserEvents->event_start_date .$oModelUserEvents->event_duration." minutes" ) );
                $oModelUserEvents->event_description          = $requestParam['event_description'];
                $oModelUserEvents->event_intensity            = $requestParam['event_intensity'];
                $oModelUserEvents->is_recurring               = $requestParam['is_recurring'];
                $oModelUserEvents->event_status               = Yii::$app->params['event_status']['in_process'];
                $oModelUserEvents->created_at                 = date( "Y-m-d H:i:s" );
                $oModelUserEvents->save( false );
                $snActivityName = !empty( $oModelUserEvents->activity ) ? $oModelUserEvents->activity->activity_name : "";
                if ( !empty( $requestParam['participants'] ) ) {
                    $ArrParticipants = explode( ',', $requestParam['participants'] );
                    if ( !empty( $oParticipantsId ) ) {
                        $oParticipantsToBeDeletd = array_diff( $oParticipantsId, $ArrParticipants );
                        if ( !empty( $oParticipantsToBeDeletd ) ) {
                            foreach ( $oParticipantsToBeDeletd as $key => $value ) {
                                $oDelete = EventParticipants::find()->where( ['event_id'=>$oModelUserEvents->id, 'user_id'=>$value] )->one();
                                $oDelete->delete();
                            }
                        }
                    }
                    foreach ( $ArrParticipants as $key => $participant ) {
                        $oModel = EventParticipants::find()->where( ['user_id'=> $participant, 'event_id'=>$oModelUserEvents->id] )->one();
                        if ( !empty( $oModel ) ) {
                            $oModelParticipats = $oModel;
                        }else {
                            $oModelParticipats = new EventParticipants;
                        }
                        $oModelParticipats->is_forwarded = 0;
                        $oModelParticipats->invited_by =  !empty( $requestParam['user_id'] ) ? $requestParam['user_id'] : "";
                        $oModelParticipats->event_id = $oModelUserEvents->id;
                        $oModelParticipats->user_id  = $participant;
                        $oModelParticipats->created_at = date( "Y-m-d H:i:s" );
                        $oModelParticipats->participant_status = Yii::$app->params['participant_status']['pending'];
                        $oModelParticipats->save( false );
                        $oModelParticipatedUsers[] = $oModelParticipats;
                        $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$oModelParticipats->user_id] )->one();
                        $snDeviceToken = $snDeviceDetails['device_tocken'];

                        $notificationArr = [
                        "device_token"   => $snDeviceToken,
                        "message"               => "You are invited in ".$snActivityName." session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $oModelUserEvents->event_start_date ) ),
                        "notification_type"     => 'Event Invitation',
                        "user_id"   => $oModelParticipats->user_id,
                        "event_id"  => !empty( $oModelUserEvents->id ) ? $oModelUserEvents->id : "",
                        ];
                        if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                            Common::SendNotification( $notificationArr );
                        }
                    }
                }else {
                    if ( !empty( $oParticipantsId ) ) {
                        foreach ( $oParticipantsId as $key => $value ) {
                            $oDelete = EventParticipants::find()->where( ['event_id'=>$oModelUserEvents->id, 'user_id'=>$value] )->one();
                            $oDelete->delete();
                        }
                    }
                }
            }
            $ssMessage = "Event created successfully.";
            $amReponseParam['event_id'] = $oModelUserEvents->id;
            //$amReponseParam['name'] = $oModelUserEvents->name;
            $amReponseParam['activity_id'] = $oModelUserEvents->activity_id;
            $amReponseParam['activity_name'] = $snActivityName;
            $amReponseParam['event_longitude'] = $oModelUserEvents->event_startpoint_longitude;
            $amReponseParam['event_latitude'] = $oModelUserEvents->event_startpoint_latitude;
            //$amReponseParam['event_endpoint_longitude'] = $oModelUserEvents->event_endpoint_longitude;
            // $amReponseParam['event_endpoint_latitude'] = $oModelUserEvents->event_endpoint_latitude;
            $amReponseParam['event_start_date'] = $oModelUserEvents->event_start_date;
            $amReponseParam['event_end_date'] = $oModelUserEvents->event_end_date;
            $amReponseParam['event_duration'] = $oModelUserEvents->event_duration;
            $amReponseParam['event_location'] = !empty( $oModelUserEvents->event_location ) ? $oModelUserEvents->event_location : "";
            $amReponseParam['event_description'] = $oModelUserEvents->event_description;
            $amReponseParam['event_intensity'] = $oModelUserEvents->event_intensity;
            $amReponseParam['is_recurring'] = $oModelUserEvents->is_recurring;
            $amReponseParam['created_at'] = $oModelUserEvents->created_at;
            $amReponseParam['event_status'] = Yii::$app->params['event_status_value'][$oModelUserEvents->event_status];
            $amReponseParam['participants'] = $oModelParticipatedUsers;
            $amReponseParam['participants_count'] = count( $oModelParticipatedUsers );
            $amReponseParam['recurring_parent_id'] = $oModelUserEvents->recurring_parent_id;
            $amReponseParam['recurring_events_dates'] = ( $requestParam['is_recurring'] == 1 ) ? $EventStartDateArr : [];
            //  $amReponseParam['is_forwarded'] = (!empty($oModelUserEvents->is_forwarded) && $oModelUserEvents->is_forwarded == 1) ? $oModelUserEvents->is_forwarded : 0 ;



            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }
    /*
     * Function : GetUserEvents()
     * Description : User can view the events created by him/her with event details
     * Request Params :'user_id'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionGetMyUserEvents() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            /*          $query = new Query;
             $query->select( 'ue.*,ep.*,a.activity_name,u.first_name,u.last_name' )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'users as u',
                'u.id = ue.user_id' )
            ->join( 'LEFT JOIN', 'event_participants as ep',
                'ep.event_id = ue.id' )
            ->join( 'LEFT JOIN', 'activities as a',
                'a.id = ue.activity_id' )
            ->where('ue.user_id = '.$requestParam['user_id'].' ');
            $command = $query->createCommand();
            $arrUserEvents = $command->queryAll();*/
            //p($arrUserEvents);
            $oModelUserEvents = UserEvents::find()->with( 'eventParticipants' )->where( ['user_id'=>$requestParam['user_id']] )->asArray()->all();
            $ssMessage = "User Events List.";
            $amReponseParam = $oModelUserEvents;
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function :ParticipateInEvent()
     * Description : User can invite other users for event
     * Request Params :'user_id', 'event_id', 'comment', 'event_participants'
     * Response Params : ''
     * Author :Rutusha Joshi
     */

    public function actionInviteParticipants() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam =  [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id', 'event_participants' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            if ( !empty( $requestParam['event_participants'] ) ) {
                foreach ( $requestParam['event_participants'] as $key => $participants ) {
                    // $modelCheckParticipantStatus = EventParticipants::find()->where(['user_id'=>$participants,'event_id'=> $requestParam['event_id'],'participant_status'=>Yii::$app->params['participant_status']['pending']])->one();
                    //if(empty($modelCheckParticipantStatus)){
                    $oModel =  new EventParticipants();
                    $snEvent = UserEvents::findOne( $requestParam['event_id'] );
                    if ( !empty( $snEvent ) && ( $requestParam['user_id'] == $snEvent->user_id ) ) {
                        $oModel->is_forwarded = 0;
                    }else {
                        $oModel->is_forwarded = 1;
                    }
                    $oModel->invited_by = $requestParam['user_id'];
                    $oModel->user_id = $participants;
                    $oModel->event_id = $requestParam['event_id'];
                    $oModel->participant_status = Yii::$app->params['participant_status']['pending'];
                    $oModel->created_at = date( "Y-m-d H:i:s" );
                    $oModel->save( false );
                    $snActivityName = !empty( $oModelUserEvents->activity ) ? $oModelUserEvents->activity->activity_name : "";

                    //SEND NOTIFICATION TO USER//
                    $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$oModel->user_id] )->one();
                    $snDeviceToken = $snDeviceDetails['device_tocken'];
                    $notificationArray = [
                    "device_token"   => $snDeviceToken,
                    "message"               =>  "You are invited in ".$snActivityName." session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $snEvent->event_start_date ) ),
                    "notification_type"     => 'Event Invitation',
                    "user_id"   => $oModel->user_id,
                    "event_id" => $requestParam['event_id'],
                    ];
                    if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                        Common::SendNotification( $notificationArray );
                    }
                    //}
                }
            }
            $ssMessage = "Participants invited successfully.";
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );

    }

    /*
     * Function : ContactsToBeInvited()
     * Description : User can see list of contacts which are not in user's contacts list.
     * Request Params :'user_id'
     * Response Params : List of contact numbers which are to be invited
     * Author :Rutusha Joshi
     */

    public function actionContactsToBeInvited() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amReponseParam = $amResponse =  [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $query = new Query;
            $query->select( 'u.first_name,u.last_name,u.phone,u.email' )
            ->from( 'users as u' )
            ->join( 'LEFT JOIN', 'user_contact_details as uc',
                'uc.user_id = u.id' )
            ->where( 'u.status = '.Yii::$app->params['status']['active'].' AND u.id != '.$requestParam['user_id'].' AND u.role_id = '.Yii::$app->params['userroles']['application_users'].' AND u.phone NOT IN ("SELECT contact_number FROM user_contact_details WHERE user_id = 3")' );
            $command = $query->orderBy( 'u.first_name ASC' )->createCommand();
            $arrUserContactsDetails = $command->queryAll();
            $ssMessage = "List of contacts to be invited.";
            $amReponseParam = $arrUserContactsDetails;
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : AddUserFavouriteActivities()
     * Description : User can add his/her Favourite Activities.
     * Request Params :'user_id,activities'
     * Response Params : List of contact numbers which are to be invited
     * Author :Rutusha Joshi
     */

    public function actionAddUserFavouriteActivities() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amReponseParam = $amResponse =  [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'activities' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $ArrActivities = $requestParam['activities'];
        $oModelUser = Users::findOne( $snUserId );
        if ( !empty( $oModelUser ) ) {
            if ( !empty( $ArrActivities ) ) {
                foreach ( $ArrActivities as $key => $activity ) {
                    $oModelUserActivity              = new UserActivities;
                    $oModelUserActivity->user_id     = $snUserId;
                    $oModelUserActivity->activity_id = $activity;
                    $oModelUserActivity->save( false );
                }
                $ssMessage = "Activities added successfully.";
                $amReponseParam = "";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : AddUserFavouriteActivities()
     * Description : User can add his/her Favourite Activities.
     * Request Params :'user_id,activities'
     * Response Params : List of contact numbers which are to be invited
     * Author :Rutusha Joshi
     */

    public function actionAddUserFavouritePlaces() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amReponseParam = $amResponse =  [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'places' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        $snUserId = $requestParam['user_id'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $ArrPlaces = $requestParam['places'];
        $oModelUser = Users::findOne( $snUserId );
        if ( !empty( $oModelUser ) ) {
            if ( !empty( $ArrPlaces ) ) {
                foreach ( $ArrPlaces as $key => $place ) {
                    $oModelUserPlace              = new UserFavouritePlaces;
                    $oModelUserPlace->user_id     = $snUserId;
                    $oModelUserPlace->name = $place['name'];
                    $oModelUserPlace->address = $place['address'];
                    $oModelUserPlace->place_longitude = $place['place_longitude'];
                    $oModelUserPlace->place_latitude = $place['place_latitude'];
                    $oModelUserPlace->created_at = date( "Y-m-d H:i:s" );
                    $oModelUserPlace->save( false );
                }
                $ssMessage = "Places added successfully.";
                $amReponseParam = "";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : EditProfile()
     * Description : Edit User Profile
     * Request Params : university_id,first_name,last_name,email address,password,profile_pic
     * Response Params : user_id,firstname,email,last_name, email,status,created_at
     * Author : Ankit
     */

    public function actionEditProfile() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'first_name', 'last_name', 'address_line_1', 'birth_date', 'gender' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {
            // Database field
            $model->first_name             = $requestParam['first_name'];
            $model->last_name              = $requestParam['last_name'];
            $model->address_line_1         = !empty( $requestParam['address_line_1'] ) ? $requestParam['address_line_1'] : "";
            $model->birth_date             = date( "Y-m-d", strtotime( $requestParam['birth_date'] ) );
            $model->gender                 = Yii::$app->params['gender'][$requestParam['gender']];
            $model->user_initial_longitude = !empty( $requestParam['user_initial_longitude'] ) ? $requestParam['user_initial_longitude'] : '';
            $model->user_initial_latitude  = !empty( $requestParam['user_initial_latitude'] ) ? $requestParam['user_initial_latitude'] : '';
            //$model->event_radious_range    = !empty( $requestParam['event_radious_range'] ) ? $requestParam['event_radious_range'] : 20;
            $model->role_id                = Yii::$app->params['userroles']['application_users'];
            $model->notification_status    = Yii::$app->params['notification_status']['active'];
            $model->updated_at             = date( 'Y-m-d H:i:s' );
            $model->status                 = Yii::$app->params['status']['active'];
            //$model->event_radious_range    = !empty( $requestParam['event_radious_range'] ) ? $requestParam['event_radious_range'] : '';




            if ( isset( $requestFileparam['image']['name'] ) ) {

                $model->user_image = UploadedFile::getInstanceByName( 'image' );
                $Modifier          = md5( ( $model->user_image ) );
                $ssFileName        = $Modifier . rand( 11111, 99999 );
                $Extension         = $model->user_image->extension;
                $model->user_image->saveAs( Yii::$app->params['upload_user_image'] . $ssFileName . '.' . $model->user_image->extension );
                $model->user_image = $ssFileName      . '.' . $Extension;
            }
            if ( $model->save( false ) ) {

                // Device Registration
                $ssMessage                                = 'Your profile has been updated successfully.';

                $amReponseParam['user_email']             = $model->email;
                $amReponseParam['user_id']                = $model->id;
                $amReponseParam['first_name']             = $model->first_name;
                $amReponseParam['last_name']              = $model->last_name;
                $amReponseParam['address_line_1']         = !empty( $model->address_line_1 ) ? $model->address_line_1 : "";
                $amReponseParam['country_code']           = $model->country_code;
                $amReponseParam['phone']                  = $model->phone;
                $amReponseParam['verification_code']      = $model->verification_code;
                $amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $model->birth_date ) );
                $amReponseParam['gender']                 = Yii::$app->params['gender_value'][$model->gender];
                $amReponseParam['user_initial_longitude'] = !empty( $model->user_initial_longitude ) ? $model->user_initial_longitude : "";
                $amReponseParam['user_initial_latitude']  = !empty( $model->user_initial_latitude ) ? $model->user_initial_latitude : "";
                $amReponseParam['event_radious_range']    = !empty( $model->event_radious_range ) ? $model->event_radious_range : '';
                $amReponseParam['is_mobile_verified']     = !empty( $model->is_code_verified ) && ( $model->is_code_verified > 0 ) ? $model->is_code_verified : 0;
                $amReponseParam['auth_token']             = !empty( $model->auth_token ) ? $model->auth_token : "";
                $amReponseParam['image']                  = !empty( $model->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$model->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $model->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";


                $amResponse                               = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : DeleteFavouritePlaces()
     * Description : User can Delete his/her favourite places.
     * Request Params :
     * Response Params :
     * Author :Rutusha Joshi
     */

    public function actionDeleteFavouritePlaces() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam = $user_places = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'fav_place_id' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            if ( !empty( $requestParam['fav_place_id'] ) ) {
                $ArrFavPlaces = explode( ",", $requestParam['fav_place_id'] );
                foreach ( $ArrFavPlaces as $key => $fav_place ) {
                    $oModelUserFavPlaces = UserFavouritePlaces::find()->where( ['user_id'=>$requestParam['user_id'], 'id'=>$fav_place] )->one();
                    if ( !empty( $oModelUserFavPlaces ) ) {
                        $user_places[] = $oModelUserFavPlaces;
                        $oModelUserFavPlaces->delete();
                    }
                }
            }
            $ssMessage = "Favourite Places deleted successfully.";
            $amReponseParam = $user_places ;
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : GetEventDetails()
     * Description : User can view the events created by him/her with event details
     * Request Params :'user_id'
     * Response Params : 'user_id','event_id'
     * Author :Rutusha Joshi
     */

    public function actionGetEventDetails() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amReponseParam  = $snParticipants =  [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $active_status = Yii::$app->params['participant_status']['active'];
            $snUserEvents = UserEvents::find()->with( /*[*/'eventParticipants'/*=> function( $q )use( $active_status ) {
                    return $q->where( "participant_status = $active_status" );
                }]*/ )->where( ['id'=> $requestParam['event_id']] )->asArray()->all();


            if ( !empty( $snUserEvents ) ) {
                $oModelUserEvents = array_shift( $snUserEvents );
                $amReponseParam['event_id'] = $oModelUserEvents['id'];
                $amReponseParam['is_recurring'] =  Yii::$app->params['is_recurring_value'][$oModelUserEvents['is_recurring']];
                $activity = Activities::find()->where( ['id'=>$oModelUserEvents['activity_id']] )->one();
                $amReponseParam['activity_name'] = $activity['activity_name'];
                $amReponseParam['event_longitude'] = $oModelUserEvents['event_startpoint_longitude'];
                $amReponseParam['event_latitude'] = $oModelUserEvents['event_startpoint_latitude'];
                $amReponseParam['event_location'] = !empty( $oModelUserEvents['event_location'] ) ? $oModelUserEvents['event_location'] : "";
                $amReponseParam['event_start_date'] = $oModelUserEvents['event_start_date'];
                $amReponseParam['event_end_date'] = $oModelUserEvents['event_end_date'];
                $amReponseParam['event_duration'] = $oModelUserEvents['event_duration'];
                $amReponseParam['event_description'] = $oModelUserEvents['event_description'];
                $amReponseParam['event_intensity'] = $oModelUserEvents['event_intensity'];
                $amReponseParam['created_at'] = $oModelUserEvents['created_at'];
                $amReponseParam['event_status'] = Yii::$app->params['event_status_value'][$oModelUserEvents['event_status']];
                $amReponseParam['event_creater_id'] = $oModelUserEvents['user_id'];
                $amReponseParam['recurring_parent_id'] = !empty( $oModelUserEvents['recurring_parent_id'] ) ? $oModelUserEvents['recurring_parent_id'] : "" ;
                $snCreaterUser = Users::findOne( $oModelUserEvents['user_id'] );

                $amReponseParam['event_creater_name'] = !empty( $snCreaterUser ) ? $snCreaterUser->first_name.' '.$snCreaterUser->last_name : "";
                $amReponseParam['event_creater_image'] = !empty( $snCreaterUser->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$snCreaterUser->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $snCreaterUser->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                $amReponseParam['comment_count'] = ParticipantComments::find()->where( ['event_id'=>$requestParam['event_id']] )->count();
                $amReponseParam['is_edited'] = ( $oModelUserEvents['updated_at'] == "0000-00-00 00:00:00" ) ? "No" : "Yes";
                $amReponseParam['is_creater'] = ( $requestParam['user_id'] == $snCreaterUser->id ) ? "Yes" : "No";
                if ( $amReponseParam['is_creater'] == "Yes" ) {
                    $amReponseParam['is_participated'] = "Yes";
                    $amReponseParam['is_forwarded'] = "No";
                }else {
                    $snEventParticiapnts = EventParticipants::find()->where( ['event_id'=>$amReponseParam['event_id'], 'user_id'=>$requestParam['user_id']] )->one();
                    if ( !empty( $snEventParticiapnts ) && ( $snEventParticiapnts->participant_status == Yii::$app->params['participant_status']['active'] ) ) {
                        $amReponseParam['is_participated'] = "Yes";
                        $amReponseParam['is_forwarded'] = ( !empty( $snEventParticiapnts->is_forwarded ) &&  ( $snEventParticiapnts->is_forwarded == '1' ) ) ? "Yes" : "No";
                    }else if ( !empty( $snEventParticiapnts ) && ( $snEventParticiapnts->participant_status == Yii::$app->params['participant_status']['pending'] ) ) {
                            $amReponseParam['is_participated'] = "No";
                            $amReponseParam['is_forwarded'] = ( !empty( $snEventParticiapnts->is_forwarded ) &&  ( $snEventParticiapnts->is_forwarded == '1' ) ) ? "Yes" : "No";
                        }else {
                        $amReponseParam['is_participated'] = "No";
                        $amReponseParam['is_forwarded'] = "No";
                    }
                }

                if ( !empty( $oModelUserEvents['eventParticipants'] ) ) {
                    array_walk( $oModelUserEvents['eventParticipants'], function( $arr ) use( &$amResponseData, $active_status ) {
                            $ttt                       = $arr;
                            $oModelUser       = Users::find()->where( ['id'=>$ttt['user_id']] )->one();
                            $ttt['first_name']     = !empty( $oModelUser ) ? $oModelUser->first_name : "";
                            $ttt['last_name']     = !empty( $oModelUser ) ? $oModelUser->last_name : "";
                            $ttt['image']     =  !empty( $oModelUser->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$oModelUser->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $oModelUser->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                            $ttt['is_joined'] = !empty( $ttt['participant_status'] ) && ( $ttt['participant_status'] == $active_status ) ? "Yes" : "No";
                            $ttt['invited_by'] = !empty( $ttt['invited_by'] ) ? $ttt['invited_by'] : "";
                            unset( $ttt['id'] );
                            unset( $ttt['event_id'] );
                            unset( $ttt['created_at'] );
                            unset( $ttt['updated_at'] );
                            $amResponseData[]          = $ttt;
                            return $amResponseData;
                        } );
                    $amReponseParam['eventParticipants'] = $amResponseData;

                }else {
                    $amReponseParam['eventParticipants'] = [];
                }
                $ssMessage = "User Event Details.";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );

            }else {
                $ssMessage = "Event has been deleted.";
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : GetUserDetails()
     * Description : Get User Details
     * Request Params : user_id
     * Response Params : user's details
     * Author : Rutusha Joshi
     */

    public function actionGetUserDetails() {
        //Get all request parameter
        $amData = Common::checkRequestType();
        $amResponse = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );
        $amParamsResult   = Common::checkRequestParameterKey( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam     = $amData['request_param'];
        $requestFileparam = $amData['file_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $model = Users::findOne( ["id" => $snUserId] );
        if ( !empty( $model ) ) {

            // Device Registration
            $ssMessage                                = 'User Profile Details.';

            $amReponseParam['user_email']             = $model->email;
            $amReponseParam['user_id']                = $model->id;
            $amReponseParam['first_name']             = $model->first_name;
            $amReponseParam['last_name']              = $model->last_name;
            $amReponseParam['address_line_1']         = $model->address_line_1;
            $amReponseParam['country_code']           = $model->country_code;
            $amReponseParam['phone']                  = $model->phone;
            $amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $model->birth_date ) );
            $amReponseParam['gender']                 = Yii::$app->params['gender_value'][$model->gender];
            $amReponseParam['user_initial_longitude'] = !empty( $model->user_initial_longitude ) ? $model->user_initial_longitude : "";
            $amReponseParam['user_initial_latitude']  = !empty( $model->user_initial_latitude ) ? $model->user_initial_latitude : "";
            $amReponseParam['event_radious_range']    = !empty( $model->event_radious_range ) ? $model->event_radious_range : '';
            $amReponseParam['is_mobile_verified']     = !empty( $model->is_code_verified ) && ( $model->is_code_verified > 0 ) ? $model->is_code_verified : 0;
            $amReponseParam['image']                  = !empty( $model->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$model->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $model->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";


            $amResponse                               = Common::successResponse( $ssMessage, $amReponseParam );
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    // this is testing webservice
    protected function radiouscalculation( $user_latitude, $user_longitude ) {

        $radius = 5;

        $sql   = "SELECT *, ( 6371 * acos( cos( radians({$user_latitude}) ) * cos( radians( `event_startpoint_latitude` ) ) * cos( radians( `event_startpoint_longitude` ) - radians({$user_longitude}) ) + sin( radians({$user_latitude}) ) * sin( radians( `event_startpoint_latitude` ) ) ) ) AS distance FROM `user_events` HAVING distance < {$radius} ORDER BY id ASC ";
        $model = UserEvents::findBySql( $sql )->asArray()->all();
        // p($model);

        p( $model );

        p( $user_latitude, 0 );
        p( $user_longitude );


    }

    /*
     * Function : GetListOfEvents which is in Radious ()
     * Description : User can view future events in application
     * Request Params :'user_id'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionGetListOfEvents() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse = $amResponseData = $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'user_initial_latitude', 'user_initial_longitude' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        $snActicveStatus = Yii::$app->params['participant_status']['active'];
        $snPendingStatus = Yii::$app->params['participant_status']['pending'];

        if ( !empty( $oModelUser ) ) {
            // $this->radiouscalculation($requestParam['user_latitude'] ,$requestParam['user_longitude'] );
            $radius = !empty( $oModelUser->event_radious_range ) && ( $oModelUser->event_radious_range > 0 ) ? $oModelUser->event_radious_range : 20;
            $user_latitude = $requestParam['user_initial_latitude'];
            $user_longitude = $requestParam['user_initial_longitude'];


            $query = new Query;
            $query->select( 'u.first_name,u.last_name,u.user_image,u.event_radious_range,a.activity_name,ue.event_start_date,ue.activity_id,ue.user_id,ue.event_end_date,ue.event_startpoint_longitude,ue.event_startpoint_latitude,ue.event_location,ue.event_duration,ue.id AS event_id,ue.updated_at'  )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'users as u', 'u.id =ue.user_id' )
            ->join( 'LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`' )
            ->where( "`ue`.`event_status` != '".Yii::$app->params['event_status']['completed']."' AND `ue`.`event_start_date` >= CURDATE() AND `ue`.`event_start_date` <= CURDATE() +  INTERVAL 7 DAY AND (6371 * acos( cos(radians({$user_latitude}) ) * cos(radians( `ue`.`event_startpoint_latitude`))*cos( radians( `ue`.`event_startpoint_longitude` ) - radians({$user_longitude}) ) + sin( radians({$user_latitude}) ) * sin( radians( `ue`.`event_startpoint_latitude`)))) < {$radius}  " );

            //->select( 'u.first_name,u.last_name,u.joining_date,projects.name as project_name,projects.handled_by as team_lead_id,department.name as department_name,up.user_id,up.start_date,up.end_date,up.allocated_hours,up.avg_hours,((up.avg_hours * 100) / 8) AS resource_utilization,((select sum(avg_hours) as total from user_projects where user_id= up.user_id) * 100 )/8 as total_utilization' );
            $command = $query->orderBy( 'ue.event_start_date ASC' )->createCommand();
            $arrEventDetails = $command->queryAll();

            if ( !empty( $arrEventDetails ) ) {
                array_walk( $arrEventDetails, function( $arr ) use( &$amResponseData, $snUserId , $snActicveStatus, $snPendingStatus ) {
                        $ttt                       = $arr;
                        $ttt['event_longitude']=$arr['event_startpoint_longitude'];
                        $ttt['event_latitude']=$arr['event_startpoint_latitude'];
                        $ttt['image']     =  !empty( $ttt['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$ttt['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $ttt['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                        $ttt['is_creater'] = ( $snUserId == $ttt['user_id'] ) ? "Yes" : "No";
                        if ( $ttt['is_creater'] == "Yes" ) {
                            $ttt['is_participated'] = "Yes";
                            $ttt['is_forwarded'] = "No";
                        }else {
                            $snEventParticiapnts = EventParticipants::find()->where( ['event_id'=>$ttt['event_id'], 'user_id'=>$snUserId] )->one();
                            if ( !empty( $snEventParticiapnts ) && ( $snEventParticiapnts->participant_status == $snActicveStatus ) ) {
                                $ttt['is_participated'] = "Yes";
                                $ttt['is_forwarded'] = ( !empty( $snEventParticiapnts->is_forwarded ) &&  ( $snEventParticiapnts->is_forwarded == '1' ) ) ? "Yes" : "No";
                            }else if ( !empty( $snEventParticiapnts ) && ( $snEventParticiapnts->participant_status == $snPendingStatus ) ) {
                                $ttt['is_participated'] = "No";
                                $ttt['is_forwarded'] = ( !empty( $snEventParticiapnts->is_forwarded ) &&  ( $snEventParticiapnts->is_forwarded == '1' ) ) ? "Yes" : "No";
                            }else {
                                $ttt['is_participated'] = "No";
                                $ttt['is_forwarded'] = "No";
                            }
                        }
                        $ttt['is_edited'] = ( $ttt['updated_at'] == "0000-00-00 00:00:00" ) ? "No" : "Yes";

                        unset( $ttt['status'] );
                        unset( $ttt['event_startpoint_longitude'] );
                        unset( $ttt['event_startpoint_latitude'] );
                        unset( $ttt['user_image'] );
                        unset( $ttt['updated_at'] );
                        $amResponseData[]          = $ttt;
                        return $amResponseData;
                    } );

                $amReponseParam = $amResponseData;




                $ssMessage = "User Events List.";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage = "No Details found.";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function : EnterComment()
     * Description : User Can comment in event
     * Request Params :'user_id','event_id','comment'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionEnterComment() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id', 'comment' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $oModelParticipantComments = new ParticipantComments();
            $oModelParticipantComments->user_id = $snUserId;
            $oModelParticipantComments->event_id = $requestParam['event_id'];
            $oModelParticipantComments->comment = $requestParam['comment'];
            $oModelParticipantComments->created_at = date( "Y-m-d H:i:s" );
            $oModelParticipantComments->save( false );
            $amReponseParam = $oModelParticipantComments;
            $ssMessage = "Comment added successfully.";
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : GetAllComments()
     * Description : User Can comment in event
     * Request Params :'user_id','event_id','comment'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionGetAllComments() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            $oModelComments = ParticipantComments::find()->where( ['event_id'=>$requestParam['event_id']] )->asArray()->all();
            if ( !empty( $oModelComments ) ) {

                foreach ( $oModelComments as $key => $SingleCommentDetails ) {
                    $UserAllDetails = Users::find()->where( ['id'=>$SingleCommentDetails['user_id']] )->one();
                    $ssMessage = "User Comments.";

                    $amReponseParam['comment_id']  =          $SingleCommentDetails['id'];
                    $amReponseParam['user_email']             = $UserAllDetails->email;
                    $amReponseParam['user_id']                = $UserAllDetails->id;
                    $amReponseParam['first_name']             = $UserAllDetails->first_name;
                    $amReponseParam['last_name']              = $UserAllDetails->last_name;
                    // $amReponseParam['address_line_1']         = $UserAllDetails->address_line_1;
                    // $amReponseParam['country_code']           = $oModelUser->country_code;
                    // $amReponseParam['phone']                  = $oModelUser->phone;
                    /*$amReponseParam['birth_date']             = date( "d-m-Y", strtotime( $oModelUser->birth_date ) );*/
                    /*  $amReponseParam['user_initial_longitude'] = !empty( $oModelUser->user_initial_longitude ) ? $oModelUser->user_initial_longitude : "";
            $amReponseParam['user_initial_latitude']  = !empty( $oModelUser->user_initial_latitude ) ? $oModelUser->user_initial_latitude : "";
            $amReponseParam['event_radious_range']    = !empty( $oModelUser->event_radious_range ) ? $oModelUser->event_radious_range : '';
            $amReponseParam['is_mobile_verified']     = !empty( $oModelUser->is_code_verified ) && ( $oModelUser->is_code_verified > 0 ) ? $oModelUser->is_code_verified : 0;*/


                    $amReponseParam['image']                  = !empty( $UserAllDetails->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$UserAllDetails->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $UserAllDetails->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                    $amReponseParam['event_id'] = $SingleCommentDetails['event_id'];
                    $amReponseParam['comment'] = $SingleCommentDetails['comment'];
                    $amReponseParam['created_at'] = $SingleCommentDetails['created_at'];

                    $AllReSponse[] =$amReponseParam;


                }
                $amResponse = Common::successResponse( $ssMessage, $AllReSponse );
            }  else {
                $ssMessage = "No Comments found";
                $amResponse = Common::successResponse( $ssMessage );
            }



        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function : JoinEvent()
     * Description : User Can comment in event
     * Request Params :'user_id','event_id','comment'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionJoinEvent() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        $snEventDetails = UserEvents::findOne( $requestParam['event_id'] );
        $snActivityName = !empty( $snEventDetails->activity ) ? $snEventDetails->activity->activity_name : "";
        if ( !empty( $oModelUser ) ) {
            $EventParticipants = EventParticipants::find()->where( ['user_id'=>$snUserId, 'event_id'=>$requestParam['event_id']] )->one();
            if ( !empty( $EventParticipants ) && ( $EventParticipants->participant_status == Yii::$app->params['participant_status']['pending'] ) ) {
                $EventParticipants->participant_status = Yii::$app->params['participant_status']['active'];
                $EventParticipants->updated_at = date( "Y-m-d H:i:s" );
                $EventParticipants->save( false );
                //SEND NOTIFICATION TO USER//
                $snEventCreaterId = !empty( $snEventDetails ) ? $snEventDetails->user_id : "";
                $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$snEventCreaterId] )->one();
                $snDeviceToken = $snDeviceDetails['device_tocken'];
                $notificationArray = [
                "device_token"   => $snDeviceToken,
                "message"               => $oModelUser->first_name." ".$oModelUser->last_name." has joined your ".$snActivityName." session.",
                "notification_type"     => 'Join Event',
                "user_id"   => $snEventCreaterId,
                "event_id"  => $requestParam['event_id'],
                ];
                if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                    Common::SendNotification( $notificationArray );
                }
                $amReponseParam['event_id'] = $snEventDetails->id;
                //$amReponseParam['name'] = $oModelUserEvents->name;
                $amReponseParam['activity_id'] = $snEventDetails->activity_id;
                $amReponseParam['activity_name'] = $snActivityName;
                $amReponseParam['event_longitude'] = $snEventDetails->event_startpoint_longitude;
                $amReponseParam['event_latitude'] = $snEventDetails->event_startpoint_latitude;
                //$amReponseParam['event_endpoint_longitude'] = $snEventDetails->event_endpoint_longitude;
                // $amReponseParam['event_endpoint_latitude'] = $snEventDetails->event_endpoint_latitude;
                $amReponseParam['event_start_date'] = $snEventDetails->event_start_date;
                $amReponseParam['event_end_date'] = $snEventDetails->event_end_date;
                $amReponseParam['event_duration'] = $snEventDetails->event_duration;
                $amReponseParam['event_location'] = !empty( $snEventDetails->event_location ) ? $snEventDetails->event_location : "";
                $amReponseParam['event_description'] = $snEventDetails->event_description;
                $amReponseParam['event_intensity'] = $snEventDetails->event_intensity;
                $amReponseParam['is_recurring'] = $snEventDetails->is_recurring;
                $amReponseParam['created_at'] = $snEventDetails->created_at;
                $amReponseParam['event_status'] = Yii::$app->params['event_status_value'][$snEventDetails->event_status];
                $amReponseParam['recurring_parent_id'] = !empty( $snEventDetails->recurring_parent_id ) ? $snEventDetails->recurring_parent_id : "";

                $ssMessage = "successfully joined in event";
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
            else if ( !empty( $EventParticipants ) && ( $EventParticipants->participant_status == Yii::$app->params['participant_status']['active'] ) ) {
                    $ssMessage = "You have already joined this event.";
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }
            else if ( empty( $EventParticipants ) ) {
                    $newParticipant = new EventParticipants;
                    $newParticipant->user_id = $requestParam['user_id'];
                    $newParticipant->event_id = $requestParam['event_id'];
                    $newParticipant->created_at = date( "Y-m-d H:i:s" );
                    $newParticipant->participant_status = Yii::$app->params['participant_status']['active'];
                    $newParticipant->save( false );
                    //SEND NOTIFICATION TO USER//
                    $event_details = UserEvents::findOne( $requestParam['event_id'] );
                    $snEvent_creater = !empty( $event_details ) ? $event_details->user_id : "";
                    $snDevice_details = Devicedetails::find()->where( ["userid"=>$snEvent_creater] )->one();
                    $snDeviceToken = $snDevice_details['device_tocken'];

                    //SEND NOTIFICATION TO USER//
                    $notificationArray = [
                    "device_token"   => $snDeviceToken,
                    "message"               => $oModelUser->first_name." ".$oModelUser->last_name." has joined your ".$snActivityName." session.",
                    "notification_type"     => 'Join Event',
                    "user_id"   => $snEvent_creater,
                    "event_id"  => $requestParam['event_id'],
                    ];
                    if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                        Common::SendNotification( $notificationArray );
                    }
                    $amReponseParam['event_id'] = $snEventDetails->id;
                    //$amReponseParam['name'] = $oModelUserEvents->name;
                    $amReponseParam['activity_id'] = $snEventDetails->activity_id;
                    $anActivity = Activities::findOne( $snEventDetails->activity_id );
                    $amReponseParam['activity_name'] = !empty( $anActivity ) ? $anActivity->activity_name : "";
                    $amReponseParam['event_longitude'] = $snEventDetails->event_startpoint_longitude;
                    $amReponseParam['event_latitude'] = $snEventDetails->event_startpoint_latitude;
                    //$amReponseParam['event_endpoint_longitude'] = $snEventDetails->event_endpoint_longitude;
                    // $amReponseParam['event_endpoint_latitude'] = $snEventDetails->event_endpoint_latitude;
                    $amReponseParam['event_start_date'] = $snEventDetails->event_start_date;
                    $amReponseParam['event_end_date'] = $snEventDetails->event_end_date;
                    $amReponseParam['event_duration'] = $snEventDetails->event_duration;
                    $amReponseParam['event_location'] = !empty( $snEventDetails->event_location ) ? $snEventDetails->event_location : "";
                    $amReponseParam['event_description'] = $snEventDetails->event_description;
                    $amReponseParam['event_intensity'] = $snEventDetails->event_intensity;
                    $amReponseParam['is_recurring'] = $snEventDetails->is_recurring;
                    $amReponseParam['created_at'] = $snEventDetails->created_at;
                    $amReponseParam['event_status'] = Yii::$app->params['event_status_value'][$snEventDetails->event_status];
                    $amReponseParam['recurring_parent_id'] = !empty( $snEventDetails->recurring_parent_id ) ? $snEventDetails->recurring_parent_id : "";
                    $ssMessage = "successfully joined in event";
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }


        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }
    /*
     * Function : CancelEvent()
     * Description : User Can cancel in event
     * Request Params :'user_id','event_id','comment'
     * Response Params : 'user_id', 'contact_number', 'contact_email', 'contact_name', 'contact_from'
     * Author :Rutusha Joshi
     */

    public function actionCancelEvent() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id', 'delete_future_event' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            // Delete Recurring event with delete_future_event
            if ( $requestParam['delete_future_event'] == 1 ) {
                $oModelUserEvents                             = UserEvents::find()->where( ['user_id'=>$requestParam['user_id'], 'id'=>$requestParam['event_id'], 'recurring_parent_id'=>$requestParam['recurring_parent_id']] )->One();
                if ( !empty( $oModelUserEvents ) ) {
                    $snActivityName = !empty( $oModelUserEvents->activity ) ? $oModelUserEvents->activity->activity_name : "";

                    //SEND NOTIFICATION TO USER//
                    $oModelRecurringEvents = UserEvents::find()->where( ['recurring_parent_id'=>$requestParam['recurring_parent_id']] )->asArray()->all();
                    if ( !empty( $oModelRecurringEvents ) ) {
                        foreach ( $oModelRecurringEvents as $key => $value ) {
                            $snEventsIds[] = $value['id'];
                        }
                        $events = !empty( $snEventsIds ) ? implode( ',', $snEventsIds ) : "";
                        $event_participants = EventParticipants::find()->where( "event_id IN (".$events.") AND participant_status = ".Yii::$app->params['participant_status']['active'] )->asArray()->all();
                        if ( !empty( $event_participants ) ) {
                            foreach ( $event_participants as $key => $participant ) {
                                $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$participant['user_id']] )->one();
                                $snDeviceToken = $snDeviceDetails['device_tocken'];
                                $notificationArray = [
                                "device_token"   => $snDeviceToken,
                                "message"               => $snActivityName." session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $oModelUserEvents->event_start_date ) )." has been cancelled.",
                                "notification_type"     => 'Cancel Event',
                                "user_id"   => $participant['user_id'],
                                "event_id"  => $requestParam['event_id'],
                                ];
                                if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                                    Common::SendNotification( $notificationArray );
                                }
                            }
                        }
                    }
                    $snEventsDeleted = UserEvents::find()->where( 'event_start_date >= :event_start_date AND user_id = :user_id AND recurring_parent_id=:recurring_parent_id ', [':event_start_date' =>$oModelUserEvents->event_start_date, ':user_id' => $requestParam['user_id'], ':recurring_parent_id'=>$requestParam['recurring_parent_id']] )->asArray()->all();
                    $amReponseParam['deleted_events'] = !empty( $snEventsDeleted ) ? implode( ",", array_column( $snEventsDeleted, 'id' ) ) : "";
                    UserEvents::deleteAll( 'event_start_date >= :event_start_date AND user_id = :user_id AND recurring_parent_id=:recurring_parent_id ', [':event_start_date' =>$oModelUserEvents->event_start_date, ':user_id' => $requestParam['user_id'], ':recurring_parent_id'=>$requestParam['recurring_parent_id']] );
                    $ssMessage  = 'Event deleted successfully.';
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }  else {
                    // once deleted events than if try for delete event
                    $ssMessage  = 'Event already deleted';
                    $amResponse = Common::errorResponse( $ssMessage );
                }
                // if single event want to delete
            }else {
                $oModelUserEvents                             = UserEvents::find()->where( ['user_id'=>$requestParam['user_id'], 'id'=>$requestParam['event_id']] )->one();
                if ( !empty( $oModelUserEvents ) ) {
                    $snEventId = $oModelUserEvents->id;
                    $snActivityName = !empty( $oModelUserEvents->activity ) ? $oModelUserEvents->activity->activity_name : "";
                    //SEND NOTIFICATION TO USER//
                    $snEventParticiapnts = EventParticipants::find()->where( ['event_id'=>$requestParam['event_id'], 'participant_status'=>Yii::$app->params['participant_status']['active']] )->asArray()->all();
                    if ( !empty( $snEventParticiapnts ) ) {
                        foreach ( $snEventParticiapnts as $key => $participant ) {
                            $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$participant['user_id']] )->one();
                            $snDeviceToken = $snDeviceDetails['device_tocken'];
                            $notificationArray = [
                            "device_token"   => $snDeviceToken,
                            "message"               => $snActivityName." session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $oModelUserEvents->event_start_date ) )." has been cancelled.",
                            //"message"               => $snActivityName." session is cancelled by ".$oModelUser->first_name." ".$oModelUser->last_name,/*." on ".date("d M",strtotime($oModelUserEvents->event_start_date))." has been cancelled."*/
                            // "message"               => "Session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date("d M",strtotime($oModelUserEvents->event_start_date))." has been cancelled.",
                            "notification_type"     => 'Cancel Event',
                            "user_id"   => $participant['user_id'],
                            "event_id"  => $requestParam['event_id'],
                            ];
                            if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                                Common::SendNotification( $notificationArray );
                            }
                        }
                    }
                    $oModelUserEvents->delete();
                    $amReponseParam['deleted_events'] = $snEventId;
                    $ssMessage  = 'Event deleted successfully.';
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }else {
                    $ssMessage  = 'Event already deleted';
                    $amResponse = Common::errorResponse( $ssMessage, $amReponseParam );
                }
            }
        }
        else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function :
     * Description : Get Event Count
     * Request Params :'user_id'
     * Response Params :
     * Author :An
     */
    public function actionGetEventCount_09_01_2016() {


        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        // Find Event which is remaining convert to in process
        $oModelUserEvents   = UserEvents::find()->where( "user_id = ".$requestParam['user_id']." AND event_status = '".Yii::$app->params['event_status']['in_process']."' AND event_start_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" )->count();
        $oModelJoinEvents    = EventParticipants::find()->where( ['user_id'=>$requestParam['user_id'], 'participant_status'=>'1'] )->asArray()->all();
        if ( !empty( $oModelJoinEvents ) ) {

            foreach ( $oModelJoinEvents as $key => $join_event ) {
                $snJoinEvent[] = $join_event['event_id'];
            }
            $events = implode( ',', $snJoinEvent );
            $join_event_count   = UserEvents::find()->where( "id IN (".$events.") AND event_start_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" )->count();
        }else {
            $join_event_count = '0';
        }
        $oModelPendingEvents = EventParticipants::find()->where( ['user_id'=>$requestParam['user_id'], 'participant_status'=>Yii::$app->params['participant_status']['pending']] )->asArray() ->All();
        if ( !empty( $oModelPendingEvents ) ) {
            foreach ( $oModelPendingEvents as $key => $pending_event ) {
                $snPendingEvent[] = $pending_event['event_id'];
            }
            $snEvents = implode( ',', $snPendingEvent );
            $pending_event_count   = UserEvents::find()->where( "id IN (".$snEvents.") AND event_start_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" )->count();
        }else {
            $pending_event_count = '0';
        }

        $ssMessage  = 'Success.';
        $amReponseParam['my_event_count'] = !empty( $oModelUserEvents ) ? $oModelUserEvents : "0";
        $amReponseParam['join_event_count'] = $join_event_count;
        $amReponseParam['pending_event_count'] = $pending_event_count;

        $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function :
     * Description : Get Event Count
     * Request Params :'user_id'
     * Response Params :
     * Author :An
     */


    public function actionGetAllMySession() {


        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        // Find Event which is remaining convert to in process
        // $oModelUserEvents   =  UserEvents::find()->where( ['user_id'=>$requestParam['user_id'], 'event_status'=>Yii::$app->params['event_status']['in_process']] )->asArray()->All();
        ////////////////////////////////////////////////////////////////////////////////////////////////
        $query = new Query;
        $query->select( 'u.first_name,u.last_name,u.user_image,a.activity_name,ue.*,ue.id AS event_id'  )
        ->from( 'user_events as ue' )
        ->join( 'LEFT JOIN', 'users as u', 'u.id =ue.user_id' )
        ->join( 'LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`' )
        ->where( "`ue`.`event_status` = '".Yii::$app->params['event_status']['in_process']."' AND `ue`.`user_id` =".$requestParam['user_id']." AND `ue`.`event_start_date` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" );
        $command = $query->createCommand();
        $oModelUserEvents = $command->queryAll();
        if ( !empty( $oModelUserEvents ) ) {
            array_walk( $oModelUserEvents, function( $arr ) use( &$amResponseData ) {
                    $ttt                       = $arr;
                    $ttt['image']     =  !empty( $ttt['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$ttt['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $ttt['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                    $ttt['recurring_parent_id'] = !empty( $ttt['recurring_parent_id'] ) ? $ttt['recurring_parent_id'] : "";
                    $ttt['is_recurring'] = Yii::$app->params['is_recurring_value'][$ttt['is_recurring']];
                    $ttt['event_status'] = Yii::$app->params['event_status_value'][$ttt['event_status']];
                    unset( $ttt['id'] );
                    unset( $ttt['created_at'] );
                    unset( $ttt['updated_at'] );
                    unset( $ttt['user_image'] );
                    unset( $ttt['event_endpoint_longitude'] );
                    unset( $ttt['event_endpoint_latitude'] );
                    $amResponseData[]          = $ttt;
                    return $amResponseData;
                } );
            $amReponseParam['my_event'] = $amResponseData;

        }else {
            $amReponseParam['my_event'] = [];
        }
        ///////////////////////////////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////////////////////////////
        $oModelJoinEvents    = EventParticipants::find()->where( ['user_id'=>$requestParam['user_id'], 'participant_status'=>Yii::$app->params['participant_status']['active']] )->asArray()->All();
        if ( !empty( $oModelJoinEvents ) ) {
            foreach ( $oModelJoinEvents as $key => $join_event ) {
                $snJoinEvent[] = $join_event['event_id'];
            }
            $events = implode( ',', $snJoinEvent );
            $query = new Query;
            $query->select( 'u.first_name,u.last_name,u.user_image,a.activity_name,ue.*,ue.id AS event_id'  )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'users as u', 'u.id =ue.user_id' )
            ->join( 'LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`' )
            ->where( "`ue`.`id` IN  (".$events.") AND `ue`.`event_start_date` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" );
            $command = $query->createCommand();
            $oModelJoinEventsDetails = $command->queryAll();
            if ( !empty( $oModelJoinEventsDetails ) ) {
                array_walk( $oModelJoinEventsDetails, function( $arr ) use( &$snJoinEventResponse ) {
                        $ttt                       = $arr;
                        $ttt['image']     =  !empty( $ttt['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$ttt['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $ttt['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                        $ttt['recurring_parent_id'] = !empty( $ttt['recurring_parent_id'] ) ? $ttt['recurring_parent_id'] : "";
                        $ttt['is_recurring'] = Yii::$app->params['is_recurring_value'][$ttt['is_recurring']];
                        $ttt['event_status'] = Yii::$app->params['event_status_value'][$ttt['event_status']];
                        unset( $ttt['id'] );
                        unset( $ttt['created_at'] );
                        unset( $ttt['updated_at'] );
                        unset( $ttt['user_image'] );
                        unset( $ttt['event_endpoint_longitude'] );
                        unset( $ttt['event_endpoint_latitude'] );

                        $snJoinEventResponse[]          = $ttt;
                        return $snJoinEventResponse;
                    } );
                $amReponseParam['join_event'] = $snJoinEventResponse;

            }else {
                $amReponseParam['join_event'] = [];
            }
            // }
        }
        //////////////////////////////////////////////////////////////////////////////////////////////
        $oModelPendingEvents = EventParticipants::find()->where( ['user_id'=>$requestParam['user_id'], 'participant_status'=>Yii::$app->params['participant_status']['pending']] )->asArray() ->All();
        if ( !empty( $oModelPendingEvents ) ) {
            foreach ( $oModelPendingEvents as $key => $pending_event ) {
                $snPendingEvent[] = $pending_event['event_id'];
            }
            $pending_events = implode( ',', $snPendingEvent );
            $query = new Query;
            $query->select( 'u.first_name,u.last_name,u.user_image,a.activity_name,ue.*,ue.id AS event_id'  )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'users as u', 'u.id =ue.user_id' )
            ->join( 'LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`' )
            ->where( "`ue`.`id` IN  (".$pending_events.") AND `ue`.`event_start_date` BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)" );
            $command = $query->createCommand();
            $oModelPendingEventsDetails = $command->queryAll();
            if ( !empty( $oModelPendingEventsDetails ) ) {
                array_walk( $oModelPendingEventsDetails, function( $arr ) use( &$snPendingEventResponse ) {
                        $ttt                       = $arr;
                        $ttt['image']     =  !empty( $ttt['user_image'] ) && file_exists( Yii::$app->params['upload_user_image'].$ttt['user_image'] ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $ttt['user_image'] : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                        $ttt['recurring_parent_id'] = !empty( $ttt['recurring_parent_id'] ) ? $ttt['recurring_parent_id'] : "";
                        $ttt['is_recurring'] = Yii::$app->params['is_recurring_value'][$ttt['is_recurring']];
                        $ttt['event_status'] = Yii::$app->params['event_status_value'][$ttt['event_status']];
                        unset( $ttt['id'] );
                        unset( $ttt['created_at'] );
                        unset( $ttt['updated_at'] );
                        unset( $ttt['user_image'] );
                        unset( $ttt['event_endpoint_longitude'] );
                        unset( $ttt['event_endpoint_latitude'] );

                        $snPendingEventResponse[]          = $ttt;
                        return $snPendingEventResponse;
                    } );
                $amReponseParam['pending_event'] = $snPendingEventResponse;

            }else {
                $amReponseParam['pending_event'] = [];
            }
        }
        $ssMessage  = 'Success.';
        $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function :
     * Description :
     * Request Params :
     * Response Params :
     * Author :An
     */


    public function actionDeleteComment() {


        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'comment_id', 'event_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );


        $oModelComments = ParticipantComments::find()->where( ['id'=>$requestParam['comment_id'], 'event_id'=>$requestParam['event_id']] )->one();
        if ( !empty( $oModelComments ) ) {
            if ( $requestParam['user_id'] == $oModelComments->user_id ) {
                $oModelComments->delete();
                $ssMessage  = 'Comment has been deleted successfully.';
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage  = 'Sorry you can not perform this action.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Comment already deleted';
            $amResponse = Common::errorResponse( $ssMessage );
        }

        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function :UpdateEventRadiousRange()
     * Description : Update Event Radious Range
     * Request Params : user_id, event_radious_range
     * Response Params : success message
     * Author : Rutusha Joshi
     */


    public function actionUpdateEventRadiousRange() {


        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_radious_range' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $oModelUser->event_radious_range = $requestParam['event_radious_range'];
            $oModelUser->save( false );
            $ssMessage  = 'Event radious range updated successfully.';
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }
    /*
     * Function :EditUserEvent()
     * Description : Update Event
     * Request Params : 'user_id', 'event_id', 'activity_id', 'event_longitude', 'event_latitude', 'event_start_date', 'event_duration', 'event_description', 'event_intensity'
     * Response Params : success message,Event details
     * Author : Rutusha Joshi
     */
    public function actionEditUserEvent() {
        //Get all request parameter
        $amData = Common::checkRequestType();

        $amResponse  = $amReponseParam =  array();

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'event_id', 'activity_id', 'event_longitude', 'event_latitude', 'event_start_date', 'event_duration', 'event_description', 'event_intensity' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status ////
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            $oModelEvent = UserEvents::find()->where( ['id'=>$requestParam['event_id']] )->one();
            if ( !empty( $oModelEvent ) ) {
                if ( $oModelUser->id == $oModelEvent->user_id ) {
                    $oModelEvent->user_id                    = $requestParam['user_id'];
                    $oModelEvent->name                       = !empty( $requestParam['name'] ) ? $requestParam['name'] : "";
                    $oModelEvent->activity_id                = $requestParam['activity_id'];
                    $oModelEvent->event_startpoint_longitude = $requestParam['event_longitude'];
                    $oModelEvent->event_startpoint_latitude  = $requestParam['event_latitude'];
                    $oModelEvent->event_endpoint_longitude   = !empty( $requestParam['event_endpoint_longitude'] ) ? $requestParam['event_endpoint_longitude'] : "";
                    $oModelEvent->event_endpoint_latitude    = !empty( $requestParam['event_endpoint_latitude'] ) ? $requestParam['event_endpoint_latitude'] : "";
                    $oModelEvent->event_start_date           = date( "Y-m-d H:i:s", strtotime( $requestParam['event_start_date'] ) );
                    $oModelEvent->event_duration             = $requestParam['event_duration'];
                    $oModelEvent->event_location             = !empty( $requestParam['event_location'] ) ? $requestParam['event_location'] : "";
                    $oModelEvent->event_end_date             = date( "Y-m-d H:i:s", strtotime( $oModelEvent->event_start_date .$oModelEvent->event_duration." minutes" ) );
                    $oModelEvent->event_description          = $requestParam['event_description'];
                    $oModelEvent->event_intensity            = $requestParam['event_intensity'];
                    $oModelEvent->event_status               = Yii::$app->params['event_status']['in_process'];
                    $oModelEvent->updated_at                 = date( "Y-m-d H:i:s" );
                    $oModelEvent->save( false );
                    //SEND NOTIFICATION TO PARTICIPANTS//
                    $snEventParticiapnts = EventParticipants::find()->where( ['event_id'=>$oModelEvent->id, 'participant_status'=>Yii::$app->params['participant_status']['active']] )->asArray()->all();
                    if ( !empty( $snEventParticiapnts ) ) {
                        foreach ( $snEventParticiapnts as $key => $participant ) {
                            $snDeviceDetails = Devicedetails::find()->where( ["userid"=>$participant['user_id']] )->one();
                            $snDeviceToken = $snDeviceDetails['device_tocken'];
                            $notificationArray = [
                            "device_token"   => $snDeviceToken,
                            "message"               => "Session by ".$oModelUser->first_name." ".$oModelUser->last_name." on ".date( "d M", strtotime( $oModelEvent->event_start_date ) )." has been changed.",
                            "notification_type"     => 'Update Event',
                            "user_id"   => $participant['user_id'],
                            "event_id"  => $requestParam['event_id'],
                            ];
                            if ( $snDeviceToken != '' && strlen( $snDeviceToken ) == '64' ) {

                                Common::SendNotification( $notificationArray );
                            }
                        }
                    }
                    $ssMessage = "Event updated successfully.";
                    $amReponseParam['event_id'] = $oModelEvent->id;
                    $amReponseParam['activity_id'] = $oModelEvent->activity_id;
                    $amReponseParam['activity_name'] = !empty( $oModelEvent->activity ) ? $oModelEvent->activity->activity_name : "";
                    $amReponseParam['event_longitude'] = $oModelEvent->event_startpoint_longitude;
                    $amReponseParam['event_latitude'] = $oModelEvent->event_startpoint_latitude;
                    $amReponseParam['event_start_date'] = $oModelEvent->event_start_date;
                    $amReponseParam['event_end_date'] = $oModelEvent->event_end_date;
                    $amReponseParam['event_duration'] = $oModelEvent->event_duration;
                    $amReponseParam['event_location'] = !empty( $oModelEvent->event_location ) ? $oModelEvent->event_location : "";
                    $amReponseParam['event_description'] = $oModelEvent->event_description;
                    $amReponseParam['event_intensity'] = $oModelEvent->event_intensity;
                    $amReponseParam['is_recurring'] = $oModelEvent->is_recurring;
                    $amReponseParam['created_at'] = $oModelEvent->created_at;
                    $amReponseParam['updated_at'] = $oModelEvent->updated_at;
                    $amReponseParam['event_status'] = Yii::$app->params['event_status_value'][$oModelEvent->event_status];
                    $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
                }else {
                    $ssMessage  = 'You are not authorize to edit this event';
                    $amResponse = Common::errorResponse( $ssMessage );
                }
            }else {
                $ssMessage  = 'No event Exist.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function :CompletedEventsHistory()
     * Description : Completed Events History
     * Request Params : user_id
     * Response Params : success message,list of completed events
     * Author : Rutusha Joshi
     */


    public function actionCompletedEventsHistory() {


        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            $query1 =  new Query;
            $query1->select( "id AS event_id" )
            ->from( 'user_events' )
            ->where( "user_id = '".$requestParam['user_id']."' AND event_start_date < CURDATE()" );

            $query2 = new Query;
            $query2->select( 'ue.id AS event_id' )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'event_participants as ep', 'ep.event_id = ue.id' )
            ->where( "`ep`.`user_id` = '".$requestParam['user_id']."' AND `ep`.`participant_status` = '".Yii::$app->params['participant_status']['active']."' AND `ue`.`event_start_date` < CURDATE()" );

            $unionQuery = $query1->union( $query2 );
            $command = $unionQuery->createCommand();
            $oModelUserEvents = $command->queryAll();
            if ( !empty( $oModelUserEvents ) ) {
                $arrEvents = array_column( $oModelUserEvents, 'event_id' );
                $events = implode( ',', $arrEvents );
                $query = new Query;
                $query->select( 'u.first_name,u.last_name,u.user_image,a.activity_name,ue.*,ue.id AS event_id'  )
                ->from( 'user_events as ue' )
                ->join( 'LEFT JOIN', 'users as u', 'u.id =ue.user_id' )
                ->join( 'LEFT JOIN', 'activities as a', 'a.`id` = `ue`.`activity_id`' )
                ->where( "`ue`.`id` IN  (".$events.")" )
                ->orderBy( 'ue.event_start_date DESC' );
                $command = $query->createCommand();
                $arrCompletedEventsList = $command->queryAll();
                array_walk( $arrCompletedEventsList, function( $arr ) use( &$amResponseData ) {
                        $ttt                       = $arr;
                        $snCreator       = Users::find()->where( ['id'=>$ttt['user_id']] )->one();
                        $ttt['first_name']     = !empty( $snCreator ) ? $snCreator->first_name : "";
                        $ttt['last_name']     = !empty( $snCreator ) ? $snCreator->last_name : "";
                        $ttt['image']     =  !empty( $snCreator->user_image ) && file_exists( Yii::$app->params['upload_user_image'].$snCreator->user_image ) ? Yii::getAlias( '@host' ) . '/' . "uploads/profile_pictures/" . $snCreator->user_image : Yii::getAlias( '@host' ) . '/' . "uploads/no_image.png";
                        $ttt['recurring_parent_id'] = !empty( $ttt['recurring_parent_id'] ) ? $ttt['recurring_parent_id']  : "";
                        $ttt['event_location'] = !empty( $ttt['event_location'] ) ? $ttt['event_location']  : "";
                        $ttt['event_longitude'] = $ttt['event_startpoint_longitude'];
                        $ttt['event_latitude'] = $ttt['event_startpoint_latitude'];
                        $ttt['event_status'] = Yii::$app->params['event_status_value'][$ttt['event_status']];
                        unset( $ttt['id'] );
                        unset( $ttt['created_at'] );
                        unset( $ttt['updated_at'] );
                        unset( $ttt['user_image'] );
                        unset( $ttt['name'] );
                        unset( $ttt['event_startpoint_longitude'] );
                        unset( $ttt['event_startpoint_latitude'] );
                        unset( $ttt['event_endpoint_longitude'] );
                        unset( $ttt['event_endpoint_latitude'] );
                        $amResponseData[]          = $ttt;
                        return $amResponseData;
                    } );
                $amReponseParam  = $amResponseData;
                $ssMessage  = 'Completed Events List';
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage  = 'No events found.';
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }


    /*
     * Function :RecentPlacesList()
     * Description : Recent Places List
     * Request Params : user_id
     * Response Params : success message,list of Recent Places Visited
     * Author : Rutusha Joshi
     */
    public function actionRecentPlacesList() {

        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }

        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );

        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );

        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            $query1 =  new Query;
            $query1->select( "id AS event_id" )
            ->from( 'user_events' )
            ->where( "user_id = '".$requestParam['user_id']."' AND event_start_date < CURDATE()" );

            $query2 = new Query;
            $query2->select( 'ue.id AS event_id' )
            ->from( 'user_events as ue' )
            ->join( 'LEFT JOIN', 'event_participants as ep', 'ep.event_id = ue.id' )
            ->where( "`ep`.`user_id` = '".$requestParam['user_id']."' AND `ep`.`participant_status` = '".Yii::$app->params['participant_status']['active']."' AND `ue`.`event_start_date` < CURDATE()" );

            $unionQuery = $query1->union( $query2 );
            $command = $unionQuery->createCommand();
            $oModelUserEvents = $command->queryAll();
            if ( !empty( $oModelUserEvents ) ) {
                $arrEvents = array_column( $oModelUserEvents, 'event_id' );
                $events = implode( ',', $arrEvents );
                $query = new Query;
                $query->select( "id AS event_id,FORMAT(`event_startpoint_latitude`,4) AS `event_latitude`,FORMAT(`event_startpoint_longitude`,4) AS `event_longitude`,event_location" )
                ->from( "user_events" )
                ->where( "`id` IN  (".$events.")" )
                ->orderBy( "event_start_date DESC" )
                ->groupBy( "event_latitude,event_longitude" )
                ->limit( 20 );
                $command = $query->createCommand();
                $arrEventsList = $command->queryAll();

                $amReponseParam  = $arrEventsList;
                $ssMessage  = 'Recent Places List';
                $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
            }else {
                $ssMessage  = 'No Recent Places found.';
                $amResponse = Common::errorResponse( $ssMessage );
            }
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

    /*
     * Function :
     * Description : Get Event Count
     * Request Params :'user_id'
     * Response Params :
     * Author :An
     */
    public function actionGetEventCount() {

        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id', 'user_initial_latitude', 'user_initial_longitude' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $snUserId = $requestParam['user_id'];
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {
            // $this->radiouscalculation($requestParam['user_latitude'] ,$requestParam['user_longitude'] );

            $radius = !empty( $oModelUser->event_radious_range ) && ( $oModelUser->event_radious_range > 0 ) ? $oModelUser->event_radious_range : 20;
            //$radius = $oModelUser->event_radious_range;
            $user_latitude = $requestParam['user_initial_latitude'];
            $user_longitude = $requestParam['user_initial_longitude'];

            $arrEventsCounts = UserEvents::find()->where( "`event_status` != '".Yii::$app->params['event_status']['completed']."' AND `event_start_date` >= CURDATE() AND `event_start_date` <= CURDATE() +  INTERVAL 7 DAY AND (6371 * acos( cos(radians({$user_latitude}) ) * cos(radians( `event_startpoint_latitude`))*cos( radians( `event_startpoint_longitude` ) - radians({$user_longitude}) ) + sin( radians({$user_latitude}) ) * sin( radians( `event_startpoint_latitude`)))) < {$radius}  " )->count();
            $ssMessage  = 'Success.';
            $amReponseParam['my_event_count'] = !empty( $arrEventsCounts ) ? $arrEventsCounts : "0";
            $amResponse = Common::successResponse( $ssMessage, $amReponseParam );
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );

    }
    /*
     * Function :
     * Description : Reset Badge Count
     * Request Params :'user_id','auth_token'
     * Response Params :
     * Author :An
     */
    public function actionResetBadgeCount() {

        $amData = Common::checkRequestType();

        $amResponse =  $amReponseParam = [];

        // Check required validation for request parameter.
        $amRequiredParams = array( 'user_id' );

        $amParamsResult   = Common::checkRequiredParams( $amData['request_param'], $amRequiredParams );

        // If any getting error in request paramter then set error message.
        if ( !empty( $amParamsResult['error'] ) ) {
            $amResponse = Common::errorResponse( $amParamsResult['error'] );
            Common::encodeResponseJSON( $amResponse );
        }
        $requestParam = $amData['request_param'];
        //Check User Status//
        $this->matchUserStatus( $requestParam['user_id'] );
        //VERIFY AUTH TOKEN
        $authToken = Common::get_header( 'auth_token' );
        Common::checkAuthentication( $authToken );
        $oModelUser = Users::findOne( $requestParam['user_id'] );
        if ( !empty( $oModelUser ) ) {

            $oModelUser->badge_count = 0;
            $oModelUser->save( false );
            $ssMessage  = "Badge count updated successfully.";
            $amResponse = Common::successResponse( $ssMessage );
        }else {
            $ssMessage  = 'Invalid User.';
            $amResponse = Common::errorResponse( $ssMessage );
        }
        // FOR ENCODE RESPONSE INTO JSON //
        Common::encodeResponseJSON( $amResponse );
    }

}

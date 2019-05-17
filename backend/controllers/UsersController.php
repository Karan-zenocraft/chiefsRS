<?php

namespace backend\controllers;

use Yii;
use common\models\Users;
use common\models\UsersSearch;
use common\models\UserRoles;
use yii\base\Model;
use common\models\Restaurants;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\EmailFormat;
use common\components\Common;
use backend\components\AdminCoreController;
use yii\helpers\ArrayHelper;
use \yii\web\Request;


/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends AdminCoreController
{
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * Lists all Users models.
     *
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
        $UsersFirstName = ArrayHelper::map( Users::find()->asArray()->all(), 'first_name', 'first_name' );
        $UserRolesDropdown = ArrayHelper::map( UserRoles::find()->where( "id !=" .Yii::$app->params['super_admin_role_id']." AND id !=".Yii::$app->params['administrator_role_id'])->asArray()->all(), 'id', 'role_name' );

        return $this->render( 'index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'UsersFirstName' => $UsersFirstName,
            'UserRolesDropdown' => $UserRolesDropdown,
            ] );
    }

    /**
     * Displays a single Users model.
     *
     * @param string  $id
     * @return mixed
     */
    public function actionView( $id ) {
        $this->layout = 'popup';
        return $this->render( 'view', [
            'model' => $this->findModel( $id ),
            ] );
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */

    public function actionCreate() {
        $backEndBaseUrl = Yii::$app->urlManager->createAbsoluteUrl( ['/site/index'] );
      //  $frontEndBaseUrl = str_replace( '/backend/web/dashboard', '/frontend/web/site/login', $backEndBaseUrl );
        $backendLoginURL = Yii::$app->params['site_url'].Yii::$app->params['login_url'];
        $model = new Users();
        $Restaurants = Restaurants::RestaurantsDropDown();
        $model->setScenario( 'create' );
        $UserRolesDropdown = ArrayHelper::map( UserRoles::find()->where( "id !=" .Yii::$app->params['super_admin_role_id'] )->asArray()->all(), 'id', 'role_name' );
        if ( $model->load( Yii::$app->request->post() ) && $model->validate() ) {

            $model->password = md5( $_REQUEST['Users']['password'] );
            $model->save( false );
            ///////////////////////////////////////////////////////////
            //Get email template into database for forgot password
            $emailformatemodel = EmailFormat::findOne( ["title"=>'user_registration', "status"=>'1'] );
            if ( $emailformatemodel ) {

                //create template file
                $AreplaceString = array( '{password}' => Yii::$app->request->post( 'Users' )['password'], '{username}' => $model->first_name, '{email}' => $model->email, '{loginurl}'=>$backendLoginURL );

                $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );

                //send email for new generated password
                Common::sendMailToUser( $model->email, Yii::$app->params['adminEmail'] , $emailformatemodel->subject, $body );

                //////////////////////////////////////////////////////////
                Yii::$app->session->setFlash( 'success', Yii::getAlias( '@user_add_message' ) );
            }
            return $this->redirect( ['users/index'] );
        } else {
            return $this->render( 'create', [
                'model' => $model,
                'UserRolesDropdown' => $UserRolesDropdown,
                'Restaurants' => $Restaurants
                ] );
        }
    }

    public function actionUpdate( $id ) {
        $model = $this->findModel( $id );
        $model->setScenario( 'update' );
        $Restaurants = Restaurants::RestaurantsDropDown();

        $UserRolesDropdown = ArrayHelper::map( UserRoles::find()->where( "id !=" .Yii::$app->params['super_admin_role_id'] )->asArray()->all(), 'id', 'role_name' );

        if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@user_update_message' ) );
            return $this->redirect( ['users/index'] );
        } else {
            return $this->render( 'update', [
                'model' => $model,
                'UserRolesDropdown'=>$UserRolesDropdown,
                'Restaurants' => $Restaurants
                ] );
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param string  $id
     * @return mixed
     */
    public function actionDelete( $id ) {
        $snDeleteStatus = $this->findModel( $id )->delete();
        if ( !empty( $snDeleteStatus ) && $snDeleteStatus=='1' ) {
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@user_delete_message' ) );
        }

        return $this->redirect( ['users/index'] );
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string  $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel( $id ) {
        if ( ( $model = Users::findOne( $id ) ) !== null ) {
            return $model;
        } else {
            throw new NotFoundHttpException( 'The requested page does not exist.' );
        }
    }
}

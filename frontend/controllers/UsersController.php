<?php

namespace frontend\controllers;

use Yii;
use common\models\UserProjects;
use common\models\ProjectsSearch;
use frontend\components\FrontCoreController;
use common\models\MilestonesSearch;
use common\models\TasksSearch;
use common\models\TimesheetSearch;
use yii\helpers\ArrayHelper; // Load array helper
use common\models\Projects;
use common\models\Milestones;
use common\models\Tasks;
use common\models\Users;
use common\components\Common;
use common\models\EmailFormat;
use yii\web\BadRequestHttpException;


class UsersController extends FrontCoreController {

    public function beforeAction( $action ) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction( $action );
    }


    public function actionIndex() {
        return $this->render( 'index' );
    }

    public function actionMyProjects() {
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
    public function actionProjectDetail( $id ) {
        $this->layout = 'popup';
        return $this->render( 'project_detail', [
            'model' => Projects::findOne( $id ),
            ] );
    }
    public function actionMilestones( $id = '' ) {
        $snProjectId = ( $id > 0 ) ? $id : 0;
        $snUserRoleId = Common::get_user_role( Yii::$app->user->id );
        $searchModel = new MilestonesSearch();
        $queryParams = array_merge( array(), Yii::$app->request->getQueryParams() );
        if ( $snProjectId > 0 ) {
            $queryParams["MilestonesSearch"]["project_id"] = $snProjectId;
            $queryParams["MilestonesSearch"]["is_deleted"] = Yii::$app->params['allow_deleted_status'];
            $dataProvider = $searchModel->search( $queryParams, true );
            $dataProvider->query->andFilterWhere( ['!=', 'milestones.status', Yii::$app->params['new_status']] );
            $snProjectName = Common::get_name_by_id( $snProjectId, $flag = "projects" );

        }else {
            //$queryParams["MilestonesSearch"]["status"] = Yii::$app->params['milestone_status_array']['QA-Pending'];
            $queryParams["MilestonesSearch"]["qa_user_id"] = Yii::$app->user->id;
            $dataProvider = $searchModel->search( $queryParams, false );
            $dataProvider->query->andFilterWhere( ['!=', 'milestones.status', Yii::$app->params['new_status']] );
            $snProjectName = '';
        }
        /*if(empty($_GET["MilestonesSearch"]))
        {
            $dataProvider->query->andFilterWhere(['=','milestones.status',Yii::$app->params['in_process_status']]);

        }
        else{*/
        //$dataProvider->query->andFilterWhere(['!=','milestones.status',Yii::$app->params['archived_status']]);
        /* }*/

        return $this->render( 'milestones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snUserRoleId' => $snUserRoleId,
            'snProjectName' => $snProjectName,
            ] );
    }

    public function actionMilestoneDetail( $id ) {
        $this->layout = 'popup';
        $oModel = Milestones::findOne( $id );
        $snTasks = "";
        $snTasksDetails = ArrayHelper::map( $oModel->tasks, 'name', 'description' );
        foreach ( $snTasksDetails as $key => $value ) {
            $snTasks =$snTasks. '- '.'<b>'.$key.'</b>'.':<br>'.'->'.$value.'<br>';
        }
        return $this->render( 'milestone_detail', [
            'model' => $oModel,
            'Tasks' => $snTasks,
            ] );
    }

    public function actionTasks( $id ) {
        $snProjectId = ( $_GET['pid'] > 0 ) ? $_GET['pid'] : 0;
        $snMilestoneId = ( $id > 0 ) ? $id : 0;
        $snMilestoneName = Common::get_name_by_id( $snMilestoneId, $flag = "milestones" );
        $snProjectName = Common::get_name_by_id( $snProjectId, $flag = "projects" );
        $searchModel = new TasksSearch();
        $queryParams = array_merge( array(), Yii::$app->request->getQueryParams() );
        $queryParams["TasksSearch"]["milestone_id"] = $snMilestoneId;
        $queryParams["TasksSearch"]["is_deleted"] = Yii::$app->params['allow_deleted_status'];

        $dataProvider = $searchModel->search( $queryParams );
        /* if(empty($_REQUEST["TasksSearch"]))
        {
            //$queryParams["TasksSearch"]["status"] = Yii::$app->params['in_process_project_status'] ;
            $dataProvider->query->andFilterWhere(['=','tasks.status',Yii::$app->params['in_process_status']]);

        }
        else{*/
        //$dataProvider->query->andFilterWhere(['!=','tasks.status',Yii::$app->params['archived_status']]);
        $dataProvider->query->andFilterWhere( ['!=', 'tasks.status', Yii::$app->params['new_status']] );
        /* }*/

        return $this->render( 'tasks', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snMilestoneName' => $snMilestoneName,
            'snProjectName' => $snProjectName,
            ] );
    }
    public function actionTaskDetail( $id ) {
        $this->layout = 'popup';
        return $this->render( 'task_detail', [
            'model' => Tasks::findOne( $id ),
            ] );
    }

    public function actionTimesheet( $id ) {

        $snTaskId = ( $id > 0 ) ? $id : 0;
        $snTaskName = Common::get_name_by_id( $snTaskId, $flag = "tasks" );
        $snProjectName = Common::get_name_by_id( $_GET['pid'], $flag = "projects" );
        $snMilestoneName = Common::get_name_by_id( $_GET['mid'], $flag = "milestones" );
        $searchModel = new TimesheetSearch();
        $queryParams = array_merge( array(), Yii::$app->request->getQueryParams() );
        $queryParams["TimesheetSearch"]["task_id"] = $snTaskId;
        $dataProvider = $searchModel->search( $queryParams );

        // GET PROJECTS //
        /*$amProjects = ArrayHelper::map(UserProjects::find()->where(['user_id' => Yii::$app->user->id])->asArray()->all(), 'project_id', function($amValue) {
                            return $amValue->project->name;
                        });*/

        // GET MILESTONES //

        /* $amMilestones = ArrayHelper::map(Milestones::find()->where(['project_id'=>!empty($_GET['pid']) ? $_GET['pid'] : 0])->asArray()->all(), 'id', function($amValue) {
                            return $amValue['name'];
                        });


        // GET TASKS //
        $amTasks = ArrayHelper::map(Tasks::find()->where(['milestone_id'=>!empty($_GET['mid']) ? $_GET['mid'] : 0])->asArray()->all(), 'id', function($amValue) {
                            return $amValue['name'];
                        });*/
        return $this->render( 'timesheet', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'snTaskName' => $snTaskName,
            'snProjectName' => $snProjectName,
            'snMilestoneName' => $snMilestoneName,
            /*'amMilestones' => $amMilestones,
                    'amTasks' => $amTasks*/
            ] );
    }
    public function actionUpdateMilestoneStatus() {
        $snMilestoneId = ( $_REQUEST['mid'] > 0 ) ? $_REQUEST['mid'] : 0;
        // GET Milestone detail by mid
        $oModel = Milestones::find()->where( ['id'=> $snMilestoneId] )->one();
        if ( $oModel->status != Yii::$app->params['milestone_status_array']['QA-Pending'] && $oModel->status != Yii::$app->params['milestone_status_array']['QA-Approved'] ) {
            //CALL LAYOUT FOR POPUP WINDOW
            $this->layout = 'popup';

            if ( $oModel->load( Yii::$app->request->post() ) && !empty( Yii::$app->request->post() ) ) {
                // UPDATE STATUS
                $oModel->save( false );
                Yii::$app->session->setFlash( 'success', Yii::getAlias( '@milestone_update_status_message' ) );
                return Common::closeColorBox();
            }

        }else {
            throw new BadRequestHttpException( 'The requested page does not exist.' );
        }

        return $this->render( 'updateStatus', [
            'oModel'=>$oModel,
            ] );
    }

    public function actionUpdateTaskStatus() {
        //CALL LAYOUT FOR POPUP WINDOW
        $this->layout = 'popup';
        $snTaskId = ( $_REQUEST['tid'] > 0 ) ? $_REQUEST['tid'] : 0;
        // GET Milestone detail by mid
        $oModel = Tasks::find()->where( ['id'=> $snTaskId] )->one();

        if ( $oModel->load( Yii::$app->request->post() ) && !empty( Yii::$app->request->post() ) ) {
            // UPDATE STATUS
            $oModel->save( false );
            Yii::$app->session->setFlash( 'success', Yii::getAlias( '@task_update_status_message' ) );
            return Common::closeColorBox();
        }
        return $this->render( 'updateStatus', [
            'oModel'=>$oModel,
            ] );
    }
    //THIS FUNCTION SENDS MILESTONE FOR QA//
    public function actionSendMilestoneForQa() {
        $snMilestoneId = ( $_REQUEST['mid'] > 0 ) ? $_REQUEST['mid'] : 0;
        // GET Milestone detail by mid
        $oModel = Milestones::find()->where( ['id'=> $snMilestoneId] )->one();
        if ( $oModel->status == Yii::$app->params['milestone_status_array']['Completed'] ) {
            //CALL LAYOUT FOR POPUP WINDOW
            $this->layout = 'popup';
            $snProjectId = ( $_REQUEST['pid'] > 0 ) ? $_REQUEST['pid'] : 0;

            //$qaUsersArr = Users::QaUsersDropDownArr();
            $qaUsersArr = Common::get_users_by_role_id( Yii::$app->params['userroles']['qa'] );
            if ( $oModel->load( Yii::$app->request->post() ) && !empty( Yii::$app->request->post() ) ) {
                // UPDATE STATUS
                $oModel->status = Yii::$app->params['milestone_status_array']['QA-Pending'];
                $oModel->send_to_qa_by = Yii::$app->user->id;
                $oModel->qa_date = date( "Y-m-d" );
                $snNote = nl2br( $_REQUEST['Milestones']['notes'], true );
                $snMilestoneName = $oModel->name;
                $oModel->save( false );
                //GET USER AND QA USER DETAILS//
                $snQaUserDetail = $oModel->qaUser;
                $snUserDetail = $oModel->sendToQaBy;
                $snTLEmail = !empty( $oModel->project->handledBy ) ? $oModel->project->handledBy->email : '';
                $snSalesPersonEmail = !empty( $oModel->project->salesPerson ) ? $oModel->project->salesPerson->email : '';

                //GET PROJECT AND TASKS DETAILS//
                $snProjectDetail = $oModel->project;
                $snTasksDetails = ArrayHelper::map( $oModel->tasks, 'name', 'description' );
                $snTasks = '';
                foreach ( $snTasksDetails as $key => $value ) {
                    $snTasks =$snTasks. '- '.'<b>'.$key.'</b>'.':<br>'.'->'.$value.'<br>';
                }
                $snFrontEndDetails = $snProjectDetail->frontend_details;
                $snBackEndDetails = $snProjectDetail->backend_details;


                //Get email template into database for forgot password
                $emailformatemodel = EmailFormat::findOne( ["title"=>'send_milestone_for_qa', "status"=>'1'] );
                if ( $emailformatemodel ) {

                    //create template file
                    $AreplaceString = array(
                        '{user_name}' => $snUserDetail->first_name.' '.$snUserDetail->last_name,
                        '{snQaUserName}' => $snQaUserDetail->first_name.' '.$snQaUserDetail->last_name,
                        '{project_name}' => $snProjectDetail->name,
                        '{milestone_name}' => $snMilestoneName,
                        '{task_names}' => $snTasks,
                        '{backend_details}'=>$snBackEndDetails,
                        '{frontend_details}'=>$snFrontEndDetails,
                        '{release_date}'=>date( "Y-m-d", strtotime( $oModel->end_date ) ),
                        '{notes}'=>$snNote
                    );
                    $subject = "Need QA - ".$snProjectDetail->name." - ".$snMilestoneName;
                    $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );

                    //send email for new generated password
                    if ( empty( $snTLEmail ) && empty($snSalesPersonEmail) ) {
                        $snMailStatus = Common::sendMail($snQaUserDetail->email, $snUserDetail->email, $subject, $body, false, Yii::$app->params['ProjectManagerEmail'] );
                    }else {
                        $snMailStatus = Common::sendMailApproveReject($snQaUserDetail->email, $snUserDetail->email, $subject, $body, false, Yii::$app->params['ProjectManagerEmail'],$snTLEmail,$snSalesPersonEmail);
                    }
                    if ( $snMailStatus == true ) {
                        Yii::$app->session->setFlash( 'success', Yii::getAlias( '@success_send_for_qa' ) );
                        return Common::closeColorBox();

                    }else {
                        Yii::$app->session->setFlash( 'fail', Yii::getAlias( '@create_leave_error_message' ) );
                        return Common::closeColorBox();
                    }
                }

            }
        }else {
            throw new BadRequestHttpException( 'The requested page does not exist.' );
            //Yii::$app->session->setFlash( 'fail', '@error_qa_send' );
            //return Common::closeColorBox();
        }
        return $this->render( 'send_milestone_for_qa', [
            'oModel'=>$oModel,
            'qaUsersArr'=>$qaUsersArr,
            ] );
    }

    //THIS FUNCTION GIVES QA APPROVAL FOR MILESTONE//
    public function actionGiveQaApproval() {
        $snMilestoneId = ( $_REQUEST['mid'] > 0 ) ? $_REQUEST['mid'] : 0;
        // GET Milestone detail by mid
        $oModel = Milestones::find()->where( ['id'=> $snMilestoneId] )->one();
        if ( $oModel->qa_user_id == Yii::$app->user->id ) {
            //CALL LAYOUT FOR POPUP WINDOW
            $this->layout = 'popup';
            $snProjectId = ( $_REQUEST['pid'] > 0 ) ? $_REQUEST['pid'] : 0;
            if ( $oModel->load( Yii::$app->request->post() ) && !empty( Yii::$app->request->post() ) ) {
                // UPDATE STATUS
                $oModel->status = Yii::$app->params['milestone_status_array']['QA-Approved'];
                $oModel->qa_approved_date = date( "Y-m-d" );
                $snNote = nl2br( $_REQUEST['Milestones']['notes'], true );
                $snMilestoneName = $oModel->name;
                $oModel->save( false );
                //GET USER AND QA USER DETAILS//
                $snQaUserDetail = $oModel->qaUser;
                $snUserDetail = $oModel->sendToQaBy;
                $snTLEmail = !empty( $oModel->project->handledBy ) ? $oModel->project->handledBy->email : '';
                $snSalesPersonEmail = !empty( $oModel->project->salesPerson ) ? $oModel->project->salesPerson->email : '';
                //GET PROJECT AND TASKS DETAILS//
                $snProjectDetail = $oModel->project;
                $snTasksDetails = ArrayHelper::map( $oModel->tasks, 'name', 'description' );
                $snTasks = '';
                foreach ( $snTasksDetails as $key => $value ) {
                    $snTasks =$snTasks. '- '.'<b>'.$key.'</b>'.':<br>'.'->'.$value.'<br>';
                    //$snTasks =$snTasks. '- '.$value.'<br>';
                }
                $snFrontEndDetails = $snProjectDetail->frontend_details;
                $snBackEndDetails = $snProjectDetail->backend_details;


                //Get email template into database for forgot password
                $emailformatemodel = EmailFormat::findOne( ["title"=>'qa_approval_notification', "status"=>'1'] );
                if ( $emailformatemodel ) {

                    //create template file
                    $AreplaceString = array(
                        '{user_name}' => $snUserDetail->first_name.' '.$snUserDetail->last_name,
                        '{snQaUserName}' => $snQaUserDetail->first_name.' '.$snQaUserDetail->last_name,
                        '{project_name}' => $snProjectDetail->name,
                        '{milestone_name}' => $snMilestoneName,
                        '{task_names}' => $snTasks,
                        '{backend_details}'=>$snBackEndDetails,
                        '{frontend_details}'=>$snFrontEndDetails,
                        '{release_date}'=>date( "Y-m-d", strtotime( $oModel->end_date ) ),
                        '{tested_date}' => date( "Y-m-d" ),
                        '{notes}'=>$snNote
                    );
                    $subject = "QA Approval - ".$snProjectDetail->name." - ".$snMilestoneName;

                    $body = Common::MailTemplate( $AreplaceString, $emailformatemodel->body );

                    //send email for new generated password
                    if ( empty( $snTLEmail ) && empty($snSalesPersonEmail) ) {
                        $snMailStatus = Common::sendMail( $snUserDetail->email, $snQaUserDetail->email, $subject, $body, false, Yii::$app->params['ProjectManagerEmail'] );
                    }else {
                        $snMailStatus = Common::sendMailApproveReject( $snUserDetail->email, $snQaUserDetail->email, $subject, $body, false, Yii::$app->params['ProjectManagerEmail'],$snTLEmail,$snSalesPersonEmail);
                    }
                    if ( $snMailStatus == true ) {
                        Yii::$app->session->setFlash( 'success', Yii::getAlias( '@success_qa_approval' ) );
                        return Common::closeColorBox();

                    }else {
                        Yii::$app->session->setFlash( 'fail', Yii::getAlias( '@create_leave_error_message' ) );
                        return Common::closeColorBox();
                    }
                }
            }
        }else {
            throw new BadRequestHttpException( 'The requested page does not exist.' );
            //return Common::closeColorBox();
        }
        return $this->render( 'give_qa_approval', [
            'oModel'=>$oModel,
            ] );
    }

}

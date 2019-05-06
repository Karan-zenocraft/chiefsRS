<?php

namespace backend\controllers;

use Yii;
use common\models\LeaveQuota;
use common\models\LeaveQuotaSearch;
use common\models\Leaves;
use yii\web\Controller;
use common\components\Common;
use common\models\Users;
use common\models\UserProjects;
use common\models\EmailFormat;
use common\models\UsersTechnicalSkills;
use common\models\Technology;
use yii\db\Query;

/**
 * PagesController implements the CRUD actions for Pages model.
 */
class CronJobController extends Controller
{
    /*THIS CRON JOB ACTION WILL ADD PREVIOUS MONTH BALANCE TO NEXT MONTH'S TOTAL LEAVES
      THIS CRON JOB NEEDS TO EXECUTE ON FIRST DATE AT 12.01AM OF EVERY MONTH
    */
    public function actionCarryForwardLeavesQuota() {
        //GET CURRENT DATE,MONTH AND YEAR//
        $snCurrentDate                           = date( "Y/m/d" );
        $snCurrentDateYear                       = date( "Y", strtotime( $snCurrentDate ) );
        $snCurrentDateMonth                      = date( "m", strtotime( $snCurrentDate ) );

        //GET PREVIOUS MONTH AND TOTAL PENDING LEAVES//
        $snPrevMonth                             = Common::get_previous_month( $snCurrentDate );
        $omLeavesQuotaPrevMonth                  = LeaveQuota::find()->where( ['month'=>$snPrevMonth, 'year'=>$snCurrentDateYear] )->one();
        $PrevMonthPendingLeave                   = ( $omLeavesQuotaPrevMonth ) ? $omLeavesQuotaPrevMonth->total_leaves : 0 ;

        $omLeavesQuotaCurrentMonth               = LeaveQuota::find()->where( ['month'=>$snCurrentDateMonth, 'year'=>$snCurrentDateYear] )->one();
        if ( !empty( $omLeavesQuotaCurrentMonth ) ) {
            $CurrentMonthTotalLeaves                 = $omLeavesQuotaCurrentMonth->total_leaves;
            $omLeavesQuotaCurrentMonth->total_leaves = $CurrentMonthTotalLeaves + $PrevMonthPendingLeave;
            $omLeavesQuotaCurrentMonth->previous_month_bal = $PrevMonthPendingLeave;
            $omLeavesQuotaCurrentMonth->save( false );
        }else {
            $omLeaveQuota = new LeaveQuota();
            $omLeaveQuota->year = $snCurrentDateYear;
            $omLeaveQuota->month = $snCurrentDateMonth;
            $omLeaveQuota->total_leaves = Common::get_users_total_count();
            $omLeaveQuota->previous_month_bal = $PrevMonthPendingLeave;
            $omLeaveQuota->save( false );

        }

    }

    /*THIS CRON JOB ACTION WILL CARRY FORWARD MAXIMUM THREE LEAVES TO EACH EMPLOYEE'S LEAVE BALANCE
      THIS CRON JOB NEEDS TO EXECUTE ON FIRST DATE AT 12.01AM OF EVERY YEAR
    */
    public function actionYearlyCarryForwardLeavesForUser() {
        //GET CURRENT DATE,MONTH AND YEAR//
        $oModelUsers = Users::find()->where( ['status'=>'1', 'company'=>'INHERITX'] )->asArray()->all();
        if ( !empty( $oModelUsers ) ) {
            foreach ( $oModelUsers as $user ) {
                $omUser = Users::find()->where( ['id'=>$user['id']] )->one();
                $snTotalPendingLeaves = $omUser->total_leaves_pending;
                $snSandwichLeaveCount = $omUser->sandwich_leave_count;
                if ( $snTotalPendingLeaves >= Yii::$app->params['max_carry_forward_leaves'] ) {
                    $omUser->total_leaves_pending = Yii::$app->params['max_carry_forward_leaves'] + Yii::$app->params['on_the_spot_leaves'];
                }else {
                    $omUser->total_leaves_pending = $snTotalPendingLeaves + Yii::$app->params['on_the_spot_leaves'];
                }
                $omUser->sandwich_leave_count = 0;
                $omUser->save( false );

            }

        }
        echo "Executed";exit;

    }

    /*THIS CRON JOB ACTION WILL ADD ONE LEAVE TO EACH EMPLOYEE'S LEAVE BALANCE
      THIS CRON JOB NEEDS TO EXECUTE ON FIRST DATE AT 12.02AM OF EVERY MONTH
    */
    public function actionMonthlyCarryForwardLeavesForUser() {

        //GET CURRENT DATE,MONTH AND YEAR//
        $oModelUsers = Users::find()->where( ['status'=>'1', 'company'=>'INHERITX'] )->asArray()->all();
        if ( !empty( $oModelUsers ) ) {
            foreach ( $oModelUsers as $user ) {
                $omUser = Users::find()->where( ['id'=>$user['id']] )->one();
                $snTotalPendingLeaves = $omUser->total_leaves_pending;
                $omUser->total_leaves_pending = $snTotalPendingLeaves + Yii::$app->params['leave_balance_count'];
                $omUser->cron_exec_date = date( 'Y-m-d H:i:s' );
                $omUser->save( false );
            }

        }
        echo "Executed";exit;
    }

    /*THIS CRON JOB ACTION WILL SEND EMAIL NOTIFICATION TO TEAM LEAD AND PROJECT MANAGER IF USER GET AVALAIBLE IN NEXT WEEK OR NEXT WEEK
      THIS CRON JOB NEEDS TO EXECUTE ON EVERY DAY
    */

    public function actionResourceAvalaibleNotification() {
        $user_technical_skills = $AllocatedUsers = '';
        //GET USERS WITH RESOURCE UTILIZATION (%) AND TOTAL ITILIZATION(%)//
        $query = new Query;
        $query->select( 'up.user_id,u.first_name,u.last_name,u.joining_date,projects.name as project_name,projects.handled_by as team_lead_id,department.name as department_name,up.user_id,up.start_date,up.end_date,up.allocated_hours,up.avg_hours,((up.avg_hours * 100) / 8) AS resource_utilization,((select sum(avg_hours) as total from user_projects where end_date >= CURDATE() AND user_id= up.user_id) * 100 )/8 as total_utilization'  )
        ->from( 'user_projects as up' )
        ->join( 'LEFT JOIN', 'users as u',
            'u.id =up.user_id' )
        ->join( 'LEFT JOIN', 'department',
            'department.`id` = `u`.`department`' )
        ->join( 'LEFT JOIN', 'projects',
            'projects.`id` = `up`.`project_id`' )
        ->where( 'u.status = "1" AND u.company = "INHERITX" AND u.role_id NOT IN ('.Yii::$app->params['userroles']['qa'].','.Yii::$app->params['userroles']['designer'].') AND up.start_date IS NOT NULL and up.end_date IS NOT NULL AND up.end_date >= CURDATE()' );
        //->select( 'u.first_name,u.last_name,u.joining_date,projects.name as project_name,projects.handled_by as team_lead_id,department.name as department_name,up.user_id,up.start_date,up.end_date,up.allocated_hours,up.avg_hours,((up.avg_hours * 100) / 8) AS resource_utilization,((select sum(avg_hours) as total from user_projects where user_id= up.user_id) * 100 )/8 as total_utilization' );
        $command = $query->orderBy( 'up.end_date ASC' )->createCommand();
        $arrUserProjectsDetails = $command->queryAll();
        //GENERATE CSV FILE NAME//
        $filename = 'resource_utilization_'.rand().'_'.date( "Y-m-d" ).'.csv';
        //CSV FILE UPLOAD PATH//
        $uploaddir = dirname( __DIR__ ) .'/../csv/';
        $uploadfile = $uploaddir.$filename;

        $headers = array(
            'Sr No',
            'Employee Name',
            'Experience',
            'Project',
            'Release Date',
            'TL',
            'Daily Allocated Hours',
            'Project Utilization(%)',
            'Total Utilization(%)',
            'Technologies',
            'Avialable in next 30 days',
        );

        //OPEN THE NEW CSV FILE//
        $fp = fopen( $uploadfile, 'w' );
        //WRITE HEADERS TO CSV FILE//
        fputcsv( $fp, $headers );
        if ( !empty( $arrUserProjectsDetails ) && count( $arrUserProjectsDetails ) > 0 ) {
            //SET BODY AND SUBJECT FOR EMAIL NOTIFICATION//
            $subject = "Resource Availability Notification";
            $body = "Hi All,
                </br>
                </br> Please find attached Resource Allocation Sheet.
                </br>
                </br>";
            $i = 0;
            foreach ( $arrUserProjectsDetails as $key=>$userProjectDetails ) {
                $interval = Common::get_date_diff_in_days( $userProjectDetails['end_date'], true );
                if ( !empty( $interval ) && $interval >= 1 && $interval <= 30 ) {
                    $snDateInterval =  "Yes";
                }else {
                    $snDateInterval = 'No';
                }
                $snUserIds[] = $userProjectDetails['user_id'];
                $snUserName = $userProjectDetails['first_name'].' '. $userProjectDetails['last_name'];
                $snJoiningDate = $userProjectDetails['joining_date'];
                $snExperience = !empty( $snJoiningDate ) ? Common::get_date_diff_in_years( $snJoiningDate ) : "-";
                $snProjectName = $userProjectDetails['project_name'];
                $snFromEmail = Yii::$app->params['adminEmail'];
                $snEndDate = date("d-m-Y",strtotime($userProjectDetails['end_date']));
                $snAvgHours = $userProjectDetails['avg_hours'];
                $snTeamLeadId = $userProjectDetails['team_lead_id'];
                $snTLDetails = Users::findOne( $snTeamLeadId );
                $snResourceUtilization = round( $userProjectDetails['resource_utilization'] );
                $snTotalUtilization = round( $userProjectDetails['total_utilization'] );
                $snUserTechnichalSkills = UsersTechnicalSkills::find()->select( 'technology_id' )->where( ['users_technical_skills.user_id'=>$userProjectDetails['user_id']] )->orderBy( 'users_technical_skills.rating DESC' )->asArray()->all();
                $technologies = '-';
                if ( !empty( $snUserTechnichalSkills ) ) {
                    $technologyNameArr = [];
                    $technologyIdArr = array_column( $snUserTechnichalSkills, 'technology_id' );
                    foreach ( $technologyIdArr as $key=>$value ) {

                        $technology_name = Technology::find()->select( 'name' )->where( ['id'=>$value] )->one();
                        $technologyNameArr[] = $technology_name->name;
                    }
                    if ( !empty( $technologyNameArr ) ) {
                        $technologies = implode( ',', $technologyNameArr );

                    }else {
                        $technologies = '-';
                    }
                }
                $snTLName = !empty( $snTLDetails ) ? $snTLDetails->first_name.' '.$snTLDetails->last_name:"-";

                $i = $i+ 1;
                $rows = array( $i, $snUserName, $snExperience, $snProjectName, $snEndDate, $snTLName, $snAvgHours, $snResourceUtilization, $snTotalUtilization, $technologies, $snDateInterval );
                //WRITE USER DETAILS TO CSV FILE//
                fputcsv( $fp, $rows );
            }
            $r1 = array( "", "", "", "", "", "", "", "", "", "", "" );
            fputcsv( $fp, $r1 );
            fputcsv( $fp, $r1 );
            $r2 = array( "Bench Users Details", "", "", "", "", "", "", "", "", "", "" );
            fputcsv( $fp, $r2 );
            fputcsv( $fp, $r1 );
            if ( !empty( $snUserIds ) ) {
                $AllocatedUsers = implode( ',', $snUserIds );
            }
            $q = new Query;
            $q->select( 'u.first_name,u.last_name,u.joining_date,projects.name as project_name,projects.handled_by as team_lead_id,department.name as department_name,up.user_id,up.start_date,up.end_date,up.allocated_hours,up.avg_hours,((up.avg_hours * 100) / 8) AS resource_utilization,((select sum(avg_hours) as total from user_projects where end_date >= CURDATE() AND user_id= up.user_id) * 100 )/8 as total_utilization'  )
            ->from( 'user_projects as up' )
            ->join( 'LEFT JOIN', 'users as u', 'u.id =up.user_id' )
            ->join( 'LEFT JOIN', 'department', 'department.`id` = `u`.`department`' )
            ->join( 'LEFT JOIN', 'projects', 'projects.`id` = `up`.`project_id`' )
            ->where( 'u.status = "1" AND u.company = "INHERITX" AND u.role_id NOT IN ('.Yii::$app->params['userroles']['qa'].','.Yii::$app->params['userroles']['designer'].') AND up.start_date IS NOT NULL and up.end_date IS NOT NULL AND up.end_date < CURDATE() and u.id NOT IN ('.$AllocatedUsers.')' );
            $commands = $q->orderBy( 'u.first_name ASC' )->groupBy( 'u.first_name' )->createCommand();
            $snUserProjectsDetails = $commands->queryAll();
            $j = 0;
            foreach ( $snUserProjectsDetails as $key=>$snDetails ) {
                $snUserName = $snDetails['first_name'].' '. $snDetails['last_name'];
                $snJoiningDate = $snDetails['joining_date'];
                $snExperience = !empty( $snJoiningDate ) ? Common::get_date_diff_in_years( $snJoiningDate ) : "-";
                $snProjectName = '-';
                $snFromEmail = Yii::$app->params['adminEmail'];
                $snEndDate = '-';
                $snAvgHours = '-';
                $snTeamLeadId = '-';
                $snResourceUtilization = '-';
                $snTotalUtilization = '-';
                $snDateInterval = '-';
                $snUserTechnichalSkills = UsersTechnicalSkills::find()->select( 'technology_id' )->where( ['users_technical_skills.user_id'=>$snDetails['user_id']] )->orderBy( 'users_technical_skills.rating DESC' )->asArray()->all();
                $technologies = '-';
                if ( !empty( $snUserTechnichalSkills ) ) {
                    $technologyNameArr = [];
                    $technologyIdArr = array_column( $snUserTechnichalSkills, 'technology_id' );

                    foreach ( $technologyIdArr as $key=>$value ) {

                        $technology_name = Technology::find()->select( 'name' )->where( ['id'=>$value] )->one();
                        $technologyNameArr[] = $technology_name->name;

                    }
                    if ( !empty( $technologyNameArr ) ) {
                        $technologies = implode( ',', $technologyNameArr );

                    }else {
                        $technologies = '-';
                    }
                }
                $snTLName = '-';
                $j = $j+ 1;
                $rows = array( $j, $snUserName, $snExperience, $snProjectName, $snEndDate, $snTLName, $snAvgHours, $snResourceUtilization, $snTotalUtilization, $technologies, $snDateInterval );
                //WRITE USER DETAILS TO CSV FILE//
                fputcsv( $fp, $rows );
            }
            //CLOSE OPENED CSV FILE //
            fclose( $fp );
            $body.= "Thanks & Regards<br>";
            $body.= "<b>Admin</b>";
            //SEND EMAIL NOTIFICATION//
            $snMailStatus = Common::sendMailToUserWithAttachment( /*Yii::$app->params['managersEmail'],*//*'prakash@inheritx.com',*/'rutusha@inheritx.com', $snFromEmail, $subject, $body, $uploadfile );
            echo "Success";
            //FOR UNLINK THE GENERATED CSV//
            //unlink($uploadfile);
        }
        else {
            echo "exit";
        }
    }
}

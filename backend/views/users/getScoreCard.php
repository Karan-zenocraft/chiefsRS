<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use common\components\Common;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use common\models\Projects;
use common\models\ScoreCardSearch;
use common\models\Timesheet;



//p($snTotalHours);
/* @var $this yii\web\View */
/* @var $searchModel common\models\TimesheetSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'app', 'Manage Score Card' );
$this->params['breadcrumbs'][] = ['label' => 'Manage users', 'url' => ['users/index']];

$this->params['breadcrumbs'][] = $this->title;
$script = <<< JS
$('.search-button').click(function(){
    $('.scoreCard-search').toggle();
    return false;
});
JS;
$this->registerJs($script);
?>
<div class="timesheet-index email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?php echo !empty( $snTaskName ) ? Html::encode( $this->title ).' - '.$snTaskName : Html::encode( $this->title )?></div>
        <div class="pull-right">
                <?php echo Html::a( Yii::t( 'app', '<i class="icon-refresh"></i> Reset' ), Yii::$app->urlManager->createUrl( ['users/get-score-card', 'id'=> $_GET['id']] ), ['class' => 'btn btn-primary'] ) ?>

        </div>

    </div>
        <!-- Project Forloop -->
        <?php
         echo Html::a('Advanced Search', '#', array('class' => 'search-button'));
         echo $this->render('scoreCardSearch',['ProjectsDropDown'=>Projects::ProjectDropDownArr( $flag=false, $id=$_GET['id'])]);

        ?>
        <?php foreach ( $arrAssignedProjects as $projects ) {?>

    <div>
    <h6 class = "block-content"><?php echo !empty( $projects ) ? ( $projects['name']. ' : ' .Common::display_hours( $projects['total_hours'] ) ) : '-'   ?>
    </h6>
    </div>
    <div class="block-content">
        <table border="2">
           <tr>
                <td width = "15%"><center>Milestone Name</center></td>
                <td width = "13%" ><center>Estimated Hours</center></td>
                <td width = "14%"><center>Consumed Hours</center></td>
                <td width = "12%"><center>Normal Hours</center></td>
                <td width = "10%"><center>Bug Hours</center></td>
                <td width = "10%"><center>CR Hours</center></td>
                <td width = "15%"><center>Suggestion Hours</center></td>
                <td width = "20%"><center>Feedback Hours</center></td>
                <td width = "20%"><center>Support Hours</center></td>
                <td width = "20%"><center> Total Billable Hours</center></td>
                <td width = "20%"><center>Profit/Loss Hours</center></td>

            </tr>
        <?php foreach ( $projects['milestones'] as $milestone ) {?>
        <?php if ( $milestone['is_deleted'] == Yii::$app->params['allow_deleted_status'] && $milestone['status'] != Yii::$app->params['new_status'] ) {?>
            <tr>
                <?php $score_card_details = Common::get_score_card_details( $_GET['id'], $milestone['id'] );
?>
                <td width = "15%"><center><?= $milestone['name']?></center></td>
                <td width = "13%"><center><?= Common::display_hours($score_card_details['estimated_hours']) ?></center></td>
                <td width = "14%"><center><?= Common::display_consumed_hours($score_card_details['consumed_hours']) ?></center></td>
                <td width = "12%"><center><?= Common::display_consumed_hours($score_card_details['normal_hours']) ?></center></td>
                <td width = "10%"><center><?= Common::display_consumed_hours($score_card_details['bug_hours']) ?></center></td>
                <td width = "10%"><center><?= Common::display_consumed_hours($score_card_details['cr_hours']) ?></center></td>
                <td width = "15%"><center><?= Common::display_consumed_hours($score_card_details['suggestion_hours']) ?></center></td>
                <td width = "20%"><center><?= Common::display_consumed_hours($score_card_details['feedback_hours']) ?></center></td>
                <td width = "20%"><center><?= Common::display_consumed_hours($score_card_details['support_hours']) ?></center></td>
                <td width = "20%"><center><?= Common::display_consumed_hours($score_card_details['total_billable_hours']) ?></center></td>
                <td width = "20%"><center><?= $score_card_details['profit_hours/loss_hours'] ?></center></td>

            </tr>


        <?php } }?>
        </table>
                <div class="clearfix"></div>

    </div>
        <?php }?>





</div>

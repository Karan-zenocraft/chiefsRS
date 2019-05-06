<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MilestonesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Timesheet');
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['users/my-projects']];
$this->params['breadcrumbs'][] = ['label' => $snProjectName, 'url' => ['users/milestones','id'=>isset($_GET['pid']) ? $_GET['pid'] : 0]];
$this->params['breadcrumbs'][] = ['label' => $snMilestoneName, 'url' => ['users/tasks','id'=>isset($_GET['mid']) ? $_GET['mid'] : 0,'pid'=>isset($_GET['pid']) ? $_GET['pid'] : 0]];
$this->params['breadcrumbs'][] = ['label' => $snTaskName/*, 'url' => ['users/timesheet','tid'=>isset($_GET['tid']) ? $_GET['tid'] : 0,'mid'=>isset($_GET['mid']) ? $_GET['mid'] : 0,'pid'=>isset($_GET['pid']) ? $_GET['pid'] : 0]*/];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="milestones-index email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><h3><?= Html::encode($this->title).' - '.$snTaskName?></h3></div>
        <div class="pull-right"><?= Html::a('Back', ['tasks', 'id' => isset($_GET['mid']) ? $_GET['mid'] : 0,'pid'=>!empty($_GET['pid']) ? $_GET['pid'] : 0], ['class' => 'btn btn-primary']) ?>
          <?php
             $amRequestArr[] = 'users/timesheet';
             unset($_GET['TimesheetSearch']);
             $amRequestArr = array_merge($amRequestArr,$_GET); 
         ?>
        <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl($amRequestArr), ['class' => 'btn btn-primary']) ?>
    </div>
    </div>
    <div class="block-content">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>        
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='col-md-5 col-sm-12'><div class='row'>{summary}</div></div>\n<div class='col-md-7 col-sm-12'><div class='row'>{pager}</div></div>",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                /*[
                    'attribute' => 'project_id',
                    'header' => 'Project',
                    'filter' => $amProjects,
                    'headerOptions' => ["style" => "width:15%;text-align:center;"],
                    'value' => function($data) {
                        return $data->project->name;
                    }
                ],*/
               /* [
                    'attribute' => 'milestone_id',
                    'header' => 'Milestone',
                    'filter' => $amMilestones,
                    'headerOptions' => ["style" => "width:15%;text-align:center;"],
                    'value' => function($data) {
                        return $data->milestone->name;
                    }
                ],
                [
                    'attribute' => 'task_id',
                    'header' => 'Task',
                    'filter' => $amTasks,
                    'headerOptions' => ["style" => "width:15%;text-align:center;"],
                    'value' => function($data) {
                        return $data->task->name;
                    }
                ],*/
                [
                    'attribute' => 'task_type',
                    'header' => 'Task Type',
                    'filter' => Yii::$app->params['TASK_TYPE'],
                    'headerOptions' => ["style" => "width:10%;text-align:center;"],
                    'value' => function($data) {
                        return Yii::$app->params['TASK_TYPE'][$data->task_type];
                    }
                ],
                [
                    'attribute' => 'task_description',
                    'header' => 'Description',
                    'format' => 'raw',
                    'value' => function($data) {
                        $ssText = (strlen($data->task_description) > 40) ? substr($data->task_description, 0, 40) . '...' : $data->task_description;
                        return Html::a($ssText, ['timesheet/view', 'id' => $data->id,'tid'=>isset($_GET['id']) ? $_GET['id'] : 0,'mid'=>isset($_GET['mid']) ? $_GET['mid'] : 0,'pid'=>!empty($_GET['pid']) ? $_GET['pid'] : 0],['class'=>'colorbox_popup','onclick'=>'javascript:openColorBox();']);
                    }
                ],
                [
                    'attribute' => 'hours',
                    'header' => 'Hour',
                    'filter' => false,
                    'headerOptions' => ["style" => "width:5%;text-align:center;"],
                    'contentOptions' => ["style" => "width:5%;text-align:center;"],
                    'value' => function($data) {
                        $snHours = Common::display_hours($data->hours);
                        return $snHours;
                        //return str_replace(".",":",number_format($data->hours,2));
                    },
                ],
                [
                    'attribute' => 'entry_date',
                    'format' => 'raw',
                    'headerOptions' => ["style" => "width:11%;text-align:center;"],
                    'contentOptions' => ["style" => "width:11%;text-align:center;"],
                    'filter' => DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'entry_date',
                        'language' => 'en',
                        'dateFormat' => 'yyyy-MM-dd',
                        'options' => ['class' => 'form-control']
                    ]),
                    'value' => function($data) {
                        return date('Y-m-d', strtotime($data->entry_date));
                    }
                ],
                /*[
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ["style" => "width:10%;"],
                    'template' => '{view}{update}{delete}',
                ]*/
            ],
        ]);
        ?>
    </div>
</div>

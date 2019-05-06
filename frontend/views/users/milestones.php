<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MilestonesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->title = !empty($snProjectName) ? Yii::t('app', 'Milestones').' - '.$snProjectName : Yii::t('app', 'Milestones') ;
$this->title = Yii::t('app', 'Milestones');
if (isset($_GET['id'])) {
    $this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['users/my-projects']];
    $this->params['breadcrumbs'][] = $snProjectName;
}else{
    
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="milestones-index email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><h3><?php echo !empty($snProjectName) ? Yii::t('app', 'Milestones').' - '.$snProjectName : Yii::t('app', 'Milestones') ; ?></h3></div>
        <div class="pull-right">
            <?php if (isset($_GET['id'])) { ?>
                <?php echo Html::a('Back', ['my-projects'], ['class' => 'btn btn-primary']) ?>
                <?php echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['/users/milestones', 'id' => $_GET['id']]), ['class' => 'btn btn-primary']) ?>
            <?php } else { ?>
                <?php echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['/users/milestones']), ['class' => 'btn btn-primary']) ?>
            <?php } ?>
        </div>
    </div>
    <div class="block-content">
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php
        echo
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='col-md-5 col-sm-12'><div class='row'>{summary}</div></div>\n<div class='col-md-7 col-sm-12'><div class='row'>{pager}</div></div>",
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'project_id',
                    'visible' => empty($_GET['id']),
                    // 'format' => 'raw',
                    'value' => function( $data ) {
                        return $data->project->name;
                    }
                ],
                // 'name',
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => function( $data ) {
                        return Html::a($data->name, ['users/milestone-detail', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox();']);
                    }
                ],
                //  'description:ntext',
                [
                    'attribute' => 'start_date',
                    'filter' => false,
                    'headerOptions' => ["style" => "width:8%;text-align:center;"],
                    'contentOptions' => ["style" => "width:8%;text-align:center;"],
                    'value' => function( $data ) {
                        return date('Y-m-d', strtotime($data->start_date));
                    }
                ],
                [
                    'attribute' => 'end_date',
                    'filter' => false,
                    'headerOptions' => ["style" => "width:8%;text-align:center;"],
                    'contentOptions' => ["style" => "width:8%;text-align:center;"],
                    'value' => function( $data ) {
                        return date('Y-m-d', strtotime($data->end_date));
                    }
                ],
                ['attribute' => 'actual_hours',
                    'filter' => false,
                    'headerOptions' => ["style" => "width:11%;text-align:center;"],
                    'contentOptions' => ["style" => "width:11%;text-align:center;"],
                    'value' => function( $data ) {
                        return Common::display_hours($data->actual_hours);
                    },
                    'visible' => $snUserRoleId != Yii::$app->params['userroles']['qa'],
                ],
                [
                    'attribute' => 'qa_date',
                    'value' => function( $data ) {
                        return !empty($data->qa_date) ? date('Y-m-d', strtotime($data->qa_date)) : '-';
                    }
                ],
                [
                    'attribute' => 'qa_approved_date',
                    'value' => function( $data ) {
                        return !empty($data->qa_approved_date) ? date('Y-m-d', strtotime($data->qa_approved_date)) : '-';
                    }
                ],
                [
                    'attribute' => 'status',
                    'header' => 'Status',
                    'filter' => Yii::$app->params['milestone_status'],
                    'value' => function( $data ) {
                        return Yii::$app->params['milestone_status'][$data->status];
                    },
                    'headerOptions' => ["style" => "width:15%;text-align:center;"],
                    'contentOptions' => ["style" => "width:15%;text-align:center;"],
                ],
                // 'created_at',
                // 'updated_at',
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'visible' => $snUserRoleId != Yii::$app->params['userroles']['qa'],
                    'headerOptions' => ["style" => "width:10%;"],
                    'template' => '{task}{update_status}',
                    'buttons' => [
                        'task' => function( $url, $model ) {
                            return Html::a('View Tasks', Yii::$app->urlManager->createUrl(['users/tasks', 'id' => $model->id, 'pid' => $model->project_id]), [
                                        'title' => Yii::t('yii', 'View Tasks'),
                                        'class' => 'float_left',
                                    ]);
                        },
                        'update_status' => function ( $url, $model, $title ) {
                            $title = 'Update Status';
                            $flag = false;
                            $url = Yii::$app->urlManager->createUrl(['users/update-milestone-status', 'mid' => $model->id, 'pid' => $model->project_id]);
                            return Common::update_status_button($url, $model, $title, $flag);
                        },
                      /*  'send_to_qa' => function ( $url, $model ) {
                            $title = 'Send for QA';
                            $flag = true;
                            $url = Yii::$app->urlManager->createUrl(['users/send-milestone-for-qa', 'mid' => $model->id, 'pid' => $model->project_id]);
                            return Common::send_for_qa_button($url, $model, $title, $flag);
                        },*/
                    ]
                ],
       /*         [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'visible' => $snUserRoleId == Yii::$app->params['userroles']['qa'],
                    'headerOptions' => ["style" => "width:10%;"],
                    'template' => '{qa_approval}',
                    'buttons' => [
                        'qa_approval' => function ( $url, $model ) {
                            $title = 'Give Approval';
                            $flag = false;
                            $url = Yii::$app->urlManager->createUrl(['users/give-qa-approval', 'mid' => $model->id, 'pid' => $model->project_id]);
                            return Common::send_for_qa_button($url, $model, $title, $flag);
                        },
                    ]
                ]*/
            ],
        ]);
        ?>
    </div>
</div>

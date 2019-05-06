<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MilestonesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t('app', 'Tasks');
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['users/my-projects']];
$this->params['breadcrumbs'][] = ['label' => $snProjectName, 'url' => ['users/milestones','id'=>$_GET['pid']]];
$this->params['breadcrumbs'][] = ['label' => $snMilestoneName/*, 'url' => ['tasks/index', 'pid'=>( $_GET['pid'] > 0 ) ? $_GET['pid'] : 0,'mid'=>( $_GET['mid'] > 0 ) ? $_GET['mid'] : 0]*/];

/*$this->params['breadcrumbs'][] = ['label' => $snProjectName, 'url' => ['users/milestones','id'=>isset($_GET['pid']) ? $_GET['pid'] : 0]];
$this->params['breadcrumbs'][] = $this->title;*/
?>
<div class="milestones-index email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><h3><?= Html::encode($this->title).' - '.$snMilestoneName ?></h3></div>
        <div class="pull-right">
            <?= Html::a('Back', ['milestones','id'=>isset($_GET['pid']) ? $_GET['pid'] : 0], ['class' => 'btn btn-primary']) ?>
        <?php
             $amRequestArr[] = 'users/tasks';
            unset($_GET['TasksSearch']);
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
               // 'name',
                [
                    'attribute'=>'name', 
                    'format' => 'raw',
                    'value' => function($data) {
                       return Html::a($data->name, ['users/task-detail', 'id' => $data->id],['class'=>'colorbox_popup','onclick'=>'javascript:openColorBox();']);
                    }
                ],
                //'description:ntext',
                [
                    'attribute' => 'status',
                    'filter' => Yii::$app->params['task_status'],
                    'value' => function($data) {
                        return Yii::$app->params['task_status'][$data->status];
                    },
                ],
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ["style" => "width:15%;"],
                    'template' => '{timesheet}{update_status}',
                    'buttons' => [
                        'timesheet' => function($url, $model) {
                            return Html::a('View Timesheet', Yii::$app->urlManager->createUrl(['users/timesheet', 'id' => $model->id,'mid' => $model->milestone_id,'pid'=>!empty($_GET['pid']) ? $_GET['pid'] : 0]), [
                                        'title' => Yii::t('yii', 'View Timesheet'),
                            ]);
                        },
                        'update_status' => function ($url, $model) {
                                $title = 'Update Stutus';
                                $flag = true;
                                $url = Yii::$app->urlManager->createUrl(['users/update-task-status','tid' => $model->id,'mid' => $model->milestone_id,'pid'=>!empty($_GET['pid']) ? $_GET['pid'] : 0]);
                                return Common::update_status_button($url, $model,$title,$flag);
                            },
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>

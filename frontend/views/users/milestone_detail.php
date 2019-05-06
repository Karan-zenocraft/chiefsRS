<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Timesheet;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $model common\models\Milestones */

$this->title = "Milestone Detail : ".$model->name;

?>
<div class="pages-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
    <div class="block-content">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'attribute'=>'project_id',
                'value'=>$model->project->name,
            ],
            [
                'label'=>'Milestone Name',
                'value'=>$model->name,
            ],
            [
                'label'=>'Tasks',
                'format' => 'raw',
                'visible' => Common::get_user_role(Yii::$app->user->id) == Yii::$app->params['userroles']['qa'],
                'value'=> !empty($Tasks) ? $Tasks : '-',
            ],
            'description:ntext',
            [
                'attribute' => 'start_date',
                'value' => date('Y-m-d', strtotime($model->start_date)),
                
            ],
            [
                'attribute' => 'end_date',
                'value' => date('Y-m-d', strtotime($model->end_date)),
            ],
            [
                'attribute' => 'actual_hours',
                'value' => Common::display_hours($model->actual_hours),
            ],
            [
                'label'=>'Consumed Hours',
                'value'=>Timesheet::consumedHoursTobeDisplayed(array('milestone_id'=>$model->id)),
            ],
            [
                'attribute' => 'status',
                'value' => Yii::$app->params['milestone_status'][$model->status],
            ],
         ],
    ]) ?>
</div>
</div>
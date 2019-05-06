<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Timesheet;
use common\components\Common;


/* @var $this yii\web\View */
/* @var $model common\models\Milestones */

$this->title = 'Task Detail - '.$model->name;
?>
<div class="pages-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= $this->title; ?></div>
    </div>
    <div class="block-content">
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            [
                'label'=>'Project Name',
                'value'=>$model->milestone->project->name,
            ],
            [
                'attribute'=>'milestone_id',
                'value'=>$model->milestone->name,
            ],
            [
                'label'=>'Task Name',
                'value'=>$model->name,
            ],
            'description:ntext',
          /* [
                'attribute' => 'start_date',
                'value' => date('m/d/Y', strtotime($model->start_date)),
                
            ],
            [
                'attribute' => 'end_date',
                'value' => date('m/d/Y', strtotime($model->end_date)),
            ],*/
            [
                'attribute' => 'actual_hours',
                'value' => Common::display_hours($model->actual_hours),
            ],
            [
                'label'=>'Consumed Hours',
                'value'=>Timesheet::consumedHoursTobeDisplayed(array('task_id'=>$model->id)),
            ],
            [
                'attribute' => 'status',
                'value' => Yii::$app->params['milestone_status'][$model->status],
            ],
         ],
    ]) ?>
</div>
</div>

<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Timesheet;

/* @var $this yii\web\View */
/* @var $model common\models\Milestones */

$this->title = "Project Detail : ".$model->name;

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
                'label'=>'Project Name',
                'value'=>$model->name,
            ],
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => Yii::$app->params['milestone_status'][$model->status],
            ],
         ],
    ]) ?>
</div>
</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */

$this->title = 'Update Restaurant: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
//$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurants-update email-format-create">
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<div class="block-content">
    <div class="goodtable">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Restaurant MealTimes</div>   
            <div class="pull-right">       
             <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurants/update','id'=>$model->id]), ['class' => 'btn btn-primary']) ?>  </div>
        </div> 
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
         'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='col-md-5 col-sm-12'><div class='row1'>{summary}</div></div>\n<div class='col-md-7 col-sm-12'><div class='row'>{pager}</div></div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            //'restaurant_id',
             [
                    'attribute' => 'meal_type',
                    'filter' => Yii::$app->params['meal_times'],
                    'value' => function($data) {
                        return Yii::$app->params['meal_times'][$data->meal_type];
                    },
             ],
             [
                    'attribute' => 'start_time',
                    'value' => function($data) {
                        return (!empty($data->start_time)) ? $data->start_time : "-" ;
                    },
             ],
              [
                    'attribute' => 'end_time',
                    'value' => function($data) {
                        return (!empty($data->end_time)) ? $data->end_time : "-" ;
                    },
             ],
            //'status',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

           	[
                   		'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ["style" => "width:40%;"],
                        'contentOptions' => ["style" => "width:40%;"],
                        'template' => '{update}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                              $url = Yii::$app->urlManager->createurl(['restaurant-meal-times/update', 'id' => $model->id, 'rid' => $model->restaurant_id]);
                                return Common::template_update_tag_button($url, $model,$flag=3);
                            },
                        ]
            ],
        ],
    ]); ?>
     </div>

</div>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantWorkingHoursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurant Working Hours';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Working Hours', 'url' => ['restaurant-working-hours/index','rid'=>$_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<div class="restaurant-working-hours-index email-format-index">
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title).' - '.$snRestaurantName ?>
        </div>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add workig Hours'), Yii::$app->urlManager->createUrl(['restaurant-working-hours/create', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-success']) ?>
            <?php echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurant-working-hours/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="block-content">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'restaurant_id',
            'weekday',
            'opening_time',
            'closing_time',
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
                                $flag = 1;
                                $url = Yii::$app->urlManager->createurl(['restaurant-menu/update', 'rid' => $model->restaurant_id, 'id' => $model->id]);
                                return Common::template_update_button($url, $model, $flag);
                            },
                        ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

   </div>
</div>

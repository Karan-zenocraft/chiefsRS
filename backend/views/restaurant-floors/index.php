<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantFloorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Restaurant Floors';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Floors', 'url' => ['restaurant-floors/index', 'rid' => $_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<div class="restaurant-floors-index email-format-index">
       <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
        <div class="block-content collapse in">
        <div class="restaurant-floors-form span12">

             <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
             <?php if (!empty($_REQUEST['RestaurantFloorsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
                <div class="restaurantss-floors-serach common_search">
                 <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
        <?php } else {?>
            <div class="restaurant-floors-serach common_search">
                 <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title) . ' - ' . $snRestaurantName ?>
        </div>
       <!--  <div class="pull-right">
            <?php //Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Layout'), Yii::$app->urlManager->createUrl(['restaurant-layout/create', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-success colorbox_popup','onclick' => 'javascript:openColorBox(420,400);']) ?>
        </div> -->
    </div>
    <div class="block-content">
    <?php// Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        //'id',
        //'restaurant_id',
        'name',
        //'created_by',
        //'updated_by',
        [
            'attribute' => 'status',
            'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return Yii::$app->params['status'][$data->status];
            },
        ],

        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{tables}',
            'buttons' => [
                /* 'update' => function ($url, $model) {
                $flag = 2;
                $url = Yii::$app->urlManager->createurl(['restaurant-layout/update', 'rid' => $model->restaurant_id, 'id' => $model->id]);
                return Common::template_update_tag_button($url, $model, $flag);
                },*/
                'tables' => function ($url, $model) {
                    $title = "Manage Tables";
                    $flag = 4;
                    $url = Yii::$app->urlManager->createUrl(['restaurant-tables/index', 'rid' => $model->restaurant_id, 'lid' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                /* 'delete' => function ($url, $model) {
            $flag = 1;
            $url = Yii::$app->urlManager->createurl(['restaurant-layout/delete', 'rid' => $model->restaurant_id, 'id' => $model->id]);
            $confirmmessage = "Are you sure you want to delete this Layout?";
            return Common::template_delete_button($url, $model,$confirmmessage, $flag);
            },*/
            ],
        ],
    ],
]);?>

    <?php// Pjax::end(); ?>
   </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
    $('.restaurant-floors-serach').hide();
        $('.open_search').click(function(){
            $('.restaurant-floors-serach').toggle();
        });
    });

</script>
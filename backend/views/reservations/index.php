<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Common;
use common\models\Tags;
/* @var $this yii\web\View */
/* @var $searchModel common\modelsReservationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Reservations');
$this->params['breadcrumbs'][] = ['label' => 'Manage Users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Reservations', 'url' => ['reservations/index','user_id'=>$_GET['user_id']]];
$this->params['breadcrumbs'][] = ['label' => Common::get_name_by_id($_GET['user_id'],"Users")];
?>
<div class="reservations-index email-format-index">
    <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
        <div class="block-content collapse in">
        <div class="reservations-form span12">
   
             <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
             <?php if(!empty($_REQUEST['ReservationsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
                <div class="reservations-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
                </div> 
        <?php }else{ ?>
           <div class="reservation-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
            </div>  
    <?php } ?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title).' - '.Common::get_name_by_id($_GET['user_id'],"Users") ?>
        </div>
       <!--  <div class="pull-right">
            <?php // Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Menu'), Yii::$app->urlManager->createUrl(['restaurant-menu/create', 'rid' => ( $_GET['user_id'] > 0 ) ? $_GET['user_id'] : 0]), ['class' => 'btn btn-success']) ?>
            <?php // echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurant-menu/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div> -->
    </div>
<?php //Pjax::begin(); ?>
  <div class="block-content">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
         'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'first_name',
            'last_name',
            'email:email',
            'contact_no',
            //'user_id',
            [
                        'attribute' => 'restaurant_id',
                       // 'filter' => Restaurants::RestaurantsDropDown(),
                        'filterOptions' => ["style" => "width:13%;"],
                        'headerOptions' => ["style" => "width:13%;"],
                        'contentOptions' => ["style" => "width:13%;"],
                        'value' => function($data) {
                            return $data->restaurant->name;
                        },
            ],
            //'layout_id',
            //'table_id',
            'date',
            'booking_start_time',
            //'booking_end_time',
            'total_stay_time',
            'no_of_guests',
          //  'pickup_drop',
            [
                        'attribute' => 'pickup_drop',
                        'value' => function($data) {
                            return ($data->pickup_drop == 0) ? "No" : "Yes";
                        },
            ],
               [
                        'attribute' => 'tag_id',
                        'filter' => Tags::TagsDropDown(),
                        'value' => function($data) {
                            $TagsDropDown = Tags::TagsDropDown();
                            return !empty($data->tag_id) ? $TagsDropDown[$data->tag_id] : "-";
                        },
                ],   
             [
                        'attribute' => 'status',
                        'value' => function($data) {
                            return Yii::$app->params['reservation_status'][$data->status];
                        },
            ],
            //'pickup_location',
            //'pickup_lat',
            //'pickup_long',
            //'pickup_time',
            //'drop_location',
            //'drop_lat',
            //'drop_long',
            //'drop_time',
            //'special_comment:ntext',
            //'created_at',
            //'updated_at',

         //   ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php //Pjax::end(); ?>

  </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {  
    $('.reservation-serach').hide();
        $('.open_search').click(function(){
            $('.reservation-serach').toggle();
        });
    });

</script>
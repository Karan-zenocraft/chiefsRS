<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Common;
use common\models\Tags;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ReservationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reservations';
?>
<section>
<div class="row">
<div class="col-lg-12 p-5 reservations-index">
     <div class="flash_message">
                    <?php include_once '../views/layouts/flash_message.php'; ?>
    </div>
<div class="table-responsive reservation_table">
<div class="row">
    <div class="col-md-8">
    <h1 class="display-4 reservation"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="pull-right col-md-4">  
         <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Book Restaurant'), Yii::$app->urlManager->createUrl(['reservations/create']), ['class' => 'btn btn-primary']) ?>
      <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['reservations/index']), ['class' => 'btn btn-primary']) ?>
  </div>
</div>
<div class="row">

<div class="col-md-8">
     <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
             <?php if(!empty($_REQUEST['ReservationsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
                <div class="reservations-serach">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
                </div> 
        <?php }else{ ?>
           <div class="reservation-serach">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
            </div>  
    <?php } ?>
</div>
</div>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
         'layout' => "{items}\n{pager}",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            //'user_id',
            [
                        'attribute' => 'restaurant_id',
                        'filter' => $snRestaurantDropDown,
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
                [
                        'attribute' => 'pickup_drop',
                        'value' => function($data) {
                            return Yii::$app->params['pickup_drop_status'][$data->pickup_drop];
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
               [
                        'attribute' => 'tag_id',
                        'filter' => Tags::TagsDropDown(),
                        'value' => function($data) {
                            $TagsDropDown = Tags::TagsDropDown();
                            return !empty($data->tag_id) ? $TagsDropDown[$data->tag_id] : "-";
                        },
                ],   
            //'special_comment:ntext',
               [
                        'attribute' => 'status',
                        'filter' => Yii::$app->params['reservation_status'],
                        'value' => function($data) {
                            return Yii::$app->params['reservation_status'][$data->status];
                        },
                ],
            //'created_at',
            //'updated_at',
   [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ["style" => "width:22%;color:#FDA403"],
                        'contentOptions' => ["style" => "width:22%;"],
                        'template' => '{update}{cancel}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                $flag = 1;
                                return Common::template_update_button($url, $model, $flag);
                            },
                              'cancel' => function ($url, $model) {
                                $flag = 1;
                                $confirmmessage = "Are you sure you want to cancel this booking?";
                                $url = Yii::$app->urlManager->createUrl(['reservations/cancel','id'=>$model->id]);
                                return ($model->status == "2") ? "" : Common::template_cancel_button($url, $model,$confirmmessage, $flag);
                            },
                            'delete' => function ($url, $model) {
                                $flag = 2;
                                $confirmmessage = "Are you sure you want to delete this booking?";
                                $url = Yii::$app->urlManager->createUrl(['reservations/delete','id'=>$model->id]);

                                return Common::template_cancel_button($url, $model,$confirmmessage, $flag);
                            },
                        ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
</div>
</div>
</div>
</section>
<script type="text/javascript">
$( document ).ready(function() {  
    $('.reservation-serach').hide();
        $('.open_search').click(function(){
            $('.reservation-serach').toggle();
        });
    });

</script>
<?php

use common\models\BookReservations;
use common\models\Tags;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */

$this->title = "Reservation Description : " . $model->restaurant->name;
\yii\web\YiiAsset::register($this);
?>
 <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=$this->title;?></div>
    </div>
<div class="reservations-view block-content">
    <?=DetailView::widget([
    'model' => $model,
    'attributes' => [
        // 'id',
        //'user_id',
        [
            'attribute' => 'restaurant_id',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return $data->restaurant->name;
            },
        ],
        [
            'attribute' => 'floor_id',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return BookReservations::get_floor($data->id);
            },
        ],
        [
            'attribute' => 'table_id',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return BookReservations::get_table($data->id);
            },
        ],
        //'table_id',
        'date',
        'booking_start_time',
        //'booking_end_time',
        'total_stay_time',
        'no_of_guests',
        [
            'attribute' => 'pickup_drop',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return ($data == "1") ? "YES" : "NO";
            },
        ],
        [
            'attribute' => 'pickup_location',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->pickup_location) ? $data->pickup_location : "-";
            },
        ],
        //'pickup_lat',
        //'pickup_long',
        [
            'attribute' => 'pickup_time',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->pickup_time) ? $data->pickup_time : "-";
            },
        ],
        [
            'attribute' => 'pickup_location',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->pickup_location) ? $data->pickup_location : "-";
            },
        ],
        //'drop_location',
        //'drop_lat',
        //'drop_long',
        [
            'attribute' => 'drop_time',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->drop_time) ? $data->drop_time : "-";
            },
        ],
        [
            'attribute' => 'drop_location',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->drop_location) ? $data->drop_location : "-";
            },
        ],
        //'drop_time',
        'special_comment:ntext',
        [
            'attribute' => 'tag_id',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return !empty($data->tag_id) ? Tags::get_tags($data->tag_id) : "-";
            },
        ],
        [
            'attribute' => 'status',
            // 'filter' => Yii::$app->params['status'],
            'value' => function ($data) {
                return Yii::$app->params['reservation_status'][$data->status];
            },
        ],
        //'created_at',
        //'updated_at',
    ],
])?>

</div>

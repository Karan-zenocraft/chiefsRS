<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Reservations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reservations-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'restaurant_id',
            'layout_id',
            'table_id',
            'date',
            'booking_start_time',
            'booking_end_time',
            'total_stay_time',
            'no_of_guests',
            'pickup_drop',
            'pickup_location',
            'pickup_lat',
            'pickup_long',
            'pickup_time',
            'drop_location',
            'drop_lat',
            'drop_long',
            'drop_time',
            'special_comment:ntext',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

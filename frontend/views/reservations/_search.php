<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReservationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservations-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'restaurant_id') ?>

    <?= $form->field($model, 'layout_id') ?>

    <?= $form->field($model, 'table_id') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'booking_start_time') ?>

    <?php // echo $form->field($model, 'booking_end_time') ?>

    <?php // echo $form->field($model, 'total_stay_time') ?>

    <?php // echo $form->field($model, 'no_of_guests') ?>

    <?php // echo $form->field($model, 'pickup_drop') ?>

    <?php // echo $form->field($model, 'pickup_location') ?>

    <?php // echo $form->field($model, 'pickup_lat') ?>

    <?php // echo $form->field($model, 'pickup_long') ?>

    <?php // echo $form->field($model, 'pickup_time') ?>

    <?php // echo $form->field($model, 'drop_location') ?>

    <?php // echo $form->field($model, 'drop_lat') ?>

    <?php // echo $form->field($model, 'drop_long') ?>

    <?php // echo $form->field($model, 'drop_time') ?>

    <?php // echo $form->field($model, 'special_comment') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

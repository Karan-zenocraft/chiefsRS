<?php

use common\models\Restaurants;
use common\models\Tags;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modelsReservationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reservations-search">

    <?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => [
        'data-pjax' => 1,
    ],
]);?>


    <?php // echo $form->field($model, 'user_id') ?>
<div class="row">
    <div class="col-md-6">
    <?php echo $form->field($model, 'restaurant_id')->dropDownList(array('' => '') + Restaurants::RestaurantsDropDown()); ?>
    </div>
    <?php // echo $form->field($model, 'floor_id') ?>

    <?php // echo $form->field($model, 'table_id') ?>
    <div class="col-md-6">
        <?=$form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['readonly' => 'readonly', 'class' => 'reservation_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?=$form->field($model, 'booking_start_time')->textInput(["id" => "booking_start_time"])?>
    </div>
    <?php // echo $form->field($model, 'booking_end_time') ?>
    <div class="col-md-6">
        <?php echo $form->field($model, 'total_stay_time') ?></div>
</div>
<div class="row">
    <div class="col-md-6">
    <?php echo $form->field($model, 'no_of_guests') ?>
    </div>
    <div class="col-md-6">
    <?php echo $form->field($model, 'pickup_drop')->dropDownList(array('' => '') + Yii::$app->params['pickup_drop_status']); ?>
    </div>
</div>

    <?php // echo $form->field($model, 'pickup_location') ?>

    <?php // echo $form->field($model, 'pickup_lat') ?>

    <?php // echo $form->field($model, 'pickup_long') ?>

    <?php // echo $form->field($model, 'pickup_time') ?>

    <?php // echo $form->field($model, 'drop_location') ?>

    <?php // echo $form->field($model, 'drop_lat') ?>

    <?php // echo $form->field($model, 'drop_long') ?>

    <?php // echo $form->field($model, 'drop_time') ?>

    <?php // echo $form->field($model, 'special_comment') ?>
<div class="row">
    <div class="col-md-6">
        <?php $tagsArr = Tags::TagsDropDown();?>
   <?=$form->field($model, 'tag_id')->dropDownList(array("" => "") + $tagsArr);?>
     </div>
    <div class="col-md-6">
    <?php echo $form->field($model, 'status')->dropDownList(array_merge(array('' => ''), Yii::$app->params['reservation_status'])); ?>
     </div>
</div>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?=Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
         <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['reservations/index', "temp" => "clear"]), ['class' => 'btn btn-default clear_button'])?>
    </div>

    <?php ActiveForm::end();?>
</div>

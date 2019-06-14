<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Restaurants;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\modelsReservationsSearch */
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

    <?php //$form->field($model, 'id') ?>

    <?php // $form->field($model, 'first_name') ?>

    <?php // $form->field($model, 'last_name') ?>

    <?php // $form->field($model, 'email') ?>

    <?php // $form->field($model, 'contact_no') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php  echo $form->field($model, 'restaurant_id')->dropDownList(array(''=>'')+Restaurants::RestaurantsDropDown()); ?>

    <?php // echo $form->field($model, 'layout_id') ?>

    <?php // echo $form->field($model, 'table_id') ?>

    <?= $form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd','clientOptions' => ['minDate'=>'0'],'options' => ['readonly'=>'readonly','class'=>'reservation_date']/*, 'clientOptions' => ['minDate'=>'0']*/]) ?>

    <?= $form->field($model, 'booking_start_time')->textInput(["id"=>"booking_start_time"]) ?>

    <?php // echo $form->field($model, 'booking_end_time') ?>

    <?php  echo $form->field($model, 'total_stay_time') ?>

    <?php  echo $form->field($model, 'no_of_guests') ?>

    <?php  echo $form->field($model, 'pickup_drop')->dropDownList(array(''=>'')+Yii::$app->params['pickup_drop_status']); ?>

    <?php // echo $form->field($model, 'pickup_location') ?>

    <?php // echo $form->field($model, 'pickup_lat') ?>

    <?php // echo $form->field($model, 'pickup_long') ?>

    <?php // echo $form->field($model, 'pickup_time') ?>

    <?php // echo $form->field($model, 'drop_location') ?>

    <?php // echo $form->field($model, 'drop_lat') ?>

    <?php // echo $form->field($model, 'drop_long') ?>

    <?php // echo $form->field($model, 'drop_time') ?>

    <?php // echo $form->field($model, 'special_comment') ?>

    <?php  echo $form->field($model, 'status')->dropDownList(array_merge(array(''=>''),Yii::$app->params['reservation_status'])); ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
         <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['reservations/index',"temp"=>"clear"]), ['class' => 'btn btn-default clear_button']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

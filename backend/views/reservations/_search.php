<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Restaurants;
use yii\jui\DatePicker;
use common\models\Tags;
/* @var $this yii\web\View */
/* @var $model common\modelsReservationsSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="reservations-search">
    <?php $form = ActiveForm::begin([
    'action' => ['index','user_id'=>$_GET['user_id']],
    'method' => 'get',
    /* 'options' => [
    'data-pjax' => 1
    ],*/
    ]); ?>
    <?php //$form->field($model, 'id') ?>
    <div class="row">
        <div class="span3"><?= $form->field($model, 'first_name') ?></div>
        <div class="span3"><?= $form->field($model, 'last_name') ?></div>
    </div>
    <div class="row">
        <div class="span3"><?= $form->field($model, 'email') ?></div>
        <div class="span3"><?= $form->field($model, 'contact_no') ?></div>
    </div>
    <?php // echo $form->field($model, 'user_id') ?>
    <div class="row">
        <div class="span3"><?php  echo $form->field($model, 'restaurant_id')->dropDownList(array(''=>'')+Restaurants::RestaurantsDropDown()); ?></div>
        <?php // echo $form->field($model, 'layout_id') ?>
        <?php // echo $form->field($model, 'table_id') ?>
        <div class="span3"><?= $form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd','clientOptions' => ['minDate'=>'0'],'options' => ['readonly'=>'readonly','class'=>'reservation_date']/*, 'clientOptions' => ['minDate'=>'0']*/]) ?></div>
    </div>
    <div class="row">
        <div class="span3"><?= $form->field($model, 'booking_start_time')->textInput(["id"=>"booking_start_time"]) ?></div>
        <?php // echo $form->field($model, 'booking_end_time') ?>
        <div class="span3"><?php  echo $form->field($model, 'total_stay_time') ?></div>
    </div>
    <div class="row">
        <div class="span3"><?php  echo $form->field($model, 'no_of_guests') ?></div>
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
        <div class="span3">
            <?php  $tagsArr = Tags::TagsDropDown(); ?>
            <?= $form->field($model, 'tag_id')->dropDownList(array(""=>"")+$tagsArr); ?>
        </div>
    </div>
    <div class="row">
        <div class="span3"><?php  echo $form->field($model, 'status')->dropDownList(array_merge(array(''=>''),Yii::$app->params['reservation_status'])); ?></div>
    </div>
</div>
<?php // echo $form->field($model, 'created_at') ?>
<?php // echo $form->field($model, 'updated_at') ?>
<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['reservations/index','user_id'=>$_GET['user_id'],"temp"=>"clear"]), ['class' => 'btn btn-default']) ?>
</div>
<?php ActiveForm::end(); ?>
</div>
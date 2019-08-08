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
    <?php
if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
    $form = ActiveForm::begin([

        'action' => ['index', 'user_id' => $_GET['user_id']],
        'method' => 'get',
        /* 'options' => [
    'data-pjax' => 1
    ],*/
    ]);
} else {
    $form = ActiveForm::begin([

        'action' => ['index', 'restaurant_id' => $_GET['restaurant_id']],
        'method' => 'get',
        /* 'options' => [
    'data-pjax' => 1
    ],*/
    ]);
}
?>
    <?php //$form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'user_id') ?>
    <div class="row">
        <div class="span3"><?php echo $form->field($model, 'restaurant_id')->dropDownList(array('' => '') + Restaurants::RestaurantsDropDown()); ?></div>
        <?php // echo $form->field($model, 'floor_id') ?>
        <?php // echo $form->field($model, 'table_id') ?>
        <div class="span3"><?=$form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['readonly' => 'readonly', 'class' => 'reservation_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?></div>
    </div>
    <div class="row">
        <div class="span3"><?=$form->field($model, 'booking_start_time')->textInput(["id" => "booking_start_time"])?></div>
        <?php // echo $form->field($model, 'booking_end_time') ?>
        <div class="span3"><?php echo $form->field($model, 'total_stay_time') ?></div>
    </div>
    <div class="row">
        <div class="span3"><?php echo $form->field($model, 'no_of_guests') ?></div>
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
            <?php $tagsArr = Tags::TagsDropDown();?>
            <?=$form->field($model, 'tag_id')->dropDownList(array("" => "") + $tagsArr);?>
        </div>
    </div>
    <div class="row">
        <div class="span3"><?php echo $form->field($model, 'status')->dropDownList(array_merge(array('' => ''), Yii::$app->params['reservation_status'])); ?></div>
    </div>
</div>
<?php // echo $form->field($model, 'created_at') ?>
<?php // echo $form->field($model, 'updated_at') ?>
<div class="form-group">
    <?=Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary'])?>
    <?php if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {?>
    <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['reservations/index', 'user_id' => $_GET['user_id'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
        <?php } else {?>
             <?=Html::a(Yii::t('app', '<i class="icon-refresh"></i> clear'), Yii::$app->urlManager->createUrl(['reservations/index', 'restaurant_id' => $_GET['restaurant_id'], "temp" => "clear"]), ['class' => 'btn btn-default'])?>
     <?php }?>
</div>
<?php ActiveForm::end();?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
            $('#booking_start_time').timepicker({'disableTextInput': true});
    $('#booking_start_time').on('focus',function(){
        $(this).trigger('blur');
    });
    });
</script>
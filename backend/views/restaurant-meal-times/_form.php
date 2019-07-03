<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\form\ActiveForm;
use kartik\widgets\TimePicker;
//use kartik\icons\FontAwesomeAsset;
//use farystha\widgets\JqueryClockPicker;


/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMealTimes */
/* @var $form yii\widgets\ActiveForm */
//FontAwesomeAsset::register($this);

?>

<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-meal-times-form span12">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'restaurant_id')->textInput() ?>
<?= $form->field($model, 'meal_type')->textInput(['value'=>Yii::$app->params['meal_times'][$model->meal_type],'disabled'=>true]) ?></td>
       
            <div class="input-group clockpicker">
   <?= $form->field($model, 'start_time')->textInput(['class'=>'form-control start_time','value'=>$model->start_time]); ?>
                 <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
       

            <?php //echo $form->field($model, 'start_time')->widget(TimePicker::classname(), []); ?>
            <div class="input-group clockpicker">
   <?= $form->field($model, 'end_time')->textInput(['class'=>'form-control end_time','value'=>$model->end_time]); ?>
                 <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>


   
  
    <?php //echo $form->field($model, 'status')->textInput() ?>

    <?php //echo $form->field($model, 'created_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group form-actions">
         <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['restaurants/update','id'=>$model->restaurant_id]), ['class' => 'btn default','onClick' => 'parent.jQuery.colorbox.close();']) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

<script type="text/javascript">
    jQuery(function($) {
    $('.start_time').timepicker({'disableTextInput': true});
    $('.end_time').timepicker({'disableTextInput': true});
});
</script>
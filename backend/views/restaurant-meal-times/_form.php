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
<table>
    <tr>
        <td><?= $form->field($model, 'meal_type')->textInput(['value'=>Yii::$app->params['meal_times'][$model->meal_type],'disabled'=>true]) ?></td>
        <td> 
            <div class="input-group clockpicker">
   <?= $form->field($model, 'start_time')->textInput(['class'=>'form-control','value'=>$model->start_time,'readonly'=>true]); ?>
                 <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </td>

            <?php //echo $form->field($model, 'start_time')->widget(TimePicker::classname(), []); ?></td>
       <td> 
            <div class="input-group clockpicker">
   <?= $form->field($model, 'end_time')->textInput(['class'=>'form-control','value'=>$model->end_time,'readonly'=>true]); ?>
                 <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </td>
    </tr>

</table>

   
  
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
$('.clockpicker').clockpicker({
    placement: 'bottom',
    align: 'left',
    donetext: 'Done',
    'default': 'now',
     donetext: 'Done'
});
});
</script>
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantWorkingHours */
/* @var $form yii\widgets\ActiveForm */
?>
<style type="text/css">
    tr td {
  padding-right: 10px;
}​
</style>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
<div class="restaurant-working-hours-form span12">

    <?php $form = ActiveForm::begin(); ?>

    <?php //echo $form->field($model, 'restaurant_id')->textInput() ?>
<table>
    


    <?php $week_days = Yii::$app->params['week_days'];
    foreach ($week_days as $key => $value) { ?>
        <tr>
        <td><?= Html::a('24 Hours', ['#'], ['class' => 'btn btn-primary','onclick' => '(function ( $event ) { alert("Button $key clicked"); })();']) ?></td>
        <td><?= Html::checkBox('24hours',[],['label'=>'24hours','id'=>"restaurantworkinghours-24hours-$key hours_$key restaurant_hours",'onclick'=>"calc()"]); ?></td>

        <td><?= $form->field($model, "weekday[$key]")->textInput(['value'=>$value,'disabled'=>true]) ?></td>

        <td><?= $form->field($model, "opening_time[$key]")->textInput() ?></td>

        <td><?= $form->field($model, "closing_time[$key]")->textInput() ?></td>
        
        <td><?= $form->field($model, "status[$key]")->dropDownList(Yii::$app->params['restaurants_working_hours_status']) ?></td>
    </tr>
  <?php   }
     ?>
</table>


    <?php //echo $form->field($model, 'created_by')->textInput() ?>

    <?php //echo $form->field($model, 'updated_by')->textInput() ?>

    <?php //echo $form->field($model, 'created_at')->textInput() ?>

    <?php //echo $form->field($model, 'updated_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
<script type="text/javascript">
    function calc()
    {
    console.log($(this).val());
    }

</script>

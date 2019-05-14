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
div label input {
   margin-right:100px;
}
body {
    font-family:sans-serif;
}

#ck-button {
    margin:4px;
    background-color:#04c;
    border-radius:4px;
    border:1px solid;
    overflow:auto;
    float:left;
    color: #fff;
}

#ck-button label {
    text-align: center;
    width:5.0em;
}

#ck-button label span {
    text-align:center;
    padding:3px 0px;
    display:block;
}

#ck-button label input {
    position:absolute;
    top:-20px;
}

#ck-button input:checked + span {
    background-color:#911;
    color:#fff;
}
#ck-button:hover {
    background:lightgreen;
}
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

       
        <td>   <div id="ck-button">
   <label><?= Html::checkBox('24hours',[],['label'=>'24hours','id'=>"restaurantworkinghours-24hours-$key hours_$key restaurant_hours",'class'=>'fulldayhours','value'=>"hours_$key",'data-id' => "$key"]); ?></label>
</div></td>

        <td><?= $form->field($days, "weekday[$key]")->textInput(['value'=>$value,'disabled'=>true]) ?></td>
        
        <td><div class="input-group clockpicker">
            <?= $form->field($days, "opening_time[$key]")->textInput(['class'=>"form-control opening_time_$key"]) ?>  
            <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </td>
          <td><div class="input-group clockpicker">
            <?= $form->field($days, "closing_time[$key]")->textInput(['class'=>"form-control closing_time_$key"]) ?>  
            <span class="input-group-addon">
                     <span class="glyphicon glyphicon-time"></span>
                </span>
            </div>
        </td>
        
        <td><?= $form->field($days, "status[$key]")->dropDownList(Yii::$app->params['restaurants_working_hours_status']) ?></td>
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
    function calc(cb)
    {
    console.log(cb.checked);
    return false;
    }
    jQuery(function($) {
$('.clockpicker').clockpicker({
    placement: 'bottom',
    align: 'left',
    donetext: 'Done',
    'default': 'now',
     donetext: 'Done'
});
 $('.fulldayhours').change(function() {
        var key = $(this).data('id');
        if($(this).is(':checked')){
            $('.opening_time_'+key).val("00:00");
            $('.closing_time_'+key).val("23:59");
        }else{
           $('.opening_time_'+key).val("");
            $('.closing_time_'+key).val("");
        }
       // if($('[$key]start_date'))
    });
});
</script>

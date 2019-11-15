<?php

use kartik\widgets\SwitchInput;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\Reservations */
/* @var $form yii\widgets\ActiveForm */
?>
  <div class="row">
              <div class="col-lg-12 p-5 reservations-form">
             <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <small>CLOSE </small><span aria-hidden="true">&times;</span>
                </button> --><br>

               <?php $form = ActiveForm::begin();?>
                  <div class="row">
                     <div class="col-md-12">
                        <?php
if ($model->isNewRecord) {
    if ((isset($_GET['rid']) && !empty($_GET['rid']))) {
        $restaurant_id = $_GET['rid'];
        echo $form->field($model, 'restaurant_id')->dropDownList($snRestaurantDropDown, ['value' => $restaurant_id, 'readonly' => "readonly"]);
    } else {

        $restaurant_id = "";
        echo $form->field($model, 'restaurant_id')->dropDownList(array("" => "") + $snRestaurantDropDown, ['value' => !empty($model->restaurant_id) ? $model->restaurant_id : $restaurant_id]);
    }
} else {
    echo $form->field($model, 'restaurant_id')->dropDownList(array("" => "") + $snRestaurantDropDown);
}
?>
                    </div>
                  </div>
               <!--     <div class="row">
                    <div class="col-md-6">
                      <?php //echo $form->field($model, 'first_name')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?php //echo $form->field($model, 'last_name')->textInput() ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <?php //echo $form->field($model, 'email')->textInput() ?>
                    </div>
                     <div class="col-md-6">
                      <?php //echo $form->field($model, 'contact_no')->textInput() ?>
                    </div>
                  </div> -->
                  <div class="row">
                    <div class="col-md-6">
                       <?=$form->field($model, 'date')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'clientOptions' => ['minDate' => '0'], 'options' => ['readonly' => 'readonly', 'class' => 'reservation_date']/*, 'clientOptions' => ['minDate'=>'0']*/])?>
                    </div>
                    <div class="col-md-6">
                    <?=$form->field($model, 'no_of_guests')->textInput()?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                     <?=$form->field($model, 'booking_start_time')->textInput(["id" => "booking_start_time"])?>
                    </div>
                  <!--   <div class="col-md-6">
                     <?php // $form->field($model, 'booking_end_time')->textInput(["id"=>"booking_end_time"]) ?>
                    </div> -->
                  </div>
                   <div class="row">
                    <div class="col-md-6">
                  <?=$form->field($model, 'total_stay_time')->textInput()->hint('Enter time in minutes');?>
                    </div>
                    <div class="col-md-6">
                    <?php //$model->pickup_drop = 1;
echo $form->field($model, 'pickup_drop')->widget(SwitchInput::classname()); ?>
                       <input type="hidden" name="switch_active" id="switch_active">
                    </div>
                  </div>

                   <div class="row pickup_row">
                    <div class="col-md-6">
                  <?=$form->field($model, 'pickup_location')->textInput(['maxlength' => true, 'id' => 'autocomplete'])?>
                    </div>
                    <div class="col-md-6">
                    <?=$form->field($model, 'pickup_time')->textInput(["id" => "pickup_time"])?>
                    </div>
                    <?=$form->field($model, 'pickup_lat')->textInput(["hidden" => "true", 'lattitude'])->label(false);?>
                    <?=$form->field($model, 'pickup_long')->textInput(["hidden" => "true", 'longitude'])->label(false);?>

                  </div>
                   <div class="row pickup_row">
                    <div class="col-md-6">
                    <?=$form->field($model, 'drop_location')->textInput(['maxlength' => true, 'id' => 'autocomplete'])?>
                    </div>
                    <div class="col-md-6">
                      <?=$form->field($model, 'drop_time')->textInput(["id" => "drop_time"])?>
                    </div>
                     <?=$form->field($model, 'drop_lat')->textInput(["hidden" => "true", 'id' => 'lattitude'])->label(false);?>
                    <?=$form->field($model, 'drop_long')->textInput(["hidden" => "true", 'longitude'])->label(false);?>
                  </div>


                  <div class="row">
                    <div class="col-md-6">
                       <?=$form->field($model, 'special_comment')->textarea(['rows' => 6])?>
                    </div>

                    <div class="col-md-6">
                       <?=$form->field($model, 'tag_id[]')->dropDownList(array("" => "") + $tagsArr, [
    'multiple' => 'multiple',
    'class' => 'chosen-select input-md required',
    'value' => $model->tag_id,
]);?>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12 form-group">
                    <?=Html::submitButton($model->isNewRecord ? 'Reserve Now' : 'Update booking', ['class' => 'btn btn-success btn btn-primary btn-lg btn-block'])?>
                    </div>

                  </div>

               <?php ActiveForm::end();?>
              </div>
              </div>
<script type="text/javascript">
$(document).ready(function(){
  if($("#reservations-pickup_drop").prop('checked') == true){
      $(".pickup_row").show();
  }else{
        $(".pickup_row").hide();
  }
});
   $('#reservations-pickup_drop').on('change.bootstrapSwitch', function(e) {
      var switch_active = e.target.checked;

      if(switch_active == true){
        $(".pickup_row").show();
        $("#switch_active").val("1");
      }else{
        $(".pickup_row").hide();
        $("#switch_active").val("0");
       // $('.pickup_row').find('input:text').val('');
      }
  });


</script>
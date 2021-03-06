<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\web\js\common;
use yii\jui\DatePicker;

$this->title = Yii::t('app', 'Edit Restaurant Working Hours: ' . $snRestaurantName);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left users_permission_title"><?= Html::encode($this->title) ?></div>
    </div>

    <div class="portlet-body form block-content collapse in">
        <div class="users-form span12 hours_form">

            <?php $form = ActiveForm::begin(['id' => 'workinghours_form']); ?>
            <?php //Html::checkBox('select_all', false, array('label' => 'Select All', 'class' => 'select_all')) ?>
          
            <?php 
            foreach ($week_days_hours_details as $key => $weekday) { 

                ?>
           <?php  //$user['support_only']=='1'); ?>            
                <?php //  Html::checkBox("user_permissions[user_id][$snUserId]",false,array('label'=>$user['first_name'].' '.$user['last_name']));  ?>
             
                       
                            <div id="ck-button">
                                <label>
                                    <?= $form->field($weekday, "[$key]hours24")->checkbox(['class' => 'fulldayhours', 'data-id' => "$key",'id'=>"restaurantworkinghours-24hours-$key hours_$key restaurant_hours"])->label("24 Hours"); ?>
                                </label>
                            </div>
                     <div class="row">
                        <div class="span3">
                            <?= $form->field($weekday, "[$key]weekday")->textInput(['value'=>Yii::$app->params['week_days'][$key],'disabled'=>true]) ?>
                       </div>

                        <div class="span3">
                              <?= $form->field($weekday, "[$key]opening_time")->textInput(['class'=>"form-control opening_time_$key opening_time_common",'id'=>'opening_time','required'=>"required"]) ?>   
                       </div>
                        <div class="span3">
                            <?php echo $form->field($weekday, "[$key]closing_time")->textInput(['class'=>"form-control closing_time_$key closing_time_common",'id'=>'closing_time',"required"=>"required"]) ?>  
                       </div>
                        <div class="span3">
                            <?= $form->field($weekday, "[$key]status")->dropDownList(Yii::$app->params['restaurants_working_hours_status']) ?>
                       </div>
                   </div>       
            <?php } ?>
        

            <div class="form-group form-actions">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success submitButton'/* , 'onClick' => 'javascript:console.log($(".users-form .userfieldsShow"));return false;' */]) ?>
                <?= Html::a(Yii::t('app', 'Cancel'), 'javascript:void(0)', ['class' => 'btn default btn-success', 'onClick' => 'parent.jQuery.colorbox.close();']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
  
    jQuery(function($) {
    $('.opening_time_common').timepicker({'disableTextInput': true});
    $('.closing_time_common').timepicker({'disableTextInput': true});

 $('.fulldayhours').each(function() {
        var key = $(this).data('id');
        if($(this).is(':checked')){
            $('.opening_time_'+key).val("12:00am");
            $('.closing_time_'+key).val("11:30pm");
            $('.opening_time_'+key).attr({'readonly': true});
            $('.closing_time_'+key).attr({'readonly': true});
        }else{
            $('.opening_time_'+key).attr({'readonly': false});
            $('.closing_time_'+key).attr({'readonly': false});
        }
    });

 $('.fulldayhours').change(function() {
        var key = $(this).data('id');
        if($(this).is(':checked')){
            $('.opening_time_'+key).val("12:00am");
            $('.closing_time_'+key).val("11:30pm");
            $('.opening_time_'+key).attr({'readonly': true});
            $('.closing_time_'+key).attr({'readonly': true});
        }else{
           $('.opening_time_'+key).val("");
            $('.closing_time_'+key).val("");
            $('.opening_time_'+key).attr({'readonly': false});
            $('.closing_time_'+key).attr({'readonly': false});
        }
    });
});
</script>


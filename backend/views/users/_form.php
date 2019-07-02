<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Users */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
        <div class="users-form span12 common_search">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="span3 style_input_width"><?= $form->field($model, 'role_id')->dropDownList($UserRolesDropdown,['class'=>'roles']) ?></div>
                <div class="span3 style_input_width"> <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?></div>
                <div class="span3 style_input_width">
                <?= $model->isNewRecord ? ($form->field($model, 'password')->passwordInput(['maxlength' => 255])) : '' ?>  
            </div>
            </div>
            <div class="row">
                <div class="span3 style_input_width"><?= $form->field($model, 'first_name')->textInput(['maxlength' => 255]) ?></div>
                <div class="span3 style_input_width"><?= $form->field($model, 'last_name')->textInput(['maxlength' => 255]) ?></div>
                <div class="span3 style_input_width"><?= $form->field($model, 'restaurant_id')->dropDownList($Restaurants,['class'=>'restaurants']); ?></div>
            </div>
            <div class="row">
                <div class="span3 style_input_width"><?= $form->field($model, 'address')->textArea(['maxlength' => 255]) ?></div>
                <div class="span3 style_input_width"><?= $form->field($model, 'status')->dropDownList(Yii::$app->params['user_status']);?></div>
            </div>
            <div class="form-group form-actions">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Cancel'), Yii::$app->urlManager->createUrl(['users/index']), ['class' => 'btn default']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){        
        var role_id = $('.roles :selected').val();
            if((role_id == "3") || (role_id == "4")){
            $(".field-users-restaurant_id").show();
            }else{
            $(".field-users-restaurant_id").hide();
            }
            $('.roles').change(function() {
            var key = $(this).val();
            if((key == "3") || (key == "4")){
            $(".field-users-restaurant_id").show();
            }else{
            $(".field-users-restaurant_id").hide();
            
            }
        // if($('[$key]start_date'))
        });
    });

</script>
<?php 
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use common\web\js\common;
$this->title = Yii::t('app', 'Add Total leaves: ' .$oModel['first_name'].' '.$oModel['last_name']);

?>
<div class="pages-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
    <div class="block-content">
		<div class="users-form span12">

    		<?php $form = ActiveForm::begin(['id'=>'add_total_leaves_form']); ?>
  <?= $form->field($oModel,'total_leaves_pending')->textInput(['class'=>'total_leaves_pending_required total_leaves_pending_not_zero']); ?>
    	
     		<div class="form-group form-actions">
     			<input type='hidden' name="id" value="<?= $_GET['id'] ?>">
           		 <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
	        	 <?= Html::a(Yii::t('app', 'Cancel'),'javascript:void(0)', ['class' => 'btn default btn-success','onClick'=>'parent.jQuery.colorbox.close();']) ?>

	        </div>
	   		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">

//START OF VALIDATION OF add_total_leaves_form//
$(document).ready(function(){
var form1 = $('#add_total_leaves_form');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);
    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // focus the last invalid input
        ignore: ":hidden",  // validate all fields including form hidden input
       
        invalidHandler: function (event, validator) { //display error alert on form submit              
            success1.hide();
            error1.show();
           /* $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
            }, 2000);*/
            //Metronic.scrollTo(error1, -200);
        },

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
                $(element).closest('div').find('.help-block').show();
        },

        unhighlight: function (element) { // revert the change done by hightlight
            $(element)
                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                $(element).closest('div').find('.help-block').hide();
        },

        success: function (label) {
            label
                .closest('.form-group').removeClass('has-error'); // set success class to the control group            
        },

        submitHandler: function (form) {
            success1.show();
            error1.hide();
             if ($(form).valid()){
                //To prevent the submit button clicking again & again
                $('button[type=submit]').attr('disabled', true);
                //$("#loading").fadeIn("slow");
                form.submit(); 
            }
           return false;
        }
    });
    // START OF CUSTOM MESSAGES AND VALIDATION FOR create_leave_form//
     $.validator.addMethod("total_leaves_pending_required", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snStartDate = value;
        return snStartDate != '';
      }, "Total Leaves is required");


      /*  $.validator.addMethod("total_leaves_pending_not_zero", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snAllocatedHours = value;
        return snAllocatedHours > 0;
      }, "Total leaves should be not zero");*/
});
//END OF VALIDATION OF add_total_leaves_form//
</script>
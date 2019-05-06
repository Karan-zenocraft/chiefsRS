<?php 
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use common\web\js\common;
$this->title = Yii::t('app', 'QA Approval: ' .$oModel['name']);

?>
<div class="pages-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
     <center><div id="loading" style="display:none;position:center;padding:2px;"><img src="<?php echo Yii::$app->getUrlManager()->getBaseUrl();?>/img/loading.gif" width="64" height="64" /><br>Loading..</div></center>
    <div class="block-content">
		<div class="users-form span12">

    		<?php $form = ActiveForm::begin(['id'=>'send_for_qa_form']); ?>
         <?= $form->field($oModel,'notes')->textArea(['rows' => 8, 'cols' => 50,'class'=>'form-control notes_required'])->label('Add Note'); ?>
    	
     		<div class="form-group form-actions">
     			<input type='hidden' name="mid" value="<?= $_GET['mid'] ?>">
           		 <?= Html::submitButton('Approve', ['class' => 'btn btn-success qa_approval']) ?>
	        	 <?= Html::a(Yii::t('app', 'Cancel'),'javascript:void(0)', ['class' => 'btn default btn-success','onClick'=>'parent.jQuery.colorbox.close();']) ?>

	        </div>
	   		<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){

    var form1 = $('#send_for_qa_form');
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
                 $("#loading").fadeIn("slow");
                form.submit(); 
            }
           return false;
        }
    });
    // START OF CUSTOM MESSAGES AND VALIDATION FOR create_leave_form//
      $.validator.addMethod("notes_required", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var notes = value;
        return notes != '';
      }, "Notes can not be blank");

});

</script>
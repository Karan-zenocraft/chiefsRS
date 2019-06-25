function openColorBox(smWidth, smHeight)
{ 
    smWidth = (smWidth > 0) ? smWidth : "840px";
    smHeight = (smHeight > 0) ? smHeight : "500px";
    $('.colorbox_popup').colorbox({
        //href: urls,
        width: smWidth,
        height: smHeight,
        iframe: true,        
        scrolling: true,
        title:''
    });
}

//fadeout flash message
$(".flash_message").delay(3000).slideUp(500);

 //SELECT ALL CHECKBOXES IN CHECKBOX LIST IN     USERS PERMISSION POP UP    
$('.select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    if($(this).is(':checked')) {
        checkboxes.prop('checked', true);
    } else {
        checkboxes.prop('checked', false);
    }
});

$('.reject_leave').click(function(e){
  if(confirm("Are you sure you want to reject the leave application?")){
    $("#loading").fadeIn("slow");
    }else{
      return false;
    }
});
//Add label for required field identificaiton
/*if($("form .required").size() > 0){
   $("form").prepend('<p class="note">Fields with <span class="required">*</span> are required.</p>');
}*/

// Add required star in all form
//$(".required > label").append('<span class="required">*</span>');
$(document).ready(function(){

    /*console.log(12312312);
  $(".supportOnlyCheckBox").on("load", function() {

        if($(this).is(':checked'))
        { console.log(123);
          $(this).closest('.form-group').next().find('input').addClass('ignoreValidations');
        }
        else
        {
          console.log(123);
          $(this).closest('.form-group').next().find('input').removeClass('ignoreValidations'); 
        }

    });
*/  $('.userCheckbox').change(function() {
        var key = $(this).data('id');
        if($(this).is(':checked')){
            $('.'+key+'-userFields').show();
            $('.'+key+'-supportOnlyDiv').show();
        }else{
            $('.'+key+'-userFields').hide();
            $('.'+key+'-supportOnlyDiv').hide();
        }
       // if($('[$key]start_date'))
    });

$(".userCheckbox").each(function() {
  //console.log($(this).is(':checked'));
  //console.log($(this).closest('.row_user').prev().find('.supportOnlyCheckBox').is(':checked'));
  //return false;
    if($(this).is(':checked') && $(this).closest('.row_user').children('.divSupport').find('.supportOnlyCheckBox').is(':checked'))
    {
      $(this).closest('.row_user').find('input').addClass('ignoreValidations');
    }
    else
    {
      $(this).closest('.row_user').find('input').removeClass('ignoreValidations'); 
    }
});


//If support only checkbox checked add class ignoreValidations ele remove that class//
  $('.supportOnlyCheckBox').change(function() {
    var key = $(this).data('id');
    if($(this).is(':checked'))
    {
      $('.'+key+'-userFields').hide();
      //$(this).closest('.form-group').next().find('input').addClass('ignoreValidations');
    }
    else
    {
      $('.'+key+'-userFields').show();
      //$(this).closest('.form-group').next().find('input').removeClass('ignoreValidations'); 
    }
  });
        //if($(this).is('not:checked')){
    /*START: Validation for edit permission form*/
    var form1 = $('#permission_form');
    var error1 = $('.alert-danger', form1);
    var success1 = $('.alert-success', form1);
    form1.validate({
        errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // focus the last invalid input
        ignore: ".ignoreValidations, :hidden",  // validate all fields including form hidden input and ignoreValidations class
       
        invalidHandler: function (event, validator) { //display error alert on form submit              
            success1.hide();
            error1.show();
            $('html, body').animate({
            scrollTop: $(validator.errorList[0].element).offset().top
            }, 2000);
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
    // START OF CUSTOM MESSAGES AND VALIDATION FOR permission_form//
         $.validator.addMethod("opening_time", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var opening_time = value;
        return opening_time != '';
      }, "Opening Time is required");

        $.validator.addMethod("closing_time", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var opening_time = value;
        return opening_time != '';
      }, "Closing Time is required");
          //}
       // if($('[$key]start_date'))
    //});
     // END OF CUSTOM MESSAGES AND VALIDATION FOR permission_form//

    /*END: Validation for add subquestions form */
/*START: hide end date and no of days fields in half day leave*/


    /*$('#leaves-leave_type').change(function(){
        var leave_type = $('#leaves-leave_type').val();
        if(leave_type == 0.5){
            $('.field-leaves-end_date').hide();
            $('#leaves-end_date').val('');
            $('.field-leaves-no_of_days').hide();
            $('#leaves-no_of_days').val('');

        }else{
            $('.field-leaves-end_date').show();
            $('.field-leaves-no_of_days').show();
        }



    });*/
    /*START: Validation for edit permission form*/
    var form1 = $('#create_leave_form');
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
     $.validator.addMethod("leave_type_required", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snStartDate = value;
        return snStartDate != '';
      }, "Leave Mode is required");

          $.validator.addMethod("leave_type1_required", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snStartDate = value;
        return snStartDate != '';
      }, "Leave Type is required");

         $.validator.addMethod("required_start_date", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snStartDate = value;
        return snStartDate != '';
      }, "Start Date is required");

        $.validator.addMethod("required_end_date", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snEndDate = value;
        return snEndDate != '';
      }, "End Date is required");

        $.validator.addMethod("required_no_of_days", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snAlcHours = value;
        return snAlcHours != '';
      }, "Number of days are required");

         $.validator.addMethod("required_tl_user_id", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snAlcHours = value;
        return snAlcHours != '';
      }, "There is required to select team leader");

        $.validator.addMethod("required_reason", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snAvgHour = value;
        return snAvgHour != '';
      }, "Reason for leave is required");

        $.validator.addMethod("no_of_days_not_zero", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var snAllocatedHours = value;
        return snAllocatedHours > 0;
      }, "Nunmber of days should be not zero");

        //VALIDATION FOR START DATE SHOULD BE GREATER//

          $.validator.addMethod("start_date_not_greater_end_date", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var start_date = $('.start_date').val();
        var end_date = value;
        return end_date >= start_date;
      }, "End date should be greater than or equal to start date");

        $.validator.addMethod("same_month", function(value, element) {
      //If false, the validation fails and the message below is displayed
        var start_date = new Date($('.start_date').val());
        var end_date = new Date(value);
        var snStartDateMonth = start_date.getMonth();
        var startMonth = snStartDateMonth + 1;
        var  snEndDateMonth = end_date.getMonth();
        var EndMonth = snEndDateMonth + 1;
        if(startMonth === EndMonth){
          return true;
        }else{
          return false;
        }
      }, "You can apply leaves only for same month");
});

/*$(document).ready(function(){
    if($.fn.datepicker){
        $.datepicker.setDefaults({maxDate: new Date()});
    }
});*/

<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Restaurants;
use common\models\ContactUs;
$this->title = 'Chiefs RS';
?>
  <div class="col-md-9">
            <?php 
        $url = Yii::getAlias('@web')."/img/logo.png";
        ?>
            <a class="brand" href="#"><img src="<?php echo $url; ?>"></a>
            <h1 class="site-heading site-animate mb-3">Welcome to Chiefs RS reservation System</h1>
            <h2 class="h5 site-subheading mb-5 site-animate">Please book your restaurant now</h2>    
          <form name="search" id="search" method="post" action="<?= Yii::$app->urlManager->createUrl(['site/restaurants']) ?>">
            <p><input type="text" name="search_restaurant" class="search_text site-animate" placeholder="Search for a Restaurant"><a href="javascript:void(0);" onclick="document.getElementById('search').submit();" class="btn btn-outline-white btn-lg site-animate"><i class="fas fa-search" style="text-align:center;"></i> </a></p>
          </form>
          </div>
          <?php if(Yii::$app->user->isGuest){?>
  <div class="form-w3ls col-md-3">

    <ul class="tab-group cl-effect-4">
        <?php

        $signup_active = "";
        $login_active = "";
         if(isset($_REQUEST['hidden']) && !empty($_REQUEST['hidden']) && ($_REQUEST['hidden'] == 'signup')){
          $signup_active = "active";
          $login_active = "";

        }else{
          $signup_active = "";
          $login_active = "active";

        }?>
        <li class="tab login_tab <?php echo $login_active ?>"><a href="#signin-agile">Log In</a></li>
        <li class="tab signup_tab <?php echo $signup_active ?>"><a href="#signup-agile">Join Us</a></li>        
    </ul>

    <div class="tab-content">
        <div id="signin-agile"> 
            <div class="logo">
    <img src="themes/eatwell/images/chief-rs_logo.png" alt="">
  </div>
       <?php 

       $form = ActiveForm::begin(['id' => 'login-form','method'=>'post']); ?>
                <?= $form->field($model, 'email')->textInput(['class'=>'form-control login_email input_field_design','placeholder'=>'Email'/*'onfocus'=>"this.value = '';","onblur"=>"if (this.value == '') {this.value = 'Email';}"*/])->label(false);?>
                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control input_field_design','placeholder'=>'Password'])->label(false); ?>
                <input type="text" name="hidden" value="login" hidden="true">
                <p class="forgot"> <a href="<?= Yii::$app->urlManager->createUrl(['site/request-password-reset']); ?>">Forgot Password?</a> </p>
              
                <div class="form-group">
                    <?= Html::submitButton('Log In', ['class' => 'sign-in','name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
    </div>
    <div id="signup-agile">   

       <?php  //  $model2 = new SignupForm(); 
     $form2 = ActiveForm::begin(['id' => 'form-signup']); ?>
     <?= $form2->field($model2, 'first_name')->textInput(['class'=>'form-control input_field_design','placeholder'=>'First Name'])->label(false); ?>
                    <?= $form2->field($model2, 'last_name')->textInput(['class'=>'form-control input_field_design','placeholder'=>'Last Name'])->label(false); ?>
                    <?= $form2->field($model2, 'email')->textInput(['class'=>'form-control input_field_design','placeholder'=>'Email'])->label(false); ?>

                    <?= $form2->field($model2, 'password')->passwordInput(['class'=>'form-control input_field_design','placeholder'=>'Password'])->label(false); ?>
                      <?= $form2->field($model2, 'confirm_password')->passwordInput(['class'=>'form-control input_field_design','placeholder'=>'Confirm Password'])->label(false); ?>
                   <?= $form2->field($model2, 'contact_no')->textInput(['class'=>'form-control input_field_design','placeholder'=>'Contact Number'])->label(false); ?>
                <input type="text" name="hidden" value="signup" hidden="true">
                  <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'register','form'=>'form-signup','name' => 'signup-button']) ?>
                </div>
        <?php ActiveForm::end(); ?>
    </div> 
    </div> 
</div> <!-- /form -->
<?php } ?>
        </div>
      </div>
    </section>
    <?php
       $url = Yii::getAlias('@web')."/themes/eatwell/images/logo.png";
       ?>
     <div id="social_icons">
           <a href=""><img src="<?= Yii::getAlias('@web')."/themes/eatwell/images/apple.png" ?>" alt="apple logo and link to download on apple app store"></a>
           <a href=""><img src="<?= Yii::getAlias('@web')."/themes/eatwell/images/facebook.png" ?>" alt="facebook"></a>
           <a href=""><img src="<?= Yii::getAlias('@web')."/themes/eatwell/images/twitter.png" ?>" alt="twitter"></a>
           <a href=""><img src="<?= Yii::getAlias('@web')."/themes/eatwell/images/insta.png" ?>" alt="instagram"></a>
       </div>
    <!-- END section -->
     <section class="site-section" id="section-about">
      <div class="container">
        <div class="row">
          <div class="col-md-5 site-animate mb-5">
            <h4 class="site-sub-title">Our Story</h4>
            <h2 class="site-primary-title display-4">Welcome</h2>
            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>

            <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p>
            <p><a href="#" class="btn btn-secondary btn-lg">Learn More About Us</a></p>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-6 site-animate img" data-animate-effect="fadeInRight">
            <img src="themes/eatwell/images/about_img_1.jpg" alt="Free Template by colorlib.com" class="img-fluid">
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->
    
    <!-- END section -->

    <section class="site-section bg-light" id="section-contact">
      <div class="container">
        <div class="row">

          <div class="col-md-12 text-center mb-5 site-animate">
            <h2 class="display-4">Get In Touch</h2>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
  <center><div id="loading" style="display:none;position:center;padding:2px;"><img src="<?php echo ($_SERVER['HTTP_HOST'] == "localhost") ? Yii::getAlias('@web').'../../../common/web/img/loading.gif' : Yii::$app->params['site_url'].'/common/web/img/loading.gif'; ?>" width="64" height="64" /><br>Loading..</div></center>
          <div class="col-md-7 mb-5 site-animate">
           <?php $form = ActiveForm::begin(['id'=>'contact_us','action'=>Yii::$app->urlManager->createUrl("site/contact-us")]); ?>

              <?php $model = new ContactUs(); ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'message')->textarea(['rows' => 10]) ?>
            
            <div class="form-group">
              <?= Html::submitButton(Yii::t('app', 'Send Message'), ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-4 site-animate">
            <p><img src="themes/eatwell/images/about_img_1.jpg" alt="" class="img-fluid"></p>
            <p class="text-black">
              Address: <br> 121 Street, Melbourne Victoria <br> 3000 Australia <br> <br>
              Phone: <br> 90 987 65 44 <br> <br>
              Email: <br> <a href="mailto:info@yoursite.com">info@yoursite.com</a>
            </p>

          </div>
          
        </div>
      </div>
    </section>
   <!--  <div id="map"></div> -->
   <script type="text/javascript">
$('body').on('beforeSubmit', "form#contact_us",function () {
     var form = $(this);
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }
     // submit form
     $.ajax({
          url: form.attr('action'),
          type: 'post',
          data: form.serialize(),
          beforeSend: function(){
             $("#loading").fadeIn("slow");
          },
          success: function (response) {
               // do something with response
              if(response){
                alert("You Email has been sent successfully.");
              }else{
                alert("something Went wrong,Your mail is not sent.");
              }
          },
          complete: function(){
            $("#loading").fadeOut();
      }
     });
     return false;
});
   </script>
  <?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Restaurants;
$this->title = 'Chiefs RS';
?>
   <div id="main-grid">
    <span><button class="display_none"><i class="fas fa-align-justify"></i></button></span>
            <img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/logo.png'?>" alt="logo">
            <p>Welcome to Chiefs RS reservation System.</p>
            <p>Please book your table now.</p>
            <div>
                <input type="search" name="search" id="searchsss" value="Search For a Restaurant or a Location">
                <span><button><i class="fas fa-search" style="opacity: 0.85"></i></button></span>
            </div>
            <div id="authentication">
                <div id="buttons">
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
                    <button id="login_btn" data-active="<?php echo $login_active ?>">log in</button>
                    <button id="register_btn" data-active="<?php echo $signup_active ?>">Join us</button>
                </div>
                <div id="login">
                    <img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/chief-rs_logo.png';?>" alt="chief-rs-main-logo"><br>
                   <!--  <input type="text" name="user_name" id="user_name" placeholder="user name">
                    <p class="display_none_1 validation_error">Email is required </p>
                    <input type="password" name="password" id="password" placeholder="password">
                    <p class="display_none_1 validation_error">Password is required</p>
                    <p><a href="">forgot password</a></p>
                    <button type="submit">log in</button> -->

                      <?php 

       $form = ActiveForm::begin(['id' => 'login-form','method'=>'post']); ?>
                <?= $form->field($model, 'email')->textInput(['class'=>'form-control login_email','placeholder'=>'Email','id'=>'user_name'/*'onfocus'=>"this.value = '';","onblur"=>"if (this.value == '') {this.value = 'Email';}"*/])->label(false);?>
                <?= $form->field($model, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Password','id'=>'password'])->label(false); ?>
                <input type="text" name="hidden" value="login" hidden="true" id="login">
                <p class="forgot"> <a href="<?= Yii::$app->urlManager->createUrl(['site/request-password-reset']); ?>">Forgot Password?</a> </p>
              
                <div class="form-group">
                    <?= Html::submitButton('Log In', ['class' => 'sign-in','name' => 'login-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
                </div>
                <div id="register">
                    <p>Please enter the details below</p>
                          <?php  //  $model2 = new SignupForm(); 
                 $form2 = ActiveForm::begin(['id' => 'form-signup']); ?>
                 <?= $form2->field($model2, 'first_name')->textInput(['class'=>'form-control','placeholder'=>'First Name'])->label(false); ?>
                    <?= $form2->field($model2, 'last_name')->textInput(['class'=>'form-control','placeholder'=>'Last Name'])->label(false); ?>
                    <?= $form2->field($model2, 'email')->textInput(['class'=>'form-control','placeholder'=>'Email'])->label(false); ?>

                    <?= $form2->field($model2, 'password')->passwordInput(['class'=>'form-control','placeholder'=>'Password'])->label(false); ?>
                    <?= $form2->field($model2, 'address')->textArea(['rows' => 2,'class'=>'form-control','placeholder'=>'Address'])->label(false); ?>
                    <input type="text" name="hidden" value="signup" hidden="true" id="signup">
                  <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'register','form'=>'form-signup','name' => 'signup-button']) ?>
                </div>
        <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <div id="social_icons">
            <a href=""><img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/apple.png';?>" alt="apple logo and link to download on apple app store"></a>
            <a href=""><img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/facebook.png';?>" alt="facebook"></a>
            <a href=""><img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/twitter.png';?>" alt="twitter"></a>
            <a href=""><img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/assets/insta.png'?>" alt="instagram"></a>
        </div>
    </section>
    <section class="site-section" id="section-about">
        <div class="container">
            <div class="row">
                <div class="col-md-5 site-animate mb-5">
                    <h4 class="site-sub-title">Our Story</h4>
                    <h2 class="site-primary-title display-4">Welcome</h2>
                    <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there
                        live the blind texts.</p>

                    <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary
                        regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your
                        mouth.</p>
                    <p><a href="#" class="btn btn-secondary btn-lg">Learn More About Us</a></p>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-6 site-animate img" data-animate-effect="fadeInRight">
                    <img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/images/about_img_1.jpg';?>" alt="Free Template by colorlib.com" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
    <section class="site-section bg-light" id="section-contact">
        <div class="container">
            <div class="row">

                <div class="col-md-12 text-center mb-5 site-animate">
                    <h2 class="display-4">Get In Touch</h2>
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and
                                Consonantia, there live the blind texts.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-7 mb-5 site-animate">
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="text" class="form-control" id="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                                placeholder="Write your message"></textarea>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-lg" value="Send Message">
                        </div>
                    </form>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-4 site-animate">
                    <p><img src="<?php echo Yii::getAlias('@web').'/themes/chiefsrs/images/about_img_1.jpg';?>" alt="" class="img-fluid"></p>
                    <p class="text-black">
                        Address: <br> 121 Street, Melbourne Victoria <br> 3000 Australia <br> <br>
                        Phone: <br> 90 987 65 44 <br> <br>
                        Email: <br> <a href="mailto:info@yoursite.com">info@yoursite.com</a>
                    </p>

                </div>

            </div>
        </div>
    </section>
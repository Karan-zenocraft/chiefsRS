 <?php
/* @var $this yii\web\View */
$this->title = 'Chiefs RS';
?>
 <ul class="tab-group cl-effect-4">
        <li class="tab active"><a href="#signin-agile">Log In</a></li>
    <li class="tab"><a href="#signup-agile">Join Us</a></li>        
    </ul>

    <div class="tab-content">
        <div id="signin-agile"> 
            <div class="logo">
    <center><img src="themes/eatwell/images/Chiefs_rs_logo.png" alt=""></center>
  </div>  
 <!--      <form action="#" method="post">
      
        <input type="text" name="user" placeholder="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Name';}" required="required">
        
        <input type="password" name="password" placeholder="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="required">
        
        <p class="forgot"> <a href="#">Forgot Password?</a> </p>
        <input type="submit" class="sign-in" value="Log In">
      </form> -->
       <?php 
        $model = new LoginForm;

       $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'email')->textInput(['class'=>'form-control login_email','placeholder'=>'Email'/*'onfocus'=>"this.value = '';","onblur"=>"if (this.value == '') {this.value = 'Email';}"*/])->label(false);?>
                <?= $form->field($model, 'password')->passwordInput()->label(false); ?>
                <p class="forgot"> <a href="<?= Yii::$app->urlManager->createUrl(['site/request-password-reset']); ?>">Forgot Password?</a> </p>
              
                <div class="form-group">
                    <?= Html::submitButton('Log In', ['class' => 'sign-in']) ?>
                </div>
            <?php ActiveForm::end(); ?>
    </div>
    <div id="signup-agile">   
      <form action="#" method="post">
      
        <input type="text" name="user" placeholder="Your Full Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your Full Name';}" required="required">
        
        <input type="email" name="email" placeholder="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="required">
        
        <input type="password" name="password" placeholder="Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}" required="required">
         <input type="text" name="password" placeholder="Confirm Password" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Confirm Password';}" required="required">
        <input type="text" name="address" placeholder="Address" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Confirm Password';}" required="required">
        
        <input type="submit" class="register" value="Sign up">
      </form>
       <?php    $model2 = new SignupForm();
     $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model2, 'first_name')->label(false); ?>
                <?= $form->field($model2, 'last_name')->label(false); ?>
                <?= $form->field($model2, 'email')->label(false); ?>
                <?= $form->field($model2, 'password')->passwordInput()->label(false); ?>
                <?= $form->field($model2, 'address')->textArea(['maxlength' => 255])->label(false); ?>
                <div class="form-group">
                    <?= Html::submitButton('Sign Up', ['class' => 'register']) ?>
                </div>
        <?php ActiveForm::end(); ?>
    </div> 
    </div><!-- tab-content -->
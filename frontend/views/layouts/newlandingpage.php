<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
//use frontend\assets\StatusAsset;
use common\assets\CommonAppAsset;
use frontend\widgets\Alert;
use common\components\Common;
use yii\bootstrap\ActiveForm;
use common\models\LoginForm;
use frontend\models\SignupForm;
/* @var $this \yii\web\View */
/* @var $content string */
use frontend\assets\StatusAsset;
StatusAsset::register($this);
//CommonAppAsset::register( $this );
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
<head>
    <meta charset="<?php echo Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway" rel="stylesheet">
 <!--    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/open-iconic-bootstrap.min.css">
    <link rel="stylesheet" href="../css/animate.css">
    
    <link rel="stylesheet" href="../css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/owl.theme.default.min.css">

    <link rel="stylesheet" href="../css/icomoon.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href=""> -->
    <!-- <link rel="stylesheet" href="/css/style_1.css"> -->
    
    <script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js" integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH" crossorigin="anonymous"></script>
    
    <title><?php echo Html::encode( $this->title ) ?></title>
  <?php $this->head(); ?>
</head>
<body data-spy="scroll" data-target="#site-navbar" data-offset="200">
     <?php $this->beginBody() ?>
    <nav class="display_none" id="sticky_nav">
        <ul>
             <?php if ( Yii::$app->user->isGuest ) { ?>
            <li class="title_bar_buttons"><a href="#section-home" class="TODO_color_yellow">home</a></li>
            <li class="title_bar_buttons"><a href="#section-about" class="TODO_color_yellow">about</a></li>
            <li class="title_bar_buttons"><a href="#section-contact" class="TODO_color_yellow">contact</a></li>
          <?php }else{ ?>
             <li class="title_bar_buttons"><a href="#section-home" class="TODO_color_yellow">home</a></li>
            <li class="title_bar_buttons"><a href="#section-about" class="TODO_color_yellow">about</a></li>
            <li class="title_bar_buttons"><a href="#section-contact" class="TODO_color_yellow">contact</a></li>
              <li class="title_bar_buttons"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/restaurants']);?>" class="TODO_color_yellow">Restaurants</a></li>
            <li class="title_bar_buttons"><a href="#" class="TODO_color_yellow">Booking History</a></li>
            <li class="title_bar_buttons"><a href="<?= Yii::$app->urlManager->createUrl(['site/logout']); ?>" class="TODO_color_yellow">Logout(<?= Yii::$app->user->identity->first_name ?>),</a></li>
          <?php } ?>
        </ul>
    </nav>
    <section id="first-main-div">
        <header>
            <ul>
                <li class="title_bar_buttons"><a href="#">home</a></li>
                <li class="title_bar_buttons"><a href="#section-about">about</a></li>
                <li class="title_bar_buttons"><a href="#section-contact">contact</a></li>
            </ul>
        </header>
        
           <div class="flash_message">
                    <?php include_once 'flash_message.php'; ?>
                </div><?php echo
                Breadcrumbs::widget( [
                  'links' => isset( $this->params['breadcrumbs'] ) ? $this->params['breadcrumbs'] : [],
                  ] )
                ?><?php //echo Alert::widget() ?><?php echo $content ?>

    <footer class="site-footer site-bg-dark site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 site-animate">
                            <h2 class="site-heading-2">About Us</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Cumque, similique, delectus
                                blanditiis odit expedita amet. Sed labore ipsum vel dolore, quis, culpa et magni autem
                                sequi facere eos tenetur, ex?</p>
                        </div>
                        <div class="col-md-1"></div>
                        <div class="col-md-3 site-animate">
                            <div class="site-footer-widget mb-4">
                                <h2 class="site-heading-2">The Restaurant</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#" class="py-2 d-block">About Us</a></li>
                                    <li><a href="#" class="py-2 d-block">Chefs</a></li>
                                    <li><a href="#" class="py-2 d-block">Events</a></li>
                                    <li><a href="#" class="py-2 d-block">Contact</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2 site-animate">
                            <div class="site-footer-widget mb-4">
                                <h2 class="site-heading-2">Useful links</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#" class="py-2 d-block">Foods</a></li>
                                    <li><a href="#" class="py-2 d-block">Drinks</a></li>
                                    <li><a href="#" class="py-2 d-block">Breakfast</a></li>
                                    <li><a href="#" class="py-2 d-block">Brunch</a></li>
                                    <li><a href="#" class="py-2 d-block">Dinner</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-2 site-animate">
                            <div class="site-footer-widget mb-4">
                                <h2 class="site-heading-2">Useful links</h2>
                                <ul class="list-unstyled">
                                    <li><a href="#" class="py-2 d-block">Foods</a></li>
                                    <li><a href="#" class="py-2 d-block">Drinks</a></li>
                                    <li><a href="#" class="py-2 d-block">Breakfast</a></li>
                                    <li><a href="#" class="py-2 d-block">Brunch</a></li>
                                    <li><a href="#" class="py-2 d-block">Dinner</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row site-animate">
                <div class="col-md-12 text-center">
                    <div class="site-footer-widget mb-4">
                        <ul class="site-footer-social list-unstyled ">
                            <li class="site-animate"><a href="#"><span class="icon-twitter"></span></a></li>
                            <li class="site-animate"><a href="#"><span class="icon-facebook"></span></a></li>
                            <li class="site-animate"><a href="#"><span class="icon-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
                    <div class="col-md-12 text-center">
            <p>&copy; <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved by <a href="<?php echo Yii::getAlias('@web'); ?>" target="_blank">Chiefs RS</a>
          </div>
            </div>
        </div>
    </footer>

<!--     <script src="../javascript/jquery.min.js"></script>
    <script src="../javascript/popper.min.js"></script>
    <script src="../javascript/bootstrap.min.js"></script>
    <script src="../javascript/jquery.easing.1.3.js"></script>
    <script src="../javascript/jquery.waypoints.min.js"></script>
    <script src="../javascript/owl.carousel.min.js"></script>
    <script src="../javascript/jquery.animateNumber.min.js"></script>
    <script src="../javascript/main_1.js"></script>    
    <script src="../javascript/main.js"></script> -->

    <script>
        $(document).ready(function () {
            // Add smooth scrolling to all links
            $("a").on('click', function (event) {

                // Make sure this.hash has a value before overriding default behavior
                if (this.hash !== "") {
                    // Prevent default anchor click behavior
                    event.preventDefault();

                    // Store hash
                    var hash = this.hash;

                    // Using jQuery's animate() method to add smooth page scroll
                    // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 800, function () {

                        // Add hash (#) to URL when done scrolling (default click behavior)
                        window.location.hash = hash;
                    });
                } // End if
            });
        });
    </script>
 <?php $this->endBody(); ?>
  <?php $this->endPage() ?>
</body>
</html>
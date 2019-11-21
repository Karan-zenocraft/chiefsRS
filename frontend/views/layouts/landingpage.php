<?php

use frontend\assets\StatusAsset;
//use frontend\assets\StatusAsset;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */
use yii\widgets\Breadcrumbs;
StatusAsset::register($this);
$this->registerCssFile('@web/themes/chiefsrs/css/landingpage.css', ['depends' => [yii\web\JqueryAsset::className()]]);

//CommonAppAsset::register( $this );
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
        <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
        <title>
            <?php echo Html::encode($this->title) ?>
        </title>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><?php echo Html::csrfMetaTags() ?>
   <!--  <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway" rel="stylesheet"> -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <?php $this->head();?>

<!--
        <style>
        
        #scroll {position:fixed;right:40px;bottom:20px;cursor:pointer;width:40px;height:40px;background-color:transparent;text-indent:-9999px;display:none;-webkit-border-radius:60px;-moz-border-radius:60px;border-radius:6px;border: 1px solid #10303F; }
#scroll:hover{}
#scroll span {position:absolute;top:50%;left:50%;margin-left:-8px;margin-top:-12px;height:0;width:0;border:8px solid transparent;border-bottom-color:#10303F;}
#scroll:hover {background-color:transparent;border-color:#D17C0D;transition: 0.25s ease; opacity:1;filter:"alpha(opacity=100)";-ms-filter:"alpha(opacity=100)";}
#scroll:hover span{border-bottom-color:#D17C0D;transition: 0.25s ease;}

.scrollbar-dusty-grass::-webkit-scrollbar-thumb {border-radius: 10px;-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
background-image: -webkit-linear-gradient(330deg, #FDA403 0%, #020000 100%);background-image: linear-gradient(120deg, #FDA403 0%, #020000 100%); }
.thin::-webkit-scrollbar {width: 6px; }

        </style>
-->
        
    </head>
    <body data-spy="scroll" data-target="#site-navbar" data-offset="200" class="example-1  scrollbar-dusty-grass square thin">
      <?php $this->beginBody()?>
    <nav class="navbar navbar-expand-lg navbar-dark site_navbar bg-dark site-navbar-light" id="site-navbar">
          <?php //NavBar::begin(); ?>
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#site-nav" aria-controls="site-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse" id="site-nav">
          <ul class="navbar-nav ml-auto">
            <?php if (Yii::$app->user->isGuest) {?>
            <li class="nav-item active"><a href="#section-home" class="nav-link">Home</a></li>
            <li class="nav-item"><a href="#section-about" class="nav-link">About</a></li>
            <!-- <li class="nav-item"><a href="#section-menu" class="nav-link">Menu</a></li>
            <li class="nav-item"><a href="#section-news" class="nav-link">News</a></li>
            <li class="nav-item"><a href="#section-gallery" class="nav-link">Gallery</a></li> -->
            <li class="nav-item"><a href="#section-contact" class="nav-link">Contact</a></li>
             <li class="nav-item"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/restaurants']); ?>" class="nav-link list_rest">Restaurants</a></li>
          <?php } else {?>
             <li class="nav-item active"><a href="#section-home" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="#section-about" class="nav-link">About</a></li>
               <li class="nav-item"><a href="#section-contact" class="nav-link">Contact</a></li>
              <li class="nav-item"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/restaurants']); ?>" class="nav-link">Restaurants</a></li>
              <li class="nav-item"><a href="<?php echo Yii::$app->urlManager->createUrl(['reservations/index']); ?>" class="nav-link list_rest">My Reservations</a></li>
            <li class="nav-item"><a href="<?=Yii::$app->urlManager->createUrl(['site/logout']);?>" class="nav-link">Logout(<?=Yii::$app->user->identity->first_name?>)</a></li>
          <?php }?>

          </ul>
        </div>
      </div>
        <?php //NavBar::end(); ?>
    </nav>
       <?php
$url_bg = Yii::getAlias('@web') . "/themes/chiefsrs/images/bg_3.jpg";
?>
      <section class="site-cover" style="background-image: url(<?php echo $url_bg; ?>);" id="section-home">
      <div class="container">
        <div class="row align-items-center site-vh-100">

                <div class="flash_message" style="padding-top:7%">
                    <?php include_once 'flash_message.php';?>
                </div><?php echo
Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?><?php //echo Alert::widget() ?><?php echo $content ?>


<footer class="site-footer site-bg-dark site-section">
      <div class="container">
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
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
          </div>
        </div>
      </div>
    </footer>

    <!-- loader -->
    <div id="site-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
      <?php $this->endBody();?>
      <?php $this->endPage()?>
            
            
            
        </body>
</html>
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
$this->registerCssFile('@web/themes/chiefsrs/css/forgotpassword.css', ['depends'=> [yii\web\JqueryAsset::className()]]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
      <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
        <title>
            <?php echo Html::encode( $this->title ) ?>
        </title>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><?php echo Html::csrfMetaTags() ?>
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700|Raleway" rel="stylesheet">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <?php $this->head(); ?>

    </head>
    <body data-spy="scroll" data-target="#site-navbar" data-offset="200">
      <?php $this->beginBody() ?>
    <nav class="navbar navbar-expand-lg navbar-dark site_navbar bg-dark site-navbar-light nav_list" id="site-navbar">
          <?php //NavBar::begin(); ?>
      <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#site-nav" aria-controls="site-nav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="oi oi-menu"></span> Menu
        </button>

        <div class="collapse navbar-collapse restaurant_nav" id="site-nav">
          <ul class="navbar-nav ml-auto">
           
             <li class="nav-item"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/index']);?>" class="nav-link list_rest">Home</a></li>
              <li class="nav-item"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/restaurants']);?>" class="nav-link list_rest">Restaurants</a></li>
          </ul>
        </div>
      </div>
        <?php //NavBar::end(); ?>    
    </nav>
    
        
               <?php echo
                Breadcrumbs::widget( [
                  'links' => isset( $this->params['breadcrumbs'] ) ? $this->params['breadcrumbs'] : [],
                  ] )
                ?>

                <?php //echo Alert::widget() ?><?php echo $content ?>
        

    <!-- loader -->
    <div id="site-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
      <?php $this->endBody(); ?>
      <?php $this->endPage() ?>
        </body>
</html>
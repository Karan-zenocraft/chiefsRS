<?php

use common\assets\CommonAppAsset;
use common\components\Common;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
CommonAppAsset::register($this);
?><?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?php echo Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1"><?php echo Html::csrfMetaTags() ?>
        <title>
            <?php echo Html::encode($this->title) ?>
        </title><?php $this->head()?>
         <script src="<?php echo Yii::$app->getUrlManager()->getBaseUrl(); ?>/js/jquery-1.11.2.min.js"></script>
    </head>
    <body class="example-1  scrollbar-dusty-grass square thin">
        <?php $this->beginBody()?>
        <div class="wrap">
            <?php
NavBar::begin([
    'brandLabel' => 'Chiefs RS',
    'brandUrl' => Yii::$app->urlManager->createUrl(['site/index']),
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
]);
$menuItems = [];
if (!Yii::$app->user->isGuest) {
    $snUserRoleId = Common::get_user_role(Yii::$app->user->id, $flag = 0);
    if (!empty($snUserRoleId) && $snUserRoleId == "5") {
        $menuItems = [
            ['label' => 'Restaurants', 'url' => ['#']/*,'visible'=> $snUserRoleId != Yii::$app->params['userroles']['qa']*/],
            ['label' => 'Menus', 'url' => ['#'], 'visible' => $snUserRoleId == "2"],
            ['label' => 'Tables', 'url' => ['#']],
            /* ['label' => 'Project Documents', 'url' => ['/project-documents/index']],*/
            // ['label' => 'Leaves', 'url' => ['/leaves/index']],
            ['label' => 'Logout (' . Yii::$app->user->identity->first_name . ')',
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post'],
            ],
        ];
    }
} else {
    $menuItems = [
        ['label' => 'Login',
            'url' => ['/site/index'],
            'linkOptions' => ['data-method' => 'post'],
        ],
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>
            <div class="container">
                <div class="flash_message">
                    <?php include_once 'flash_message.php';?>
                </div><?php echo
Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
])
?><?php //echo Alert::widget() ?><?php echo $content ?>
            </div>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="pull-left">
                    © <?php echo Yii::getAlias('@site_footer') . " " . date('Y'); ?>
                </p>
            </div>
        </footer><?php $this->endBody()?><?php $this->endPage()?>
    </body>
</html>

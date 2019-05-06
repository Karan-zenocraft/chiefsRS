<?php
use frontend\assets\AppAsset;
use common\assets\CommonAppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
CommonAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::getAlias('@site_title'); ?>&nbsp; - &nbsp;<?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="popup_bod">
    <?php  $this->beginBody() ?>

    <div class="container-fluid">
        <div class="row-fluid">
            
                <div class="row-fluid content">
                    <div class="block"><?= $content ?></div>
              
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

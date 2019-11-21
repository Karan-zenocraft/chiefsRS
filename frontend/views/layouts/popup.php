<?php
use common\assets\CommonAppAsset;
use frontend\assets\AppAsset;
use yii\helpers\Html;
/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
CommonAppAsset::register($this);
?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?=Yii::$app->language?>">
<head>
    <link rel="shortcut icon" type="image/png" href="img/favicon.png"/>
    <meta charset="<?=Yii::$app->charset?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?=Html::csrfMetaTags()?>
    <title><?=Yii::getAlias('@site_title');?>&nbsp; - &nbsp;<?=Html::encode($this->title)?></title>
    <?php $this->head()?>
</head>
<body class="popup_bod example-1  scrollbar-dusty-grass square thin">
    <?php $this->beginBody()?>

    <div class="container-fluid">
        <div class="row-fluid">

                <div class="row-fluid content">
                    <div class="block"><?=$content?></div>

            </div>
        </div>
    </div>

    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>

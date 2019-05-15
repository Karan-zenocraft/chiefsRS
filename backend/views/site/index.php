<?php
use yii\helpers\Html;
use common\models\Users;
use common\models\Restaurants;
use common\models\Tags;
use common\models\MenuCategories;
/* @var $this yii\web\View */

$this->title = 'Statistics';
$this->params['breadcrumbs'][] = $this->title;
//$this->params['page']['title'] = "Dashboard";
?>
<div class="site-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
    <div class="block-content collapse in">
    <div class="span3">
        <div class="chart" data-percent="<?= Users::find()->count();?>"><?= Users::find()->count()."%"; ?></div>
        <div class="chart-bottom-heading"><span class="label label-info">Users</span>

        </div>
    </div>
    <div class="span3">
        <div class="chart" data-percent="<?= Restaurants::find()->count();?>"><?= Restaurants::find()->count()."%"; ?></div>
        <div class="chart-bottom-heading"><span class="label label-info">Restaurants</span>

        </div>
    </div>
    <div class="span3">
        <div class="chart" data-percent="<?= Tags::find()->count();?>"><?= Tags::find()->count()."%"; ?></div>
        <div class="chart-bottom-heading"><span class="label label-info">Tags</span>

        </div>
    </div>
    <div class="span3">
        <div class="chart" data-percent="<?= MenuCategories::find()->count(); ?>"><?= MenuCategories::find()->count()."%"; ?></div>
        <div class="chart-bottom-heading"><span class="label label-info">Menu Categories</span>

        </div>
    </div>
    </div>
    <!--div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div-->
</div>
<script>
$(function() {
    // Easy pie charts
    $('.chart').easyPieChart({animate: 1000});
});
</script>
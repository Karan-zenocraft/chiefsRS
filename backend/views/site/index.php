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
            <div class="chart-bottom-heading">
                <span class="label label-info">Users</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?= Restaurants::find()->count();?>"><?= Restaurants::find()->count()."%"; ?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Restaurants</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?= Tags::find()->count();?>"><?= Tags::find()->count()."%"; ?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Tags</span>
            </div>
        </div>
        <div class="span3">
            <div class="chart" data-percent="<?= MenuCategories::find()->count(); ?>"><?= MenuCategories::find()->count()."%"; ?></div>
            <div class="chart-bottom-heading">
                <span class="label label-info">Menu Categories</span>
            </div>
        </div>
    </div>
</div>
<script>
$(function() {
    // Easy pie charts
    $('.chart').easyPieChart({animate: 1000});
});
</script>
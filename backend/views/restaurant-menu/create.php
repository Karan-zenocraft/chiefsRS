<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMenu */

$this->title = "Add Menu - ".$snRestaurantName;
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Menu', 'url' => ['restaurant-menu/index','rid'=>$_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<div class="restaurant-menu-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
        'MenuCategoriesDropdown'=>$MenuCategoriesDropdown
    ]) ?>

</div>

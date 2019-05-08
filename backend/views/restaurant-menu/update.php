<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMenu */

$this->title = 'Update Restaurant Menu: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Menus', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-menu-update email-format-create">
    <?= $this->render('_form', [
        'model' => $model,
        'MenuCategoriesDropdown'=>$MenuCategoriesDropdown
    ]) ?>

</div>

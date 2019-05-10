<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMealTimes */

$this->title = 'Update Restaurant Meal Time: ' . Yii::$app->params['meal_times'][$model->meal_type];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => $model->restaurant->name . ' Restaurant', 'url' => ['restaurants/update', 'id' => $model->restaurant_id]];
$this->params['breadcrumbs'][] = 'Update Meal Time';
?>
<div class="restaurant-meal-times-update email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantMealTimes */

$this->title = 'Create Restaurant Meal Times';
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Meal Times', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-meal-times-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

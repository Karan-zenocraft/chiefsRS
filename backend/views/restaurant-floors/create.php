<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantFloors */

$this->title = 'Create Restaurant Floor';
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Floors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-floors-create email-format-index">

    <?= $this->render('_form', [
        'model' => $model,
        'snRestaurantName' => $snRestaurantName,

    ]) ?>

</div>

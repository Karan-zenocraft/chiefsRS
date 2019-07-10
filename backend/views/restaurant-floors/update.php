<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantFloors */

$this->title = 'Update Restaurant Floor: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Floors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-floor-update email-format-index">

    <?= $this->render('_form', [
        'model' => $model,
      //  'snRestaurantName' => $snRestaurantName,
    ]) ?>

</div>

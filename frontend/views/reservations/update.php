<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */

$this->title = 'Update Reservations: ' . $model->id;
?>
<div class="reservations-update">

 <h1 class="mb-4 reserve_restaurant">Update Booking</h1>  
    <?= $this->render('_form', [
        'model' => $model,
        'snRestaurantDropDown' => $snRestaurantDropDown,
        'tagsArr' => $tagsArr,
    ]) ?>

</div>

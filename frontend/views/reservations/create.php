<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Reservations */
?>
<div class="reservations-create">

   <h1 class="mb-4 reserve_restaurant">Book Restaurant</h1>  

    <?= $this->render('_form', [
        'model' => $model,
        'snRestaurantDropDown' => $snRestaurantDropDown
    ]) ?>

</div>

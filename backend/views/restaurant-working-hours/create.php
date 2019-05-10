<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantWorkingHours */

$this->title = 'Create Restaurant Working Hours';
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Working Hours', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-working-hours-create email-format-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

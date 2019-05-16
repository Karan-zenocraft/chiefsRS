<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantLayout */

$this->title = 'Create Restaurant Layout';
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Layouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-layout-create email-format-index">

    <?= $this->render('_form', [
        'model' => $model,
        'snRestaurantName' => $snRestaurantName,

    ]) ?>

</div>

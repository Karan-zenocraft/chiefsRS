<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantLayout */

$this->title = 'Update Restaurant Layout: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Layouts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-layout-update email-format-index">

    <?= $this->render('_form', [
        'model' => $model,
      //  'snRestaurantName' => $snRestaurantName,
    ]) ?>

</div>

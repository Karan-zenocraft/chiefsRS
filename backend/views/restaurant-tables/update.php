<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTables */

$this->title = 'Update Restaurant Tables: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="restaurant-tables-update email-format-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

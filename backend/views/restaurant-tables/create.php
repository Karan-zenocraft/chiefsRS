<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTables */

$this->title = 'Create Restaurant Tables';
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-tables-create email-format-index">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

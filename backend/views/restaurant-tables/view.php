<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\RestaurantTables */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Restaurant Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="restaurant-tables-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'restaurant_id',
            'floor_id',
            'table_no',
            'name',
            'min_capacity',
            'max_capacity',
            'created_by',
            'updated_by',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

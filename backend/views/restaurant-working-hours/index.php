<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantWorkingHoursSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurant Working Hours';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurant-working-hours-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Restaurant Working Hours', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'restaurant_id',
            'weekday',
            'opening_time',
            'closing_time',
            //'status',
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>

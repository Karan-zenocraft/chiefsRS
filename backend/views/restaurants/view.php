<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Restaurants */

$this->title = "Restaurant Description : ".$model->name;
\yii\web\YiiAsset::register($this);
?>
 <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
 <div class="block-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'name',
            'description:ntext',
            'address:ntext',
            'city',
            'state',
            'country',
            'pincode',
            'lattitude',
            'longitude',
            'website',
            'contact_no',
            'email:email',
            'max_stay_time_after_reservation',
            'status',
           // 'created_at',
            //'updated_at',
        ],
    ]) ?>

</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Users */

$this->title = "User Details : ".$model->first_name." ".$model->last_name;
\yii\web\YiiAsset::register($this);
?>
<div class="users-view">
 <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
 <div class="block-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
          //  'id',
            [
                'label'=>'User Role',
                'value' => Yii::$app->params['userrole_name'][$model->role_id],
            ],
            'email:email',
          //  'password',
            'first_name',
            'last_name',
            'address:ntext',
            [
                'label'=>'status',
                'value' => Yii::$app->params['status'][$model->status],
            ],
          //  'created_at',
           // 'updated_at',
        ],
    ]) ?>

</div>

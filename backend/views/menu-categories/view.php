<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\MenuCategories */

$this->title = "Menu Category Description : ".$model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="menu-categories-view">

<div class="tags-view">
  <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=  $this->title; ?></div>
    </div>
 <div class="block-content">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           //'id',
            'name',
            //'description:ntext',,
             ['attribute'=>'description',
             'value' => function( $model ) {
                        return wordwrap($model->description,40,"<br>\n");
                    }
          //   'value' => wordwrap($model->description,15,"<br>\n"),
             //str_replace(".",":",number_format($model->hours,2))
            ],
             [
                'label'=>'status',
                'value' => Yii::$app->params['status'][$model->status],
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>

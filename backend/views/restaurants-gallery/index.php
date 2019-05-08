<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantsGallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurants Galleries';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];

?>
<div class="restaurants-gallery-index email-format-index">

   <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title).' - '.$snRestaurantName ?>
        </div>
        <div class="pull-right">
            <?php echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurants-gallery/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="block-content">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
          'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'restaurant_id',
            'image_title',
            'image_description:ntext',
            'image_name',
            [
                    'attribute' => 'status',
                    'header' => 'Status',
                    'filter' => Yii::$app->params['status'],
                    'value' => function( $data ) {
                        return Yii::$app->params['status'][$data->status];
                    },
                    'headerOptions' => ["style" => "width:5%;text-align:center;"],
                    'contentOptions' => ["style" => "width:5%;text-align:center;"],
                ],
            //'created_by',
            //'updated_by',
            //'created_at',
            //'updated_at',

           
             [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ["style" => "width:40%;"],
                        'contentOptions' => ["style" => "width:40%;"],
                        'template' => '{update}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                $flag = 1;
                                return Common::template_update_button($url, $model, $flag);
                            },
                            'delete' => function ($url, $model) {
                                $flag = 1;
                                $confirmmessage = "Are you sure you want to delete this this image?";
                                return Common::template_delete_button($url, $model,$confirmmessage, $flag);
                            },
                        ]
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>
   </div>
</div>

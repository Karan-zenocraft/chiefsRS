<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MenuCategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Menu Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-categories-index email-format-index">
 <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
        <div class="pull-right">   
        <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Menu Category'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['menu-categories/index']), ['class' => 'btn btn-primary']) ?>
       </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="block-content">
        <div class="goodtable">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'name',
           [
                    'attribute' => 'description',
                    //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
                    'format' => 'raw',
                    'value' => function( $data ) {
                        $ssText = (!empty($data->description) ) ? $data->description : "";
                        return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox();']);
                    }
            ],
            [
                        'attribute' => 'status',
                        'filter' => Yii::$app->params['status'],
                        'filterOptions' => ["style" => "width:13%;"],
                        'headerOptions' => ["style" => "width:13%;"],
                        'contentOptions' => ["style" => "width:13%;"],
                        'value' => function($data) {
                            return Yii::$app->params['status'][$data->status];
                        },
                    ],
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
                                $confirmmessage = "Are you sure you want to delete this user?";
                                return Common::template_delete_button($url, $model,$confirmmessage, $flag);
                            },
                        ]
            ],
        ],
    ]); ?>

</div>
    </div>
</div>


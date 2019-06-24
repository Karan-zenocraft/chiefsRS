<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantTablesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurant Tables';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Layouts', 'url' => ['restaurant-layout/index','rid'=>$_GET['rid'],'lid'=>$_GET['lid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<div class="restaurant-tables-index email-format-inde">
           <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
        <div class="block-content collapse in">
        <div class="restaurant-tables-form span12">
   
             <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
             <?php if(!empty($_REQUEST['RestaurantTablesSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
                <div class="restaurantss-tables-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
                </div> 
        <?php }else{ ?>
            <div class="restaurant-tables-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div>  
    <?php } ?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title).' - '.$snLayoutName ?>
        </div>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Table'), Yii::$app->urlManager->createUrl(['restaurant-tables/create', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0,'lid'=>( $_GET['lid'] > 0 ) ? $_GET['lid'] : 0]), ['class' => 'btn btn-success colorbox_popup','onclick' => 'javascript:openColorBox(420,580);']) ?>
            <?php  // echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurant-tables/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0,'lid'=>( $_GET['lid'] > 0 ) ? $_GET['lid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="block-content">
    

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
           // 'restaurant_id',
           // 'layout_id',
            'table_no',
            'name',
            'min_capacity',
            'max_capacity',
            //'created_by',
            //'updated_by',
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
                        return Common::template_update_tag_button($url, $model, $flag);
                    },
                    'delete' => function ($url, $model) {
                        $flag = 1;
                        $confirmmessage = "Are you sure you want to delete this Menu Category?";
                        return Common::template_delete_button($url, $model,$confirmmessage, $flag);
                    },
                ]
            ],
        ],
    ]); ?>

</div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {  
    $('.restaurant-tables-serach').hide();
        $('.open_search').click(function(){
            $('.restaurant-tables-serach').toggle();
        });
    });

</script>
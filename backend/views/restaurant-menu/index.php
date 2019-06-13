<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\components\Common;
/* @var $this yii\web\View */
/* @var $searchModel common\models\\RestaurantMenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Restaurant Menu';
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants', 'url' => ['restaurants/index']];
$this->params['breadcrumbs'][] = ['label' => 'Manage Restaurants Menu', 'url' => ['restaurant-menu/index','rid'=>$_GET['rid']]];
$this->params['breadcrumbs'][] = ['label' => $snRestaurantName];
?>
<div class="restaurant-menu-index email-format-index">
    <div class="email-format-index">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left">Search Here</div>
        </div>
        <div class="block-content collapse in">
        <div class="restaurant-menu-form span12">
   
             <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
             <?php if(!empty($_REQUEST['RestaurantMenuSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
                <div class="restaurants-menu-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
                </div> 
        <?php }else{ ?>
            <div class="restaurant-menu-serach common_search">
                 <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div>  
    <?php } ?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left">
            <?php echo Html::encode($this->title).' - '.$snRestaurantName ?>
        </div>
        <div class="pull-right">
            <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Menu'), Yii::$app->urlManager->createUrl(['restaurant-menu/create', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-success']) ?>
            <?php // echo Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['restaurant-menu/index', 'rid' => ( $_GET['rid'] > 0 ) ? $_GET['rid'] : 0]), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <div class="block-content">

    <?php // Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
        'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            //'restaurant_id',
            'name',
            //'description:ntext',
             [
                    'attribute' => 'description',
                    //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
                    'format' => 'raw',
                    'value' => function( $data ) {
                        $ssText = Common::get_substr($data->description,20);
                        return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox(700,650);']);
                    }
            ],
             [
                'attribute' => 'menu_category_id',
                'label' => 'Category',
                'filter' => $MenuCategories,
                'value' => function($data) use($MenuCategories) {
                        return !empty($MenuCategories[$data->menu_category_id]) ? $MenuCategories[$data->menu_category_id] : '';
                    },
            ],
            //'price',
            //'photo',
            //'created_by',
            //'updated_by',
                   [
                    'attribute' => 'status',
                    'header' => 'Status',
                    'filter' => Yii::$app->params['status'],
                    'value' => function( $data ) {
                        return Yii::$app->params['status'][$data->status];
                    },
                    'headerOptions' => ["style" => "width:12%;text-align:center;"],
                    'contentOptions' => ["style" => "width:12%;text-align:center;"],
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
                                $url = Yii::$app->urlManager->createurl(['restaurant-menu/update', 'rid' => $model->restaurant_id, 'id' => $model->id]);
                                return Common::template_update_button($url, $model, $flag);
                            },
                            'delete' => function ($url, $model) {
                                $flag = 1;
                                $url = Yii::$app->urlManager->createurl(['restaurant-menu/delete', 'id' => $model->id, 'rid' => $model->restaurant_id]);

                                $confirmmessage = "Are you sure you want to delete this this image?";
                                return Common::template_delete_button($url, $model,$confirmmessage, $flag);
                            },
                        ]
            ],
        ],
    ]); ?>

    <?php // Pjax::end(); ?>
   </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {  
    $('.restaurant-menu-serach').hide();
        $('.open_search').click(function(){
            $('.restaurant-menu-serach').toggle();
        });
    });

</script>

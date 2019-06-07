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
      <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">
   
     <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
     <?php if(!empty($_REQUEST['MenuCategoriesSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
        <div class="menu-categoriess-serach">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div> 
<?php }else{ ?>
    <div class="menu-categories-serach">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div>  
    <?php } ?>
</div>
</div>
</div>
 <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
  <!--       <div class="pull-right">   
        <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Menu Category'), ['create'], ['class' => 'btn btn-success colorbox_popup','onclick' => 'javascript:openColorBox();']) ?>
       </div> -->
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="block-content">
        <div class="goodtable">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
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
                        $ssText = Common::get_substr($data->description,20);
                        return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox(600,500);']);
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
    $('.menu-categories-serach').hide();
        $('.open_search').click(function(){
            $('.menu-categories-serach').toggle();
        });
    });

</script>
<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = ' Manage Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-index email-format-index">
        <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="users-form span12">
   
     <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
     <?php if(!empty($_REQUEST['UsersSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
        <div class="userss-serach common_search">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div> 
<?php }else{ ?>
    <div class="users-serach common_search">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div>  
    <?php } ?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
        <div class="pull-right">            
            <?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add User'), ['create'], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '<i class="icon-refresh"></i> Reset'), Yii::$app->urlManager->createUrl(['users/index']), ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="block-content">
        <div class="goodtable">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => null,
                //'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='col-md-5 col-sm-12'><div class='row1'>{summary}</div></div>\n<div class='col-md-7 col-sm-12'><div class='row'>{pager}</div></div>",
                'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
                'columns' => [
              [
                    'attribute' => 'fullName',
                    'label' => 'Name',
                    //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
                    'format' => 'raw',
                    'value' => function( $data ) {
                        $ssText = (!empty($data->first_name) && !empty($data->last_name) ) ? $data->first_name." ".$data->last_name : "";
                        return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox();']);
                    }
                ],
                   /* [
                        'attribute' => 'last_name',
                        'filterOptions' => ["style" => "width:10%;"],
                        'headerOptions' => ["style" => "width:10%;"],
                        'contentOptions' => ["style" => "width:10%;"],
                    ],*/
                    'email:email',
                    [
                        'attribute' => 'role_id',
                        'header' => 'Role',
                        'filter' => $UserRolesDropdown,
                        'filterOptions' => ["style" => "width:17%;"],
                        'headerOptions' => ["style" => "width:17%;"],
                        'contentOptions' => ["style" => "width:17%;"],
                        'value' => function($data) use($UserRolesDropdown) {
                            return !empty($UserRolesDropdown[$data->role_id]) ? $UserRolesDropdown[$data->role_id] : '';
                        },
                    ],
                 /*   [
                    'attribute' => 'address',
                    'filter' => $DepartmentDropdown,
                    'value' => function($data) use($DepartmentDropdown) {
                            return !empty($DepartmentDropdown[$data->address]) ? $DepartmentDropdown[$data->address] : '';
                        },
                    ],*/
                    [
                        'attribute' => 'status',
                        'filter' => Yii::$app->params['user_status'],
                        'filterOptions' => ["style" => "width:13%;"],
                        'headerOptions' => ["style" => "width:13%;"],
                        'contentOptions' => ["style" => "width:13%;"],
                        'value' => function($data) {
                            return Yii::$app->params['user_status'][$data->status];
                        },
                    ],
                    [
                        'header' => 'Actions',
                        'class' => 'yii\grid\ActionColumn',
                        'headerOptions' => ["style" => "width:40%;"],
                        'contentOptions' => ["style" => "width:40%;"],
                        'template' => '{update}{manage_reservations}{delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                $flag = 1;
                                return Common::template_update_button($url, $model, $flag);
                            },
                              'manage_reservations' => function ($url, $model) {
                                $title = "Manage Reservations";
                                $flag =4;
                                $url = Yii::$app->urlManager->createUrl(['reservations/index', 'user_id' => $model->id]);
                                return Common::template_view_gallery_button($url, $model,$title,$flag);
                                
                            },
                            'delete' => function ($url, $model) {
                                $flag = 1;
                                $confirmmessage = "Are you sure you want to delete this user?";
                                return Common::template_delete_button($url, $model,$confirmmessage, $flag);
                            },

                        ]
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
$( document ).ready(function() {  
    $('.users-serach').hide();
        $('.open_search').click(function(){
            $('.users-serach').toggle();
        });
    });

</script>
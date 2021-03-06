<?php

use common\components\Common;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RestaurantsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Restaurants';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="restaurants-index email-format-index">
      <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="tags-form span12">

     <?=Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'), "javascript:void(0);", ['class' => 'btn btn-primary open_search']);?>
     <?php if (!empty($_REQUEST['RestaurantsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] == "clear")) {?>
        <div class="restaurantss-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
<?php } else {?>
    <div class="restaurants-serach common_search">
         <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    <?php }?>
</div>
</div>
</div>
<div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?=Html::encode($this->title)?></div>
        <?php $user_role = Common::get_user_role(Yii::$app->user->id, $flag = 0);
if ($user_role != Yii::$app->params['userroles']['manager']) {?>

        <div class="pull-right">
        <?=Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Restaurant'), ['create'], ['class' => 'btn btn-success'])?>
       </div>
<?php }
?>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
  <div class="block-content">
        <div class="goodtable">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => null,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

        // 'id',
        [
            'attribute' => 'name',
            //  'filter' => Yii::$app->params['status'],
            'filterOptions' => ["style" => "width:16%;text-align:center;"],
            'headerOptions' => ["style" => "width:16%;text-align:center;"],
            'contentOptions' => ["style" => "width:16%;text-align:center;"],
            'value' => function ($data) {
                return $data->name;
            },
        ],
        [
            'attribute' => 'description',
            //'visible'=>( !empty( $_GET['tid'] ) ) ? false : true,
            'format' => 'raw',
            'value' => function ($data) {
                $ssText = Common::get_substr($data->description, 20);
                return Html::a($ssText, ['view', 'id' => $data->id], ['class' => 'colorbox_popup', 'onclick' => 'javascript:openColorBox(700,650);']);
            },
        ],
        //  'description:ntext',
        [
            'attribute' => 'address',
            //  'filter' => Yii::$app->params['status'],
            'filterOptions' => ["style" => "width:25%;text-align:center;"],
            'headerOptions' => ["style" => "width:25%;text-align:center;"],
            'contentOptions' => ["style" => "width:25%;text-align:center;"],
            'value' => function ($data) {
                return $data->address;
            },
        ],
        //'city',
        //'state',
        [
            'attribute' => 'country',
            //  'filter' => Yii::$app->params['status'],
            'filterOptions' => ["style" => "width:10%;text-align:center;"],
            'headerOptions' => ["style" => "width:10%;text-align:center;"],
            'contentOptions' => ["style" => "width:10%;text-align:center;"],
            'value' => function ($data) {
                return $data->country;
            },
        ],
        //'pincode',
        //'lattitude',
        //'longitude',
        [
            'attribute' => 'website',
            //  'filter' => Yii::$app->params['status'],
            'filterOptions' => ["style" => "width:10%;text-align:center;"],
            'headerOptions' => ["style" => "width:10%;text-align:center;"],
            'contentOptions' => ["style" => "width:10%;text-align:center;"],
            'value' => function ($data) {
                return $data->website;
            },
        ],
        'contact_no',
        //'email:email',
        'max_stay_time_after_reservation',
        [
            'attribute' => 'status',
            'filter' => Yii::$app->params['status'],
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                return Yii::$app->params['status'][$data->status];
            },
        ],
        [
            'attribute' => 'status',
            'filter' => Yii::$app->params['status'],
            'format' => 'raw',
            'filterOptions' => ["style" => "width:13%;"],
            'headerOptions' => ["style" => "width:13%;"],
            'contentOptions' => ["style" => "width:13%;"],
            'value' => function ($data) {
                $url = "#";
                $status = ($data->status == 1) ? "true" : "false";
                $class = ($data->status == 1) ? "switch2" : "";
                return Html::a('<label class="switch"><input type="checkbox" value="' . $status . '" onclick="switchoff_restaurant(' . $data->id . ');" id="' . $data->id . '" class="' . $class . '"><span class="slider round"></span></label>', $url);
            },
        ],

        //'created_at',
        //'updated_at',

        [
            'header' => 'Actions',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ["style" => "width:40%;"],
            'contentOptions' => ["style" => "width:40%;"],
            'template' => '{update}{manage_working_hours}{manage_gallery}{manage_menu}{manage_layout}{manage_reservations}{delete}',
            'buttons' => [
                'update' => function ($url, $model) {
                    $flag = 1;
                    return Common::template_update_button($url, $model, $flag);
                },
                'delete' => function ($url, $model) {
                    $flag = 1;
                    $confirmmessage = "Are you sure you want to delete this Restaurant?";
                    return Common::template_delete_button($url, $model, $confirmmessage, $flag);
                },
                'manage_gallery' => function ($url, $model) {
                    $title = "Manage Gallery";
                    $flag = 2;
                    $url = Yii::$app->urlManager->createUrl(['restaurants-gallery/index', 'rid' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                'manage_menu' => function ($url, $model) {
                    $title = "Manage Menu Items";
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['restaurant-menu/index', 'rid' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                'manage_working_hours' => function ($url, $model) {
                    $title = "manage Restaurant's Working Hours";
                    $flag = 1;
                    $url = Yii::$app->urlManager->createUrl(['restaurants/update-workinghours', 'rid' => $model->id]);
                    return Common::template_update_permission_button($url, $model, $title, $flag);

                },
                'manage_layout' => function ($url, $model) {
                    $title = "manage Restaurant's Layout";
                    $flag = 3;
                    $url = Yii::$app->urlManager->createUrl(['restaurant-floors/index', 'rid' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },
                'manage_reservations' => function ($url, $model) {
                    $title = "Manage Reservations";
                    $flag = 4;
                    $url = Yii::$app->urlManager->createUrl(['reservations/index', 'restaurant_id' => $model->id]);
                    return Common::template_view_gallery_button($url, $model, $title, $flag);

                },

            ],
        ],
    ],
]);?>
 </div>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
    $('.restaurants-serach').hide();
        $('.open_search').click(function(){
            $('.restaurants-serach').toggle();
        });
    });
/*function switchoff_restaurant(id){
      $("#"+id).toggleClass("switch2");
   if ($("#"+id).is(':checked')) {
   $("#"+id).attr('value', 'true');
      $.ajax({
     url: "restaurants/switchoff-restaurant",
     type: 'post',
     dataType: 'json',
     data: {
               checked: true,
               restaurant_id:id,
           },
     success: function (data) {
      if(data == "success"){
       alert("success");
       return false;
      }else if(data=="reported"){
        alert("You have already reported this question");
        location.reload();
      }else{
        alert("something went wrong");
      }
     }
  });
 } else {
   $("#"+id).attr('value', 'false');
         $.ajax({
     url: "restaurants/switchoff-restaurant",
     type: 'post',
     dataType: 'json',
     data: {
               checked: false,
               restaurant_id:id,
           },
     success: function (data) {
      if(data == "success"){
       alert("success");
        location.reload();
      }else if(data=="error"){
        alert("Something went wrong");
         location.reload();
      }
     }
  });
 }
//document.getElementById(id).checked = false;
}*/




/*   $(document).ready(function(){
 $("input").click(function(){
   $("input").toggleClass("switch2");
   if ($(this).is(':checked')) {
   $(this).attr('value', 'true');
 } else {
   $(this).attr('value', 'false');
 }
//      if ($(this).hasClass('switch2')) {
//    $(this).attr('value', 'true');
//  } else {
//    $(this).attr('value', 'false');
//  }
 });
});*/
function switchoff_restaurant(id){
      $("#"+id).toggleClass("switch2");
   if ($("#"+id).val() == "true") {
   $("#"+id).attr('value', 'false');
      $.ajax({
     url: "restaurants/switchoff-restaurant",
     type: 'post',
     dataType: 'json',
     data: {
               checked: false,
               restaurant_id:id,
           },
     success: function (data) {
      if(data == "success"){
         alert("Restaurant is inactive for reservations.");
        location.reload();
      }else if(data=="error"){
        alert("Something went wrong");
         location.reload();
      }
     }
  });
 } else {
   $("#"+id).attr('value', 'true');
         $.ajax({
     url: "restaurants/switchoff-restaurant",
     type: 'post',
     dataType: 'json',
     data: {
               checked: true,
               restaurant_id:id,
           },
     success: function (data) {
      if(data == "success"){
       alert("Restaurant is active for the reservations now");
        location.reload();
      }else if(data=="error"){
        alert("Something went wrong");
         location.reload();
      }
     }
  });
 }
//document.getElementById(id).checked = false;
}
</script>



<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\modelContactUsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contact us Management');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact-us-index email-format-index">
        <div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left">Search Here</div>
    </div>
        <div class="block-content collapse in">
        <div class="contact-us-form span12">
   
     <?= Html::a(Yii::t('app', '<i class="icon-filter icon-white"></i> Filter'),"javascript:void(0);", ['class' => 'btn btn-primary open_search']); ?>
     <?php if(!empty($_REQUEST['ContactUsSearch']) || (!empty($_GET['temp']) && $_GET['temp'] =="clear")){ ?>
        <div class="contact-uss-serach common_search">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div> 
<?php }else{ ?>
    <div class="contact-us-serach common_search">
         <?php  echo $this->render('_search', ['model' => $searchModel]); ?>   
        </div>  
    <?php } ?>
</div>
</div>
</div>
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
    </div>
   
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="block-content">
        <div class="goodtable">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => null,
         'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

          //  'id',
            'name',
            'email:email',
            'message:ntext',

          //  ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
     </div>
    </div>
</div>
    <?php Pjax::end(); ?>

<script type="text/javascript">
$( document ).ready(function() {  
    $('.contact-us-serach').hide();
        $('.open_search').click(function(){
            $('.contact-us-serach').toggle();
        });
    });
</script>

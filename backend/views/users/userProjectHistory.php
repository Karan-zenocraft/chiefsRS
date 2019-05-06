<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\grid\GridView;
use common\components\Common;
use common\models\UserProjects;
use yii\helpers\ArrayHelper;
use common\models\Clients;
use common\models\Users;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = Yii::t( 'app', 'User Project History' );
$this->params['breadcrumbs'][] = ['label' => 'Manage users', 'url' => ['users/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-projects-index email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?php echo Html::encode( $this->title ) ?></div>
        <div class="pull-right">
            <?php echo Html::a( Yii::t( 'app','Back' ), Yii::$app->urlManager->createUrl( ['users/index'] ), ['class' => 'btn btn-default'] ) ?>
            <?php echo Html::a( Yii::t( 'app', '<i class="icon-refresh"></i> Reset' ), Yii::$app->urlManager->createUrl( ['users/get-user-project-history','id'=>$_GET['id']] ), ['class' => 'btn btn-primary'] ) ?>
        </div>


    </div>
        <div class="block-content">
        <div class="goodtable">

    <?php echo GridView::widget( [
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'rowOptions' => function ( $data ) {
        $color = Common::get_css_class_by_date_diff( $data->end_date );
        if ( !empty( $color ) ) {
            return ['class'=> $color];
        }else {
            return [];
        }
    },
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='margin-top-10'>{summary}</div>\n<div class='dataTables_paginate paging_bootstrap pagination'>{pager}</div>",

    'columns' => [
    ['class' => 'yii\grid\SerialColumn',
    'filterOptions' => ["style" => "width:4%;"],
    'headerOptions' => ["style" => "width:4%;text-align:center;"],
    'contentOptions' => ["style" => "width:4%;text-align:center;"]
    ],
/*    [
    'attribute' => 'department_name',
    'format'=>'raw',
   // 'filter' => $amDepartmentDropdown,
    'filterOptions' => ["style" => "width:5%;"],
    'headerOptions' => ["style" => "width:5%;"],
    'contentOptions' => ["style" => "width:5%;"],
    'value'=> function( $data ) {
        return !empty( $data->user->department0 ) ? $data->user->department0->name : '-';
    },
    ],
    [
    'attribute' => 'project_id',
    'filterOptions' => ["style" => "width:15%;"],
    'headerOptions' => ["style" => "width:20%;"],
    'contentOptions' => ["style" => "width:20%;"],
    'format'=>'raw',
    'value'=> function( $data ) {
        return !empty( $data->project->name ) ? $data->project->name : '-';
    },
    ],
    [
    'attribute' => 'client_name',
    'filterOptions' => ["style" => "width:15%;"],
    'headerOptions' => ["style" => "width:20%;"],
    'contentOptions' => ["style" => "width:20%;"],
    'format'=>'raw',
    'value'=> function( $data ) {
        return !empty( $data->project->clientName ) ? $data->project->clientName->name : '-';
    },
    ],*/
    [
    'attribute' => 'department_name',
    'format'=>'raw',
    'filter' => $amDepartmentDropdown,
    'filterOptions' => ["style" => "width:10%;"],
    'headerOptions' => ["style" => "width:15%;"],
    'contentOptions' => ["style" => "width:15%;"],
    'value'=> function( $data ) {
        return !empty( $data->department_name ) ? $data->department_name : '-';
    },
    ],
    [
    'attribute' => 'project_id',
    'filterOptions' => ["style" => "width:15%;"],
    'headerOptions' => ["style" => "width:20%;"],
    'contentOptions' => ["style" => "width:20%;"],
    'format'=>'raw',
    'value'=> function( $data ) {
        return !empty( $data->project->name ) ? $data->project->name : '-';
    },
    ],
    [
    'attribute' => 'client_name',
    'filter'         => ArrayHelper::map(Clients::find()->select(['id','name'])->groupBy('id')->asArray()->all(), 'id', 'name'),
    'filterOptions' => ["style" => "width:15%;"],
    'headerOptions' => ["style" => "width:20%;"],
    'contentOptions' => ["style" => "width:20%;"],
    'format'=>'raw',
    'value'=> function( $data ) {
        return !empty( $data->project->clientName ) ? $data->project->clientName->name : '-';
    },
    ],
     [
    'attribute' => 'tl_name',
    'label' => 'TL',
    'filter'    => ArrayHelper::map( Users::find()->where( "(role_id = '".Yii::$app->params['userroles']['admin']."' OR role_id = '".Yii::$app->params['userroles']['super_admin']."') AND company = 'INHERITX' AND status = '1'" )->orderBy( 'first_name' )->asArray()->all(), 'id', function( $user ) {
                        return $user['first_name'].' '.$user['last_name'];
                    } ),

    'filterOptions' => ["style" => "width:15%;"],
    'headerOptions' => ["style" => "width:20%;"],
    'contentOptions' => ["style" => "width:20%;"],
    'format'=>'raw',
    'value'=> function( $data ) {
        return !empty( $data->project->handledBy ) ? $data->project->handledBy->first_name.' '.$data->project->handledBy->last_name : '-';
    },
    ],
    ['attribute'=>'start_date',
    'format' => 'raw',
    'headerOptions' => ["style" => "width:11%;text-align:center;"],
    'contentOptions' => ["style" => "width:11%;text-align:center;"],
    'filter' => DatePicker::widget( [
        'model' => $searchModel,
        'attribute' => 'start_date',
        'language' => 'en',
        'dateFormat' => 'yyyy/MM/dd',
        'options' => ['class' => 'form-control']
        ] ),
    'value' => function( $data ) {
        return !empty( $data->start_date ) ? date( 'Y/m/d', strtotime( $data->start_date ) ) : '-';
    }
    ],
    ['attribute'=>'end_date',
    'format' => 'raw',
    'headerOptions' => ["style" => "width:11%;text-align:center;"],
    'contentOptions' => ["style" => "width:11%;text-align:center;"],
    'filter' => DatePicker::widget( [
        'model' => $searchModel,
        'attribute' => 'end_date',
        'language' => 'en',
        'dateFormat' => 'yyyy/MM/dd',
        ] ),
    'value' => function( $data ) {
        //$color = Common::get_css_class_by_date_diff($data->end_date,$data->id);
        //return Html::tag('span', $data->end_date, ['style'=>'background-color:'.$color.';']);
        //return Html::tag('span', $data->end_date, ['class'=>$color]);
        return !empty( $data->end_date ) ? date( 'Y/m/d', strtotime( $data->end_date ) ) : '-';
    },
    ],
    /* ['attribute'=>'allocated_hours',
              'value' => function($data) {
                    $snHours = Common::display_hours($data->allocated_hours);
                    return $snHours;
                     //return str_replace(".",":",number_format($data->hours,2));
                },

            ],
            ['attribute'=>'avg_hours',
              'value' => function($data) {
                    $snHours = Common::display_hours($data->avg_hours);
                    return $snHours;
                     //return str_replace(".",":",number_format($data->hours,2));
                },

            ],*/
    ],
    ] ); ?>

 </div>
    </div>
</div>

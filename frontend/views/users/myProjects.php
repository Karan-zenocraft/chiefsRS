    <?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-projects-index">

      <div class="pull-right">
            <?php echo Html::a( Yii::t( 'app', '<i class="icon-refresh"></i> Reset' ), Yii::$app->urlManager->createUrl( ['/users/my-projects'] ), ['class' => 'btn btn-primary'] ) ?>
        </div>
    <h1><?php echo Html::encode( $this->title ) ?></h1>
    <?php echo
GridView::widget( [
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => "<div class='table-scrollable'>{items}</div>\n<div class='col-md-5 col-sm-12'><div class='row'>{summary}</div></div>\n<div class='col-md-7 col-sm-12'><div class='row'>{pager}</div></div>",
    'columns' => [
    ['class' => 'yii\grid\SerialColumn'],
    [
    'attribute' => 'name',
    //'header' => 'Project Name',
    'format'=>'raw',
    'value' => function( $data ) {
        return Html::a( $data->name, ['users/project-detail', 'id' => $data->id], ['class'=>'colorbox_popup', 'onclick'=>'javascript:openColorBox();'] );
    }
    ],
    [
    'attribute' => 'status',
    'filter' => Yii::$app->params['project_status'],
    'value' => function( $data ) {
        return Yii::$app->params['project_status'][$data->status];
    },
    ],
  [
    'header' => 'Actions',
    'class' => 'yii\grid\ActionColumn',
    'headerOptions' => ["style" => "width:25%;text-align:center;"],
    'contentOptions' => ["style" => "width:15%;text-align:center;"],
    'template' => '{milestone}{view_documents}',
    'visible'=> Common::get_user_role(Yii::$app->user->id) != Yii::$app->params['userroles']['qa'],
    'buttons' => [
    'milestone' => function( $url, $model ) {
        return Html::a( 'View Milestones', Yii::$app->urlManager->createUrl( ['users/milestones', 'id' => $model->id] ), [
            'title' => Yii::t( 'yii', 'View Milestones' ),
            'class' => 'view_milestones',
            ] );
    },
    'view_documents' => function ( $url, $model ) {
         return Html::a( 'View Documents', Yii::$app->urlManager->createUrl( ['project-documents/index', 'id' => $model->id] ), [
            'title' => Yii::t( 'yii', 'View Documents' ),
            ] );
    },
    ]
    ],
    [
    'header' => 'Actions',
    'class' => 'yii\grid\ActionColumn',
    'headerOptions' => ["style" => "width:25%;text-align:center;"],
    'contentOptions' => ["style" => "width:15%;text-align:center;"],
    'template' => '{milestone}{view_documents}',
    'visible'=> Common::get_user_role(Yii::$app->user->id) == Yii::$app->params['userroles']['qa'],
    'buttons' => [
    'view_documents' => function ( $url, $model ) {
         return Html::a( 'View Documents', Yii::$app->urlManager->createUrl( ['project-documents/index', 'id' => $model->id] ), [
            'title' => Yii::t( 'yii', 'View Documents' ),
            ] );
    },
    ]
    ]
    ],
    ] );
?>

</div>

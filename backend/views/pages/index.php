<?php

use yii\helpers\Html;
use yii\grid\GridView;

use common\components\Common;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Manage Pages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="email-format-index">
    <div class="navbar navbar-inner block-header">
        <div class="muted pull-left"><?= Html::encode($this->title) ?></div>
        <div class="pull-right"><?= Html::a(Yii::t('app', '<i class="icon-plus"></i> Add Page'), ['create'], ['class' => 'btn btn-success']) ?></div>
    </div>
    <div class="block-content">
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],                
                'page_title',
                 'status',
                [
                    'header' => 'Actions',
                    'class' => 'yii\grid\ActionColumn',
                    'headerOptions' => ["style" => "width:20%;"],
                    'template' => '{update}{delete}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return Common::template_update_button($url, $model);
                        },
                        'delete' => function ($url, $model) {
                            return Common::template_delete_button($url, $model);
                        },
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>
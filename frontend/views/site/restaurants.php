<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Restaurants;
use common\components\Common;
use yii\widgets\Pjax;
$this->title = 'Chiefs RS';
?>    
         <?php Pjax::begin(['id' => 'gallery_r','timeout'=>100000,'enablePushState' => false,
        'clientOptions' => ['method' => 'POST']]); ?>
    <section class="site-section bg-light" id="section-news">
      <div class="container">

        <div class="row">
          <div class="col-md-12 text-center mb-5 site-animate">
            <h2 class="display-4">Restaurants</h2>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
 <?php if(!empty($models)){ 
          $count = 0;
          foreach ($models as $key => $restaurant) { ?>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="media d-block mb-4 text-center site-media site-animate">
              <img src="<?php echo Yii::getAlias('@web')."../../../uploads/".$restaurant->photo?>" alt="<?= $restaurant->photo;?>" class="img-fluid r_list">
              <div class="media-body p-md-5 p-4">
                <h5 class="mt-0 h4"><?php echo !empty($restaurant->name) ? $restaurant->name : "-"; ?></h5>
                <p class="mb-4"><?php echo !empty($restaurant->description) ? Common::get_substr($restaurant->description,70) : "-"; ?></p>

                    <p class="mb-0">
                <!--   <a href="<?php //echo Yii::$app->urlManager->createUrl(['site/restaurant-details',"rid"=>$restaurant->id]) ?>" class="btn btn-primary btn-sm">Read More</a> -->
                </p>
                <p class="mb-0">
                  <a onclick="window.open ('http://localhost<?php echo Yii::$app->urlManager->createUrl(['site/restaurant-details',"rid"=>$restaurant->id]) ?>', ''); return false" href="javascript:void(0);" class="btn btn-primary btn-sm">Read More</a>
                </p>
              </div>
            </div>
          </div>
        <?php } 
      } ?>
        </div>
      </div>
    </section>
          <?php echo \yii\widgets\LinkPager::widget([
            'pagination' => $pagination,
           // 'options' => ['class' => 'pagination r_list'],
            ]);
             Pjax::end();
        ?>
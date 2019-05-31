<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Restaurants;
use common\components\Common;
$this->title = 'Chiefs RS';
?>

    <section class="site-section bg-light" id="section-offer">
    <div class="title_restaurant">Restaurants</div>
      <div class="container">
        
        <div class="row">
          <div class="col-md-12 text-center mb-5 site-animate">
            <!-- <h4 class="site-sub-title">Our Offers</h4>
            <h2 class="display-4">Our Offer This Summer</h2> -->
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="owl-carousel site-owl">
                <?php 
        if(!empty($Restaurants)){ 
          $count = 0;
          foreach ($Restaurants as $key => $restaurant) { ?>
              <div class="item">
                <div class="media d-block mb-4 text-center site-media site-animate border-0 restaurant_image">
                  <img src="<?php echo Yii::getAlias('@web')."../../../uploads/".$restaurant->photo?>" alt="Free Template by colorlib.com" class="img-fluid">
                  <div class="media-body p-md-5 p-4">
                  <!--   <h5 class="text-primary">$19.50</h5> -->
                    <h5 class="mt-0 h4"><?php echo !empty($restaurant->name) ? $restaurant->name : "-"; ?></h5>
                    <p class="mb-4"><?php echo !empty($restaurant->description) ? Common::get_substr($restaurant->description,70) : "-"; ?></p>

                    <p class="mb-0"><a href="<?php echo Yii::$app->urlManager->createUrl(['site/restaurant-details',"rid"=>$restaurant->id]) ?>" class="btn btn-primary btn-sm">Read More</a></p>
                  </div>
                </div>
              </div>
                <?php $count++;
                if($count>=3)
                  {
                    echo "</div></div><div class='col-md-12'><div class='owl-carousel site-owl'>";
                    $count=0;
                  }

               ?>
        <?php }
          }
         ?>

         <!--    </div>
          </div> -->
          
        </div>
      </div>
    </section>
		
      
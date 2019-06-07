<?php
use common\models\RestaurantMenu;
use yii\widgets\Pjax;
?>
<div class="container">
  <div class="row align-items-center site-vh-100">
    <div class="col-md-12">
      <?php
      $url = Yii::getAlias('@web')."/img/chiefs-rs-text.png";
      ?>
      <!--   <a class="brand" href="#"><img src="<?php echo $url; ?>" width="35%" height="35%"></a> -->
      <h1 class="site-heading site-animate mb-3"><?= !empty($snRestaurantsDetail) ? $snRestaurantsDetail->name : "-" ?></h1>
      <h2 class="h5 site-subheading mb-5 site-animate">Please book our restaurant now</h2>
      <?php if(Yii::$app->user->isGuest){ ?>
      <p>For Booking Restaurant <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="btn btn-secondary btn-lg book_restaurant">Register Now</a></p>
    <?php }else{ ?>
       <p><a href="<?= Yii::$app->urlManager->createUrl(['users/book']) ?>" class="btn btn-secondary btn-lg book_restaurant">Book Now</a></p>
    <?php } ?>
    </div>
   <!--  <div class="col-md-8">
      <?php// p($snRestaurantWorkingHoursArr); ?>
        <h1 class="site-heading site-animate mb-3"><?php // !empty($snRestaurantWorkingHoursArr) ? $snRestaurantWorkingHoursArr : "-" ?></h1>
      <h2 class="h5 site-subheading mb-5 site-animate">Please book our restaurant now</h2>
      <p>Restaurants Meal Time</p>
    </div> -->
    
  </div>
</section>
<section class="site-section section_details" id="section-about">
  <div class="container">
    <div class="row">
      <div class="col-md-5 site-animate mb-5">
        <h4 class="site-sub-title">Our Story</h4>
        <h2 class="site-primary-title display-4">Welcome</h2>
        <p><?= !empty($snRestaurantsDetail->description) ? $snRestaurantsDetail->description : "No contents found."  ?></p>
        <!--  <p class="mb-4">A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a paradisematic country, in which roasted parts of sentences fly into your mouth.</p> -->
      </div>
      <div class="col-md-1"></div>
      <div class="col-md-6 site-animate img" data-animate-effect="fadeInRight">
        <img src="<?= ($snRestaurantsDetail->photo) ? Yii::getAlias('@web')."../../../uploads/".$snRestaurantsDetail->photo : "No image uploaded"?>" alt="chiefsRS" class="img-fluid" style="width:100%;height: 60vh">
      </div>
    </div>
  </div>
</section>
<section class="site-section section_details" id="section-time">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-5 site-animate">
        <h2 class="display-4">Our Working Times </h2>
      </div>
      
      <div class="col-md-12 text-center">
        <ul class="nav site-tab-nav nav-pills mb-5" id="pills-tab" role="tablist">
          <li class="nav-item site-animate">
            <a class="nav-link days active" id="pills-days-tab" data-toggle="pill" href="#pills-days" role="tab" aria-controls="pills-days" aria-selected="true">Working Times</a>
          </li>
            <li class="nav-item site-animate">
            <a class="nav-link meals" id="pills-meals-tab" data-toggle="pill" href="#pills-meals" role="tab" aria-controls="pills-meals" aria-selected="true">Working MealTimes</a>
          </li>
        </ul>
        <div class="tab-content text-left">
               <div class="tab-pane fade days show active" id="pills-days" role="tabpanel" aria-labelledby="pills-days-tab">
            <div class="row">
               <div class="col-md-12">
        <div style="overflow-x:auto;" class="working_times">
            <table class="table_times">
                <?php //p($snRestaurantWorkingHoursArr,0);
                echo "<tr><th>Time</th>";
                foreach ($snRestaurantWorkingHoursArr as $key => $value) {
                echo "<th>".Yii::$app->params['week_days'][$value->weekday]."</th>";
                }
                echo "</tr><tr><td>Opening Time</td>";
                foreach ($snRestaurantWorkingHoursArr as $key => $value) {
                  echo "<td>".$value->opening_time."</td>";
                }
                echo "</tr><td>Closing Time</td>";
                 foreach ($snRestaurantWorkingHoursArr as $key => $value) {
                  echo "<td>".$value->closing_time."</td>";
                }
                 echo "</tr>";
                ?>
            </table>
        </div>
      </div>
            </div>
          </div>
          <div class="tab-pane fade meals" id="pills-meals" role="tabpanel" aria-labelledby="pills-meals-tab">
            <div class="row">
          <div class="col-md-12">
        <div style="overflow-x:auto;" class="working_times">
            <table class="table_times">
                <?php // p($snRestaurantMealTimesArr);
                echo "<tr><th>Time</th>";
                foreach ($snRestaurantMealTimesArr as $key => $value) {
                echo "<th>".Yii::$app->params['meal_times'][$value->meal_type]."</th>";
                }
                echo "</tr><tr><td>Start Time</td>";
                foreach ($snRestaurantMealTimesArr as $key => $value) {
                  echo "<td>".$value->start_time."</td>";
                }
                echo "</tr><td>End Time</td>";
                 foreach ($snRestaurantMealTimesArr as $key => $value) {
                  echo "<td>".$value->end_time."</td>";
                }
                 echo "</tr>";
                ?>
            </table>
        </div>
      </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="site-section section_details" id="section-menu">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-5 site-animate">
        <h2 class="display-4">Delicious Menu</h2>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
      </div>
      
      <div class="col-md-12 text-center">
        <ul class="nav site-tab-nav nav-pills mb-5" id="pills-tab" role="tablist">
          <?php
          if(!empty($snRestaurantMenuCategoryArr)){
          foreach ($snRestaurantMenuCategoryArr as $key => $category) { ?>
          <li class="nav-item site-animate">
            <a class="nav-link <?= (strtolower($category->name) == "breakfast") ? 'active' : '' ?>" id="pills-<?= strtolower($category->name)?>-tab" data-toggle="pill" href="#pills-<?= strtolower($category->name)?>" role="tab" aria-controls="pills-<?= strtolower($category->name);?>" aria-selected="true"><?= $category->name;?></a>
          </li>
          <?php }
          }
          ?>
        </ul>
        <div class="tab-content text-left">
          <?php
          if(!empty($snRestaurantMenuCategoryArr)){
          foreach ($snRestaurantMenuCategoryArr as $key => $category) { ?>
          <div class="tab-pane fade <?= (strtolower($category->name) == "breakfast") ? 'show active' : '' ?>" id="pills-<?= strtolower($category->name)?>" role="tabpanel" aria-labelledby="pills-<?= strtolower($category->name)?>-tab">
            <div class="row">
              
              <?php
              $breakfastMenu =  RestaurantMenu::find()->where(['restaurant_id'=>$_REQUEST['rid'],'menu_category_id'=>$category->id,'status'=>"1"])->all();
              //  p($breakfastMenu);
              if(!empty($breakfastMenu)){
              foreach ($breakfastMenu as $key_menu => $menu) { ?>
              <div class="col-md-6 site-animate">
                <div class="media menu-item">
                  <img class="mr-3" src="<?php echo Yii::getAlias('@web')."/../../uploads/".$menu->photo; ?>" class="img-fluid" alt="chiefsRS">
                  <div class="media-body">
                    <h5 class="mt-0"><?= !empty($menu->name) ? $menu->name : ""?></h5>
                    <p><?= !empty($menu->description) ? $menu->description : ""?></p>
                    <h6 class="text-primary menu-price"><?= !empty($menu->price) ? "$".$menu->price : ""?></h6>
                  </div>
                </div>
              </div>
              <?php
              }
              }
              ?>  
            </div>
          </div>
          <?php }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- END section -->
 <?php
      Pjax::begin(['id' => 'gallery_r','timeout'=>100000]); ?>
<section class="site-section section_details" id="section-gallery">
  <div class="container">
    <div class="row site-custom-gutters">
      <div class="col-md-12 text-center mb-5 site-animate">
        <h2 class="display-4">Gallery</h2>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
          </div>
        </div>
      </div>
      <div id="categories"></div>
    

<?php if (!empty($models)) {
      foreach ($models as $key => $image) {
          ?>
          <div class="col-md-4 site-animate">
              <a href="<?php echo Yii::getAlias('@web') . "../../../uploads/" . $image->image_name; ?>" class="site-thumbnail image-popup">
                  <img src="<?php echo Yii::getAlias('@web') . "../../../uploads/" . $image->image_name; ?>" alt="chiefsRS" class="img-fluid" style="width:80%;height:50vh;" title="<?= $image->image_title; ?>">
              </a>
          </div>
      <?php
      }
}
?>
    </div>
  </div>
</section>
  <?php  echo \yii\widgets\LinkPager::widget([
        'pagination' => $pagination,
    ]);

    Pjax::end();?>
<!-- END section -->
<section class="site-section section_details bg-light" id="section-contact">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center mb-5 site-animate">
        <h2 class="display-4">Get In Touch</h2>
        <div class="row justify-content-center">
          <div class="col-md-7">
            <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
            <p class="text-black">
              <?php
              if(!empty($snRestaurantsDetail)){ ?>
              Address: <br><?= $snRestaurantsDetail->address; ?><br>
              Phone: <br><?= $snRestaurantsDetail->contact_no; ?><br> <br>
              Email: <br> <a href="mailto:<?= $snRestaurantsDetail->email; ?>"><?= $snRestaurantsDetail->email; ?></a>
              <?php } ?>
            </p>
          </div>
        </div>
      </div>
      <!--   <div class="col-md-7 mb-5 site-animate">
        <form action="" method="post">
          <div class="form-group">
            <label for="name" class="sr-only">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="email" class="sr-only">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="message" class="sr-only">Message</label>
            <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="Write your message"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" class="btn btn-primary btn-lg" value="Send Message">
          </div>
        </form>
      </div> -->
      
    </div>
  </div>
</section>
<div id="map"></div>
<?php// p($snRestaurantsDetail); ?>
<input type="hidden" name="lat" id="lat" value="<?= $snRestaurantsDetail->lattitude; ?>">
<input type="hidden" name="long" id="long" value="<?= $snRestaurantsDetail->longitude; ?>">
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBvpANF446OIBFdLaqozAf-lheEZ__oVVg&libraries=geometry"></script>
 <!--  <script type="text/javascript">
  $.pjax.reload({container: '#gallery_r'});
</script> -->
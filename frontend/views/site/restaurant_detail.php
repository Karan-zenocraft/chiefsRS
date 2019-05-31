 <div class="container">
        <div class="row align-items-center site-vh-100">
             <div class="col-md-12">
            <?php 
        $url = Yii::getAlias('@web')."/img/chiefs-rs-text.png";
        ?>
          <!--   <a class="brand" href="#"><img src="<?php echo $url; ?>" width="35%" height="35%"></a> -->
            <h1 class="site-heading site-animate mb-3"><?= !empty($snRestaurantsDetail) ? $snRestaurantsDetail->name : "-" ?></h1>
            <h2 class="h5 site-subheading mb-5 site-animate">Please book our restaurant now</h2>
              <p><a href="<?= ( Yii::$app->user->isGuest) ? Yii::$app->urlManager->createUrl(['site/index']) : Yii::$app->urlManager->createUrl(['users/book'])  ?>" class="btn btn-secondary btn-lg">Book Now</a></p>
          </div>
         
        </div>
      </section>
<section class="site-section" id="section-about">
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

    <section class="site-section" id="section-menu">
      <div class="container">
        <div class="row">
          <div class="col-md-12 text-center mb-5 site-animate">
            <h2 class="display-4">Delicious Menu</h2>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Look at this mouth watering delicious menu of our Restaurant</p>
              </div>
            </div>
          </div>

          <div class="col-md-12 text-center">

            <ul class="nav site-tab-nav nav-pills mb-5" id="pills-tab" role="tablist">
              <li class="nav-item site-animate">
                <a class="nav-link active" id="pills-breakfast-tab" data-toggle="pill" href="#pills-breakfast" role="tab" aria-controls="pills-breakfast" aria-selected="true">Breakfast</a>
              </li>
              <li class="nav-item site-animate">
                <a class="nav-link" id="pills-lunch-tab" data-toggle="pill" href="#pills-lunch" role="tab" aria-controls="pills-lunch" aria-selected="false">Lunch</a>
              </li>
              <li class="nav-item site-animate">
                <a class="nav-link" id="pills-dinner-tab" data-toggle="pill" href="#pills-dinner" role="tab" aria-controls="pills-dinner" aria-selected="false">Dinner</a>
              </li>
            </ul>

            <div class="tab-content text-left">
              <div class="tab-pane fade show active" id="pills-breakfast" role="tabpanel" aria-labelledby="pills-breakfast-tab">
                <div class="row">
                  <div class="col-md-6 site-animate">
                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$24.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$14.50</h6>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6 site-animate">
                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$12.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$18.50</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-lunch" role="tabpanel" aria-labelledby="pills-lunch-tab">
                <div class="row">
                  <div class="col-md-6 site-animate">

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$14.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$24.50</h6>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6 site-animate">

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$18.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$12.50</h6>
                      </div>
                    </div>

                    
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="pills-dinner" role="tabpanel" aria-labelledby="pills-dinner-tab">
                <div class="row">
                  <div class="col-md-6 site-animate">

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$24.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$14.50</h6>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6 site-animate">

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Fried Potato w/ Garlic</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$18.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Italian Sauce Mushroom</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$35.50</h6>
                      </div>
                    </div>

                    <div class="media menu-item">
                      <img class="mr-3" src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="img-fluid" alt="chiefsRS">
                      <div class="media-body">
                        <h5 class="mt-0">Salted Fried Chicken</h5>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                        <h6 class="text-primary menu-price">$12.50</h6>
                      </div>
                    </div>

                    
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section bg-light" id="section-news">
      <div class="container">

        <div class="row">
          <div class="col-md-12 text-center mb-5 site-animate">
            <h2 class="display-4">News</h2>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="media d-block mb-4 text-center site-media site-animate">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/offer_1.jpg" alt="chiefsRS" class="img-fluid">
              <div class="media-body p-md-5 p-4">
                <h5 class="mt-0 h4">We Have Dilecious Food</h5>
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>

                <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="media d-block mb-4 text-center site-media site-animate">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/offer_2.jpg" alt="chiefsRS" class="img-fluid">
              <div class="media-body p-md-5 p-4">
                <h5 class="mt-0 h4">Chef Special Menu</h5>
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>

                <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="media d-block mb-4 text-center site-media site-animate">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/offer_3.jpg" alt="chiefsRS" class="img-fluid">
              <div class="media-body p-md-5 p-4">
                <h5 class="mt-0 h4">Merriage Celebrations</h5>
                <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>

                <p class="mb-0"><a href="#" class="btn btn-primary btn-sm">Read More</a></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section" id="section-gallery">
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

          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>
          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>
          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>

          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_2.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>
          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_3.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>
          <div class="col-md-4 site-animate">
            <a href="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" class="site-thumbnail image-popup">
              <img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/menu_1.jpg" alt="chiefsRS" class="img-fluid">
            </a>
          </div>

        </div>
      </div>
    </section>
    <!-- END section -->

    <section class="site-section bg-light" id="section-contact">
      <div class="container">
        <div class="row">

          <div class="col-md-12 text-center mb-5 site-animate">
            <h2 class="display-4">Get In Touch</h2>
            <div class="row justify-content-center">
              <div class="col-md-7">
                <p class="lead">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
              </div>
            </div>
          </div>

          <div class="col-md-7 mb-5 site-animate">
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
          </div>
          <div class="col-md-1"></div>
          <div class="col-md-4 site-animate">
            <p><img src="<?php echo Yii::getAlias('@web') ?>/themes/eatwell/images/about_img_1.jpg" alt="" class="img-fluid"></p>
            <p class="text-black">
              Address: <br> 121 Street, Melbourne Victoria <br> 3000 Australia <br> <br>
              Phone: <br> 90 987 65 44 <br> <br>
              Email: <br> <a href="mailto:info@yoursite.com">info@yoursite.com</a>
            </p>

          </div>
          
        </div>
      </div>
    </section>
    <div id="map"></div>
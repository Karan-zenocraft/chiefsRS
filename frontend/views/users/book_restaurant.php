<?php

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
      <p>For Booking Restaurant <a href="<?= Yii::$app->urlManager->createUrl(['site/index']) ?>" class="btn btn-secondary btn-lg">Register Now</a></p>
    <?php }else{ ?>
       <p><a href="<?= Yii::$app->urlManager->createUrl(['users/book']) ?>" class="btn btn-secondary btn-lg book_restaurant">Book Now</a></p>
    <?php } ?>
    </div>
    
  </div>
</section>
          <section class="site-section" id="section-about">
              <div class="col-lg-12 p-5">
             <!--    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <small>CLOSE </small><span aria-hidden="true">&times;</span>
                </button> --><br>
                <h1 class="mb-4">Reserve Restaurant</h1>  
                <form action="#" method="post">
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="m_fname">First Name</label>
                      <input type="text" class="form-control" id="m_fname">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="m_lname">Last Name</label>
                      <input type="text" class="form-control" id="m_lname">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="m_email">Email</label>
                      <input type="email" class="form-control" id="m_email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="m_people">How Many People</label>
                      <select name="" id="m_people" class="form-control">
                        <option value="1">1 People</option>
                        <option value="2">2 People</option>
                        <option value="3">3 People</option>
                        <option value="4+">4+ People</option>
                      </select>
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="m_phone">Phone</label>
                      <input type="text" class="form-control" id="m_phone">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="m_date">Date</label>
                      <input type="text" class="form-control" id="m_date">
                    </div>
                    <div class="col-md-6 form-group">
                      <label for="m_time">Time</label>
                      <input type="text" class="form-control" id="m_time">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="m_message">Message</label>
                      <textarea class="form-control" id="m_message" cols="30" rows="7"></textarea>
                    </div>
                  </div>
                  
                  <div class="row">
                    <div class="col-md-12 form-group">
                      <input type="submit" class="btn btn-primary btn-lg btn-block" value="Reserve Now">
                    </div>
                  </div>

                </form>
              </div>
            </section>
     
         
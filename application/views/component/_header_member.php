<header class="masthead text-center text-white d-flex">
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <h1 class="text-uppercase">
              <strong>
              <?php echo"Welcome dear {$user_name}";?>
              </strong>
            </h1>
            <hr>
          </div>
          <div class="col-lg-8 mx-auto">
            <p class="text-faded mb-5">
                &nbsp;
            </p>
            <?php
              $home_url = site_url("users/u/");
              $cur_url = current_url();
              $lnProfile = site_url("profile/u/");

                //echo"The link is {$lnProfile}";
            ?>
            <a class="btn btn-primary btn-xl js-scroll-trigger" href="<?php echo $lnProfile;?>" style="color:white;">My Profile</a>
          </div>
        </div>
      </div>
    </header>

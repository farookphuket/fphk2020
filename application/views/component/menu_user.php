<!-- Navigation -->
<?php

  $home_url = site_url("users/u");
  $cur_url = current_url();

  $about = "#about";
  $booking = "#my_booking";
  $post = "#my_post";
  if($cur_url != $home_url):
    $about = $home_url."#about";
    $booking = $home_url."#my_booking";
    $post = $home_url."#my_post";
  endif;

?>
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">
			<?php echo $sysName;?>
		</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">

            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo $home_url;?>">Home</a>
            </li>



            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo $about;?>">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo $booking;?>">My Booking</a>
            </li>

            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo $post;?>">My Post</a>
            </li>

            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>



            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#portfolio">Portfolio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="<?php echo site_url("users/logout");?>">Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

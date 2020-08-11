<!-- Last edit 28-july-2019 9:02 a.m. -->
<?php

  $home_url = site_url("mod/");
  $cur_url = current_url();

  $tour = site_url("tour");
  $user = site_url("users");
  $article = site_url("article");

?>
<nav class="navbar  navbar-expand-md navbar-dark bg-primary fixed-left">
<button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#admin_menu" aria-controls="admin_menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="admin_menu">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $home_url;?>">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $tour;?>">Manage Tour</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $article;?>">Manage Article</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo $user;?>">Manage User</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?php echo site_url("users/logout");?>">Logout</a>
      </li>
    </ul>
  </div>

</nav>

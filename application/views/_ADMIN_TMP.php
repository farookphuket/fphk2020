<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    $head_tag = "component/_tag_in_head.php";
    $this->load->view($head_tag);

    $admin_nav = site_url("public/css/admin_nav.css");
  ?>
  <link rel="stylesheet" href="<?php echo $admin_nav;?>" />
</head>
<body id="page-top">
  <?php
      $menu_left = "component/menu_admin.php";
      $this->load->view($menu_left);
  ?>
  <div class="status"></div>
  <div class="container">
    <?php $this->load->view($subview); ?>
  </div>



</body>
</html>

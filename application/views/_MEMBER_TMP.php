<?php
  require("page_head.php");
?>

  <body id="page-top">
    <div class="status">

    </div>
    <?php
      $menu = "component/menu_user.php";
      $this->load->view($menu);
    ?>

    <!--header start-->
    <?php

        $home_url = site_url("users/u");
        $cur_url = current_url();
        $header = "component/_header_member.php";

        if($cur_url == $home_url):
          $this->load->view($header);
        endif;
    ?>
    <!--end of header-->


      <?php $this->load->view($subview); ?>


<!--
    Mon/19/Nov/2018
    Call the require footer _tmp_ file
    -->
    <?php
  $page_tail = "component/_tmp_tail.php";
  $this->load->view($page_tail);
 ?>

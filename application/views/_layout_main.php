<?php
  require("page_head.php");
?>

  <body id="page-top">
	  <!-- Login with facebook 11-Apr-2020 -->
	  <div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=193320751737674&autoLogAppEvents=1"></script>


      <div class="status">

      </div>
    <?php
        $menu = "component/menu_default";
        if($is_login):
            
            $menu = "component/menu_user";
            if($is_admin):
                
                $menu = "component/menu_admin";
            endif;
        endif;

            $this->load->view($menu);
    ?>

    <!--header start-->
    <?php
        $header = "component/header_default.php";
        
        $about_main = "component/_about_main";
        
        $home_url = site_url();
        $cur_url = current_url();

        if($home_url == $cur_url):
          $this->load->view($header);
          $this->load->view($about_main);
        endif;

        //$chk_browser = "component/_browser_not_support.php";
        //$this->load->view($chk_browser);
        $g_search = "component/_google_search";
        $this->load->view($g_search);
    ?>

      <?php $this->load->view($subview); ?>



<!--
    Mon/19/Nov/2018
    Call the require footer _tmp_ file
    -->
    <?php
    $visit = "visitor/visitor_index.php";
    $this->load->view($visit);

  $page_tail = "component/_tmp_tail.php";
  $this->load->view($page_tail);

   ?>
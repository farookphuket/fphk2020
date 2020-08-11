<?php $this->load->view("page_head");?>
<body>
<?php 
    
    $menu_mod = "component/menu_mod";
    /*
    if(!$this->session->userdata("is_login")):
        $menu = "There is no menu";

    endif;
    */
    $is_login = $this->session->userdata("is_login");
    $moderate = $this->session->userdata("moderate");
    if($is_login && $moderate):
        $menu = $menu_mod;
    endif;
   
       
   $this->load->view($menu);
?>
<div class="container-fluid" id="container">
    <div class="status">
        <!--status element will be show after run the javascript command
            this element will be hidden by default
        -->
        Status Page
    </div>    
<?php 
$this->load->view($subview);
?>
<!--start modal area-->

<!--end modal-->
    


    
</div><!--end of div#container-->
<?php 

require("component/page_tail.php");


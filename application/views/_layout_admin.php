<?php 

//$this->load->view("page_head");
$tag_head = "component/_tag_in_head";
$this->load->view($tag_head);
?>
<body>
<?php 
    
    $menu_admin = "component/menu_admin";
    if(!$this->session->userdata("is_login")):
        $menu = "There is no menu";

    endif;
    $menu = $menu_admin;
   
       
   $this->load->view($menu);
?>
<div class="container-fluid" id="container">
    <div class="status">
        <!--status element will be show after run the javascript command
            this element will be hidden by default
        -->
        Status Page
    </div>
    <div class="row">
        <div class="col-md-3">
            <h1 class="module_label_left"><?php echo $this->user_type;?> nav left</h1>
            <div class="sidebar-offcanvas" id="sidebar" role="navigation">
            <div class="sidebar-nav">
                <ul class="nav">

                    <li class="active">
                        <a href="<?php echo site_url("comment/admin");?>">
                            All Comment
                     </a>
                     </li>
                    <li><a href="#">Future Link 1</a></li>
                    <li><a href="#">Future Link 2</a></li>
                    <li class="nav-divider"></li>
                    <li><a href="#">Future Link 3</a></li>
                    <li><a href="#">Future Link 4</a></li>
                    <li><a href="#">Future Link 5</a></li>
                    <li class="nav-divider"></li>
                    <li><a href="#">Future Link 6</a></li>
                    <li><a href="#">Future Link 7</a></li>
                </ul>
            </div>
            <!--/.well -->
        </div>
        </div>
        <div class="col-md-9">
            <?php 
                $this->load->view($subview);
            ?>
        </div>
    </div>

<!--start modal area-->

<!--end modal-->
    
    
</div><!--end of div.container-->


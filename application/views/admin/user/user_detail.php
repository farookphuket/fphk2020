
<section id="users" class="users">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3">
                <h2><?php echo $name;?></h2>
                <div class="list-group text-center">
                    
                <a href="#" class="list-group-item list-group-item-action btnGetProfile">Profile</a>
                <a href="#" class="list-group-item list-group-item-action btnGetPhoto">Photo</a>
                <a href="#" class="list-group-item list-group-item-action btnGetPost">Post</a>
                    
                </div>
            </div>
            <div class="col-lg-9">
                <h1 class="label_right">User Info
                </h1>
                <div class="post_list"></div>
                <div class="post_pagin"></div>
            </div>
        
        </div>

    </div>

    
</section>
<?php 
        $user_detailJS = "admin/user/user_detailJS.php";
        $this->load->view($user_detailJS);

?>
<section class="p-0 photo" id="photo">
    <div class="container-fluid no-gutters">
            <div class="row no-gutters popup-gallery photo_list">
             </div>
    </div>
</section>

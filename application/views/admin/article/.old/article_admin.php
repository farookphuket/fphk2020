<section id="article">
    <div class="row">
        <div class="container">
            <div class="col-lg-12">
                <span class="float-right">
                    <a class="btn btn-primary" href="<?php echo site_url("article");?>">
                    See All
                    </a>
                </span>
                <h1 class="text-center">Manage Article</h1>
                <p class="card-text">
                Sat 9 Mar 19 the article will only be create by Admin or Moderate 
                </p>
                <p>
                The user post is will be another method to do list on this system.
                </p>
                <p>Last modify 26/3/19</p>
                <hr class="my-4"/>
            </div>
        </div>
    </div>
    
    <div class="container-fluid">
        <div class="row">
            <?php 
                //var_dump($get_ar);
                foreach($get_ar as $row):
                    $rdUrl = site_url("article/read/$row->ar_id");
            ?>
            <div class="col-lg-4">
                <div class="container">
                    <h2>
                    <?php echo $row->ar_title; ?>
                    </h2>
                    <?php 
                        echo $row->ar_summary;
                    ?>
                    <div class="row">
                    <div class="col-md-10">
                    <p>Post by <?php echo $row->ar_post_by;?></p>
                    </div>

                    <div class="col-md-10">
                    <p>Date Add :<?php echo $row->date_add;?></p>
                    <p>Date edit :<?php echo $row->date_edit;?></p>
                    </div>

                    </div>
                    <br />
                    <a class="btn btn-primary btn-sm lnRead" href="<?php echo $rdUrl;?>" target="_blank">
                    Read More
                    </a>
                </div>
                
            </div>

            <?php 
                endforeach;
            ?>
            
        </div>
        
    </div>
    

    



</section>

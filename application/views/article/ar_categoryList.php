<div class="page-header">
    <h1>
        <?php echo $cat_name;?>
        &nbsp;
        has &nbsp;<?php echo $num_ar;?>&nbsp;item(s).
    </h1>
</div>
<div class="row">

    <?php 
        if($num_ar == 0):
            ?>
            <div class="alert alert-danger">
                <h2>There is no data yet!</h2>
            </div>
            <?php
            else:
                foreach($get_all_ar as $row):
                    ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2><?php echo $row->ar_title;?></h2>
                        </div>
                        <div class="panel-body">
                            <p>
                                <?php echo $row->ar_summary;?>
                            </p>
                            <a href="<?php echo site_url("article/read/{$row->ar_id}");?>" target="_blank" class="btn-pay">Read More</a>
                        </div>
                    </div>
                    <?php
                endforeach;
                if($num_ar >= $per_page):
                    ?>
                    <div class="pagination">
                        <?php echo $this->pagination->create_links();?>
                    </div>
                    <?php
                endif;
        endif;
    ?>
</div>

<?php 
    require("arJS.php");
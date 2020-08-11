<div class="what_new row">
    
    <div class="col-sm-6">
       <div class="alert alert-warning">
            <h3>Warning</h3>
            <h4>
                - 
                <span class="label label-default">
                    All of this article has wrote by the member.
                </span>
                
            </h4>
            <h4>
            Please write anything by respect to other.
            </h4>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="alert alert-warning">
            <h3>คำเตือน</h3>
            <p>
                - 
                <span class="label label-default">
                    บทความทั้งหลายนี้เขียนโดยสมาชิก กรุณาอ่านอย่างระวัง 
                    เพราะว่าสิ่งที่ท่านเห็น อาจจะเป็นมากกว่าสิ่งที่ท่านคิด
                </span>
                
            </p>
        </div>
    </div>
</div>

<?php 

    if($get_ar):
        $num=0;
        foreach($get_ar as $row):
            $num++;

            ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3>
                <span class="label label-default">
                    <?php echo $num;?>
                </span>
                <span class="label">
                        <?php 
                            $lnView = site_url("article/readAr/{$row->ar_id}");
                            
                        ?>
                       <a href="#" data-ar_id="<?php echo $row->ar_id;?>" class="label lnRead">
                            <?php echo $row->ar_title;?>
                       </a>&nbsp;
                </span>
                <a href="<?php echo site_url("article/read/{$row->ar_id}");?>" class="btn btn-info btn-sm" target="_blank">
                            <span class="glyphicon glyphicon-new-window"></span> 
                </a>
            </h3>
            
        </div>
        <div class="panel-body">
        <?php echo $row->ar_summary;?>
        </div>
        <div class="panel-footer">
        <h4>Wrote By
            <span class="label label-default">
                <?php echo $row->ar_post_by;?>
            </span>&nbsp;
            Date Create :
            <span class="label label-default">
                <?php echo $row->date_add;?>
            </span>&nbsp;
            Has read :
            <span class="label label-default">
                <?php echo $row->ar_read_count;?>
            </span>&nbsp;
            Last read IP :
            <span class="label label-default">
                <?php echo $row->last_view_ip;?>
            </span>&nbsp;
            Last read date :
            <span class="label label-default">
                <?php echo $row->last_view_date;?>
            </span>&nbsp;
        </h4>
        </div>
    </div>
        <?php
        endforeach;
        if($num_ar > $per_page):

            ?>
        <div class="text-center">
            <div class="pagination">
                <?php echo $this->pagination->create_links(); ?>
            </div>
        </div>
            <?php
        endif;
    endif;

?>

<div class="modal fade mdReadAr">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title mdArTitle">The title</h1>
            </div>
            <div class="modal-body">
                <input type="hidden" class="show_also_id">
                
            </div>
            <div class="modal-footer">
            <button class="btn btn-warning btnClose" type="button" data-dismiss="modal">
                Close window 
                </button>
                <button class="btn btn-danger btnClose" type="button">
                    Reload Page 
                </button>
                    
                
            </div>
        </div>
    </div>
</div>
<!--There need the different view port
<div class="row">
    <div class="left-content col-sm-4">
        <div class="page-header">
            <h1>The Category</h1>
        </div>
        <div class="cat_list">
        
        </div>
        <div class="cat_paging">
        
        </div>
    </div>
    <div class="right-content col-sm-8">
        <div class="page-header">
            <h1 class="ar_head">The article list</h1>
        </div>
        <div class="ar_list">
        
        </div>
        <div class="ar_paging">
        
        </div>
    </div>
</div>
-->
<?php


    //echo"No id set";
    require("arJS.php");


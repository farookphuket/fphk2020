<div class="page-header">
    <h1>All tour program | โปรแกรมทั้งหมด 
        <span class="label label-default">
            <?php echo $num_tour; ?>
        </span>&nbsp; รายการ

    </h1>
</div>


<div class="container">
    <div class="page-header">
        <span class="pull-right">
                <button class="btn btn-primary addTour" type="button">
                    Add new Tour
                </button>
        </span>
        <h2>รายการโปรแกรมทัวร์</h2>
    </div>
    <div class="row">
        <!--show the list of tour--> 
        <?php 
            if($num_tour != 0):
                $num = 0;
                foreach($get_tour as $row):
                    $num++;
                    ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span class="pull-right">
                    <a href="#" data-t_id="<?php echo $row->t_id;?>" class="btn btn-warning lnEdit">
                    Edit
                    </a>
                
                
                    <button class="btn btn-danger lnDel" data-t_id="<?php echo $row->t_id;?>" >
                    Delete
                    </button>
                </span>
                <h2>
                    <?php echo"{$num}).{$row->t_name}";?>
                </h2>
            </div>
            <div class="panel-body">
                <h2>
                The program summary | โปรแกรมอย่างย่อ...
                </h2>
                <p class="article_box">
                    <?php echo $row->t_summary;?>
                </p>
            </div>

        </div>
                <?php
                endforeach;
                if($num_tour >= $per_page):
                    ?>
                    <div class="pagination">
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                    <?php
                endif;
            endif;
        ?>
    </div>

</div>



<div class="modal fade frmTour">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">
                &times;
                </button>
                <h1 class="modal-title mdTitle">Title Moderate</h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmTour" action="<?php echo site_url("tour/moderate");?>">
                <div class="form-group">
                    <label class="label-control col-sm-4">Title</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control t_title" name="t_title">
                    <input type="hidden" name="t_id" class="t_id">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">Summary</label>
                    <div class="col-sm-6">
                    <textarea class="form-control t_summary" name="t_summary">
                    
                    </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">Minimum Price/Person</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control price_minimum" name="price_minimum">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">Full Price/Person</label>
                    <div class="col-sm-6">
                    <input type="text" class="form-control price_full" name="price_full">
                    </div>
                </div>


                <div class="form-group">
                    <textarea class="tinymce t_body" name="t_body">
                    </textarea>
                </div>

                </form>
                <div class="modal_status pull-right">
                    
                </div>
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-primary btnSave" type="submit" form="frmTour">Save</button>
                <button class="btn btn-danger btnClose" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php 
    require("moderateJS.php");
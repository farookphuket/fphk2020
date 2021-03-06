<div class="page-header">
    <h1>จัดการบทความ 
    &nbsp;<?php echo $user_name;?>
    </h1>
</div>

<div class="page-header">
        <h3 class="ar_sum">บทความทั้งหมด 
            <span class="label label-default">
                <?php echo $num_ar;?>
            </span>&nbsp;
            
        </h3>
        <button class="btn btn-primary lnAdd pull-right">
            <span class="glyphicon glyphicon-plus"></span> เพิ่มบทความใหม่
        </button>
</div>
<div class="row">
    
    
    

    <?php 
        if(!$num_ar):

    ?>
    <h2>
        Article is 
        <span class="alert alert-danger">
        0
        </span>&nbsp;
        item!
    </h2>
    <?php
        endif;
        $num = 0;
        foreach($get_all_ar as $row):
            $num++;
            $yes = "
            <span class='label label-success'>ใช่</span>
            ";
            $no = "
            <span class='label label-danger'>ไม่ใช่</span>
            ";

            $pub = $row->ar_show_public;
            $pub = ($pub != 0)?$pub=$yes:$pub=$no;
            $approve = ($approve = $row->ar_is_approve)?$yes:$no;
    ?>
    <div class="col-sm-6">
        
            <div class="panel panel-info panel_ar" data-p_id="<?php echo $row->ar_id;?>">
                
                
                <div class="panel-heading">
                <button class="btn btn-danger btn-sm lnDel pull-right" data-ar_id="<?php echo $row->ar_id;?>">
                    <span class="glyphicon glyphicon-trash"></span> ลบทิ้ง
                </button>&nbsp;
                <button class="btn btn-warning btn-sm lnEdit pull-right" data-ar_id="<?php echo $row->ar_id;?>">
                    <span class="glyphicon glyphicon-pencil"></span> Edit
                </button>
                    <h3>
                        <?php echo $num."-".$row->ar_title;?>
                    </h3>
                    
                
                </div>
                <div class="panel-body">
                <?php echo $row->ar_summary;?>
                </div>
                <div class="panel-footer">
                    <h4>เขียนโดย :
                        <span class="label label-default">
                            <?php echo $row->ar_post_by; ?>
                        </span>&nbsp;
                        สร้างเมื่อ :
                        <span class="label label-default">
                            <?php echo $row->date_add; ?>
                        </span>&nbsp;
                    </h4>
                    <h4>
                        เป็นสาธารณะ : <?php echo $pub;?>&nbsp;
                        ตรวจสอบแล้ว : <?php echo $approve;?>&nbsp;
                    </h4>
                </div>
            </div>

            
        
    </div>

    <?php
        endforeach;
        
    ?>

</div>
<div class="pagination">
        <?php
        if($num_ar > $per_page):
            
            echo $this->pagination->create_links(); 
               
        endif;
        ?>
</div>

<div class="modal fade mdFrm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title">Title</h1>
            </div>
            <div class="modal-body">
                <div class="ar_result">
                show data text
                </div>
                <div class="page-heading">
                    <h1>ส่วนการปรับปรุง</h1>
                </div>
                <!--form goes here--> 
                <form class="form-horizontal" id="frmAr" action="<?php echo site_url("article/moderate");?>">
                
                    
                <div class="form-group">
                    <label class="label-control col-sm-4">Category</label>
                    <div class="col-sm-6">
                        <select name="sel_cat" class="cat_id form-control">
                            <option value=0>
                                --Select category--
                            </option>
                            <?php 

                                if($num_cat):
                                    $num = 0;
                                    foreach($get_cat as $row):
                                        $num++;
                                        ?>
                            <option value="<?php echo $row->cat_id;?>">
                            <?php echo $num."-".$row->cat_title; ?>
                            </option>
                            <?php
                                    endforeach;
                                endif;

                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">
                    หัวข้อ
                    </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control ar_title" name="ar_title">
                        <input type="hidden" name="ar_id" class="ar_id">
                    </div>
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">
                    บทย่อ
                    </label>
                    <div class="col-sm-6">
                        <textarea name="ar_summary" class="form-control ar_summary" id="ar_summary">
                        </textarea>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="ar_body" class="form-control tinymce ar_body">
                    </textarea>
                    
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-3">Status</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="pub" class="pub">
                            </span>
                            <input type="text" class="form-control pub_txt">
                            
                            <span class="input-group-addon">
                                <input type="checkbox" name="approve" class="approve">
                            </span>
                            <input type="text" class="form-control app_txt">
                            
                            <span class="input-group-addon">
                                <input type="checkbox" name="s_index" class="s_index">
                            </span>
                            <input type="text" class="form-control index_txt">
                        </div>

                        
                        
                    </div>
                </div>
                
                </form>
                <!--end form-->
                
            </div>
            <div class="modal-footer">
                <div class="modal_status"></div>
                <button class="btn btn-primary btnSave" type="submit" form="frmAr">
                Save
                </button>
                <button class="btn btn-danger" type="button" data-dismiss="modal">
                Close
                </button>
                
            </div>
        </div>
    </div>
</div>


<?php 

    require("moderateJS.php");
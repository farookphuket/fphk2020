<div class="what_new">
    <div class="row">
        <div class="col-sm-6">
            <ul>
            
                <li class="alert alert-success">
                    You can create,edit or delete your own article
                </li>
                <li class="alert alert-warning">
                    Your post will not be show to public 
                    until it has approve by admin 
                    even you flag your post to so
                </li>
                <li class="alert alert-warning">
                    You cannot embed the iframe to include the vedio in to your post
                </li>
            </ul>
        </div>
        <div class="col-sm-6">
            <ul>
            
                <li class="alert alert-success">
                    ท่านสามารถ เพิ่ม,แก้ไข หรือ ลบ ข้อความ, บทความ ของท่าน
                </li>
                <li class="alert alert-warning">
                    ข้อความ บทความของท่านจะไม่แสดงเป็น สาธารณะ จนกว่าจะได้รับการตรวจสอบ
                </li>
                <li class="alert alert-warning">
                    ต้องขออภัยด้วย บัญชีของท่านไม่สามารถใช้งาน iframe ได้เนื่องด้วยเหตุผลทางความปลอดภัย
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="table-responsive">
<div class="page-header">
    <h2>Article</h2>
</div>
<span class="pull-right">
    <button class="btn btn-primary btn-sm lnAddAr">
        <span class="glyphicon glyphicon-pencil"></span> Create New
    </button>
    
</span>
<table class="table table-striped">
    <thead> 
        <tr> 
            <th>#  </th>
            <th width="50%">Title  | you have post  <?php echo $num_all_ar;?> item(s).</th>
            <th>Date Post </th>
            <th width="10%">Public</th>
            <th width="10%">Approve </th>
            <th width="10%">Read Count </th>
        </tr>
    </thead>
    <tbody> 
        <?php 
            if($get_ar):
                
                $num = 0;
                foreach($get_ar as $row):
                    $num++;
                    ?> 
        <tr>
            <td><?php echo $num; ?></td>
            <td><?php 
            $rdlink = site_url("article/readAr/{$row->ar_id}");
            //echo anchor($rdlink,$row->ar_title); 
            ?>
                <a href="<?php echo $rdlink;?>" class="lnEditAr" data-ar_id="<?php echo $row->ar_id;?>">
                    <?php echo $row->ar_title;?> 
                </a>
                <span class="pull-right">
                    <button class="btn btn-danger btn-sm lnDelAr" data-ar_id="<?php echo $row->ar_id;?>" type="button"> 
                        <span class="glyphicon glyphicon-trash"></span> Delete
                    </button>
                </span>
            </td>
            <td><?php echo $row->date_add; ?></td>
            <td>
            <?php 
                $yes = "<span class='label-success'><span class='glyphicon glyphicon-ok'></span> </span>";
                $no = "<span class='label-danger'><span class='glyphicon glyphicon-remove'></span></span>";

                $pub = $no;
                if($row->ar_show_public != 0):
                    $pub = $yes;
                endif;
                echo $pub;
                ?>
            </td>
            <td>
            <?php
                
                $ap = $no;
                if($row->ar_is_approve != 0):
                    $ap = $yes;
                endif;
                echo $ap;
                
                ?>
            </td>
            <td><?php echo $row->ar_read_count; ?></td>
        </tr>
                    <?php
                endforeach;

            else:
        ?>
        <tr> 
            <td colspan="6">You have no any post yet!</td>
        </tr>
        <?php 
            endif;
            if($num_all_ar > $per_page):
                ?> 
                <tr> 
                    <td colspan="6"><?php echo $this->pagination->create_links();?> </td>
                </tr>
                <?php
            endif;
        ?>
    </tbody>
</table>
</div>
<div class="table-responsive">
    <div class="page-header">
        <h2>Public Article</h2>
    </div>
    <div class="col-sm-6">
        <ul>
            <li>
                if you do not want page to reload after you have read the article then click on the button close but not reload
            </li>
        </ul>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>By</th>
            </tr>
        </thead>
        <tbody id="ar_list">
            <!--dynamic content by ajax-->
            
            
        </tbody>

    </table>
    <div id="get_paginator">

    </div>
</div>
<div class="modal fade mdArticle">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title mdArTitle">
                    Title of this modal
                </h1>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url("article/own");?>" method="post" class="form-horizontal frmAr" id="frmAr">
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Category</label>
                        <div class="col-sm-6">
                            <input type="hidden" class="ar_id" name="ar_id">
                            <select name="sel_cat" id="" class="sel_cat form-control">
                                <?php 
                                    if($get_cat):
                                        $num = 0;
                                        foreach($get_cat as $row):
                                            $num++;
                                            ?> 
                                <option value="<?php echo $row->cat_id;?>"> 
                                    <?php echo $row->cat_title;?>
                                </option> 
                                            <?php
                                        endforeach;
                                    else:
                                        ?> 
                                <option value="0">No Category</option>
                                        <?php
                                    endif;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Title</label>
                        <div class="col-sm-6">
                            <textarea name="ar_title" class="form-control ar_title"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Summary</label>
                        <div class="col-sm-6">
                            <textarea name="ar_summary" class="form-control ar_summary"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">&nbsp;</label>
                        <div class="col-sm-6">
                            <div class="txt_length">
                                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="ar_body" class="ar_body tinymce form-control"></textarea>
                    </div>
                    <div class="form-group">
                            <label for="" class="label-control col-sm-4">Published</label>
                            <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="ar_pub" class="ar_pub">
                                        </span>
                                        <input type="text" class="form-control pub_txt">
                                    </div>
                            </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <span class="modal_status"></span>
                    <button class="btn btn-primary btnSaveAr" type="submit" form="frmAr">
                        Create
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade mdRead">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h1 class="modal-title mdReadTitle">Title</h1>
            </div>
            <div class="modal-body mdReadBody">

            </div>
            <div class="modal-footer">
                <button class="btn btn-warning btnCloseNoReload" data-dismiss="modal">
                    Hide this window
                </button>
                <button class="btn btn-danger btnClose">
                    Refresh page
                </button>
            </div>
        </div>
    </div>
</div>
<?php

if($is_login):
    //require the JS file
    require("user_arJS.php");
endif;

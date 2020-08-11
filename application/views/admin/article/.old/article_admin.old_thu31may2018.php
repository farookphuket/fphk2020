<div class="jumbotron">
    <h1 class="page-header">Admin manage Article</h1>
</div>

<button class="btn btn-primary lnAddCat pull-right" type="button">
    Add new Category
</button>
<div class="page-header">
    <h2>List of category</h2>
</div>
<div class="row showCatList">
    <!--dynamic content from ajax-->
</div>
<div class="page-header">
    <h1 class="article-list">
        Article total <?php echo $num_all_ar;?> item(s).
    </h1>
</div>
<span class="pull-right">
    <button class="btn btn-primary lnAddAr" type="button">
    <span class="glyphicon glyphicon-plus"></span> Create New 
    </button> 
</span>
<table class="table table-striped">
    <thead>
        <th>#</th>
        <th width="50%">Title</th>
        <th width="25%">Item Status</th>
        <th>Date</th>
    </thead>
    <tbody> 
        <?php 
            if(!$num_all_ar):
                ?>
                <tr>
                    <td colspan="4">There is no Article</td>
                 </tr>
         <?php

            else:
                $num = 0;

                foreach($get_all_ar as $row):
                    $num++;
                    ?> 
                    <tr>
                        <td><?php echo $num;?></td>
                        <td> 
                            <?php 

                                $read_url = site_url("article/admin/{$user_id}");
                                
                            ?>
                            <a href="<?php echo $read_url;?>" class="lnEditAr" data-ar_id="<?php echo $row->ar_id;?>">
                                <?php echo $row->ar_title;?> 
                                </a>
                                <span class="pull-right">
                                    <button type="button" class="btn btn-danger btn-sm lnDelAr" data-ar_id="<?php echo $row->ar_id;?>">
                                        <span class="glyphicon glyphicon-trash"></span> Delete
                                    </button>
                                </span>
                        </td>
                        <td>
                        <?php 
                            
                            $yes = "
                            <span class='label label-success'>Yes</span>
                            ";
                            $no = "
                            <span class='label label-danger'>NO</span>
                            ";

                            $show_index = ($show_index = $row->ar_show_index)?$yes:$no;

                            $approve = ($approve = $row->ar_is_approve)?$yes:$no;

                            $show_public = ($show_public = $row->ar_show_public)?$yes:$no;
                            
                            
                            
                        ?>
                        <h4>
                            Approve : <?php echo $approve; ?> 
                        </h4>
                        <h4>
                            show Public : <?php echo $show_public; ?> 
                        </h4>
                        <h4>
                            show index : <?php echo $show_index; ?> 
                        </h4>
                        </td>
                        <td>
                            
                            <h4>
                            Create : 
                                <span class="label label-default">
                                <?php echo $row->date_add; ?>
                                </span>
                            </h4>
                            <h4>
                            Updated : 
                                <span class="label label-warning">
                                <?php echo $row->date_edit; ?>
                                </span>
                            </h4>
                        </td>
                    </tr>
                    <?php 
                endforeach;
                if($num_all_ar > $per_page):
                    ?> 
                    <tr> 
                        <td colspan="4"> 
                            <div class="pagination">
                            <?php   echo $this->pagination->create_links();?>
                            </div>
                        </td>
                    </tr>
                    <?php
                endif;
            endif;
        ?>
    </tbody>
</table>

<!--modal form category-->
<div class="modal fade mdCat">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">
                    Create new cat
                </h1>
            </div>
            <div class="modal-body">
                <form action="<?php echo site_url("article/saveCat");?>" class="form-horizontal frmCat" id="frmCat">
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Title</label>
                        <div class="col-sm-6">
                        <input type="text" name="cat_title" class="form-control cat_title">
                        <input type="hidden" name="cat_id" class="cat_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Section</label>
                        <div class="col-sm-6">
                        <input type="text" name="cat_section" class="form-control cat_section">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label-control col-sm-4">Category Status</label>
                        <div class="col-sm-6 input-group">
                            <span class="input-group-addon">
                                <input type="checkbox" name="cat_public" class="cat_public">
                            </span>
                            <input type="text" class="form-control cat_pub_txt">
                            <span class="input-group-addon">
                                <input type="checkbox" name="allow_change" class="allow_change">
                            </span>
                            <input type="text" class="form-control change_txt">
                        </div>
                    </div>
                </form>
                <div class="modal_status label-info pull-right"></div>
            </div>
            <div class="modal-footer">
                
                <button class="btn btn-primary btnSaveCat" type="submit" form="frmCat">
                    Save
                </button>
            </div>
        </div>
    </div>
</div>

<!-- end of modal form -->


<div class="modal fade arForm">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title md_arTitle">Title</h1>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="frmAr"  method="post" action="<?php echo site_url("article/admin");?>">
                    
                    <div class="form-group">
                        <label for="" class="col-sm-4 label-control">Category</label>
                        <div class="col-sm-6">
                        <input type="hidden" name="ar_id" class="ar_id">
                        <input type="hidden" name="cat_id" class="cat_id">
                                <select name="sel_cat" id="" class="form-control sel_cat">
                                    <option value="0">--Select--</option>
                                    <?php 
                                            if($num_cat == 0):
                                                    ?> 
                                            <option value="0">There is no Category</option>
                                                    <?php
                                            else:
                                                $num = 0;
                                                foreach($get_cat as $row):

                                                    $num++;
                                                ?> 
                                            <option value="<?php echo $row->cat_id;?>">
                                            <?php echo"{$num}-{$row->cat_title}"; ?> 
                                            </option> 
                                                <?php
                                                endforeach;
                                            endif;
                                    ?>
                                </select>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Title</label>
                        <div class="col-sm-6">
                            <textarea name="ar_title" id="" class="form-control ar_title"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Summary</label>
                        <div class="col-sm-6">
                            <textarea name="ar_summary" id="" class="form-control ar_summary"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="ar_body"  class="form-control tinymce ar_body"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="" class="label-control col-sm-4">Aprove | Public</label>
                        <div class="row">
                            <div class="col-sm-3">
                                   <div class="input-group">
                                       <span class="input-group-addon">
                                            <input type="checkbox" name="approve" class="approve"> 
                                        </span>
                                         <input type="text" class="form-control ap_txt">
                                    </div>
                            </div>
                            <div class="col-sm-3">
                                    <div class="input-group">
                                       <span class="input-group-addon">
                                           <input type="checkbox" name="ar_pub" class="ar_pub"> 
                                        </span>
                                            <input type="text" class="form-control pub_txt">
                                    </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span class="modal_status"><!--dynamic cotent--></span>
                <button type="submit" class="btn btn-primary btnArSave" form="frmAr">
                    Save
                </button>
            </div>
        </div>
    </div>

</div>

<?php
    require("article_adminJS.php");
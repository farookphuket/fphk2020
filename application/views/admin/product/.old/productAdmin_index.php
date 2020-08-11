<div class="jumbotron">
    <h1>Manage The product</h1>
</div>


<!--start div.row-->
<div class="row">
    <div id="pd-left" class="col-sm-4 pd-left">
         <span class="page-header">
            <h2>Manage Category</h2>
        </span>
        <form id="pCatFrm" class="form-horizontal pCatFrm" method="post" action="<?php echo site_url("product/saveCat");?>">
        
            <div class="form-group">
                <label class="control-label col-sm-4">
                    Category Title
                </label>
                <div class="col-sm-6">
                    <input type="text" class="form-control pdCat-title" id="pdCat-title" name="cat_title">
                    <input type="hidden" class="cat_id" name="cat_id">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">
                    Description
                </label>
                <div class="col-sm-6">
                    <textarea class="form-control pdCat-des" name="cat_des"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4">
                    &nbsp;
                </label>
                <div class="col-sm-6">
                    <button class="btn btn-primary btnCat" type="submit">
                        Create Category
                    </button>
                </div>
            </div>
        </form>
        <br />
        <div class="pcat-list">
        
        </div>
    </div>
    <!--End of left-->
    
    <!--start of right-->
    <div id="pd-right" class="col-sm-8 pd-right">
        <span class="page-header">
            <h2>Manage the product</h2>
            <span class="pull-right">
                <button type="button" class="btn btn-default lnAddP">
                    <span class="glyphicon glyphicon-plus"></span> New Product
                </button>
            </span>
        </span>
        <div class="well">
        
        </div>
        <div class="pd-list">

        </div>
    </div>
    <!--end of right-->

</div>
<!--end of div.row-->



<div class="modal fade frmProduct">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">New Product</h1>
            </div>
            <div class="modal-body">
                <div class="show_pd">
                
                </div>
                <form method="post" action="<?php echo site_url("product/product_admin_api/save_product");?>" id="productFrm" class="form-horizontal">
                  <input type="hidden" name="cat_id" class="cat_id">
                  <input type="hidden" name="pd_id" class="pd_id">
                  <div class="form-group">
                    <label for="" class="label-control col-sm-4">Category</label>
                    <div class="col-sm-6">
                        <select name="sel_cat" id="" class="form-control sel_cat">
                            <?php
                                if($num_cat != 0):
                                    $num = 0;
                                    foreach($get_cat->result() as $row):
                                        $num++;
                                    ?>
                                        <option value="<?php echo $row->cat_id;?>">
                                        <?php echo"{$num} {$row->cat_title}";?>
                                        </option>
                                    <?php
                                    endforeach;
                                else:
                                    ?>
                                        <option value="0">No Data</option>
                                    <?php
                                endif;
                            ?>
                        </select>

                    </div>

                  </div>
                  <div class="form-group">
                    <label for="" class="label-control col-sm-4">Title</label>
                    <div class="col-sm-6">
                        <input type="text" name="pd-title" id="" class="form-control pd-title">
                    </div>
                  </div>
                  <div class="form-group">
                    <textarea name="pd-body" class="tinymce pd-body"></textarea>
                  </div>  
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary btnSaveP" form="productFrm" type="submit">
                    Create Product
                </button>
                <button class="btn btn-default btnClose">Cancle
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modalConf" id="modalConf">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title"></h1>            
            </div> 
            <div class="modal-body">
                <input type="hidden" name="cat_id" class="cat_id">
            </div>
            <div class="modal-footer">
                <button class="btn btn-default btnConf">Yes ,I know
                </button>
                <button class="btn btn-default btnCancle">Cancle
                </button>
            </div>               
        </div>
    </div>                        
</div>

<?php
    require("productJS_admin.php");
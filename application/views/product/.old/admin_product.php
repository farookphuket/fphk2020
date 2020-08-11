<div class="container">
  <div class="jumbotron">
      <h1>Product</h1>
  </div>

  <div class="col-sm-4" style="background-color:lavender;">
    <div class="page-heading">
      <h2 class="frm_cat_title">Add new category</h2>
    </div>
    <form class="form-horizontal">
      <div class="form-group">
          <input type="text" class="form-control pd_cat">
          <input type="hidden" class="cat_id">
      </div>
      <div class="form-group">
          <input type="text" class="form-control pd_section">
      </div>
      <div class="form-group">
        <button class="btn btn-info btnSaveCat" type="button">Add new Category</button>
      </div>
    </form>

    <ul class="show_cat_list" id="cat_list">

    </ul>
  </div>
  <div class="col-sm-8">
        <h1 class="frm_product_show">Click here to Add new Product</h1>
        <pre>
            Show the list of product.
        </pre>
        <ul class="product_list">

        </ul>
  </div>


<div class="modal fade mdConfirm">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title"></h1>
        </div>
        <div class="modal-body">

            <div class="conf_msg">

            </div>

            <pre>
              <ul class="pd_title">

              </ul>
            </pre>
            <input type="hidden" class="pd_id" />
            <input type="hidden" class="cat_id" />
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary btnDelP">Delete</button>
        </div>
    </div>
  </div>
</div>
<!--end of modal-confirm-->
<!--modal form for the add product start-->
<!--Create on Sun 3 Sep 2017-->
<div class="modal fade mdProduct">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title">Modal Product</h1>
        </div>
        <div class="modal-body">
                <div class="show_product_detail">

                </div>
              <form class="form-horizontal">
                  <div class="form-group">
                    <label class="label-control col-sm-4">Select the Category</label>
                    <div class="col-sm-6">
                      <select class="form-control sel_cat" name="">
                        <option value="0">--Select--</option>
                      <?php
                        if($num_cat == 0):
                            ?>
                              <option value="0">There is no Data</option>
                            <?php
                          else:
                            $num =  0;
                            foreach($get_cat->result() as $row):
                                $num++;
                                ?>
                                  <option value="<?php echo $row->cat_id;?>">
                                      <?php echo"{$num} {$row->cat_title}"; ?>
                                  </option>
                                <?php
                            endforeach;
                        endif;
                       ?>
                      </select>
                  </div>
                  </div>
                  <div class="form-group">
                      <label class="label-control col-sm-4">Product Title</label>
                      <div class="col-sm-6">
                          <input type="text" class="form-control pd_title">
                          <input type="hidden" class="pd_id">
                          <input type="hidden" class="cat_id">
                      </div>
                  </div>

                  <div class="form-group">
                    <textarea class="tinymce pd_body">

                    </textarea>
                  </div>
              </form>
              <div class="modal_status">

              </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary btnSaveP">Save</button>
            <button class="btn btn-default btnCancel">Cancel</button>
        </div>
    </div>
  </div>
</div>

<!--end of modal product-->
</div>

<?php

  require("adminProductJS.php");

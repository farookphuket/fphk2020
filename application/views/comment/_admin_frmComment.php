<form class="form-horizontal" id="frmComment" action="<?php echo site_url("comment/adminSaveComment");?>">
    <div class="form-group">
        <label class="label-control col-sm-4">Comment Title</label>
        <div class="col-sm-6">
            <input type="text" name="c_title" class="form-control c_title" >
            <input type="hidden" name="c_id" class="c_id" />
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-12">
            <textarea class="c_body tinymce" name="c_body"></textarea>
        </div>
    </div>

    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <div class="form-group">
        <label class="label-control col-sm-4">Comment Status</label>
        <div class="col-sm-6">
            <div class="input-group">
              <span class="input-group-addon">
                  <input type="checkbox" name="c_approve" class="c_approve"> Mark As Approve
              </span>
            </div>

        </div>
        <p>&nbsp;</p>
        <div class="col-sm-12">
          <div class="text-center show_approve_status"></div>
        </div>
    </div>

</form>

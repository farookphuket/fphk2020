<form id="frmComment" action="<?php echo site_url("comment/adminSave"); ?>">
    
    <!-- hidden input -->
    <input type="hidden" name="c_id" class="c_id">

    <!-- End hidden input -->
    <div class="form-group">
        <label for="c_title">Comment Title</label>
        <input type="text" name="c_title" id="c_title" class="c_title form-control">
    </div>

    <div class="form-group">
        <label for="c_body">Comment Body</label>
        <textarea name="c_body" id="c_body" class="c_body form-control tinymce"></textarea>
        <p class="pt-4">&nbsp;</p>
    </div>

    <div class="form-group">
        <label for="c_is_show" class="checkbox-inline">
        <input type="checkbox" name="c_is_show" class="c_is_show"> Show on page
        </label>
    </div>
    
</form>

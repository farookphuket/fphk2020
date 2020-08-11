<form id="frmCat" action="<?php echo site_url("category/adminSave"); ?>">
    <div class="form-group">
        <label for="cat_uri">URI</label>
        <input type="text" name="cat_uri" id="cat_uri" class="form-control cat_uri">
    </div>


    <div class="form-group">
        <label for="cat_title">Title</label>
        <input type="text" name="cat_title" id="cat_title" class="form-control cat_title">
        <input type="hidden" name="cat_id" id="cat_id" class="cat_id">
        <input type="hidden" name="cat_user_id" id="cat_user_id" class="cat_user_id">
    </div>

    <div class="form-group">
        <label for="cat_section">Section</label>
        <input type="text" name="cat_section" id="cat_section" class="form-control cat_section">
    </div>

     <div class="form-group">
        <label for="cat_sum">Description</label>
        <textarea name="cat_sum" id="cat_sum" class="form-control cat_sum"></textarea>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-lg-4">
                <label for="" class="checkbox-inline">
                    <input type="checkbox" name="allow_change" class="allow_change form-control"> 
<p class="alert alert-warning">
    Make Change Allow (uncheck = not allow)
</p>
                </label>           
            </div>
            <div class="col-lg-4">
                <label for="" class="checkbox-inline">
                    <input type="checkbox" name="allow_show" class="allow_show form-control"> 
                    <p class="alert alert-warning">
                        Allow this to show (uncheck = not allow)
                    </p>
                </label>         
            </div>

            <div class="col-lg-4">
                <label for="" class="checkbox-inline">
                    <input type="checkbox" name="is_pub" class="is_pub form-control"> 
                    <p class="alert alert-warning">
                        Make this public (uncheck = not public)
                    </p>
                </label>         
            </div>

        </div>

    </div>





</form>

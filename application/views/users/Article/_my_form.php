<form id="myPost" action="<?php echo site_url("article/uSavePost"); ?>">

    <div class="form-group">
        <label for="og_url">Share URL</label>
        <input type="text" class="form-control og_url" name="og_url">
    </div>
    <div class="form-group">
        <label for="keyword">Keyword</label>
        <input type="text" class="form-control keyword" name="keyword">
    </div>
     <div class="form-group">
        <label for="keydes">Description Key</label>
        <input type="text" class="form-control keydes" name="keydes">
    </div>


    <div class="form-group">
        <label for="ar_title">Title</label>
        <input type="text" class="form-control ar_title" name="ar_title">
        <input type="hidden" class="ar_id" name="ar_id" />
        <input type="hidden" class="cat_id" name="cat_id" />
        <input type="hidden" class="kw_id" name="kw_id" />
    </div>
    <div class="form-group">
        <label for="ar_summary">Summary</label>
        <textarea name="ar_summary" class="form-control ar_summary tinymce"></textarea>
        <p class="pt-2">&nbsp;</p>
    </div>
    <div class="form-group">
        <label for="ar_body">Post body</label>
        <textarea name="ar_body" class="form-control ar_body tinymce"></textarea>
        <p class="pt-4">&nbsp;</p>
    </div>

    <div class="form-group">
        <label class="form-check-label">
    <input type="checkbox" class="form-control form-check-input is_pub" name="is_pub" value=1> Show public
  </label>
    </div>
    <div class="modal_status">
       Loading... 
    </div>
</form>

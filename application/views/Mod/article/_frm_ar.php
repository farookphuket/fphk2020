<form id="ar_form" action="<?php echo site_url("article/modSavePost");?>" class="form-horizontal">

  <div class="col-lg-12">
    <h1 class="text-center">SEO</h1>
    <hr class="my-4">
    <p>&nbsp;</p>
  </div>
  <div class="form-group">
    <label for="keyword">Keyword</label>
    <input type="text" class="form-control keyword" id="keyword" name="keyword" />

  </div>
  <div class="form-group">
    <label for="keydes">Description </label>
    <input type="text" class="form-control keydes" id="keydes" name="keydes" />

  </div>
  <div class="col-lg-12">
    <p>&nbsp;</p>
    <h1 class="text-center">Post content</h1>
    <p>&nbsp;</p>
  </div>
  <div class="form-group">
    <label for="ar_title">Title</label>
    <input type="text" name="ar_title" class="form-control ar_title" id="ar_title" />
    <input type="hidden" class="ar_id" name="ar_id"/>
    <input type="hidden" class="kw_id" name="kw_id"/>
    <input type="hidden" class="ar_user_id" name="ar_user_id"/>
  </div>
  <div class="form-group">
    <label for="ar_sum">Summary</label>
    <textarea name="ar_sum" class="form-control ar_sum" id="ar_sum" rows="10"></textarea>
  </div>
  <div class="col-lg-12">
    <p>&nbsp;</p>
    <div class="sumResult">

    </div>
    <p>&nbsp;</p>
  </div>
  <div class="form-group">
    <label for="ar_body">Post Content</label>
    <textarea name="ar_body" class="form-control tinymce ar_body" id="ar_body"></textarea>
  </div>

  <div class="col-lg12">
    <p>&nbsp;</p>
    <div class="fResult">

    </div>
    <p>&nbsp;</p>

  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input chIndex" type="checkbox" name="chIndex">
        <label class="form-check-label">Show Index Page</label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input chPublic" type="checkbox" name="chPublic">
        <label class="form-check-label">Show As Public</label>
      </div>
    </div>

    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input chApprove" type="checkbox" name="chApprove">
        <label class="form-check-label">Set Approve</label>
      </div>
    </div>

  </div>

  
</form>

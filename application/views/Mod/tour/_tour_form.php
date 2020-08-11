<form class="form-horizontal" id="fTour" action="<?php echo site_url("tour/modSave");?>">

<div class="container">
    <h2 class="text-center">Seo</h2>
</div>
<p>&nbsp;</p>
<div class="input-group mb-3">
  <input type="text" class="form-control url" name="url" placeholder="meta url" aria-label="url" aria-describedby="basic-addon1">
  <input type="hidden" name="tour_id" class="tour_id">
  <input type="hidden" name="kw_id" class="kw_id">
  <input type="hidden" name="user_id" class="user_id">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon1">meta url</span>
  </div>
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control keyword" name="keyword" placeholder="page keyword" aria-label="keyword" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">meta keyword</span>
  </div>
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control keydes" name="keydes" placeholder="page description" aria-label="keydes" aria-describedby="basic-addon2">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon2">meta description</span>
  </div>
</div>

<p>&nbsp;</p>
<div class="container">
    <h2 class="text-center">Tour program</h2>
</div>
<p>&nbsp;</p>

<div class="input-group mb-3">
  <input type="text" class="form-control title" name="title" placeholder="Tour Title" aria-label="title" aria-describedby="basic-addon3">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon3">Tour title</span>
  </div>
</div>

<div class="input-group mb-3">
  <input type="number" class="form-control fullprice" name="fullprice" placeholder="Tour Full Price" aria-label="fullprice" aria-describedby="basic-addon4">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon4">Tour Price</span>
  </div>
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control duration" name="duration" placeholder="Tour Duration" aria-label="duration" aria-describedby="basic-addon5">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon5">Tour Duration</span>
  </div>
</div>

<div class="input-group mb-3">
  <input type="text" class="form-control location" name="location" placeholder="Tour Location" aria-label="location" aria-describedby="basic-addon6">
  <div class="input-group-append">
    <span class="input-group-text" id="basic-addon6">Tour Location</span>
  </div>
</div>
<p>&nbsp;</p>
<div class="container-fluid">
    <textarea class="form-control sum" name="sum" rows="10" placeholder="Tour summary"></textarea>
</div>
<p>&nbsp;</p>
<div class="form-group">

  <textarea class="form-control  tinymce body" name="body"></textarea>
</div>
<p>&nbsp;</p>
<div class="container-fluid">

  <select class="form-control draft" name="draft">
  <option value=0>Publish</option>
  <option value=1>Save As Draft</option>
  </select>
</div>
<p>&nbsp;</p>
<div class="container-fluid">
    <div class="tourResult"></div>
</div>

</form>

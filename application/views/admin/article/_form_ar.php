<form class="form-horizontal" action="<?php echo site_url("article/adminSave");?>" id="arForm">

<div class="row">
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center">For Seo</h2>
            <hr class="my-4"/>
            
        </div>
    </div>
</div>
<label for="og_url">Meta URL</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text " id="basic-addon1">
    <?php echo site_url("article/");?>
    </span>
  </div>
  <input type="text" class="form-control og_url" id="og_url" name="og_url"  aria-describedby="basic-addon1">

    <input type="hidden" name="kw_id" class="kw_id" />
    <input type="hidden" name="ar_id" class="ar_id" />
    <input type="hidden" name="ar_user_id" class="ar_user_id" />
    <input type="hidden" name="uniq_id" class="uniq_id">
</div>

<label for="keyword">Meta keyword</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon2">Keyword</span>
  </div>
  <input type="text" class="form-control keyword" id="keyword" name="keyword" aria-describedby="basic-addon3">
</div>

<label for="keydes">Meta Description</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon3">Description</span>
  </div>
  <input type="text" class="form-control keydes" id="keydes" name="keydes" aria-describedby="basic-addon3">
</div>

<div class="row">
    <div class="container">
        <div class="col-lg-12">
            <h2 class="text-center">Article Content</h2>
            <hr class="my-4"/>
            <p class="pt-4">&nbsp;</p>
        </div>
        <div class="col-lg-12">
            
            <label for="set_cat">Set Category</label>
            <select name="set_cat" id="set_cat" class="form-control set_cat">
                <option value=0>--Select Category--</option>
<?php
    if($get_cat):
        $num = 0;
        foreach($get_cat as $row):

            $num++;
?>
    <option value="<?php echo $row->cat_id; ?>">
<?php echo"{$num} {$row->cat_title} >> [OF SECTION {$row->cat_section}] >>  [OF URI  {$row->cat_uri}]"; ?>
</option>
<?php
            endforeach;
        endif;
?>
            </select>
            <p class="pt-2">&nbsp;</p>
            <label for="set_tmp">Set Template</label>
            <select name="set_tmp" id="set_tmp" class="form-control set_tmp">
                <option value=0>-- SELECT TEMPLATE --</option>
<?php
            if($get_tmp):
                $num_t = 0;

                foreach($get_tmp as $row):
                    $num_t++;
?>
    <option value="<?php echo $row->tmp_id; ?>">
<?php echo"{$num_t} >> {$row->tmp_title} >> {$row->tmp_uri}"; ?>
</option>
<?php
                endforeach;
        
            endif;
?>
            </select>
            <p class="pt-4">&nbsp;</p>
    
        </div>
    </div>
</div>

<label for="ar_title">Title or Meta name</label>
<div class="input-group mb-3">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon4">Title</span>
  </div>
  <input type="text" class="form-control ar_title" id="ar_title" name="ar_title" aria-describedby="basic-addon4">
</div>

<label for="ar_sum">Summary of this content</label>
<div class="form-group">
  
  <textarea class="form-control ar_sum" name="ar_sum" aria-label="ar_sum" id="ar_sum"></textarea>
</div>
<p class="pt-2">&nbsp;</p>

<label for="ar_body">Content</label>
<div class="form-group">
      <textarea class="form-control ar_body" name="ar_body" aria-label="ar_body" id="ar_body"></textarea>
    <p class="pt-3">&nbsp;</p>
</div>

<div class="row">
  <div class="col-lg-4">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="is_pub" class="is_pub" id="is_pub" aria-label="Checkbox for following text input">
          </div>
        </div>
          <input type="text" class="form-control" aria-label="Text input with checkbox" value="Public" disabled>
    </div>
  </div>

  <div class="col-lg-4">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="is_index" class="is_index" aria-label="">
          </div>
        </div>
          <input type="text" class="form-control ind_text" aria-label="" value="Show in index page" disabled>
    </div>
  </div>

  <div class="col-lg-4">
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="checkbox" name="is_approve" class="is_approve" id="is_approve"  aria-label="">
          </div>
        </div>
          <input type="text" class="form-control appr_text" aria-label="" value="This content is approve" disabled>
    </div>
  </div>

</div>


</form>
<div class="modal_status">
</div>

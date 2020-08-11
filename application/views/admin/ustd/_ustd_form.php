<form id="frmStatus" action="<?php echo site_url("ustd/adminSave"); ?>">

    <div class="form-group">
        <select class="set_cat form-control" name="set_cat">
            <option value=0>
-- select category --
<?php
    if($get_cat):
        $num = 0;
        
        foreach($get_cat as $row):
            $num++;
?>
    <option value="<?php echo $row->cat_id; ?>">
<?php echo"{$row->cat_title} in >> {$row->cat_section} >> {$row->cat_des}"; ?>
</option>
<?php
        endforeach;
    else:
        echo"There is no category yet";
    endif;
?>
            </option>


        </select>
        <p class="pt-3">&nbsp;</p>
    </div>
    <div class="form-group get_tmp">
        <label for="set_tmp">Set Template</label>
        <select name="set_tmp" id="set_tmp" class="set_tmp form-control">
            <option value=0>--Select Template--</option>
        </select>
    </div>

<div class="form-group">
    <label for="st_title">Title</label>
    <input type="text" class="form-control st_title" name="st_title" id="st_title">
    <input type="hidden" name="uniq_id" class="uniq_id">
    <input type="hidden" name="st_user_id" class="st_user_id">
    <input type="hidden" name="st_id" class="st_id">
</div>

<div class="form-group">
    <label for="st_sum">Summary</label>
    <textarea name="st_sum" id="st_sum" class="form-control st_sum "></textarea>
    <p class="pt-3">&nbsp;</p>
</div>

<div class="form-group">
    <label for="st_body">Body</label>
    <textarea class="form-control st_body" name="st_body" id="st_body"></textarea>
</div>

<div class="form-group">
    <p>&nbsp;</p>
   <label class="alert alert-success checkbox-inline">
      <input type="checkbox" class="show_public" name="show_public" value="1"> Show public
    </label>   
    <label class="alert alert-warning checkbox-inline">
      <input type="checkbox" class="friend_only" name="friend_only" value="1"> Friend Only
    </label> 
    <label class="alert alert-danger checkbox-inline">
      <input type="checkbox" class="private_only" name="private_only" value="1"> Private Only
    </label> 


</div>



</form>

<form id="tmp" action="<?php echo site_url("template/adminSave") ?>">

    <!-- the hidden field -->
    <input type="hidden" name="tmp_id" id="tmp_id" class="tmp_id">
    <input type="hidden" name="tmp_user_id" id="tmp_user_id" class="tmp_user_id">
    <input type="hidden" name="cat_id" id="cat_id" class="cat_id">


    <div class="form-group">
        <label for="set_cat">Template category</label>
        <select  name="set_cat" id="set_cat" class="form-control set_cat" required>
            <option value=0>--- Select Option ---</option>
<?php
    if($get_cat):
        $num = 0;
        foreach($get_cat as $row):
            $num++;
?>
        <option value="<?php echo $row->cat_id; ?>">
        <?php echo"{$num} {$row->cat_title}"; ?>
        </option>
<?php
            endforeach;
        endif;
?>
        </select>
        <p>&nbsp;</p>
    </div>

    <div class="form-group">
        <label for="tmp_uri">URI</label>
        <input type="text" name="tmp_uri" id="tmp_uri" class="form-control tmp_uri">
        <p>you can leave this field blank.</p>
    </div>
    <div class="form-group">
        <label for="tmp_title">Title</label>
        <input type="text" name="tmp_title" id="tmp_title" class="form-control tmp_title">
        <p>The title of this template</p>
    </div>
    <div class="form-group">
        <label for="tmp_des">Description</label>
        <textarea  name="tmp_des" id="tmp_des" class="form-control tmp_des tinymce"></textarea>
    
        <p>Description just to explian</p>
        <p class="pt-2">&nbsp;</p>
    </div>

        <div class="form-group">
            <label for="tmp_body">Body</label>
            <textarea name="tmp_body" id="tmp_body" class="form-control tmp_body tinymce"></textarea>
            <p class="pt-4">&nbsp;</p>
        </div>
    <div class="form-group">
            <label for="is_pub" class="form-inline">
            <input type="checkbox" name="is_pub" id="is_pub" class="form-control is_pub"> Show Public
            </label>
            <p>Show as public</p>
        </div>
 
</form>

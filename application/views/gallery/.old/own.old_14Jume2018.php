<div class="container">
  <div class="jumbotron">
    <h1>Gallery of <?php echo $user_name; ?></h1>

  </div>

<div class="page-header">
<h1>What will do in this page</h1>
<p>-The user can see his photo</p>
<p>-The user can create album and upload more photo</p>
<p>-The user can DELETE his own photo</p>
</div>

<div class="col-sm-10">
<!--Modal start-->
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h1>Add new Picture</h1>
</div>
<div class="modal-body">
<?php
    echo form_open_multipart("gallery/add_pic","class='form-horizontal'");
?>
<div class="form-group">
<label class="label-control col-sm-2">Pic Name</label>
<div class="col-sm-6">
<input type="text" class="form-control" name="txtPicTitle" />
</div>
</div>
<div class="form-group">
<label class="label-control col-sm-2"></label>
<div class="col-sm-6">
<input type="file" name="userfile" class="btn btn-primary"/>
</div>
</div>
<div class="form-group">
</div>

</div>
<div class="modal-footer">
<button class="btn btn-info btnUpload" type="submit">
Upload
</button>

</form>
</div>
</div>
</div>
<!--end of modal-->
<div class="show_pic">

</div>
<span class="pic_detail">
<form class="form-horizontal">
<div class="form-group">
<label class="label-control col-sm-4">URL</label>
<div class="col-sm-6">
<input type="text" class="form-control pic_url" />
</div>
</div>
<div class="form-group">
<label class="label-control col-sm-4">Photo Name</label>
<div class="col-sm-6">
<input type="text" class="form-control pic_name" />
</div>
</div>
</form>
</span>
<div class="gallery cf">
<?php
    if($num_my_pic == 0):
        echo"<div class='btn btn-danger'>There is no pic</div>";
    else:
        foreach($get_my_pic as $row):
        $thumb_pic = site_url("public/image/thumb/".$row->thumb_name);
        $thumb_name = mb_strimwidth($row->pic_title,0,10,"...");
        $ln_pic = anchor(site_url("gallery/show_pic/".$row->pic_id),$thumb_name);
        ?>
        <div class="img_thumb">
        <span>
        <?php echo $ln_pic; ?>


        </span>
        <img src="<?php echo $thumb_pic; ?>" />
        <button class="btn btn-info btnShowPic"
        data-pic_id="<?php echo $row->pic_id;?>" type="button">
        show detail
        </button>

        </div>
        <?php
        endforeach;
    endif;
?>
</div>
<div class="pagination">
<?php
    echo $this->pagination->create_links();
?>
</div>
</div>
</div><!--end of div.container-->
<script>
jQuery(document).ready(function(){
    var myGallery = (function(){
var $el = jQuery(".container");
var $status = $el.find(".status");
var $btnShowPic = $el.find(".btnShowPic");
var divShowPic = $el.find(".show_pic");
var divPicDetail = $el.find(".pic_detail");
var $pic_name = $el.find(".pic_name");
var $pic_url = $el.find(".pic_url");
//hide the element
divPicDetail.hide();
        function showPic(){
           var pic_id = jQuery(this).attr("data-pic_id");
           var url = "<?php echo site_url("gallery/show_pic"); ?>";
           var data = {
            pic_id : pic_id

            };
        jQuery.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
                var result = jQuery.parseJSON(e);
                var pic_url = result.pic_url;
                var pic_name = result.pic_name;
                var showPic = result.show_img;
                divShowPic.html(showPic);
                $pic_url.val(pic_url);
                $pic_name.val(pic_name);
               // alert(showPic);
                setTimeout(function(){
                    divPicDetail.show();
                },400);
            }
        });
        }//end of show_pic
        function getEvent(){
            $btnShowPic.on("click",showPic);
        }
        return{
        getEvent : getEvent
        }
    })();
    myGallery.getEvent();
});
</script>

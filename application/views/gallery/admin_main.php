<div class="jumbotron">
    <h1>Gallery Admin</h1>
    <div class="col-md-6">
    <h2>All photos <span class="label label-info num_pic_result">0</span> item(s).</h2>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="page-header col-md-10">
            <h3>Upload new pic</h3>
        </div>
        <div class="col-md-10">
            <form class="form-horizontal" action="<?php echo site_url("gallery/ajaxDoUpload");?>" id="frmUpload" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="label-control col-sm-4">Pic Title</label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control txtPicTitle" name="txtPicTitle" required>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">
                        Public
                    </label>
                    <div class="col-sm-6">
                        <select class="form-control pic_pub" name="pic_pub" required>
                            <option value="">--Please Select--</option>
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="label-control col-sm-4">Pic Title</label>
                    <div class="col-sm-6">
                        <input type="file" class="userfile" name="userfile" hidden required>
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">&nbsp;</label>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary btnSave" form="frmUpload">
                        Upload
                        </button>
                    </div>
                    
                </div>

                <div class="form-group">
                    <label class="label-control col-sm-4">&nbsp;</label>
                    <div class="col-sm-6">
                        <div class="preview"><!--dynamic preview the image before upload--></div>
                        
                    </div>
                    
                </div>
                <div class="form-group">
                    <label class="label-control col-sm-4">&nbsp;</label>
                    <div class="col-sm-6">
                        <div class="show_result"></div>
                        <div class="progress progress-striped active">
                            <div class="progress-bar" style="width:0%"></div>
                        </div>
                        <p class="show_prog"></p>
                    </div>
                    
                </div>
            </form>
        </div>
        <div class="page-header col-md-10">
                
            </div>
        <div class="col-sm-10 gallery_show_list">
        <!--dynamic-->
        </div>
        <div class="col-sm-10 gallery_pagination" id="paginator">
            
        </div>
        <div class="col-md-10 showPlace">
        
        </div>
        
        
    </div>
    

</div>



<?php 
    require"adminJS.php";
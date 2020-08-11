<div class="jumbotron">
    <h1>จัดการรูปภาพ/คลังรูปภาพ</h1>
</div>

<!--show gallery and form-->
<div class="container">
        <div class="well">
            <h3>ข้อควรระวัง</h3>
            <ol>
                <li>file รูป จะต้องมีขนาดไม่เกิน 1 เมก</li>
                <li>file ที่อนุญาตให้อัพโหลด ".jpg,.JPEG,.png" เท่านั้น</li>
                <li>กรุณาตรวจสอบก่อนลบไฟล์</li>
            </ol>
        </div>

    <!--form upload section-->
    <div class="col-md-10">
        <div class="page-header">
            <h2>เพิ่มรูปภาพใหม่</h2>
        </div>
        
        <form class="form-horizontal" id="frmUploadPic" enctype="multipart/form-data" action="<?php echo site_url("gallery/ajaxDoUpload");?>">
            <div class="form-group">
                <label class="label-control col-sm-4">
                    ชื่อรูป
                </label>
                <div class="col-sm-6">
                    <input type="text" name="txtPicTitle" class="form-control txtPicTitle" required>
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">
                    แสดงเป็นสาธารณะ
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
                <label class="label-control col-sm-4">
                    เลือกรูปภาพ
                </label>
                <div class="col-sm-6">
                    <input type="file" name="userfile" class="userfile" hidden required>
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">
                    &nbsp;
                </label>
                <div class="col-sm-6">
                    <button class="btn btn-primary btnSave" type="submit" form="frmUploadPic">
                    อัพโหลด
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
    <!--end of form--> 
    

    <!--edit place--> 
    <div class="col-md-12 edit_place">
        <!--dynamic-->
    </div>

    

    
    
    
</div>

<!--end of gallery and form upload--> 

<!--new tab--> 
<div class="container">
    <div class="page-header">
        <h1>Gallery 1.02</h1>
    </div>
    <ul class="nav nav-tabs">
		<li class="active">
            <a  href="#1" id="tab_pri_pic" data-toggle="tab">My Gallery</a>
		</li>
		<li>
            <a href="#2" id="tab_pub_pic" data-toggle="tab">Public Gallery</a>
		</li>
        <li>
            <a href="#3" id="tab_approve_pic" data-toggle="tab">
                Not Approve
            </a>
		</li>
		
	</ul>

	<div class="tab-content ">
		<div class="tab-pane active" id="1">
            <h3>
                <?php echo $user_name;?>'s Gallery has
                &nbsp;<span class="label label-info num_pri">0</span>&nbsp;item(s).
            </h3>
            <p>
            แสดงรูปภาพใน Gallery ของ <?php echo $user_name;?> ทั้งหมด
            </p>
            <!--show own gallery-->
                    
            <div class="col-md-12 gallery cf pri_list">
                <div class="alert alert-danger">
                    <h2>
                        There are no photo!
                    </h2>
                    </div>
                </div>
                <div class="pagination cf pri_pagin">

                <!--pagination for private image-->
                </div>
                <!--end of show gallery-->
			</div>
			<div class="tab-pane" id="2">
                <h3>
                    Public Gallery | รูปภาพโพสโดยสมาชิก
                    <span class="label label-info num_pub">0</span>
                </h3>
                <p>
                    รูปภาพเหล่านี้โพสโดยสมาชิกและกำหนดให้เป็นสาธารณะที่ทุกๆ คนสามารถมองเห็นได้แม้ไม่ได้ Login
                </p>
                <p>
                    ท่านสามารถกำหนดให้รูปภาพที่ไม่เหมาะสมไม่แสดงในรายการสาธารณะได้
                </p>
                <div class="col-md-12 gallery cf pub_list">
    
                </div>
                <!--end of show public gallery-->
                <!--show pagination--> 
                <div class="pagination cf pub_pagin">
                <!--pagination for public image-->
                </div>
			</div>
            <div class="tab-pane" id="3">
                <h3>
                    Not Approve | รูปภาพโพสโดยสมาชิก ไม่อนุญาตให้แสดง
                    <span class="label label-info num_approve">0</span>
                </h3>
                <p>
                    รูปภาพเหล่านี้โพสโดยสมาชิกและกำหนดไม่ให้แสดงสาธารณะ 
                </p>
                <p>
                    ท่านสามารถกำหนดให้รูปภาพที่ไม่เหมาะสมไม่แสดงในรายการสาธารณะได้
                </p>
                <div class="col-md-12 gallery cf approve_list">
    
                </div>
                <!--end of show public gallery-->
                <!--show pagination--> 
                <div class="pagination cf approve_pagin">
                <!--pagination for public image-->
                </div>
			</div>
            
		</div>
    </div>
</div>

<!--end of tab-->


<?php require("moderateJS.php");


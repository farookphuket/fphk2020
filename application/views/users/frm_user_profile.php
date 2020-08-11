
<div class="jumbotron">
<h1><?php echo $user_name;?>'s profile</h1>

</div>
<div class="page-header">
    <h2>Please Note :</h2>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="well">
            <ul>
                <li>Please confirm your password in order to save change</li>
            </ul>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="well">
            <ul>
                <li>เพื่อบันทึก กรุณายืนยันรหัสผ่านของท่านอีกครั้งก่อนกดปุ่ม Save</li>
            </ul>
        </div>
    </div>
</div>

    <div class="panel panel-info">
        <div class="panel-heading">
            <h1>Member Info</h1>
         </div>
          <div class="panel-body">
            
<!--form in div.panel-body start-->

<form class="form-horizontal" id="frmUserProfile" action="<?php echo site_url("users/profile");?>">
    <div class="form-group">
        <label class="label-control col-sm-4">Name</label>
        <div class="col-sm-6">
            <input type="text" class="form-control u_name" name="u_name">
            
            <input type="hidden" class="u_id" name="u_id">
             
        </div>
    </div>
    <div class="form-group">
        <label class="label-control col-sm-4">E-mail</label>
        <div class="col-sm-6">
            <input type="text" class="form-control u_email" name="u_email">
              
        </div>
    </div>
    <div class="form-group">
        <label class="label-control col-sm-4">tel</label>
        <div class="col-sm-6">
            <input type="text" class="form-control u_tel" name="u_tel">
             
        </div>
    </div>
    <div class="form-group">
        <label class="label-control col-sm-4">About Me</label>
        <div class="col-sm-6">
            <div class="label_user">
            enable auto saving
            </div>

        </div>
    </div>
    <div class="form-group">
        <label class="label-control col-sm-4">&nbsp;</label>
        <div class="col-sm-6">
            <textarea class="form-control about_user" name="about_user">
            
            </textarea>

        </div>
    </div>
    <div class="well">
    <p>if you do not want change your password so just live this blank</p>
    <p>หากคุณไม่ต้องการเปลี่ยนรหัสผ่าน กรุณาเว้นช่องนี้ไว้</p>
    </div>
    <div class="form-group">
        <label for="" class="label-control col-sm-4">Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control nPass" name="nPass">
        </div>
    </div>
    <div class="form-group">
        <label for="" class="label-control col-sm-4">Re-Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control rePass" name="rePass">
        </div>
    </div>
    <div class="well">
        <p>please confirm your current password to save the change</p>
        <p>กรุณายืนยันรหัสผ่านของคุณอีกครั้ง เพื่อบันทึกการเปลี่ยนแปลง</p>
    </div>
    <div class="form-group">
        <label class="label-control col-sm-4">confirm your Password</label>
        <div class="col-sm-6">
            <input type="password" class="form-control conf_passwd" name="conf_passwd">
        </div>
    </div>

</form>
<!--end of form in div.panel-body -->

          </div>
           <div class="panel-footer">
                <div class="modal_status pull-right">
                </div>
            <button class="btn btn-info btnSave" type="submit" form="frmUserProfile">
                Update my info!
            </button>
            </div>
</div>

<?php
    require("userProfileJS.php");

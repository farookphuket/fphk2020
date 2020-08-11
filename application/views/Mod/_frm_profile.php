<form action="<?php echo site_url("mod/saveMyProfile");?>" id="myProfile">

  <div class="form-group">
    <label for="mName">Name</label>
    <input type="text" name="mName" id="mName" class="form-control mName" />
    <input type="hidden" name="mId" class="mId" />
  </div>

  <div class="form-group">
    <label for="mEmail">E-Mail</label>
    <input type="email" name="mEmail" id="mEmail" class="form-control mEmail" />
  </div>

  <div class="form-group">
    <label for="mTel">Tel</label>
    <input type="number" name="mTel" id="mTel" class="form-control mTel" />
  </div>
  <div class="form-group">
    <label for="about_user">About Me</label>
    <textarea name="about_user" class="form-control about_user" rows="10"></textarea>
  </div>

  <div class="col-lg-12">
    <p>&nbsp;</p>
    <p>If you do not want to change your current password so just leave the "new password" field empty!</p>
  </div>
  <div class="form-group">
    <label for="newPass">New Password</label>
    <input type="password" name="newPass" class="form-control newPass" />
  </div>
  <p>&nbsp;</p>
  <div class="col-lg-12">
    <p>&nbsp;</p>
    <p>
      <strong>To</strong> save your change you have to put your current password to confirm the profile change. | หากต้องการเปลี่ยนแปลงข้อมูลส่วนตัวท่านจำเป็นต้องใส่รหัสผ่านเพื่อยืนยัน เมื่อใส่รหัสผ่านแล้วคลิกบริเวณอื่น 1 ครั้ง
    </p>
  </div>
  <div class="form-group">
    <label for="passConf">Enter password then click 
      <span class="badge badge-success">here</span>
    </label>
    <input type="password" name="passConf" class="form-control passConf" />
    <p>&nbsp;</p>
  </div>
  <div class="form-group">
    <div class="float-right">
      <button type="submit" class="btn btn-primary btn-sm btnSave" form="myProfile">Save</button>
    </div>
  </div>
</form>

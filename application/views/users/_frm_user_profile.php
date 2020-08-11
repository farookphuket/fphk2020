<form id="userProfile" action="<?php echo site_url("users/saveMemberProfile");?>">

  <div class="form-group">
    <label for="u_name">Name</label>
    <input type="text" name="u_name" class="form-control u_name" id="u_name" />
    <input type="hidden" name="u_id" class="u_id" />
    <input type="hidden" name="oldPass" class="oldPass" />
  </div>
  <div class="form-group">
    <label for="u_email">Email</label>
    <input type="email" name="u_email" class="form-control u_email" id="u_email" />

  </div>

  <div class="form-group">
    <label for="u_tel">Tel</label>
    <input type="number" name="u_tel" class="form-control u_tel" id="u_tel" />

  </div>
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="u_about">About Me</label>
    <textarea name="u_about" id="u_about" class="form-control u_about" rows="10"></textarea>
    <p>&nbsp;</p>
  </div>
  <p>&nbsp;</p>
  <div class="form-group">
    <p>
      dear <strong><?php echo $user_name;?></strong>&nbsp;<br />
      the "new password" field is only if you want to change your current password.<br />
      ถ้าท่านไม่ต้องการเปลี่ยนรหัสผ่านกรุณาเว้นช่องนี้ว่างไว้
    </p>
    <label for="newPass">New Password</label>
    <input type="password" name="newPass" class="form-control newPass" id="newPass" />

  </div>
  <p>&nbsp;</p>
  <div class="form-group">
    <label for="passConfirm">Confirm password</label>
    <input type="password" name="passConfirm" class="form-control passConfirm" id="passConfirm" required />
    <br>
    <p>Enter your password to save change<br />
      ใส่รหัสผ่านเพื่อยืนยันการเปลี่ยนแปลง
    </p>
  </div>
  <p>&nbsp;</p>
  <div class="form-group">
    <div class="fResult">

    </div>
  </div>
  <p>&nbsp;</p>
  <div class="form-group">

    <label for="">&nbsp;</label>
    <div class="float-right">
      <button class="btn btn-primary btnSave" type="submit" form="userProfile">Save</button>
    </div>
  </div>

</form>

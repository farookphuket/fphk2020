<form id="frmUser" action="<?php echo site_url("users/adminSaveUser");?>">

  <div class="form-group">
    <label for="user_name">User Name</label>
    <input type="text" name="user_name" class="form-control user_name" id="user_name" required>
    <input type="hidden" name="user_id" class="user_id" />
  </div>
  <div class="form-group">
    <label for="user_email">User Email</label>
    <input type="text" name="user_email" class="form-control user_email" id="user_email" required>
  </div>
  <div class="form-group">
    <label for="user_tel">User Tel</label>
    <input type="text" name="user_tel" class="form-control user_tel" id="user_tel" required>
  </div>
  <div class="form-group">
    <div class="float-right">
      <input type="checkbox" class="about_tmp"> Need Template
    </div>
    <label for="about_user">About User</label>
    <textarea name="about_user" class="form-control about_user" rows=8></textarea>
    <p>&nbsp;</p>
    <div class="aboutResult">

    </div>
    <p>&nbsp;</p>
  </div>

  <div class="form-group">
    <label for="">&nbsp;</label>
    <div class="row">
      <div class="col-lg-3">
        <div class="text-center">
          <input type="checkbox" name="user_mod" class="user_mod" id="user_mod"> Set Moderate
        </div>

      </div>
      <div class="col-lg-3">
        <div class="text-center">
          <input type="checkbox" name="user_active" class="user_active" id="user_active"> Set Acivate
        </div>

      </div>
      <div class="col-lg-3">
        <div class="text-center">
          <input type="checkbox" name="user_ban" class="user_ban" id="user_ban"> Set Ban User
        </div>

      </div>
    </div>
  </div>

</form>

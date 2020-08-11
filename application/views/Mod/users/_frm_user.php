<form id="userForm" action="<?php echo site_url("users/modSaveUser");?>">

  <div class="form-group">
    <label for="user_name">User Name</label>
    <input type="text" name="user_name" id="user_name" class="form-control user_name" />
    <input type="hidden" name="user_id" class="user_id" />
  </div>
  <div class="form-group">
    <label for="user_email">E-mail</label>
    <input type="email" name="user_email" id="user_email" class="form-control user_email" />
  </div>
  <div class="form-group">
    <label for="user_tel">Tel</label>
    <input type="number" name="user_tel" id="user_tel" class="form-control user_tel" />
  </div>
  <p>&nbsp;</p>
  <div class="row">
    <div class="col-md-6">
      <label class="checkbox-inline">
        <input type="checkbox" name="active" class="active"> Set As <strong>Activate</strong>
      </label>
    </div>
    <div class="col-md-6">
      <label class="checkbox-inline">
        <input type="checkbox" name="ban" class="ban">  <strong>Ban</strong> This user
      </label>
    </div>
  </div>

</form>

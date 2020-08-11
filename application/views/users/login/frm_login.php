<form class="" action="<?php echo site_url("login/getLogin"); ?>"  id="user_login">

    <div class="form-group">
        <label for="">E-Mail</label>
        <input type="email" name="u_email" class="form-control u_email" required>
    </div>
    <div class="form-group">
        <label for="">Password</label>
        <input type="password" name="u_pass" class="form-control u_pass" required>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-lg-4">
               <button type="submit" form="user_login" class="btn btn-success btnLogin">Login</button>
                 <p>&nbsp;</p>
            </div>
            <div class="col-lg-4">
            <a href="<?php echo site_url("login/forgot_pass"); ?>" class="btn btn-info btnForgot">forgot password</a> 
            <p>&nbsp;</p>
            </div> 
            <div class="col-lg-4">
               <a href="#" style="color:white;" class="btn btn-warning btnRegister">Register</a> 
            <p>&nbsp;</p>
            </div> 
        </div>
    </div>
    <div class="form-group">
        <div class="frmResult">
            
        </div>
    </div>

</form>

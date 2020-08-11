<section class="register">
    <div class="row">
        <div class="container">
            <h1 class="text-center">Please Read Me Carefully</h1>
            <p>
                <strong>Dear User</strong>
                before you begin to start put any of your information into the form below I am as the owner of this website want you to know that you're no need to be a member of this website as you know that there in none of any part that require you to pay unless you are booking the tour which we have to take you deposite on it to confirm that you will be able to come.
            </p>
        </div>
    </div>

</section>

<section id="register">
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <form class="form-horizontal" id="frmRegis" action="<?php echo site_url("register/userRegister");?>">
                    <div class="form-group">
                        <label for="user_name">User Name</label>
                        <input type="text" id="user_name" name="user_name" class="form-control user_name" required/>
                    </div>
                    <div class="form-group">
                        <label for="user_email">E-mail</label>
                        <input type="email" id="user_email" class="form-control user_email" name="user_email" required/>
                    </div>
                    <div class="form-group">
                        <label for="user_pwd">Password</label>
                        <input type="password" id="user_pwd" name="user_pwd" class="form-control user_pwd" />
                    </div>
                    <div class="form-group">
                        <label for="pass_conf">Password Confirm</label>
                        <input type="password" id="pass_conf" name="pass_conf" class="form-control pass_conf" />
                    </div>


                    <p>
                        &nbsp;
                    </p>
                    <div class="form-group float-right">
                        <label>&nbsp;</label>
                        <button class="btn btn-sm btn-primary btnSave" type="submit" form="frmRegis">Register</button>
                        <a href="<?php echo site_url("home");?>" class="btn btn-danger btn-sm">cancle</a>
                    </div>
                </form>
                <p>
                    &nbsp;
                </p>
                <div class="fResult"></div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        var $el = $("#register");
        var $page_status = $(".status");

        var register = (function(){
            //---get the form
            var $f = $el.find("#frmRegis");
            var $fResult = $el.find(".fResult");

            //---input field
            var u_name = $el.find(".user_name");
            var u_email = $el.find(".user_email");
            var pass_conf = $el.find(".pass_conf");
            var u_pwd = $el.find(".user_pwd");

            var btnSave = $el.find(".btnSave");
            btnSave.prop("disabled",true);

            var err = 0;
            var msg = "";

            //---getName
            function getName(){
                var name = u_name.val();
                if(!name){
                    return false;
                }else{
                    var url = "<?php echo site_url("register/chName");?>";
                    var data = {user_name:name};
                    $.ajax({
                        type:"post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            if(parseInt(rs.err) === 1){
                                $page_status.html(rs.msg).show();
                                err = 1;
                                showError("name",rs.msg);
                            }
                            setTimeout(function(){
                                $page_status.html("loading...").fadeOut("slow");

                            },2000);
                            err = 0;
                        }
                    });
                }
            }
            /////////////////
            //----getEmail------//
            function checkEmail(){
                if(!u_email.val()){
                    return false;
                }else{
                    var url = "<?php echo site_url("register/chEmail");?>";
                    var data = {user_email : u_email.val()};
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            if(parseInt(rs.err) === 1){
                                $page_status.html(rs.msg).show();
                                err = 1;
                                showError("email",rs.msg);
                            }
                            err = 0;
                            setTimeout(function(){
                                $page_status.html("loading..").fadeOut("slow");
                            },4000);
                        }
                    });
                }

            }

            /////////////////////////
            //---chkPass
            function chkPass(){
                var p1 = u_pwd.val();
                var p2 = pass_conf.val();
                err = 0;
                msg = "";

                var fieldName = "";
                if(!u_name.val()){
                    err = 1;
                    msg = "Error : name is required!";
                    fieldName = "name";
                }else if(!u_email.val()){
                    err = 1;
                    msg = "Error : email is required!";
                    fieldName = "email";
                }else if(!u_pwd.val()){
                    err = 1;
                    msg = "Error : password is required!";
                    fieldName = "password";
                }else if(p1 != p2){
                    err = 1;
                    msg = "Error : password is not match to the password confirm";
                    fieldName = "password";
                }

                if(err === 1){
                    showError(fieldName,msg);
                }else{
                    $fResult.html("").fadeOut("slow");
                    btnSave.prop("disabled",false);

                }

            }
            ///////////////////////
            //----registerMe
            function registerMe(){
                btnSave.unbind();
                $f.submit(function(e){
                    e.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        //console.log(e);
                        var rs = $.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        msg = `
                        <div class="alert alert-success">
                            <p>
                                ${rs.msg}
                            </p>
                        </div>
                        `;
                        $fResult.html(msg).show();
                        setTimeout(function(){

                            $fResult.html("loading...").fadeOut("slow");
                            $page_status.html("loading...").fadeOut("slow");
                            $f.trigger("reset");
                            btnSave.prop("disabled",true);
                        },8000);
                    });
                })
            }
            /////////showError
            function showError(fieldName,errorMsg){
                $fResult.html("");
                var tmp_msg = "";

                switch(fieldName){
                    case"name":
                        fieldName = u_name;
                    break;
                    case"email":
                        fieldName = u_email;

                    break;
                    case"password":
                        fieldName = u_pwd;
                    break;
                }

                setTimeout(function(){
                    fieldName.focus();
                    tmp_msg = `
                    <div class="alert alert-danger">
                        ${errorMsg}
                    </div>
                    `;
                    $fResult.html(tmp_msg).show();

                },4000);

            }
            //---getEvent
            function getEvent(){
                setTimeout(function(){
                    $f.trigger("reset");
                },300);
                u_name.on("blur",function(){
                    getName();
                });

                //-----u_email.focus
                u_email.on("focus",function(){
                    $fResult.html("");
                });

                u_pwd.on("focus",function(){
                    $fResult.html("");
                });
                //---pass_conf
                pass_conf.on("blur",function(){
                    chkPass();
                });
                //-----u_email
                u_email.on("blur",function(){
                    checkEmail();
                });

                btnSave.on("click",function(){
                    registerMe();
                });
            }
            return{getEvent:getEvent}
        })();
        register.getEvent();
    });
</script>

<?php
    //--change the javascript on 23-6-2019 4:20 p.m.
    //require("registerJS.php");
    //$js = "users/registerJS.php";
    //$this->load->view($js);

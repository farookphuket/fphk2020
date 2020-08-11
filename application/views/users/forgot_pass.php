<section id="forgot_pass">
    <div class="row">
        <div class="col-lg-12">
            <div class="container">
                <h1 class="text-center">Lost your password?</h1>
                <p>&nbsp;</p>
                <div class="row">
                       <div class="col-lg-6">
                        <ul>
                            <li>
                                Try login with your google account
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <!--google link-->
                        <div class="g-signin2" data-onsuccess="onSignIn"></div>
                        <!--END of google link-->
                    </div>
                    <script>
                        function onSignIn(googleUser) {
                          var u = googleUser.getBasicProfile();
                                    var g_email = u.getEmail();
                                    var g_name = u.getName();

                                    //--sever url
                                    var to_url = "<?php echo site_url("login/googleLogin");?>";
                                    //---data to send
                                    var data = {
                                        g_email : g_email,
                                        g_name : g_name

                                    };

                                    $.ajax({
                                        type : "post",
                                        url : to_url,
                                        data : data,
                                        success : function(e){
                                            var rs = $.parseJSON(e);
                                            $(".status").html(rs.msg).show();
                                            var rd = rs.url;
                                            setTimeout(function(){
                                                location.href = rd;
                                            },2000);
                                        }
                                    });
                        }
                    </script>
                </div>
                
            </div>
        </div>

    </div>
</section>

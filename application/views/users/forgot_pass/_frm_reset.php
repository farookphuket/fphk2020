<section id="forgot_pass">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">Forgot Password?</h1>
                <p>before you begin to reset your password would you like to try the below option?</p>
                <p class="pt-4">&nbsp;</p>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Try login with google</h3>
                    </div>
                    <div class="card-body">
                        <p class="">
                            if you use google service so why don't you try their service with us
                        </p>
                        <span class="float-right">
                        <a href="<?php echo site_url("login/loadForm"); ?>" class="btn btn-primary lnGoogle" style="color:white;font-weight:bold;">Google Login</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Try login with facebook</h3>
                    </div>
                    <div class="card-body">
                        <p class="">
                            are you on facebook? so try login to your account with your facebook account.
                        </p>
                        <span class="float-right">
                            <a href="" class="btn btn-info lnFacebook" style="color:white;font-weight:bold;">Facebook Login</a>
                        </span>
                    </div>
                </div>
            </div>

                               

            </div>
        </div>
    </div>
</section>
<script charset="utf-8">
$(function(){
    const $P = $("#forgot_pass");
    const $fgt = (function(){

        let lnGoogle = getEl(".lnGoogle");
        let lnFacebook = getEl(".lnFacebook");


        function goShowForm(cmd){

            let url = "";
            switch(cmd){
            case"google":
                url = "<?php echo site_url("login/googleLogin") ?>";
            break;
            case"facebook":
                url = "<?php echo site_url("login/facebookLogin") ?>";
            break;

            } 
            location.href = url;

        }

        function getEl(el){
            return $P.find(el);
        }
        function getEvent(){
            lnGoogle.on("click",function(e){
                e.preventDefault();
                goShowForm("google");
            });
            lnFacebook.on("click",function(e){
                e.preventDefault();
                goShowForm("facebook");
            });

        }
        return{getEvent:getEvent}
    })();
    $fgt.getEvent();
}); 
</script>

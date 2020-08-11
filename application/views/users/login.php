<section id="users">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            
            <h1 class="text-center">User Login</h1>
            <p class="pt-2">&nbsp;</p>
<?php
    $frm = "users/frm_login";
    $this->load->view($frm);

?>
        </div>
    </div>
</div>


</section>
<script charset="utf-8">
    $(function(){

        const $SP = $("#users");
        const $page_status = $(".status");
        const $lg = (function(){

            let $frm = getEl("#user_login");
            let $frmResult = getEl(".frmResult");
            let u_email = getEl(".u_email");
            let u_pass = getEl(".u_pass");
            let btnLogin = getEl(".btnLogin");
            

            function getLogin(){
                btnLogin.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize();
                    $.post(url,data,function(e){
                        let rs = $.parseJSON(e);
                        $frmResult.html(rs.msg).show();
                        $page_status.html(rs.msg).show();
                        //---will be redirect to the url
                        let url = rs.url;
                        setTimeout(()=>{
                           $page_status.html("loading...").fadeOut("slow"); 
                           location.href = url;
                        },2000);
                    });
                });
            }

            function getSummary(){

            }

            function getEl(el){
                return $SP.find(el);
            }
            function getEvent(){
                btnLogin.on("click",function(){
                    getLogin();
                });
            }
            return{getEvent:getEvent}
        })();
        $lg.getEvent();

    });
</script>





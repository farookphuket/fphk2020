<script>

//-----call jQuery
$(function(){

    var $el = $(".container");
    var modal_status = $el.find(".modal_status");
    var page_status = $el.find(".status");

    var register = (function(){

        var frm_reg = $el.find("#signup_frm");
        var btnRegis = $el.find(".btnRegis");
        btnRegis.html("please process the form")
        .prop("disabled",true);
        var reg_name = $el.find(".reg_name");
        var reg_pass = $el.find(".reg_pass");
        var reg_email = $el.find(".reg_email");
        reg_name.attr("placeholder","*Enter your name")
        .val("");
        reg_pass.attr("placeholder","*Enter your pass code")
        .val("");
        reg_email.attr("placeholder","*Enter your E-Mail ,we will contact you by this email in 24 hours.")
        .val("");

        function chk_empty(fields){
          var err = 0;
          for(var i in fields){
            if(!fields[i].val() || fields[i].val().length < 4){
              err = 1;
              fields[i].css("background","red");
              
            }else{
              err = 0;
              fields[i].css("background","transparent");

            }
          }
          if(parseInt(err) === 1){
            return false;
          }
          return true;
        }
        //--------------------------chk_name to check if name is ok
        function chk_name(){
          var msg = '';
          var err = 0;
          if(!chk_empty({reg_name})){
            var res = {err : 1,msg : `Error : user name is empty or too short!`};
            showError(res);
          }else{
            var url = "<?php echo site_url("users/signup");?>";
            var data = {cmd : "chk_name",reg_name : reg_name.val()};
            $.ajax({
              type : "post",
              url : url,
              data : data,
              success : function(e){
                var err = 0;
                var msg = '';
                var rs = $.parseJSON(e);
                if(parseInt(rs.err) === 1){
                  err = 1;
                  msg = `${rs.msg}`;
                }
                showError({err:err,msg : msg});
              }
            });
          }
          //if the name is empty or too short
          //or the name is already exited
          //only show the error message Sat 21 Apr 2018
        }//--end chk_name

        function showError(st){
          var err = 0;
          var mg = "";
          if(parseInt(st.err) === 1){
            mg = `<div class="alert alert-danger">
              ${st.msg}
              </div>
              `;
              err = 1;
          }
          modal_status.html(mg).show();
          setTimeout(function(){
            modal_status.fadeOut("slow");
          },4000);

          return err;

        }

        //------------------
        function chk_email(){

            var err = 0;
            if(!chk_empty({reg_name,reg_pass})){
              err = 1;
              showError({err : 1,msg : "please process the form"});
              btnRegis.prop("disabled",true);
            }else{
              var url = "<?php echo site_url("users/signup");?>";
              var data = {reg_email : reg_email.val(),cmd : "chk_email"};
              $.ajax({
                  type : "post",
                  url : url,
                  data : data,
                  success : function(e){
                      var rs = $.parseJSON(e);
                      var m = '';
                      if(parseInt(rs.err) === 1){
                        m = `${rs.msg}`;
                        showError({err : 1,msg : m});
                      }else{
                        btnRegis.html("Register")
                        .prop("disabled",false);
                      }
                  }
              });

            }




        }
        //----------function userRegis
        //this fill fire when the user click on the button
        function userRegis(){
            //alert("working!!");
            btnRegis.unbind();
            frm_reg.submit(function(evt){
                evt.preventDefault();
                var cmd = "regis_user";
                var url = $(this).attr("action");
                var data = $(this).serialize()+"&cmd="+cmd;
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    if(parseInt(rs.error) === 1){

                        showError({err : 1,msg : rs.msg});
                        //refresh page
                    }else{

                        modal_status.html(rs.msg).show();
                        var mBox = `your operation has success!\nplease click 'ok' button to reload the page in 5 second or 'cancle' if you do not want this page to reload`;
                        if(confirm(mBox) === true){
                          setTimeout(function(){
                            location.reload();
                          },5000);
                        }else{
                          return false;
                        }

                    }

                });
            });
        }
        //------------------

        //-----getEvent fireUp the method
        function getEvent(){
            //alert("register Page");

            setTimeout(function(){
                frm_reg.trigger("reset");
                },
            500);

                //send name to check
                reg_name.on("blur",function(){
                    chk_name();
                });

                //check email
                reg_email.on("blur",function(){
                    chk_email();
                });



                //user click the button register
                btnRegis.on("click",function(){
                    userRegis();
                });

        }//end of getEvent
        return{getEvent : getEvent}
    })();

    //----call register
    register.getEvent();


})//End of jQuery

</script>

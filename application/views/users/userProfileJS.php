<script>


$(function(){
  var $el = $(".container");
  var page_status = $el.find(".status");
  var modal_status = $el.find(".modal_status");

  var profile = (function(){

    //get the form element
    var u_id = $el.find(".u_id");
    var frmProfileId = $el.find("#frmUserProfile");
    var about_user = $el.find(".about_user");
    var label_user = $el.find(".label_user");
    var u_name = $el.find(".u_name");
    var u_email = $el.find(".u_email");
    var u_tel = $el.find(".u_tel");

    //the change password field
    var nPass = $el.find(".nPass");
    var rePass = $el.find(".rePass");
    nPass.val("")
    .attr("placeholder","Please enter your new password");
    rePass.val("")
    .attr("placeholder","please re-enter your new password");

    var conf_pwd = $el.find(".conf_passwd");
    about_user.val("");
    var btnSave = $el.find(".btnSave");
    btnSave.html("your current info")
    .prop("disabled",true);

    //getUser
    function getUser(){
      
      var url = "<?php echo site_url("users/profile");?>";
      var data = {cmd : "get_user" , u_id : "<?php echo $user_id;?>"};
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          var rs = $.parseJSON(e);
          //console.log(rs.get);
          $.each(rs.get,function(i,v){
            u_id.val(v.id);
            u_name.val(v.name);
            u_email.val(v.email);
            label_user.html(v.about_user);
            about_user.val(v.about_user);
            u_tel.val(v.tel);
            nPass.val("");
            conf_pwd.attr("placeholder","Please enter your password")
            .val("");
          });
        }
      });

    }
    //-----check the new password
    function check_new_pass(){
      var err = 0;
      if(nPass.val().length < 6 ){
        alert("Error : your password is too short!");
        err = 1;

      }else if(nPass.val() !== rePass.val()){
        alert("Error : the password is not match!");
        err = 1;
      }
      if(parseInt(err) !== 1){
        return nPass.val();
      }
      return false;
    }
    //---
    function chk_pass(){
      var url = "<?php echo site_url("users/conf_pass");?>";
      var data = {passwd : conf_pwd.val()};
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          var rs = $.parseJSON(e);
          if(parseInt(rs.err) !== 0){
            //there is some error
            modal_status.html(rs.msg).show();
          }else{
            modal_status.fadeOut("slow");
            setTimeout(function(){
              btnSave.html("Please click to Update")
              .prop("disabled",false);
            },2000);
          }
        }
      });
    }
    //---saveProfile
    function saveProfile(){
      btnSave.unbind();
      
      $(frmProfileId).submit(function(evt){
        evt.preventDefault();
        var cmd = "profile_save";
        var url = $(this).attr("action");
        var data = $(this).serialize()+"&cmd="+cmd;
        $.post(url,data,function(e){
          var rs = $.parseJSON(e);
          modal_status.html(rs.msg).show();
          setTimeout(function(){
            location.reload();
          },5000);
        });
      });
      
    }

    //--------
    function getEvent(){
      
      //get this user
      getUser();

      //------------Password section
      //nPass
      
      rePass.on("blur",function(){
        check_new_pass();
      });
      //----------

      //check the current passwd
      conf_pwd.on("blur",function(){
        chk_pass();
      });

      btnSave.on("click",function(){
        saveProfile();
      });
    }
    //-----------
    return{getEvent : getEvent}
  })();
  profile.getEvent();
});
</script>
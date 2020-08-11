<script>

$(function(){

  var $el = $(".register");
  var $page_status = $el.find(".status");


  var regist = (function(){

    var reg_name = $el.find(".user_name");
    var reg_email = $el.find(".user_email");
    var btnSave = $el.find(".btnSave");

    var $f = $el.find("#frmRegis");
    var $fResult = $el.find(".fResult");

    function chReserve(name){
      
      if(!reg_name.val()){
        $fResult.html(`Error : this field is required`).show();
        
        setTimeout(function(){
          reg_name.focus();
        },2000);

        return false;
      }else{
        var url = "<?php echo site_url("register/chName");?>";
          var data = {user_name : name};
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              var rs = $.parseJSON(e);
              
              if(parseInt(rs.err) !== 0){
                $page_status.html(rs.msg).show();
                reg_name.focus();
              }else{
                $fResult.html(rs.msg).show();

              }
              
              setTimeout(function(){
                $page_status.html("").fadeOut("slow");
                $fResult.html("loading...").fadeOut("slow");
              },2000);
              
            }
          });
      }
      
      
      
      
    }

    //---check email
    function chEmail(email){
      var url = "<?php echo site_url("register/chEmail");?>";
      var data = {user_email : email};
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          console.log(e);
          var rs = $.parseJSON(e);
          
          if(rs.err !== 0){
            $page_status.html(rs.msg).show();
            reg_email.focus();
          }else{
            $fResult.html(rs.msg).show();
          }
          setTimeout(function(){
              $page_status.html("").fadeOut("slow");
              $fResult.html("").fadeOut("slow");
            },2000);
        }
      });
    }

    //---getRegister
    function getRegister(){
      btnSave.unbind();
      $f.submit(function(e){
        e.preventDefault();
        var url = $(this).attr("action");
        var data = $(this).serialize();
        $.post(url,data,function(e){
          alert(e);
        });
      });
    }

    function getEvent(){

        //---reset form
        $f.trigger("reset");
      //$page_status.html("testing").show();
      reg_name.on("blur",function(){
        chReserve($(this).val());
      });

      //---check the email
      reg_email.on("blur",function(){
        chEmail($(this).val());
      });

      //---btnSave 
      btnSave.on("click",function(){
        getRegister();
      });
    }
    return{getEvent : getEvent}
  })();

  //---call method
  regist.getEvent();
});

</script>

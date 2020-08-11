<script>

    $(function(){

        var $el = $(".container");
        var modal_status = $el.find(".modal_status"); 
        var page_status = $el.find(".status");
        var adminProfile = (function(){

            var admin_id = $el.find(".admin_id"); 
            var name = $el.find(".name");
            var email = $el.find(".email");
            var tel = $el.find(".tel");
            var passwd = $el.find(".passwd");

            var btnSave = $el.find(".btnSave");
            btnSave.prop("disabled",true);


            var url = "<?php echo site_url("admin/profile");?>";

            function getData(){
                var data = {
                    name : name.val(),
                    tel : tel.val(),
                    email : email.val()
                }; 
                return data;
            }//end of getData
            function check_admin(pwd){
                var data = getData();
                data.admin_id = admin_id.val();
                data.command = "check_admin";
                data.passwd = pwd;
                
                $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        if(parseInt(rs.error) === 1){
                            page_status.html(rs.msg).show();
                            setTimeout(function(){
                                page_status.fadeOut("slow");
                                passwd.focus();
                            },3000);
                        }else{
                            btnSave.prop("disabled",false);
                        }
                    }
                });   
            }
            function saveData(){
                btnSave.html("processing...")
                    .prop("disabled",true);
                var data = getData();
                data.command = "update";
                data.admin_id = admin_id.val();
                var url = "<?php echo site_url("admin/profile");?>"; 
                $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        btnSave.html("Success!");
                        modal_status.html(e).show();
                        setTimeout(function(){
                            location.reload();
                        },5000);
                    }
                });
            }
            function getEvent(){
                btnSave.on("click",function(){
                    saveData();
                });
                passwd.on("blur",function(){
                    check_admin($(this).val());
                });
            }
            return{getEvent : getEvent}
        })();

        adminProfile.getEvent();

    });

</script>

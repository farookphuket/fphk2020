<script>

        
        //jQuery
        $(function(){

            var $el = $(".container");
            var page_status = $el.find(".status");


            var manContact = (function(){

                var ip = "<?php echo $ip;?>";

                //----the form id
                var frmContact = $el.find("#frm_contact");
                //---form element
                var faq_id = $el.find(".faq_id");
                var faq_ip = $el.find(".faq_ip");

                var faq_title = $el.find(".faq_title");
                var faq_body = $el.find(".faq_body"); 
                var faq_email = $el.find(".faq_email");
                var btnSave = $el.find(".btn_contact");
                faq_title.attr("placeholder","Enter the title");
                faq_email.attr("placeholder","Enter your e-mail");
                faq_body.attr("placeholder","You can only sent one post per day");
                faq_body.val("");
                //----------
                function getMyFaq(){
                    //this user has post yet
                    var url = "<?php echo site_url("contact/getMyQuestion");?>";
                    $.ajax({
                        url : url,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            //console.log(rs);
                            if(parseInt(rs.num_faq) !== 0){
                                $.each(rs.get_all_faq,function(i,v){
                                    faq_email.val(v.faq_email);
                                    faq_title.val(v.faq_title);
                                    faq_body.val(v.faq_body);
                                    faq_id.val(v.faq_id);
                                    faq_ip.val(v.faq_ip);
                                    btnSave.html("Update");
                                });
                            }
                        }
                    });
                }
                //----------
                function saveMyMessage(){
                    btnSave.unbind();
                    frmContact.submit(function(evt){
                        evt.preventDefault();
                        var url = $(this).attr("action");
                        var data = $(this).serialize();
                        $.post(url,data,function(e){
                            var rs = $.parseJSON(e);
                            page_status.html(rs.msg).show();
                            setTimeout(function(){
                                page_status.html("Reloading...");
                                location.reload();
                                },400);
                        });
                    });
                }

                //----------
                function getEvent(){
                    getMyFaq();
                    btnSave.on("click",function(evt){
                        saveMyMessage();
                    });
                }
                return{getEvent : getEvent}
            })();
            manContact.getEvent();
        });
        //end of jQuery

</script>
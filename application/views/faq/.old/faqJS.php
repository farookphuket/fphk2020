<script>


$(function(){

    var $el = $(".container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");


    var faq = (function(){

        //-------------
        //this method will get the faq by user ip
        //will only work with none login user
        
        //--click link to show answer as toggle
        var lnViewFaq = $el.find(".lnViewFaq");
        var faqDetail = $el.find(".faq_detail");
        var faqAns = $el.find(".faq_ans");
        faqAns.hide();
        faqDetail.hide();
        
        //--get form
        var frmId = $el.find("#frm_contact");
        var faq_id = $el.find(".faq_id");
        var faq_name = $el.find(".faq_name");
        var faq_email = $el.find(".faq_email");
        var faq_title = $el.find(".faq_title");
        var faq_body = $el.find(".faq_body");
        var btnSend = $el.find(".btnSend");
        
        faq_name.attr("placeholder","Enter your name");
        faq_email.attr("placeholder","Enter your email");
        faq_title.attr("placeholder","Enter the message title");
        //--faq_body
        faq_body.attr("placeholder","Enter your message")
        .val("");

        btnSend.html("Please process the form!")
        .prop("disabled",true);
        
        function getFaq(){
            var url = "<?php echo site_url("faq/getFaq");?>";
            var data = {
                        faq_ip : "<?php echo $ip;?>"
                        };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    if(rs.num_faq !== 0){
                        //----
                        $.each(rs.get_faq,function(i,v){
                            faq_name.val(v.faq_name);
                            faq_title.val(v.faq_title);
                            faq_id.val(v.faq_id);
                            faq_email.val(v.faq_email);
                            faq_body.val(v.faq_body);
                        });
                        btnSend.html("update message")
                        .prop("disabled",false);
                    }
                }
            });
        }
        //--------------
        function check_form(){

            var field = "";
            if(!faq_name.val()){
                alert("Please enter your name");
                field = faq_name;
            }else if(!faq_email.val()){
                alert("Please enter your email");
                field = faq_email;
            }else if(!faq_title.val()){
                alert("Please enter the title");
                field = faq_title;
            }else if(!faq_body.val() || faq_body.val().length < 10){
                alert("Please enter the message");
                field = faq_body;
            }else{
                btnSend.html("Sent")
                .prop("disabled",false);
            }

            setTimeout(function(){
                field.focus();
                btnSend.prop("disabled",true);
            },4000);
            return false;
        }
        //-------
        function check_email(){
            //alert("check email");
            var url = "<?php echo site_url("faq/faq_check");?>";
            var data = {
                faq_email:faq_email.val(),
                cmd : "check_email"
                };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    if(parseInt(rs.err) !== 0){
                        modal_status.html(rs.msg).show();
                        faq_email.focus();
                    }else{
                        setTimeout(function(){
                            modal_status.fadeOut("slow");
                            faq_title.focus();
                        },2000);
                    }
                }
            });
            
        }
        //---------------
        function sentFaq(){
            btnSend.unbind();
            frmId.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(o){
                    //console.log(o);
                    var rs = $.parseJSON(o);
                    modal_status.html(rs.msg).show();
                    setTimeout(function(){
                        location.reload();
                    },4000);
                });
            });
        }
        //---show the answer
        function viewFaq(id){
            
            alert("id is "+id);
        }
        //---------------
        function getEvent(){
            getFaq();
            
            //show faq as toggle
            lnViewFaq.on("click",function(){
                var id = $(this).attr("data-faq_id");
                //alert("the id is "+id);
                viewFaq(id);
            });
            
            faq_body.on("blur",function(){
                check_form();
            });

            //---check if the email is valid
            faq_email.on("blur",function(){
                check_email();
            });

            btnSend.on("click",function(){
                sentFaq();
            });
        }
        return{getEvent:getEvent}
    })();

    faq.getEvent();

    var faqAnonymous = (function(){

        var url = "<?php echo site_url("faq/faq_anonymous");?>";

        var show_faq_list = $el.find(".show_faq_list");
        var show_faq_ans = $el.find(".show_faq_ans");
        
        //----getAllFaq will return the all approve fag from the database to show
        function getAllFaq(){
            var data = {
                    cmd : "getAllFaq"
            };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    $.each(rs.get,function(i,v){
                        var msg = `
                        <div class="alert alert-default">
                            <h3>
                            <a href="#" data-faq_id="${v.faq_id}" class="lnViewFaq">
                            ${v.faq_title}
                            </a>
                            has answer
                            <span class="label label-success">
                                ${v.faq_has_ans}
                            </span>
                            </h3>
                            <div>
                            
                            </div>
                        </div>
                        `;
                        show_faq_list.append(msg);
                    });
                }
            });
        }//end of getAllFaq
        //-------
        function readFaq(id){
            show_faq_ans.html("");
            var data = {
                cmd : "readFaq",
                faq_id : id
            };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    var faq_title = '';
                    var faq_body = '';
                    var show = '';
                    var num = 0;
                    $.each(rs.get_faq,function(i,v){
                        faq_title = v.faq_title;
                        faq_body = v.faq_body;
                        num = rs.get_ans.length;
                        show = `
                        <div class="alert alert-warning">
                            <h3>
                            <span class="label label-default">
                                ${faq_title} 
                            </span>&nbsp;
                            have&nbsp;
                            <span class="label label-success">
                            ${num}
                            </span>&nbsp;answers.
                            </h3>
                            <p>${v.faq_body}</p>
                        </div>
                        `;
                        show_faq_ans.append(show);
                    });
                    
                    if(parseInt(num) > 0){
                        num = 0;
                    }
                    $.each(rs.get_ans,function(i,v){
                        num++;
                        
                        
                        var show = `
                        <div class='alert alert-success'>
                        <h4>
                        <span class="label label-info">
                        (#${num}) ${v.ans_title} 
                        </span>
                        </h4>
                        <p>${v.ans_body}</p>
                        </div>
                        `;
                        show_faq_ans.append(show);
                    });


                    
                    
                }
            });
        }

        //-----
        function getEvent(){
            getAllFaq();

            //--expand the faq to see the answer
            show_faq_list.delegate(".lnViewFaq","click",function(et){
                et.preventDefault();
                var id = $(this).attr("data-faq_id");
                readFaq(id);
            });
        }
        return{getEvent : getEvent}
    })();

    //--call faqAnonymous
    faqAnonymous.getEvent();



});

</script>
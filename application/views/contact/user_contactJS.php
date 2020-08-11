<script>



$(function(){

    var $el = $(".container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");



    var message = (function(){

        var ln_compose = $el.find(".ln_compose");

        //--del message
        var ln_del = $el.find(".ln_del");
        
        //---modal compose form
        var mdMessage = $el.find(".mdFrmMessage");
        var frmCompose = $el.find("#frmSendMessage");
        var faq_email = $el.find(".faq_email");
        var faq_title = $el.find(".faq_title");
        var title_length = $el.find(".title_length");
        var text_count = $el.find(".text_count");
        title_length.hide();//--hide this by default
        var faq_body = $el.find(".faq_body");
        var btnSent = $el.find(".btnCompose");
        btnSent.prop("disabled",true);


        //---modal read message
        var ln_read = $el.find(".ln_read");
        var mdRead = $el.find(".mdRead");
        var showFaqBody = $el.find(".show_faq_body");
        var ans_list = $el.find(".ans_list");
        var btnClose = $el.find(".btnClose");
        //---readMsg
        function readMsg(id){
            
            var url = "<?php echo site_url("contact/own");?>";
            var data = {cmd : "readMessage",faq_id : id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    
                    $.each(rs.get_faq,function(i,v){
                        $(".modal-title").html(v.faq_title);
                        showFaqBody.html(v.faq_body);
                        
                        
                    });
                    //console.log(rs.get_ans.length);

                    
                    var num = 0;
                    var ans = `
                    <div class='alert alert-danger'>
                        There are no reply yet!
                    </div>`;
                    if(parseInt(rs.get_ans.length) ===0){
                        //console.log("There is no data");
                        ans_list.append(ans);
                    }else{
                        $.each(rs.get_ans,function(i,v){
                            num++;                          
                            ans = `<div class='well'>
                            <h2>${num}.${v.ans_title}</h2>
                            <p>${v.ans_body}</p>
                            </div>`;
                            ans_list.append(ans);

                                                                       
                        });

                    }
                    
                    $(mdRead).modal("show");
                }
            });
        }

        //------
        function composeForm(c,id){
            var url = "<?php echo site_url("contact/own");?>";
            var data = {};
            tinymce.activeEditor.setMode("design");
            switch(c){
                default:
                    data.cmd = "getInfo";
                    
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            //console.log(rs);
                            $.each(rs.getMyInfo,function(i,v){
                                $(".modal-title").html("Sent message to admin");
                                faq_email.val(v.email);
                                
                                setTimeout(function(){
                                    faq_title.val("")
                                    .focus();
                                },2000);
                                $(mdMessage).modal("show");
                            });
                        }
                    });
                    //$(mdMessage).modal("show");
                break;
            }
        }

        //---
        function numTitle(){
            //console.log("type");
            var numTxt = 0;
            numTxt = faq_title.val().length;
            //console.log(`${numTxt} letters`);
            text_count.html(`you have type ${numTxt} letters.`).show();
            return parseInt(numTxt);
        }

        function chk_title(){
            //--only check the text title
            //--will disable the sent button if the title is too short
            btnSent.html("Please process the form")
            .prop("disabled",true);
            var t = numTitle();
            var showMsg = ``;
            
            if(t < 20){
                showMsg = `<p class='alert alert-danger'>
                    Error : ${t} letters is too short for title!</p>
                    `;
                
            }else{
                showMsg = `
                <p class="alert alert-success">
                    title is ${t} letters you are good to go.
                </p>
                `;
                btnSent.html("sent your message")
            .prop("disabled",false);
                
            }
            title_length.html(showMsg).show();
            setTimeout(function(){
                //--the text status will be fade out in 4 sec.
                title_length.fadeOut("slow");
            },4000);

        }

        //-----sent message
        function sentMsg(){
            btnSent.unbind();
            frmCompose.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize()+"&cmd=sentMsg";
                $.post(url,data,function(o){
                    //console.log(o);
                    var rs = $.parseJSON(o);
                    var mBox = `
                    <div class="alert alert-success">
                    ${rs.msg}
                    </div>
                    <div class='alert alert-warning'>
                        your page will reload in 4 second.
                    </div>
                    `;
                    modal_status.html(mBox).show();
                    setTimeout(function(){
                        location.reload();
                    },4000);
                    
                });
            });
        }
        //--delMessage
        function delMessage(id){
            var url = "<?php echo site_url("contact/own");?>";
            var data = {cmd : "delMessage",faq_id : id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    alert(e);
                    location.reload();
                }
            });
        }
        //----
        function getEvent(){
            ln_compose.on("click",function(){
                composeForm();
            });
            
            
            //--sat 21/4/2018
            faq_title.on("keyup",function(){
                numTitle();
            });
            faq_title.on("blur",function(){
                chk_title();
            });
            //--sent message
            btnSent.on("click",function(){
                sentMsg();
            });

            //--delete message
            ln_del.on("click",function(){
                var id = $(this).attr("data-id");
                delMessage(id);
            });

            //--read message
            ln_read.on("click",function(o){
                o.preventDefault();
                var id = $(this).attr("data-id");
                readMsg(id);
            });

            //---btnClose
            btnClose.on("click",function(){
                location.reload();
            });
        }
        return{getEvent : getEvent}
    })();

    message.getEvent();
});


</script>
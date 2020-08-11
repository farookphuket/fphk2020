<script>

$(function(){

    var $el = $("#container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");

    var faq = (function(){

        //---modal reply form
        var ln_read = $el.find(".ln_read");
        var mdReply = $el.find(".mdReplyForm");
        var faq_body = $el.find(".faq_body");
        var faq_id = $el.find(".faq_id");

        //--show or not show faq in public
        var faq_pub = $el.find(".faq_pub");
        var f_txt = $el.find(".f_txt");
        f_txt.addClass("label-danger")
        .val("Mark as not show to public");
        

        //---delete the faq
        var ln_delFaq = $el.find(".del_faq");

        var ansFrm = $el.find("#ansFaq");
        var ans_title = $el.find(".ans_title");
        var ans_body = $el.find(".ans_body");
        var btnReply = $el.find(".btnReply");

        //---the url to sent request
        var url = "<?php echo site_url("faq/admin");?>";

        //--show the faq,reply list and form reply
        function replyFrm(id){
            $(".ans_list").html("");
            var url = "<?php echo site_url("faq/admin");?>";
            var data = {cmd : "getFaq",faq_id : id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    //enable tinymce
                    tinymce.activeEditor.setMode("design");
                    var rs = $.parseJSON(e);
                    var f_id = "";
                    $.each(rs.get_faq,function(i,v){
                        $(".modal-title").html(v.faq_title);
                        //console.log(rs.get_faq);
                        faq_body.html(v.faq_body);
                        $(".faq_name").html(v.faq_title);

                        //--set faq to show or hide
                        var t = "Mark this as NOT show ";
                        f_txt.removeClass("label-success")
                        .addClass("label-danger")
                        .val(t);
                        faq_pub.prop("checked",false);
                        if(parseInt(v.faq_is_show) !== 0){
                            faq_pub.prop("checked",true);
                            t = "Mark this faq as Public";
                            f_txt.removeClass("label-danger")
                            .addClass("label-success")
                            .val(t);

                        }
                        f_id = v.faq_id;

                    });
                   //console.log(rs);
                   $.each(rs.get_ans,function(i,v){
                       var a_title = v.ans_title;
                       var a_body = v.ans_body;
                       f_id = v.faq_id;
                       var show = "<hr /><div>";
                       show += "<h2>"+a_title+"</h2>";
                       show += "<pre>"+a_body+"</pre>";
                       show += "<p>Reply on ";
                       show += v.ans_date+"</p>";
                       show += "</div>";

                       $(".ans_list").append(show);

                   });
                    faq_id.val(f_id);
                    $(mdReply).modal("show");
                }
            });
        }
        //-----sendReplyFaq
        function sendReplyFaq(){
            btnReply.unbind();
            ansFrm.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize()+"&cmd=answer";
                $.post(url,data,function(e){
                    alert(e);
                    location.reload();
                });
            });
        }

        //--set or not set faq to public
        function setFaqPublic(){
            var id = faq_id.val();
            var pub = 0;
            var t = "Mark as Private";
            f_txt.removeClass("label-success")
            .addClass("label-danger");
            if(faq_pub.is(":checked") === true){
                pub = 1;
                t = "Mark as Public";
                f_txt.removeClass("label-danger")
                .addClass("label-success");
            }
            f_txt.val(t);
            var data = {
                cmd : "setFaqPublic",
                faq_id : id,
                faq_pub : pub
                };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    alert(e);
                }
            });
        } 

        //--delFaq
        function delFaq(id){

            if(confirm("Are you sure to delete faq id "+id+" ?") === false){
                return false;
            }
            var data = {cmd : "delFaq",faq_id : id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    page_status.html(e).show();
                    setTimeout(function(){
                        page_status.html("Reloading...");
                        location.reload();
                    },2000);
                }
            });
        }

        function getEvent(){
            //--ln_read
            ln_read.on("click",function(o){
                o.preventDefault();
                var id = $(this).attr("data-id");
                replyFrm(id);
            });

            //--del faq click
            ln_delFaq.on("click",function(){
                var id = $(this).attr("data-faq_id");
                delFaq(id);
            });

            //--change public or not to the faq item
            faq_pub.on("change",function(){
                setFaqPublic();
            });
            //--reply btn click
            btnReply.on("click",function(){
                sendReplyFaq();
            });
        }
        return{getEvent : getEvent}
    })();

    faq.getEvent();
});
</script>
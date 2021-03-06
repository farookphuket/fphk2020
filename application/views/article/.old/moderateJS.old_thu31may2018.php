<script>



//--moderate create on Sun-13-May-2018

//--start jQuery
$(function(){
    var $el = $("#container");

    var modal_status = $el.find(".modal_status");
    var page_status = $el.find(".status");

    var article = (function(){

        //btn
        var lnAdd = $el.find(".lnAdd");
        var lnEdit = $el.find(".lnEdit");
        var lnDel = $el.find(".lnDel");

        var panel_ar = $el.find(".panel_ar");
        
        //--modal
        var mdFrm = $el.find(".mdFrm");
        var ar_result = $el.find(".ar_result");
        var btnSave = $el.find(".btnSave");
        
        //---form element
        var frmAr = $el.find("#frmAr");
        var ar_id = $el.find(".ar_id");
        var cat_id = $el.find(".cat_id");
        var ar_title = $el.find(".ar_title");
        var ar_summary = $el.find("#ar_summary");
        var ar_body = $el.find(".ar_body");

        var pub = $el.find(".pub");
        var pub_txt = $el.find(".pub_txt");
        pub_txt.attr("placeholder","กำหนดสถานะ");
        
        var approve = $el.find(".approve");
        var app_txt = $el.find(".app_txt");
        app_txt.attr("placeholder","ยังไม่กำหนดการตวจสอบ");
        
        var s_index = $el.find(".s_index");
        var index_txt = $el.find(".index_txt");
        index_txt.attr("placeholder","สถานะการแสดงในหน้าแรก");

        //--show head result
        var ar_sum = $el.find(".ar_sum");

        //---get header summary
        function arSummary(){
            var url = "<?php echo site_url("article/summary");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);

                    var tmp = `
                    แสดงในหน้าหลัก :
                    <span class="label label-info">
                    ${rs.show_index}
                    </span>&nbsp;
                    แสดงสาธารณะ :
                    <span class="label label-success">
                    ${rs.public}
                    </span>&nbsp;
                    เป็นส่วนตัว :
                    <span class="label label-warning">
                    ${rs.private}
                    </span>&nbsp;
                    ตรวจสอบแล้ว :
                    <span class="label label-success">
                    ${rs.approve}
                    </span>&nbsp;
                    ไม่ตรวจสอบ :
                    <span class="label label-danger">
                    ${rs.not_approve}
                    </span>&nbsp;

                    `;

                    ar_sum.append(tmp);
                    
                }
            });
        }

        function setStatus(c){
            var field_name = "";
            var ch_name = "";
            var p = 0;
            var t = "";

            switch(c){
                case"pub":
                    field_name = pub_txt;
                    ch_name = pub;
                    t = "ไม่ให้เป็นสาธารณะ";
                    p = 0;
                    if(pub.is(":checked") === true){
                        p = 2;
                        t = "ให้เป็นสาธารณะ";
                        
                    }
                    
                break;
                case"app":
                    field_name = app_txt;
                    ch_name = approve;
                    t = "ไม่ผ่าน";
                    p = 0;
                    if(approve.is(":checked") === true){
                        p = 2;
                        t = "ให้ผ่าน";
                        
                    }
                break;
                case"index":
                    field_name = index_txt;
                    ch_name = s_index;
                    t = "ไม่แสดงในหน้าหลัก";
                    p = 0;
                    if(s_index.is(":checked") === true){
                        p = 2;
                        t = "แสดงในหน้าหลัก";
                        
                    }
                break;
                default:
                    approve.prop("checked",false)
                    .val(0);
                    app_txt.addClass("label-warning");
                break;
            }

            parseInt(p);
            if(p !== 0){
                field_name.removeClass("label-danger")
                .addClass("label-success");
            }else{
                field_name.removeClass("label-success")
                .addClass("label-danger"); 
            }
            field_name.val(t);
            ch_name.val(p);

        }

        

        function editAr(cmd,id){
            tinymce.activeEditor.setMode("design");
            ar_result.html("");

            //--set txt status
            pub_txt.removeClass("label-warning")
            .removeClass("label-danger")
            .removeClass("label-success");

            app_txt.removeClass("label-warning")
            .removeClass("label-danger")
            .removeClass("label-success");

            index_txt.removeClass("label-warning")
            .removeClass("label-danger")
            .removeClass("label-success");


            switch(cmd){
                case"edit":
                    
                    frmAr.trigger("reset");
                    var url = "<?php echo site_url("article/moderate");?>";
                    var data = {cmd : "edit" ,ar_id : id};
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            
                            
                            $.each(rs.get,function(i,v){
                                
                                var tmp = `
                                <div class="page-header">
                                <h2>ต้องการแก้ไขรายละเอียด เลื่อนลงไปปรับปรุงในฟอร์มด้านล่าง</h2>
                                </div>
                                <table class="table table-striped">
                                <tr>
                                    <th>Title</th>
                                    <td>${v.ar_title}</td>
                                </tr>
                                <tr>
                                    <th>บทย่อ</th>
                                    <td>
                                        ${v.ar_summary}
                                    </td>
                                </tr>
                                <tr>
                                <td colspan=2>
                                ${v.ar_body}
                                </td>
                                </tr>
                                <tr>
                                    <th>เขียนโดย</th>
                                    <td>
                                        ${v.ar_post_by}
                                    </td>
                                </tr>
                                </table>
                                `;
                                ar_result.append(tmp);
                                
                                ar_id.val(v.ar_id);
                                $(".modal-title").html(`Editing...${v.ar_title}`);
                                ar_title.val(v.ar_title);
                                cat_id.val(v.cat_id);
                                ar_summary.val(v.ar_summary);
                                var b = tinymce.activeEditor.setContent(v.ar_body);
                                ar_body.val(b);
                                
                                var p = parseInt(v.ar_show_public);
                                var pt = "เป็นส่วนตัว";
                                pub_txt.addClass("label-warning")
                                .removeClass("label-success"); 
                                if(p !== 0){
                                    pub.prop("checked",true);
                                    pt = "เป็นสาธารณะ";
                                    pub_txt.removeClass("label-warning")
                                    .addClass("label-success");
                                }
                                pub_txt.val(pt);
                                pub.val(p);


                                var a = parseInt(v.ar_is_approve);
                                var at = "ไม่ตรวจสอบ";
                                app_txt.addClass("label-danger")
                                .removeClass("label-success"); 
                                if(a !== 0){
                                    approve.prop("checked",true);
                                    at = "ตรวจสอบแล้ว";
                                    app_txt.removeClass("label-danger")
                                    .addClass("label-success");
                                }
                                app_txt.val(at);
                                approve.val(a);

                                var s = parseInt(v.ar_show_index);
                                var si = "ไม่โชว์หน้าหลัก";
                                index_txt.addClass("label-warning")
                                .removeClass("label-success"); 
                                if(s !== 0){
                                    s_index.prop("checked",true);
                                    si = "โชว์หน้าหลัก";
                                    index_txt.removeClass("label-warning")
                                    .addClass("label-success");
                                }
                                index_txt.val(si);
                                s_index.val(s);


                            });
                            $(mdFrm).modal("show");
                        }
                    });
                break;
                default:
                    $(".modal-title").html("New Article");
                    frmAr.trigger("reset");
                    ar_summary.attr("placeholder","หัวข้อรองของบทความ ไม่ควรเกิน 400 ตัวอักษร")
                    .val("");
                    ar_title.attr("placeholder","หัวข้อหลักของบทความ ไม่ควรเกิน 100 ตัวอักษร")
                    .val("");
                    $(mdFrm).modal("show");
                break;
            }
        }

        //--save
        function saveAr(){
            
            btnSave.unbind();
            frmAr.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize()+"&cmd=save";
                $.post(url,data,function(e){
                    modal_status.html(e);
                    setTimeout(function(){
                        location.reload();
                    },2000);
                });
            })

        }

        function delAr(id){
            var msg = `
            Warning คำเตือน ! คุณกำลังสั่งลบข้อมูล ${id}
            คำสั่งนี้หากดำเนินการแล้ว ไม่สามารถย้อนกลับได้\n
            คุณต้องการที่จะลบ ${id} แน่หรือ?`;
            if(confirm(msg) === false){
                return false;
            }else{
                var url = "<?php echo site_url("article/moderate");?>";
                var data = {cmd : "delete",ar_id : id};
                $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        alert(e);
                        setTimeout(function(){
                            location.reload();
                        },2000);
                    }
                });
            }
        }

        function getEvent(){
            //--call summary
            arSummary();

            lnAdd.on("click",function(){
                editAr();
            });

            //--edit
            lnEdit.on("click",function(){
                var id = $(this).attr("data-ar_id");
                editAr("edit",id);
            });

            lnDel.on("click",function(){
                var a_id = $(this).attr("data-ar_id");
                delAr(a_id);
                
                
            });

            pub.on("change",function(){
                setStatus("pub");
            });

            approve.on("change",function(){
                setStatus("app");
            });

            s_index.on("change",function(){
                setStatus("index");
            });

            btnSave.on("click",function(){
                saveAr();
            });

            
        }
        return{getEvent : getEvent}
    })();

    article.getEvent();

});//--end of jQuery
</script>
<script>


$(function(){


    var $el = $("#container");
    var page_status = $el.find(".status");

    var mod_pic = (function(){


        var emp_div = `
            <div class="well">
                <h2 class="alert alert-danger">There are no data</h2>
            </div>
        `;

        var pub_tab = $el.find("#tab_pub_pic");
        var approve_tab = $el.find("#tab_approve_pic");

        var url = "<?php echo site_url("gallery/moderate");?>";//---global url action
        
        //--public image
        var num_pub = $el.find(".num_pub");
        var pub_list = $el.find(".pub_list");
        var pub_pagin = $el.find(".pub_pagin");

        //-----private photo album
        var num_pri = $el.find(".num_pri");
        var pri_list = $el.find(".pri_list");
        var pri_pagin = $el.find(".pri_pagin");

        //---approve image
        var num_approve = $el.find(".num_approve");
        var approve_list = $el.find(".approve_list");
        var approve_pagin = $el.find(".approve_pagin");


        //---edit image
        var edit_place = $el.find(".edit_place");

        //---upload form
        var frmUploadPic = $el.find("#frmUploadPic");
        
        //--file select
        var userfile = $el.find(".userfile");

        var pic_pub = $el.find(".pic_pub");
        var btnSave = $el.find(".btnSave");

        //---show the percent
        var progress_bar = $el.find(".progress-bar");
        var show_prog = $el.find(".show_prog");
        show_prog.html(0+"%");

        //---uploadPic
        function uploadPic(){
            btnSave.unbind();
            frmUploadPic.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = new FormData(this);
                
                var req = new XMLHttpRequest();
                req.upload.addEventListener('progress',function(e){
                    var percent = Math.round(e.loaded/e.total * 100);
                    
                    progress_bar.width(percent+"%").html(percent+"%");
                    show_prog.html(percent+"%");
                    //frm.find(".progress-bar").width(percent+"%");
                });

                req.addEventListener("load",function(e){
                    progress_bar.addClass("progress-bar-success").html("Upload Successfully...");
                });
                

                req.open("post",url);
                req.send(data);

                req.onreadystatechange = function(){
                    if(req.readyState === 4){
                        if(req.status === 200){
                            var rs = req.responseText;
                            var p = JSON.parse(rs);
                            //console.log(rs.img);
                            var pic_id = 0;
                            var thumb = 0;
                            
                            $.each(p.img,function(i,v){
                                pic_id = v.pic_id;
                                thumb = "<?php echo site_url("public/image/thumb/");?>"+v.thumb_name;
                                var tmp = `
                                <img class="responsive" src="${thumb}">
                                `;
                                show_prog.html(`${v.pic_name} has been upload and resized!!`);
                                setTimeout(function(){
                                    
                                    frmUploadPic.trigger("reset");
                                    show_prog.html(0+"%");
                                    $(".preview").html(tmp);
                                    progress_bar.removeClass("progress-bar-success")
                                    .width(0+"%")
                                    .html("Ready for new upload");
                                    
                                    //--after upload call pic.getPic
                                    getPicChange();
                                },2000);
                                
                                
                            });
                            
                        }else{
                            console.log("req fail");
                            
                        }
                    }
                };


            });
        }


        //---getMyPic
        //---will get this user photo
        function getMyPic(page=1,cmd){
            var url = "<?php echo site_url("gallery/mod_getPic/"); ?>"+page+"/"+cmd;

            var show_area = pri_list;
            var pagin_area = pri_pagin;
            $.ajax({
                url : url,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    showPicList(show_area,pagin_area,rs);
                    num_pri.html(rs.num_img);
                }
            });
        }



        function showPicList(show_area,pagin_area,obj){
            //console.log(obj);
            show_area.html("");
            pagin_area.hide();

            if(!obj.get_img.length || obj.get_img.length === 0){
                show_area.html(emp_div);
            }else{
                $.each(obj.get_img,function(i,v){
                    var pic = "<?php echo site_url("public/image/");?>"+v.pic_name;

                    var thumb = "<?php echo site_url("public/image/thumb/");?>"+v.thumb_name;

                    var p_title = v.pic_title.substr(0,10);
                    var tmp = `
                    <div class="img_thumb">
                        <a href="${pic}" target="_blank" title="Click to see full image">
                            <img src="${thumb}" class="responsive" style="height:158px;" alt="${v.pic_name}">
                        </a>
                        
                        <span>
                            <a href="#" class="showPic" data-pic_id="${v.pic_id}">
                                ${p_title}
                            </a>
                        
                        </span>
                    </div>
                    `;
                    show_area.append(tmp);
                });
            }
            pagin_area.html(obj.pagination).show();
            
        }

        //---getPubPic
        function getPubPic(page=1,cmd){
            //---clear place
            pub_list.html("");
            var url = "<?php echo site_url("gallery/mod_getPic/");?>"+page+"/"+cmd;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    var show_area = pub_list;
                    var pagin_area = pub_pagin;
                    num_pub.html(rs.num_img);
                    
                    showPicList(show_area,pagin_area,rs);
                    
                    
                }
            })
        }

        //--getApprovePic
        function getApprovePic(page=1,opt){
            var url = "<?php echo site_url("gallery/mod_getPic/");?>"+page+"/"+opt;
            $.ajax({
                url : url,
                success : function(e){
                    //--clear the list
                    approve_list.html("");

                    var rs = $.parseJSON(e);
                    num_approve.html(rs.num_img);

                    var show_area = approve_list;
                    var pagin_area = approve_pagin;
                    showPicList(show_area,pagin_area,rs);

                    
                }
            })
        }

        //-----showPic
        function showPic(id){
            var data = {cmd : "edit",pic_id:id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get,function(i,v){

                        var pic = "<?php echo site_url("public/image/");?>"+v.pic_name;
                        var thumb = "<?php echo site_url("public/image/thumb/");?>"+v.thumb_name;

                        var pub = `<option value="0">No</option>`;
                        if(parseInt(v.allow_public) !== 0){
                            pub = `<option value="1">Yes</option>`;
                        }

                        var allow = `<option value="0">No</option>`;
                        if(parseInt(v.admin_allow) !== 0){
                            allow = `<option value="1">Yes</option>`;
                        }

                        var tmp = `
                                <div class="page-header">
                                    <h2>Edit ${v.pic_name} prop.</h2>
                                </div>
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="modal-title">
                                            file name ${v.pic_name} | user id ${v.user_id}
                                            </h2>
                                        </div>
                                        <div class="modal-body">
                                            <p class="text-center">
                                                <img class="responsive" src="${pic}">
                                            </p>
                                            
                                            <!--form start-->
                                            <form class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">BBCode Image</label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control pic_code" readonly="readonly">&lt;img class="responsive" src='${pic}'&gt;</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">BBCode Thumbnail</label>
                                                    <div class="col-sm-6">
                                                        <textarea class="form-control pic_code" readonly="readonly">&lt;img class="responsive" src='${thumb}'&gt;</textarea>
                                                    </div>
                                                </div>

                                                <!--edit title--> 
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">หัวข้อ</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" value="${v.pic_title}" class="form-control txtPicTitle" name="txtPicTitle" data-pic_id="${v.pic_id}" required>
                                                    </div>
                                                </div>

                                                <!-- update public --> 
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">ตั้งเป็นสาธารณะ</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control pic_pub" data-pic_id="${v.pic_id}">
                                                            ${pub}
                                                            <option value=0>No</option>
                                                            <option value=1>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Allow by admin --> 
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">ได้รับการตรวจสอบ</label>
                                                    <div class="col-sm-6">
                                                        <select class="form-control admin_allow" data-pic_id="${v.pic_id}">
                                                            ${allow}
                                                            <option value=0>No</option>
                                                            <option value=1>Yes</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Delete the picture --> 
                                                <div class="form-group">
                                                    <label class="label-control col-sm-4">ลบทิ้ง</label>
                                                    <div class="col-sm-6">
                                                        
                                                    </div>
                                                </div>


                                            </form>
                                            <!--form-end-->
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-danger btnDelPic" data-pic_id="${v.pic_id}">ลบทิ้ง</button>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                        `;

                        edit_place.html(tmp).show();
                    });
                }
            });
        }


        //---saveTitle
        function saveTitle(val,id){
            
            var data = {cmd : "updateTitle",pic_id : id,pic_title : val};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);

                    var msg = rs.msg;
                    page_status.html(msg).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        showPic(rs.pic_id);
                        
                        getPicChange();
                        
                    },2000);
                }
            });
            

        }

        //--savePub
        function savePub(val,id){
            var data = {cmd : "updatePub",pic_id : id,pic_pub : val};

            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    
                    var msg = rs.msg;
                    page_status.html(msg).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        showPic(rs.pic_id);
                        getPicChange();
                        
                    },2000);
                    
                }
            });
            
        }

        //--saveAllow
        function saveAllow(val,id){
            var data = {cmd : "updateAllow",pic_id : id,admin_allow : val};

            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    
                    var msg = rs.msg;
                    page_status.html(msg).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        showPic(rs.pic_id);
                        getPicChange();
                        
                    },2000);
                    
                }
            });
            
        }

        //---delete the image
        function delPic(id){
            var data = {cmd:"delPic",pic_id:id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    page_status.html(e).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        edit_place.slideToggle();
                        getPicChange();
                    },2000);
                }
            });
            
        }

        //---getPicChange will fetch the last result
        function getPicChange(){
            
            getMyPic(1,"getMyPic");
            getPubPic(1,"getPublicPic");
            getApprovePic(1,"getApprovePic");
        }
        
        //---getEvent
        function getEvent(){
            getPicChange();
            
            //tab on click
            pub_tab.on("click",function(){
                getPubPic(1,"getPublicPic");
            });

            //--approve tab
            approve_tab.on("click",function(){
                getApprovePic(1,"getApprovePic");
            });

            //--show preview when user select file before upload
            userfile.on("change",function(e){
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var tmp = `<img src="${e.target.result}" class="responsive">`;

                    //--show image preview before upload
                    $(".preview").html(tmp);
                };
            });

            btnSave.on("click",function(){
                uploadPic();
            });
            pub_list.delegate(".showPic","click",function(ev){
                ev.preventDefault();
                var id = $(this).attr("data-pic_id");
                showPic(id);
            });

            pri_list.delegate(".showPic","click",function(ev){
                ev.preventDefault();
                var id = $(this).attr("data-pic_id");
                showPic(id);
            });

            //--pagination link of public image
            pub_pagin.delegate(".pagination a","click",function(evt){
                evt.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getPubPic(cur_page);

            });

            //---pagination link of private image
            pri_pagin.delegate(".pagination a","click",function(evt){
                evt.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getMyPic(cur_page,"getMyPic");

            });

            //---pagination link of approve image
            approve_pagin.delegate(".pagination a","click",function(evt){
                evt.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getApprovePic(cur_page,"not_approve");

            });

            approve_list.delegate(".showPic","click",function(ev){
                ev.preventDefault();
                var id = $(this).attr("data-pic_id");
                showPic(id);
            });

            //------------------------

            edit_place.delegate(".pic_code","click",function(){
                $(this).select();
            });


            //--edit title
            edit_place.delegate(".txtPicTitle","blur",function(){
                var val = $(this).val();
                var id = $(this).attr("data-pic_id");
                saveTitle(val,id);
            });

            //---update public status
            edit_place.delegate(".pic_pub","change",function(){
                var val = $(this).val();
                var id = $(this).attr("data-pic_id");
                
                savePub(val,id);
            });

            //---update allow status
            edit_place.delegate(".admin_allow","change",function(){
                var val = $(this).val();
                var id = $(this).attr("data-pic_id");
                
                saveAllow(val,id);
            });

            //---Delete this image
            edit_place.delegate(".btnDelPic","click",function(){
                
                var id = $(this).attr("data-pic_id");
                
                delPic(id);
            });
        }
        return{
            getEvent : getEvent
        }
    })();
    //---call mod_pic
    mod_pic.getEvent();
});
</script>

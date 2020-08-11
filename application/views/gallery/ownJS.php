<script>


$(function(){
    var $el = $(".container");
    var page_status = $el.find(".status");


    var photo = (function(){
        var url = "<?php echo site_url("gallery/own");?>";

        var emp_div = `
            <div class="well">
                <h2 class="alert alert-danger">There are no data</h2>
            </div>
        `;

        //---photo list and pagination
        var photo_list = $el.find(".photo_list");
        var pagin_div = $el.find(".pagin_div");
        var showpic_div = $el.find("#show_pic");
        var pic_count = $el.find(".pic_count");


        //--form upload
        var frmUpload = $el.find("#frmUpload");
        var pic_title = $el.find(".txtPicTitle");
        var pub = $el.find(".pic_pub");
        var btnSave = $el.find(".btnUpload");

        
        //--file select
        var userfile = $el.find(".userfile");
        //---show the percent
        var progress_bar = $el.find(".progress-bar");
        var show_prog = $el.find(".show_prog");
        show_prog.html(0+"%");


        //---show tab gallery
        var approve_tab = $el.find("#tab_approve_pic");
        var approve_list = $el.find(".approve_list");
        var approve_pagin = $el.find(".approve_pagin");
        var approve_count = $el.find(".approve_count");

        //---show public tab gallery
        var pub_tab = $el.find("#tab_pub_pic");
        var pub_list = $el.find(".pub_list");
        var pub_pagin = $el.find(".pub_pagin");
        var pub_count = $el.find(".pub_count");

        
        //---getMyPic
        function getMyPic(page=1,cmd){
            var url = "<?php echo site_url("gallery/own_getPic/");?>"+page+"/"+cmd;

            var show_area = photo_list;
            var pagin_area = pagin_div;
            $.ajax({
                url : url,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    showPicList(show_area,pagin_area,rs,1);
                    //console.log(e);
                    pic_count.html(rs.num_img);
                }
            });
        }
        
        
        //---getApprovePic
        function getApprovePic(page=1,cmd){
            var url = "<?php echo site_url("gallery/own_getPic/");?>"+page+"/"+cmd;

            var show_area = approve_list;
            var pagin_area = approve_pagin;
            $.ajax({
                url : url,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    showPicList(show_area,pagin_area,rs,1);
                    //console.log(e);
                    approve_count.html(rs.num_img);
                }
            });
        }

        function getPublicPic(page=1,cmd){
            var url = "<?php echo site_url("gallery/own_getPic/");?>"+page+"/"+cmd;

            var show_area = pub_list;
            var pagin_area = pub_pagin;
            $.ajax({
                url : url,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    showPicList(show_area,pagin_area,rs);
                    //console.log(e);
                    pub_count.html(rs.num_img);
                }
            });
        }

        function showPicList(show_area,pagin_area,obj,edit=0){
            //console.log(obj);
            //show_area.html(`<p>There are ${obj.get_img.length} item</p>`);
            show_area.html("");
            var canEdit = 0;
            if(!obj.get_img || obj.get_img.length === 0){
                show_area.html(emp_div);
                pagin_area.hide();
            }else{
                
                $.each(obj.get_img,function(i,v){
                    var pic = "<?php echo site_url("public/image/");?>"+v.pic_name;
                    var thumb = "<?php echo site_url("public/image/thumb/");?>"+v.thumb_name;

                    var p_title = v.pic_title.substr(0,10);
                    
                    var edit_link = `
                    <a href="${pic}" target="_blank" class="showPic" data-pic_id="${v.pic_id}">
                    ${p_title}
                    </a>
                    `;
                    
                    if(parseInt(edit) === 1){
                        edit_link = `
                                    <a href="#" class="showPic" data-pic_id="${v.pic_id}">
                                        ${p_title}
                                    </a>
                                    `;
                    }
                    
                    
                    var tmp = `
                    <div class="img_thumb">
                        <img src="${thumb}" class="responsive" style="height:158px;">
                        <span>
                        ${edit_link}
                        </span>
                    </div>
                    `;
                    show_area.append(tmp);
                });

            }
            
            pagin_area.html(obj.pagination).show();
        }

        //---upload imgae
        function uploadPic(){
            btnSave.unbind();
            frmUpload.submit(function(ev){
                ev.preventDefault();
                var url = $(this).attr("action");
                var data = new FormData(this);

                var req = new XMLHttpRequest();
                req.upload.addEventListener('progress',function(e){
                    var percent = Math.round(e.loaded/e.total * 100);
                    //console.log(percent);
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
                                    
                                    frmUpload.trigger("reset");
                                    show_prog.html(0+"%");
                                    $(".preview").html(tmp);
                                    progress_bar.removeClass("progress-bar-success")
                                    .width(0+"%")
                                    .html("Ready for new upload");
                                    
                                    //--after upload call getPicChange
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
        //----------

        
        //-------show full image
        function showPic(id){
            var data = {cmd : "getPic",pic_id : id};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs.get);
                    showpic_div.html(rs.get);
                }
            });
        }

        function setPublic(val,id){
            //alert("the set is "+val+" pic id "+id);
            var data = {cmd : "chPub",pic_id:id,public:val};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    page_status.html(`data has been save!`).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        showPic(rs.pic_id);
                        getPicChange();
                    },2000);
                }
            });
        }

        function changeTitle(val,id){
            var data = {cmd : "changeTitle",pic_id : id,pic_title : val};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    page_status.html(`Success : Data has been save`).show();
                    setTimeout(function(){
                        page_status.fadeOut("slow");
                        showPic(rs.pic_id);
                        getPicChange();
                    },2000);
                }
            });
        }

        //----getPicChange
        function getPicChange(){
            getPublicPic(1,"getPublicPic");
            getMyPic(1,"getMyPic");
            getApprovePic(1,"not_approve");
        }

        //-----------
        function getEvent(){
            
            //--call after change
            getPicChange();
            
            //--approve image
            approve_tab.on("click",function(){
                getApprovePic(1,"not_approve");
            });
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

            //-----------end of approve tab
            //---show public tab
            pub_tab.on("click",function(){
                getPublicPic(1,"getPublicPic");
            });

            pub_pagin.delegate(".pagination a","click",function(evt){
                evt.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getPublicPic(cur_page,"getPublicPic");
            });

            
            //---end of public area

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

            //--upload button
            btnSave.on("click",function(){
                uploadPic();
            });

            pagin_div.delegate(".pagination a","click",function(ev){
                ev.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getMyPic(cur_page,"getMyPic");
            });

            photo_list.delegate(".showPic","click",function(evt){
                evt.preventDefault();
                var id = $(this).attr("data-pic_id");
                showPic(id);
            });

            showpic_div.delegate(".pic_code","click",function(){
                $(this).select();
            });

            showpic_div.delegate(".pic_pub","change",function(){
                var id = $(this).attr("data-pic_id");
                setPublic($(this).val(),id);
            });

            //--change image title
            showpic_div.delegate(".pic_title","blur",function(){
                var id = $(this).attr("data-pic_id");
                var v = $(this).val();
                
                changeTitle(v,id);
            });
        }
        return{getEvent:getEvent}
    })();
    photo.getEvent();
});

</script>
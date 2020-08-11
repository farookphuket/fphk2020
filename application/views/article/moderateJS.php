<script>

$(function(){



    //---moderateJS.php
    var $el = $("#container");

    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");

    var arMod = (function(){

        //---button adAr
        var btnAddAr = $el.find(".btnAddAr");
        //----category list
        var show_cat_list = $el.find(".show_cat_list");
        var show_cat_pagin = $el.find(".cat_list_pagin");
        var show_num_cat = $el.find(".show_num_cat");

        //--------rc_pub_post
        var label_cat_list = $el.find(".label_cat_list");
        var rc_pub_post = $el.find(".rc_pub_post");
        var rc_pub_pagin = $el.find(".rc_pub_pagin");
        var rc_pub_num = $el.find(".rc_pub_num");

        //-----------mod show list
        var mod_num_post =$el.find(".mod_num_post");
        var mod_post_list = $el.find(".mod_post_list");
        var mod_post_pagin = $el.find(".mod_post_pagin");
        //-----------------------------

        //-----------modal Article form
        var mdArForm = $el.find(".mdArForm");
        var mdArTitle = $el.find(".mdArTitle");
        //------------------------------
        //----------modal confirm
        var mdDelConf = $el.find(".mdDelConf");
        var mdConfTitle = $el.find(".mdConfTitle");
        var conf_result = $el.find(".conf_result");

        //----------------------------------
        //--------form article--------
        var frmAr = $el.find("#frmAr");
        var cat_id = $el.find(".cat_id");
        var ar_id = $el.find(".ar_id");
        var ar_title = $el.find(".ar_title");
        var ar_summary = $el.find(".ar_summary");
        var ar_body = $el.find(".ar_body");
        
        var box_showPub = $el.find(".ar_pub");
        var txt_showPub = $el.find(".txt_ar_pub");

        var box_approve = $el.find(".ar_approve");
        var txt_showApprove = $el.find(".txt_ar_approve");

        var box_index = $el.find(".ar_index");
        var txt_showIndex = $el.find(".txt_ar_index");

        var frm_result = $el.find(".frm_result");

        var btnSaveAr = $el.find(".btnSaveAr");

        //--------------end of form element--------
        //------------modal edit category form
        var mdCatForm = $el.find(".mdCategoryForm");
        var mdCatTitle = $el.find(".mdCatTitle");

        //----category form element
        var catForm = $el.find("#frmEditCat");
        var cat_title = $el.find(".cat_title");
        var cat_section = $el.find(".cat_section");
        var cat_des = $el.find(".cat_des");
        var edit_cat_id = $el.find(".edit_cat_id");

        var btnSaveCat = $el.find(".btnSaveCat");


        //------label user name
        var label_user_name = "<?php echo $user_name;?>";


        function getRecentPubPost(page=1){
            rc_pub_post.html("");
            var url = "<?php echo site_url("article/modGetPubPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    console.log(rs);
                    $.each(rs.get_ar,function(i,v){
                        var s_title = v.ar_title.substr(0,25);
                        var ln_pub_read = "<?php echo site_url("article/read/");?>"+v.ar_id;

                        var arEditBtn = "";
                        if(parseInt(v.ar_show_public) !== 0){
                            arEditBtn = `
                            <button class="btn btn-warning btnEditAr" data-ar_id="${v.ar_id}">Edit</button>
                            `;
                        }
                        var tmp = `
                            <ul>
                                <li>
                                    <div class="content-wrap">
                                        <h4>
                                        <a href="${ln_pub_read}" target="_blank" title="Click to read">
                                        ${s_title}
                                        </a>
                                        
                                        &nbsp;Post By <span class="label label-default">${v.ar_post_by}</span>
                                        </h4>
                                        <p>${v.ar_summary}</p>
                                        <p>
                                        ${arEditBtn}
                                        </p>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <h4>
                                                    Has read <span class="label label-default">
                                                    ${v.ar_read_count}
                                                    </span>&nbsp;time(s).
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <br style="clear:both"/>
                                </li>
                            </ul>
                        `;
                        rc_pub_post.append(tmp);
                    });
                    rc_pub_num.html(rs.num_ar);
                    rc_pub_pagin.html(rs.pagination);
                }
            });
        }

        //-----------------------------
        //---------modGetOwnPost
        function modGetOwnPost(page=1){
            mod_post_list.html("");
            var url = "<?php echo site_url("article/modGetOwnPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    mod_num_post.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){
                        var tmp = `
                        <li>
                            <div class="content-wrap">
                                <h3>${v.ar_title}</h3>

                                <p>${v.ar_summary}</p>
                                <button class="btn btn-warning btnEditAr" type="button" data-ar_id="${v.ar_id}">Edit</button>&nbsp;
                                <button class="btn btn-danger btnDelAr" type="button" data-ar_id="${v.ar_id}">Delete</button>
                            </div>
                        </li>
                        `;

                        mod_post_list.append(tmp);

                    });
                    
                }
            });
        }

        //----------------------------------
        //---------mod article form 
        function modFormAr(cmd,id){
            var label_user = `${label_user_name}`;
            tinymce.activeEditor.setMode("design");
            frmAr.trigger("reset");
            txt_showPub.html("Private Post");
            txt_showApprove.html("Not Approve Post");


            btnSaveAr.html("Create Post");
            switch(cmd){
                case"edit":
                    var url = "<?php echo site_url("article/modEditAr");?>";
                    var data = {ar_id : id};
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            
                            $.each(rs.get_ar,function(i,v){
                                ar_title.val(v.ar_title);
                                var ar_b = tinymce.activeEditor.setContent(v.ar_body);
                                ar_body.val(ar_b);
                                ar_summary.val(v.ar_summary);
                                ar_id.val(v.ar_id);
                                cat_id.val(v.cat_id);
                                
                                var p_box = parseInt(v.ar_show_public);
                                var p_txt = "Private Post";
                                if(p_box !== 0){
                                    p_txt = "Public Post";
                                    box_showPub.prop("checked",true);

                                } 
                                box_showPub.val(p_box);
                                txt_showPub.html(p_txt);

                                var a_box = parseInt(v.ar_is_approve);
                                var a_txt = "Not Approve Post";
                                if(a_box !== 0){
                                    a_txt = "Approve Post";
                                    box_approve.prop("checked",true);

                                } 
                                box_approve.val(a_box);
                                txt_showApprove.html(a_txt);

                                var i_box = parseInt(v.ar_show_index);
                                var i_txt = "Not show index page";
                                if(i_box !== 0){
                                    i_txt = "Show index page";
                                    box_index.prop("checked",true);

                                } 
                                box_index.val(i_box);
                                txt_showIndex.html(i_txt);

                                var rs_tmp = `
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="page-head">
                                            <h2>Editing...${v.ar_title}</h2>
                                        </div>
                                        <div class="well">
                                            "${v.ar_summary}"
                                        </div>
                                        <br style="clear:both"/>
                                        ${v.ar_body}
                                    </div>
                                
                                </div>
                                `;
                                frm_result.html(rs_tmp);
                                btnSaveAr.html("Update Post");
                                mdArTitle.html(`Editing...${v.ar_title} | ${label_user}`);
                                $(mdArForm).modal("show");
                            });
                        }
                    });
                break;
                default:
                    ar_title.attr("placeholder","Please enter the title | กรุณาใส่หัวข้อ Post");
                    mdArTitle.html(`Create new Post | ${label_user}`);
                    frm_result.html("Creating post...");
                   $(mdArForm).modal("show");
                   
                break;
            }
        }
        //----------------------------------
        //---------setBoxAr
        function setBoxAr(cmd){
            var b_name = "";
            var option = 0;
            var label = "";
            var txt = "";
            switch(cmd){
                case"show_pub":
                    b_name = box_showPub;
                    label = txt_showPub;
                    txt = "Private Post";
                    if(box_showPub.is(":checked")){
                        option = 2;
                        txt = "Public Post.";
                    }
                break;

                case"approve":
                    b_name = box_approve;
                    label = txt_showApprove;
                    txt = "Post NOT Approve.";
                    if(b_name.is(":checked")){
                        option = 2;
                        txt = "Post is Approve.";
                    }
                break;

                case"index":
                    b_name = box_index;
                    label = txt_showIndex;
                    txt = "Not show Index Page";
                    if(b_name.is(":checked")){
                        option = 2;
                        txt = "Show on Index page.";
                    }
                break;
            }

            b_name.val(option);
            label.html(txt);
        }
        //---------------------------------
        //---------modSaveAr----------
        function modSaveAr(){
            btnSaveAr.unbind();
            modal_status.html("").show();
            frmAr.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(e){
                    //alert(e);
                    var rs = $.parseJSON(e);
                    modal_status.html(rs.msg);
                    setTimeout(function(){
                        modal_status.html("Ready...");
                        modFormAr("edit",rs.ar_id);
                        getSummary();
                    },2000);
                })
            });
        }
        //--------------------------
        //-------modDelAr
        function modDelAr(cmd,id){
            $("#btnDelAr").remove();//--reset remove button

            mdConfTitle.html("loading...");
            var url = "<?php echo site_url("article/modDelAr");?>";
            var data = {ar_id : id ,cmd:cmd};
            switch(cmd){
                case"delete":
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            conf_result.html(rs.msg);
                            setTimeout(function(){
                                mdConfTitle.html(`Success | Please close this window.`);
                                conf_result.html("Success! please close this window.");
                                getSummary();
                            },3000);
                            
                        }
                    });
                break;
                default:
                    //---call the confirm box
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                           var rs = $.parseJSON(e);
                           $.each(rs.get_ar,function(i,v){

                            var title = v.ar_title;
                            var a_id = v.ar_id;
                            var tmp = `
                            <ul>
                                <li>
                                    <div class="content-wrap">
                                        <h1>You are about to delete 
                                            <span class="label label-warning">${v.ar_title}</span>
                                        </h1>
                                        <p>
                                            "${v.ar_summary}"
                                        </p>
                                        <p>
                                         ${v.ar_body}
                                        </p>
                                        <br style="clear:both" />
                                        <div class="row">
                                            <div class="col-sm-4">
                                                Post by ${v.ar_post_by}
                                            </div>
                                            <div class="col-sm-4">
                                                Date Create ${v.date_add}
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="page-header">
                                            <h1 class="confTitle">This operation cannot be UNDO!</h1>
                                        </div>
                                        <p>
                                            <b>
                                                <i>
                                                    Are you sure you want to delete?
                                                </i>
                                            </b>
                                        </p>
                                    </div>
                                </li>
                            </ul>
                            `;

                            conf_result.html(tmp);
                            var btnDel = `<button class="btn btn-primary " id="btnDelAr" data-ar_id="${v.ar_id}">Yes, Delete it</button>`;
                            mdConfTitle.html(` Please confirm to delete "${v.ar_title}".`);
                            $(".btnConfClose").before(btnDel);
                            $(mdDelConf).modal("show");
                           });
                        }
                    });
                break;
            }
        }
        //----------------------------
        //---------modGetCatList
        function modGetCatList(page=1){
            show_cat_list.html("");
            var url = "<?php echo site_url("article/modGetCatList/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get_cat,function(i,v){
                            var btn = "";
                            if(parseInt(v.allow_user_change) !== 0){
                                btn = `
                                <button class="btn btn-warning btnEditCat" data-cat_id="${v.cat_id}">Edit</button>
                                `;
                                
                            }
                            var tmp = `
                            <ul>
                                <li>
                                    <div class="content-wrap">
                                        <h2>
                                        <a href="#" class="lnReadCat" data-cat_id="${v.cat_id}">
                                            ${v.cat_title}
                                        </a>&nbsp;
                                        <span class="label label-default">${v.has_content}</span>&nbsp; post(s).
                                        </h2>
                                        <p>
                                        ${v.cat_des}
                                        </p>
                                        <p>${btn}</p>
                                    </div>
                                    <br style="clear:both"/>
                                </li>
                            </ul>
                            `;
                        show_cat_list.append(tmp);
                    });
                    show_num_cat.html(rs.num_cat);
                }
            });
        }
        //------------------------------
        //---------modEditCategory
        function modEditCategory(cmd,id){
            var url = "<?php echo site_url("article/modEditCategory/");?>"+id;
            mdCatTitle.html("Create New category only allow by admin!");
            switch(cmd){

                case"edit":
                    $.ajax({
                        url : url,
                        success : function(e){
                            var rs = $.parseJSON(e);
                             
                            $.each(rs.get_cat,function(i,v){
                                edit_cat_id.val(v.cat_id);
                                cat_title.val(v.cat_title);
                                cat_section.val(v.cat_section);
                                cat_des.val(v.cat_des);

                                mdCatTitle.html(`Editing ${v.cat_title}`);
                                $(mdCatForm).modal("show");
                            });
                        }
                    });

                break;
            }
        }
        //-------------------------------------------------
        //---------modSaveCategory------------------
        function modSaveCategory(){
            btnSaveCat.unbind();
            modal_status.html("");
            catForm.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(o){
                    var rs = $.parseJSON(o);
                    modal_status.html(rs.msg);
                    setTimeout(function(){
                        modal_status.html("Ready ! please click save button to save change you have made or click close button to close this window.");
                    },4000);
                });
            });
        }
        //---------modReadCat
        function modReadCat(page=1,id){
            label_cat_list.html("");
            rc_pub_post.html("");
            var url = "<?php echo site_url("article/modReadCat/");?>"+page;
            var data = {cat_id:id};
            $.ajax({
                type : "post",
                data : data,
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    var c_title = `
                    <h1 class="label_cat_list">
                        ${rs.cat_title}
                        &nbsp;
                        <span class="label label-default rc_pub_num">
                            ${rs.num_ar}
                        </span>
                        &nbsp;item(s).
                    </h1>
                    <br style="clear:both"/>
                    `;
                    $(".c_title").html(c_title);
                    console.log(rs);

                    $.each(rs.get_ar,function(i,v){
                        var lnReadAr = "<?php echo site_url("article/read/");?>"+v.ar_id;

                        var btnEditAr = "";
                        if(parseInt(v.ar_show_public) !== 0 ){
                            btnEditAr = `
                                <button class="btn btn-warning btnEditAr" data-ar_id="${v.ar_id}">Edit</button>
                            `;
                        }
                        var tmp = `
                        <ul>
                            <li>
                                <div class="content-wrap">
                                    <h4>
                                    <a href="${lnReadAr}" target="_blank">
                                        ${v.ar_title}
                                    </a>&nbsp;
                                    
                                    Post by 
                                    <span class="label label-default">
                                    ${v.ar_post_by}
                                    </span>
                                    </h4>
                                    <p>
                                        ${v.ar_summary}
                                    </p>
                                    <p>
                                        ${btnEditAr}
                                    </p>
                                </div>
                                <br style="clear:both"/>
                            </li>
                        </ul>
                        `;

                        rc_pub_post.append(tmp);

                    });
                    
                    
                    
                }
            });
        }
        //--------getSummary-------
        function getSummary(){
            //---getCategoryList
            modGetCatList();
            getRecentPubPost();
            modGetOwnPost();
        }

        //--------getEvent----------
        function getEvent(){
            getSummary();

            //---edit Article btn click event--------
            rc_pub_post.delegate(".btnEditAr","click",function(){
                var id = $(this).attr("data-ar_id");
                modFormAr("edit",id);
            });

            //----pagination link click
            rc_pub_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getRecentPubPost(cur_page);
            });

            //---------------------------------
            //---edit own Post button click event
            mod_post_list.delegate(".btnEditAr","click",function(){
                var id = $(this).attr("data-ar_id");
                modFormAr("edit",id);
            });

            //---------------------------------
            //---Del own Post button click event
            mod_post_list.delegate(".btnDelAr","click",function(){
                var id = $(this).attr("data-ar_id");
                modDelAr(null,id);
            });

            //---delete post button generate by javascript click event
            $(".modal-footer").delegate("#btnDelAr","click",function(){
                var id = $(this).attr("data-ar_id");
                modDelAr("delete",id);
            });
            //--------category link click event
            $(".show_cat_list").delegate(".lnReadCat","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-cat_id");
                modReadCat(null,id);
            }) ;

            //---btn edit category click event
            $(".show_cat_list").delegate(".btnEditCat","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-cat_id");
                //alert("edit cat id "+id);
                modEditCategory("edit",id);
            }) ; 

            //---button btnSaveCat click event
            btnSaveCat.on("click",function(){
                modSaveCategory();
            });

            //-------set checkbox option public
            box_showPub.on("change",function(){
                setBoxAr("show_pub");
            });

             //-------set checkbox option approve
             box_approve.on("change",function(){
                setBoxAr("approve");
            });

             //-------set checkbox option index
             box_index.on("change",function(){
                setBoxAr("index");
            });

            //-----button add new Post click event
            btnAddAr.on("click",function(){
                modFormAr();
            });

            //-----button save Ar click event
            btnSaveAr.on("click",function(){
                modSaveAr();
            });
        }
        return{getEvent:getEvent}
    })();

    //---call script
    arMod.getEvent();
});


</script>
<!--end of file-->
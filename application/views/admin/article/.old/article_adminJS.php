<script>


    $(function(){
        /*
            23 Jan 2019
        */
        var $el = $("#article");

        var arMan = (function(){

            var $ar_list = $el.find(".ar_list");
            var $ar_num = $el.find(".ar_head_num");
            var $ar_pagin = $el.find(".ar_pagin");
            var lnAddAr = $el.find(".lnAddAr");

            //---form input hidden
            var ar_id = $el.find(".ar_id");
            var kw_id = $el.find(".kw_id");
            //---modal add form
            var $mdAr = $el.find(".mdAr");
            var btnSave = $el.find(".btnSave");
            var btnClose = $el.find(".btnClose");

            //--form id
            var $arForm = $el.find("#arForm");

            //---for seo field
            var og_url = $el.find(".og_url");
            var meta_keyword = $el.find(".meta_keyword");
            var meta_des = $el.find(".meta_des");

            //-----article field
            var ar_title = $el.find(".ar_title");
            var ar_sum = $el.find(".ar_sum");
            var ar_body = $el.find(".ar_body");

            //----post status show index
            var show_index = $el.find(".show_index");

            //----post status public
            var ar_pub = $el.find(".ar_pub");

            //----post status approve
            var ar_approve = $el.find(".approve");

            var $fResult = $el.find(".form_result");
            //-----getArList
            function getArList(page=1){
                $ar_list.html("");
                var url = "<?php echo site_url("article/adminListAr/");?>"+page;
                $.ajax({
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs);
                        var num_head = `
                        Recently Post 
                        <span class="badge badge-info">${rs.num_ar}</span>&nbsp;item(s).
                        `;
                        $ar_num.html(num_head);
                        $.each(rs.get_ar,function(i,v){
                            
                            
                            var ar_pub = `
                            <span class="badge badge-danger">No</span>
                            `;
                            if(parseInt(v.ar_show_public) !== 0){
                                ar_pub = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            }

                            var ar_approve = `
                            <span class="badge badge-danger">No</span>
                            `;
                            if(parseInt(v.ar_is_approve) !== 0){
                                ar_approve = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            }

                            var ar_index = `
                            <span class="badge badge-danger">No</span>
                            `;
                            if(parseInt(v.ar_show_index) !== 0){
                                ar_index = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            }
                            
                            
                            
                            var tmp = `
                            <div class="card">
                                <div class="card-header">
                                    <h1>${v.ar_title}</h1>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            ${v.ar_summary}
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Public</th>
                                                        <td>${ar_pub}</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>Approve</th>
                                                        <td>${ar_approve}
                                                        
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Index page</th>
                                                        <td>${ar_index}
                                                        
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>Date Add</th>
                                                        <td>${v.date_add}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Last modifile</th>
                                                        <td>${v.date_edit}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Post By</th>
                                                        <td>${v.ar_post_by}</td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-primary btnEditAr" data-ar_id="${v.ar_id}">edit</button>
                                    <button class="btn btn-danger btnDelAr" data-ar_id="${v.ar_id}">delete</button>
                                </div>
                            </div>
                            <br />
                            `;
                            $ar_list.append(tmp);
                        });
                    }
                });

            }
            //------------------
            //----arForm
            function arForm(cmd,id){
                tinymce.activeEditor.setMode("design");
                $arForm.trigger("reset");
                switch(cmd){
                    case"edit":
                        var url = "<?php echo site_url("article/adminEditAr/");?>"+id;
                        $.ajax({
                            url : url,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                $.each(rs.get_ar,function(i,v){
                                    kw_id.val(v.kw_id);
                                    ar_id.val(v.ar_id);
                                    og_url.val(v.og_url);
                                    meta_keyword.val(v.kw_page_keyword);

                                    var is_pub = parseInt(v.ar_show_public);
                                    if(is_pub !== 0){
                                        ar_pub.prop("checked",true);
                                    }

                                    var index = parseInt(v.ar_show_index);
                                    if(index !== 0){
                                        show_index.prop("checked",true);
                                    }

                                    var app = parseInt(v.ar_is_approve);
                                    if(app !== 0){
                                        ar_approve.prop("checked",true);
                                    }

                                    meta_des.val(v.kw_page_des);
                                    ar_title.val(v.ar_title);
                                    ar_sum.val(v.ar_summary);
                                    tinymce.activeEditor.setContent(v.ar_body);
                                    $($mdAr).modal("show");
                                });
                            }
                        });
                    break;
                    default:
                       var url = "<?php echo site_url("article/adminFirstSave");?>";
                       $.ajax({
                        url : url,
                        success : function(e){
                            //console.log(e);
                            
                            var rs = $.parseJSON(e);
                            $.each(rs.get_ar,function(i,v){
                                kw_id.val(v.kw_id);
                                ar_id.val(v.ar_id);
                                og_url.val(v.og_url);
                                meta_keyword.val(v.kw_page_keyword);
                                meta_des.val(v.kw_page_des);
                                $($mdAr).modal("show");
                            });
                            
                        }
                       });
                    break;
                }
            }
            //-------------
            //----saveArticle
            function saveArticle(){
                btnSave.unbind();
                $arForm.submit(function(e){
                    e.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        //console.log(e);
                        
                        var rs = $.parseJSON(e);
                        $fResult.html(rs.msg);
                        var ar_id = parseInt(rs.ar_id);
                        setTimeout(function(){
                            getArList();
                            $fResult.html("");
                            arForm("edit",ar_id);
                        },2000);
                        
                        
                        
                        
                    });
                });
            }

            //-------delAr
            function delAr(cmd,id){
                switch(cmd){
                    case"delete":
                        var url = "<?php echo site_url("article/modDelAr/");?>";
                        var data = {cmd:"delete",ar_id:id};
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                alert(`${rs.msg}`);
                                setTimeout(function(){
                                    getSummary();
                                },400);
                            }
                        });
                    break;
                    default:
                        var msg = `your are about to delete ${id} this operation cannot be undo\n Are you sure to delete  id ${id}?`;
                        if(confirm(msg) === false){
                            return false;
                        }else{
                            delAr("delete",id);
                        }
                    break;
                }
            }
            //-----getSummary
            function getSummary(){
                getArList();
            }
            //-------------------
            //---getEvent
            function getEvent(){
                getSummary();

                //---lnAr click
                lnAddAr.on("click",function(e){
                    e.preventDefault();
                    arForm();
                });

                //---edit article
                $ar_list.delegate(".btnEditAr","click",function(e){
                    e.preventDefault();
                    var id = $(this).attr("data-ar_id");
                    arForm("edit",id);
                });

                //---delete article
                $ar_list.delegate(".btnDelAr","click",function(e){
                    e.preventDefault();
                    var id = $(this).attr("data-ar_id");
                    delAr(null,id);
                });

                btnSave.on("click",function(){
                    saveArticle();
                    
                });

                //----btnClose
                btnClose.on("click",function(){
                    location.reload();
                });

            }
            return{getEvent : getEvent}
        })();
        arMan.getEvent();
    });

    //call jQuery
    /*
    //---comment this out Wed 18 July 2018
    $(function(){

            var $el = $("#container");

            var page_status = $el.find(".status");
            var modal_status = $el.find(".modal_status");

            var Template = function(){
                this.construct = function(){
                    //console.log("Template is work!");
                };
                this.catTMP = function(obj){

                    var cat_id = obj.cat_id;
                    var title = obj.cat_title;
                    var pub = obj.cat_show_public;
                    var pub_label = "NO";
                    if(parseInt(pub) !== 0){
                        pub_label = "Yes";
                    }

                    var content = obj.has_content;

                    var section = obj.cat_section;
                    var ch = obj.allow_user_change;
                    var lnView = "<a href='#' data-cat_id='"+cat_id+"' class='lnEditCat'>"+title+"</a>";
                    var del = "<button class='btn btn-danger btn-sm lnDelCat pull-right' data-cat_id='"+cat_id+"' type='button'>";
                    del += "<span class='glyphicon glyphicon-trash'></span> Delete</button>";
                    
                    /*
                    var output = "";
                    output += "<div class='col-sm-4'>";
                    output += "<div class='panel panel-info'>";
                    output += "<div class='panel-heading'>"+lnView+del+"</div>";
                    output += "<div class='panel-body'>"+section+"<br />user can change "+ch+"<br/>";
                    output += "<label class='alert-info'>";
                    output += "Public "+obj.cat_show_public;
                    output += "</label>";
                    output += "</div>";
                    output += "</div>";
                    output += "</div>";

                    */
                    /*
                    var output = `
                    <div class="col-sm-4">
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                ${lnView} ${del}
                            </div>
                            <div class="panel-body">
                                
                                <h4>
                                Section Name&nbsp;
                                <span class="label label-info">
                                ${section}
                                </span>
                                </h4>
                                <h4>
                                User can view&nbsp;
                                <span class="label label-info">
                                ${pub_label}
                                </span>
                                </h4>
                                <h4>
                                Has content &nbsp;
                                <span class="label label-info">
                                ${content}
                                </span>&nbsp; item(s).
                                </h4>
                            </div>
                        </div>
                    </div>
                    `;

                    return output;
                };


                //call construct
                this.construct();
            };

            var manArticle = (function(){
                    Template = new Template();
                    
                    var lnAddAr = $el.find(".lnAddAr");
                    var lnEditAr = $el.find(".lnEditAr");
                    var lnDelAr = $el.find(".lnDelAr");
                    //---the modal form to edit Article
                    var mdArFrm = $el.find(".arForm");
                    var md_arTitle = $el.find(".md_arTitle");

                    //---category
                    var lnAddCat = $el.find(".lnAddCat");
                    var lnEditCat = $el.find(".lnEditCat");
                    var showCatList = $el.find(".showCatList");

                    //---modal category
                    var mdCat = $el.find(".mdCat");
                    //---cat form
                    var catForm = $el.find("#frmCat");
                    var cat_id = $el.find(".cat_id");
                    var cat_title = $el.find(".cat_title");
                    var cat_section = $el.find(".cat_section");

                    //---user can make change category
                    var cat_change = $el.find(".allow_change");
                    var change_txt = $el.find(".change_txt");
                    change_txt.val("Allow user to make change");

                    //--public this cat
                    var cat_pub = $el.find(".cat_public");
                    var cat_pub_txt = $el.find(".cat_pub_txt");
                    cat_pub_txt.val("Category is Private");

                    var btnSaveCat = $el.find(".btnSaveCat");


                    //the form article element
                    var arFrm = $el.find("#frmAr");
                    var ar_id = $el.find(".ar_id");
                    var cat_id = $el.find(".cat_id");
                    var arTitle = $el.find(".ar_title");
                    var arSummary = $el.find(".ar_summary");
                    var arBody = $el.find(".ar_body");
                    var sel_cat = $el.find(".sel_cat");
                    var ar_pub = $el.find(".ar_pub");
                    var pub_txt = $el.find(".pub_txt");
                    var btnArSave = $el.find(".btnArSave");

                    var t_pub = "This Article is set to Public";
                    
                    pub_txt.addClass("label-warning");
                    pub_txt.val(t_pub);

                    var approve = $el.find(".approve");
                    var ap_txt = $el.find(".ap_txt");
                    ap_txt.addClass("label-warning")
                    .val("Not Approve");

                    function getCatList(){
                        //view the category list
                        var url = "<?php echo site_url("article/getCatList");?>";
                        $.ajax({
                            url : url,
                            success : function(e){
                                //console.log(e);
                                var rs = $.parseJSON(e);
                                if(parseInt(rs.num_cat) !== 0){
                                    $.each(rs.get_cat,function(i,v){
                                       // console.log("the cat is "+v.cat_id);
                                        $(showCatList).append(Template.catTMP(v));
                                    });
                                }else{
                                    showCatList.html("There is no Category!");
                                }
                            }
                        });

                    }
                    //----
                    function frmCat(cmd,id){
                        switch(cmd){
                            case"editCat":
                                var url = "<?php echo site_url("article/admin");?>";
                                var data = {cmd : "editCat",cat_id : id};
                                $.ajax({
                                    type : "post",
                                    url : url,
                                    data : data,
                                    success : function(e){
                                        var rs = $.parseJSON(e);
                                        //console.log(rs);
                                        $.each(rs.get_cat,function(i,v){
                                            $(".modal-title").html("Edit "+v.cat_title);
                                            cat_title.val(v.cat_title);
                                            cat_id.val(v.cat_id);
                                            cat_section.val(v.cat_section);
                                           // console.log("show pub is "+v.cat_show_public);
                                            
                                            //--set public category
                                            var set_pub = parseInt(v.cat_show_public);
                                            cat_pub_txt.val("Private category");
                                            if(set_pub !== 0){
                                                cat_pub.prop("checked",true);
                                                cat_pub_txt.val("Public category");
                                            }
                                            cat_pub.val(set_pub);
                                            //--user can change
                                            var ch = parseInt(v.allow_user_change);
                                            var ch_txt = "Not Allow user change";
                                            if(ch !== 0){
                                                cat_change.prop("checked",true);
                                                ch_txt = "Allow user change";
                                            }
                                            change_txt.val(ch_txt);
                                            cat_change.val(ch);

                                            $(mdCat).modal("show");
                                        });
                                    }
                                })
                                
                            break;
                            default:
                                
                                $(mdCat).modal("show");
                            break;
                        }
                    }
                    
                    //-------cat set public
                    function catSetPub(){
                        var p = 0;
                        var t = "Private category";
                        if(cat_pub.is(":checked") === true){
                            p = 1;
                            t = "Public category";
                        }
                        cat_pub_txt.val(t);
                        cat_pub.val(p);
                        return parseInt(p);
                    }

                    //---cat set allow user
                    function catSetAllow(){
                        var p = 0;
                        var t = "Not Allow user to change";
                        if(cat_change.is(":checked") === true){
                            p = 1;
                            t = "Allow user to make change";
                        }
                        change_txt.val(t);
                        cat_change.val(p);
                        return parseInt(p);
                    }

                    function saveCat(){
                        btnSaveCat.unbind();
                        catForm.submit(function(evt){
                            evt.preventDefault();
                            var url = $(this).attr("action");
                            var data = $(this).serialize();
                            $.post(url,data,function(e){
                              modal_status.html(e.msg).show();  
                            },"json");
                            setTimeout(function(){
                                modal_status.html("Reloading...");
                                location.reload();
                            },400);
                        });
                        
                    }
                    //--delCat
                    function delCat(id){
                        
                        if(confirm("You are about to delete the category and or of the item that maybe contain\n this operation cannot be UNDO if you click on OK you may lost all of the data!\n are you sure you want to delete?")){
                            var url = "<?php echo site_url("article/admin/{$user_id}");?>";
                            var data = {cmd : "delCat",cat_id : id};
                            $.ajax({
                                type : "post",
                                url : url,
                                data : data,
                                success : function(e){
                                    var rs = $.parseJSON(e);
                                    page_status.html(rs.msg).show();
                                    setTimeout(function(){
                                        page_status.html("Reloading...").slideToggle();
                                        location.reload();
                                    },400);
                                }
                            });

                        }
                        

                        return false;
                    }
                    //-------
                    function setArPub(){
                        var p = 0;
                        var t = "This item wil set as Private";
                        pub_txt.addClass("label-warning");
                        if(ar_pub.is(":checked")){
                            p = 2;
                            t = "this item will be public";
                            pub_txt.removeClass("label-warning")
                            .addClass("label-success");
                        }
                        pub_txt.val(t);
                        ar_pub.val(p);
                        return parseInt(p);
                    }
                    function setApprove(){
                        var ap = 0;
                        var t = "Not Approve";
                        ap_txt.removeClass("label-sucess")
                        .addClass("label-warning");
                        if(approve.is(":checked")){
                            ap = 2;
                            ap_txt.removeClass("label-warning")
                            .addClass("label-success");
                            t = "Approve";
                        }
                        ap_txt.val(t);
                        approve.val(ap);
                        console.log("The ap is "+ap);
                        return parseInt(ap);
                    }

                    //--frmAr form article
                    function frmAr(){

                            //clear the modal
                            //md_arTitle.html("Add new Article");
                            //arTitle.val("");
                            arFrm.trigger("reset");
                            var p = `The article is private | ตั้งเป็นส่วนตัว`;
                            var a = `NOT APPROVE | ไม่ผ่านการตรวจสอบ`;
                            ap_txt.removeClass("label-success")
                                        .addClass("label-warning")
                                        .val(a);

                            pub_txt.removeClass("label-success")
                            .addClass("label-warning")
                            .val(p);

                            var a_title = `The title of the article best 100 charecter | หัวเรื่องไม่ควรเกิน  100 ตัวอักษร`;
                            var a_sum = "The summary is will show as it title of the list | Summary คือส่วนที่จะแสดงในหน้าหลักรายการย่อ ไม่ควรเกิน 500 ตัวอักษร";
                            arTitle.attr("placeholder",a_title).val("");
                            arSummary.attr("placeholder",a_sum)
                            .val("");
                            md_arTitle.html("Create new Article");
                            tinymce.activeEditor.setMode("design");
                            $(mdArFrm).modal("show");
                        
                    }
                        //---------

                    function num_txt_length(fieldName){

                        var title = fieldName.length;
                        
                        if(title > 10){
                            $(".modal_status").html("Good now go add the body text");
                            setTimeout(function(){
                                $(".modal_status").fadeOut("slow");
                            },400);
                        }else{
                            $(".modal_status").html("it is better to be longer title").fadeIn("slow");
                        }
                        //console.log("title length is "+title);
                        return parseInt(title);
                    }
                    function editAr(id){
                            
                            var url = "<?php echo site_url("article/admin/{$user_id}");?>";
                            var data = {cmd : "editAr",ar_id : id};
                            ar_pub.removeClass("label-warning");
                            $.ajax({
                                type : "post",
                                url : url,
                                data : data,
                                success : function(e){
                                    var rs = $.parseJSON(e);
                                    //console.log(rs);
                                    $.each(rs.get_ar,function(i,v){
                                        var title = v.ar_title;
                                        md_arTitle.html(title);
                                        arTitle.val(v.ar_title);
                                        arSummary.val(v.ar_summary);
                                        var sumText = `enter summary`;
                                        if(!v.ar_summary || v.ar_summary.length === 0){
                                            arSummary.attr("placeholder",sumText);
                                            
                                        }

                                        //the article id
                                        ar_id.val(v.ar_id);
                                        cat_id.val(v.cat_id);
                                        sel_cat.val(v.cat_id);
                                        
                                        //set the article body
                                        tinymce.activeEditor.setMode("design");
                                        arBody.val(tinymce.activeEditor.setContent(v.ar_body));
                                        //set the pub value 
                                       var p = 0;
                                        var t = "The item is set to Private";
                                        if(parseInt(v.ar_show_public) !== 0){
                                           pub_txt.removeClass("label-warning").addClass("label-success");
                                            ar_pub.prop("checked",true);
                                            t  = "The item is set to Public";
                                            
                                        }
                                        pub_txt.val(t);

                                        //set the approve
                                        var p_txt = "not approve";
                                        if(parseInt(v.ar_is_approve) !== 0){
                                            p_txt ="approved";
                                            approve.prop("checked",true);
                                            ap_txt.removeClass("label-warning")
                                            .addClass("label-success").val(p_txt);
                                        }
                                        ap_txt.val(p_txt);
                                        
                                        //set the value in checkbox
                                        ar_pub.val(v.ar_show_public);
                                        approve.val(v.ar_is_approve);

                                        $(mdArFrm).modal("show");
                                    });
                                }
                            });

                    }
                    //-------------------saveAr
                    function saveAr(){
                        //alert("The ar id is "+ar_id.val());
                        //var data = {cmd : "saveAr"};
                        
                        btnArSave.unbind();
                        var cmd = "saveAr";
                        
                        arFrm.submit(function(evt){
                            evt.preventDefault();
                            var url = $(this).attr("action");
                            var data =  $(this).serialize()+"&cmd="+cmd;
                             
                             modal_status.html("Please wait").show();
                            $.post(url,data,function(e){
                                //console.log(e);
                                var rs = $.parseJSON(e);
                                modal_status.html(rs.msg_status);
                                setTimeout(function(){
                                    modal_status.html("Reloading...");
                                    location.reload();
                                },2000);
                            });
                        });
                        
                        
                    }
                    //----
                    //--- Delete
                    function delAr(id){
                        
                        if(confirm("Delete this item?") === true){
                            var url = "<?php echo site_url("article/admin/{$user_id}");?>";
                            var data = {
                            cmd : "delAr",
                            ar_id : id
                        };
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                page_status.html(rs.msg).show();
                                setTimeout(function(){
                                    page_status.html("Reloading...").fadeOut("slow");
                                    location.reload();
                                },400);
                            }
                        });
                        }else{
                            return false;
                        }
                        
                    }
                    //-------
                    function getEvent(){
                        getCatList();

                        //lnAddCat
                        lnAddCat.on("click",function(){
                            frmCat();
                        });

                        //--edit cat
                        showCatList.delegate(".lnEditCat","click",function(evt){
                            evt.preventDefault();
                            var id = $(this).attr("data-cat_id");
                            frmCat("editCat",id);
                        });

                        //--cat public
                        cat_pub.on("change",function(){
                            catSetPub();
                        });

                        //--cat set allow user
                        cat_change.on("change",function(){
                            catSetAllow();
                        });

                        //--delete category
                        showCatList.delegate(".lnDelCat","click",function(){
                            var id = $(this).attr("data-cat_id");
                            delCat(id);
                        });


                        //add article
                        lnAddAr.on("click",function(){
                            frmAr();
                        });
                        //user click the link
                        lnEditAr.on("click",function(evt){
                            evt.preventDefault();
                            var id = $(this).attr("data-ar_id");
                            editAr(id);
                        });

                        //Delete article
                        lnDelAr.on("click",function(){
                            var id = $(this).attr("data-ar_id");
                            delAr(id);
                        });

                        //set the public
                        ar_pub.on("change",function(){
                            setArPub();
                        });

                        //approve
                        approve.on("change",function(){
                            setApprove();
                        });

                        arTitle.on("keyup",function(){
                                num_txt_length($(this).val());
                            });
                        //user click button save
                        btnArSave.on("click",function(){
                            //evt.preventDefault();
                            saveAr();
                        });

                        //--frm category
                        btnSaveCat.on("click",function(){
                            saveCat();
                        });
                    }
                    //---------
                    return{getEvent : getEvent}
            })();

            manArticle.getEvent();

    });

*/
//---------------------comment this out Wed 18 July 2018--------

//--start jQuery--//
//---Create on Wed 17 july 2018---
/*
$(function(){

    var $el = $("#container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");


    var articleAdmin = (function(){

        var btnAddCat = $el.find(".btnAddCat");
        var lnCat_edit = $el.find(".lnCat_edit");
        var lnCat_del = $el.find(".lnCat_del");

        //---button add new post
        var btnAddAr = $el.find(".btnAddAr");

        var mdCat = $el.find(".mdCat");
        var mdCatTitle = $el.find(".mdCatTitle");

        var mdLabelUserName = "<?php echo $user_name;?>";

        //--------modal delConf
        var mdDelConf = $el.find(".mdDelConf");
        var mdConfTitle = $el.find(".mdConfTitle");
        var conf_result = $el.find(".conf_result");

        //------end of modal del conf

        //----show recent article list
        var usr_rc_num = $el.find(".user_rc_num");
        var usr_rc_post = $el.find(".user_rc_post");
        var usr_rc_pagin = $el.find(".user_rc_pagin");

        //---show admin post list
        var adm_rc_num = $el.find(".adm_rc_num");
        var adm_rc_post = $el.find(".adm_rc_post");
        var adm_rc_pagin = $el.find(".adm_rc_pagin");

        //----category form
        var catFrm = $el.find("#frmCat");
        var cat_title = $el.find(".cat_title");
        var cat_id = $el.find(".cat_id");
        var cat_section = $el.find(".cat_section");
        var cat_des = $el.find(".cat_des");
        var btnSaveCat = $el.find(".btnSaveCat");

        //---checkbox show public
        var box_show_pub = $el.find(".cat_public");
        var txt_cat_pub = $el.find(".txt_cat_pub");

        //--checkbox allow change
        var box_allow = $el.find(".allow_change");
        var txt_allow = $el.find(".txt_allow_change");

        var box_admin_allow = $el.find(".allow_show");
        var txt_admin_allow = $el.find(".txt_allow_show");

        //--ar not approve show list
        var div_approve = $el.find(".div_ar_approve");
        var approve_pagin = $el.find(".div_approve_pagin");//--pagination area
        var num_approve = $el.find(".num_approve");

        //----------modal article form
        var mdArForm = $el.find(".arForm");
        var mdArTitle = $el.find(".mdArTitle");
        var mdArResult = $el.find(".modal-ar-result");

        //-----form checkbox
        var box_approve = $el.find(".ar_approve"); //--checkbox approve
        var txt_approve = $el.find(".approve_txt");

        var box_public = $el.find(".ar_public"); //--checkbox [public]
        var txt_pub = $el.find(".pub_txt");

        var box_index = $el.find(".ar_index"); //--checkbox [show index]
        var txt_index = $el.find(".index_txt");

        //------form article
        var frmAr = $el.find("#frmAr");
        var ar_id = $el.find(".ar_id");
        var ar_title = $el.find(".ar_title");
        var ar_sum = $el.find(".ar_summary");
        var ar_body = $el.find(".ar_body");

        var btnSaveAr = $el.find(".btnArSave");

        function catForm(cmd,id){
            catFrm.trigger("reset");
            mdCatTitle.html("");
            switch(cmd){
                case"edit":
                    var url = "<?php echo site_url("article/adminEditCat/");?>"+id;
                    $.ajax({
                        url : url,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            $.each(rs.get_cat,function(i,v){
                                mdCatTitle.html("Editing..."+v.cat_title);
                                cat_title.val(v.cat_title);
                                cat_section.val(v.cat_section);
                                cat_des.val(v.cat_des);
                                cat_id.val(v.cat_id);
                                
                                var cat_pub = parseInt(v.cat_show_public);
                                var t_pub = "Private category!.";
                                if(cat_pub != 0){
                                    box_show_pub.prop("checked",true);
                                    t_pub = "Public category.";
                                }
                                box_show_pub.val(cat_pub);
                                txt_pub.html(t_pub);
                                
                                var allow_ch = parseInt(v.allow_user_change);
                                var allow_c = "User cannot make any change!";
                                if(allow_ch != 0){
                                    box_allow.prop("checked",true);
                                    allow_c = "User can make change on This!";
                                }
                                box_allow.val(allow_ch);
                                txt_allow.html(allow_c);


                                var ad_allow = parseInt(v.admin_allow_show);
                                var t_allow = "NOT allow by Admin";
                                if(ad_allow != 0){
                                    box_admin_allow.prop("checked",true);
                                    t_allow = "Allow by admin.";
                                }
                                box_admin_allow.val(ad_allow);
                                txt_admin_allow.html(t_allow);

                                $(mdCat).modal("show");
                            });
                        }
                    });
                break;
                default:

                    mdCatTitle.html("Create new Category!");
                    cat_id.val(0);
                    txt_pub.html("Private category!");
                    txt_allow.html("NOT allow user to make change!");
                    txt_admin_allow.html("NOT allow to show by Admin!");
                    cat_title.attr("placeholder","Title for new Category");
                    cat_section.attr("placeholder","Section title like 'Bird','Cat','Car','People' etc.  or just leave it blank.");
                    $(mdCat).modal("show");
                break;
            }
        }
        //---------------------
        function getBox(cmd){

            var box_name = "";
            var ch_box = "";
            var txt_show = "";
            var set_box = 0;
            switch(cmd){
                case"show_pub":
                    box_name = txt_cat_pub;
                    ch_box = box_show_pub;
                    txt_show = "Private category!";
                    if(box_show_pub.is(":checked")===true){
                        set_box = 2;
                        txt_show = "Public category.";
                    }
                    
                break;
                case"allow_change":
                    box_name = txt_allow;
                    ch_box = box_allow;
                    txt_show = "Not Allow user to make change!";
                    if(box_allow.is(":checked")===true){
                        set_box = 2;
                        txt_show = "Allow user to make change!";
                    }
                break;
                case"admin_allow":
                    box_name = txt_admin_allow;
                    ch_box = box_admin_allow;
                    txt_show = "Not Allow to show by admin!";
                    if(box_admin_allow.is(":checked")===true){
                        set_box = 2;
                        txt_show = "Allow to show by admin!";
                    }
                break;
            }
            box_name.html(txt_show);
            ch_box.val(set_box);
            //console.log(`box set to ${set_box} and test val is ${ch_box.val()}`);
            
        }

        function saveCat(){
            //----submit category form
            btnSaveCat.unbind();
            catFrm.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize()+"&cmd=save_cat";
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    
                    modal_status.html(rs.msg).show();
                    setTimeout(function(){
                        catForm("edit",rs.cat_id);
                        modal_status.html("editing....").fadeOut("slow");
                    },2000);
                    
                });
            });
        }

        //---adminDelCat
        function adminDelCat(cmd,id){
            $(".conf_result").html("");
            $(".btnDelCat").remove();
            mdConfTitle.html("Please confirm to DELETE!");
            var url = "<?php echo site_url("article/adminDelCat");?>";
            var data = {cmd:cmd,cat_id:id};
            switch(cmd){
                case"delete":
                    $(".modal-header").removeClass("confTitle")
                    .addClass("label-success");
                    mdConfTitle.html("Loading...");
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            mdConfTitle.html("Success | item has been removed!");
                            modal_status.html(rs.msg);
                            setTimeout(function(){
                                getSummary();
                                $(".modal-header").removeClass("label-success")
                                .addClass("confTitle");
                            },2000);
                        }
                    });
                break;
                default:
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            
                            var rs = $.parseJSON(e);
                            //console.log(rs);
                            var msgConf = `
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="page-header">
                                            <h2>You are about to delete 
                                                <span class="label label-danger">${rs.cat_title}</span>
                                            </h2>
                                            <p>
                                                All of the below contain list will be permently remove! 
                                                <strong>
                                                    This operation cannot be undo!
                                                </strong>
                                            </p>
                                        </div>
                                    </div>
                                    
                                </div>
                            `;
                            var btnDelCat = `
                            <button class="btn btn-primary btnDelCat" data-del_id="${rs.cat_id}">Yes, I want to delete</button>
                            `;

                            $(".btnConfClose").before(btnDelCat);
                            $(".conf_result").append(msgConf);
                            $.each(rs.get_ar,function(i,v){
                                var tmp = `<div class="show-list">
                                    <ul>
                                        <li>${v.ar_title}</li>
                                    </ul>
                                </div>`;
                                $(".conf_result").append(tmp);
                            });
                            $(mdDelConf).modal("show");
                            
                        }
                    });
                break;
            }
        }

        //---------------------
        function getNotApproveAr(page=1){
            div_approve.html("");
            num_approve.html("");
            var url = "<?php echo site_url("article/getArNotApprove/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    num_approve.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){

                        var s_title = v.ar_title.substr(0,45);
                        var tmp = `
                        <div class="content-wrap">
                            <h4>
                                <b>
                                    ${s_title}
                                </b>
                                post by <span class="label label-default">
                                    ${v.ar_post_by}
                                </span>
                            </h4>
                            <p>
                                ${v.ar_summary}
                            </p>
                            <p>Post date
                                <span class="label label-default">
                                    ${v.date_add}
                                </span>
                                
                                &nbsp;Last edit &nbsp;
                                <span class="label label-default">
                                    ${v.date_edit}
                                </span> 
                                     
                                </p>

                        </div>
                        <br style="clear:both"/>
                        `;
                        div_approve.append(tmp);
                    });
                    approve_pagin.html(rs.pagination);
                    
                }
            });
        }
        //----------
        function getUserRecentPost(page=1){
            usr_rc_post.html("");
            var url = "<?php echo site_url("article/getArUserPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    usr_rc_num.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){
                        var s_title = v.ar_title.substr(0,24);
                        var s_sum = v.ar_summary.substr(0,200);
                        var tmp = `
                        <ul>
                            <li>
                                
                                <div class="content-wrap">
                                    <h3>${s_title}
                                     | post by <span class="label label-default">${v.ar_post_by}</span>
                                    </h3>
                                    <p>${v.ar_summary}</p>
                                    <p>
                                        Create ${v.date_add}
                                    </p>
                                    <p>
                                    <button type="button" class="btn btn-default btn-sm btnEditAr" data-ar_id="${v.ar_id}">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit 
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm btnDelAr" data-ar_id="${v.ar_id}">
                                                <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button>
                                    </p>
                                </div>
                                <br style="clear:both" />
                            </li>
                        </ul>
                        `;

                        usr_rc_post.append(tmp);
                    });
                    usr_rc_pagin.html(rs.pagination);
                }
            });
        }

        //----------getAdminRecentPost
        function getAdminRecentPost(page=1){
            adm_rc_post.html("");
            var url = "<?php echo site_url("article/adminGetPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    adm_rc_num.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){
                        var s_title = v.ar_title.substr(0,24);
                        
                        var tmp = `
                        <ul>
                            <li>
                                <div class="content-wrap">
                                    <h3>${s_title} | by ${v.ar_post_by}</h3>
                                    
                                    <p>${v.ar_summary}</p>
                                    <p>
                                        <button type="button" class="btn btn-default btn-sm btnEditAr" data-ar_id="${v.ar_id}">
                                                <span class="glyphicon glyphicon-pencil"></span> Edit 
                                        </button>&nbsp;
                                        <button type="button" class="btn btn-danger btn-sm btnDelAr" data-ar_id="${v.ar_id}">
                                                <span class="glyphicon glyphicon-trash"></span> Delete
                                        </button>
                                    </p>
                                </div>
                                <br style="clear:both" />
                                <hr />
                            </li>
                        </ul>
                        `;

                        adm_rc_post.append(tmp);
                    });
                    adm_rc_pagin.html(rs.pagination);
                }
            });

        }

        //------show form in modal
        function showFormAr(cmd,id){
            frmAr.trigger("reset");
            mdArResult.html("");
            tinymce.activeEditor.setMode("design");
            mdArTitle.html("");
            switch(cmd){
                case"edit_ar":
                    var url = "<?php echo site_url("article/adminEditAr");?>";
                    var data = {ar_id : id};
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            //console.log(rs);
                            
                            $.each(rs.get_ar,function(i,v){
                                var s_title = v.ar_title.substr(0,25);
                                mdArTitle.html(`Editing.....${s_title} by ${mdLabelUserName}`);
                                ar_id.val(v.ar_id);
                                ar_title.val(v.ar_title);
                                ar_sum.val(v.ar_summary);
                                ar_body.val(tinymce.activeEditor.setContent(v.ar_body));
                                cat_id.val(v.cat_id);
                                

                                //------------------------------------
                                //----checkbox pub -----
                                var t_pub = "Not Public";
                                var b_pub = parseInt(v.ar_show_public);
                                if(b_pub !== 0){
                                    box_public.prop("checked",true);
                                    t_pub = "Public";
                                }
                                box_public.val(b_pub);
                                txt_pub.html(t_pub);
                                //-------end checkbox public------------
                                //---------------------------------

                                //------------------------------------
                                //----checkbox pub -----
                                var t_index = "Not Index";
                                var b_index = parseInt(v.ar_show_index);
                                if(b_index !== 0){
                                    box_index.prop("checked",true);
                                    t_index = "Index";
                                }
                                box_index.val(b_index);
                                txt_index.html(t_index);
                                //-------end checkbox index------------
                                //---------------------------------

                                //------------------------------------
                                //----checkbox approve-----
                                var t_ap = "Not Approve";
                                var b_ap = parseInt(v.ar_is_approve);
                                if(b_ap !== 0){
                                    box_approve.prop("checked",true);
                                    t_ap = "Approved";
                                }
                                box_approve.val(b_ap);
                                txt_approve.html(t_ap);
                                //-------end checkbox approve------------
                                //---------------------------------

                                var rs_tmp = `
                                <br style="clear:both" />
                                <div class="page-header">
                                    <h1>Please click "Save" to update your change!</h1>
                                </div>
                                <div class="container">
                                    <div class="article_box">
                                        <h2>${v.ar_title}</h2>
                                        <p>${v.ar_summary}</p>
                                    </div>
                                    <div class="show-list">
                                        ${v.ar_body}
                                    </div>
                                </div>
                                
                                `;
                                mdArResult.html(rs_tmp);
                                $(mdArForm).modal("show");
                            });
                            
                        }
                    })
                break;
                default:
                    ar_id.val(0);
                    var ar_pTitle = "Please enter the title.";
                    ar_title.attr("placeholder",ar_pTitle);
                    ar_sum.attr("placeholder","please enter the summary for your post min 30 chars.");
                    mdArTitle.html(`Create new Post | ${mdLabelUserName}`);

                    $(mdArForm).modal("show");
                break;
            }
        }

        function setBoxAr(cmd){

            var txt = "";
            var opt = 0;
            var box_name = "";
            var label_name = "";
            switch(cmd){
                case"ar_approve":
                    txt = "Not Approve.";
                    box_name = box_approve;
                    label_name = txt_approve;
                    if(box_approve.is(":checked")){
                        opt = 2;
                        txt = "Approved.";
                    }
                break;
                case"ar_public":
                    txt = "Not Public.";
                    box_name = box_public;
                    label_name = txt_pub;
                    if(box_public.is(":checked")){
                        opt = 2;
                        txt = "Public.";
                    }
                break;

                case"ar_index":
                    txt = "Not Index.";
                    box_name = box_index;
                    label_name = txt_index;
                    if(box_index.is(":checked")){
                        opt = 2;
                        txt = "Index.";
                    }
                break;
            }
            box_name.val(opt);
            label_name.html(txt);
            //console.log(`opt is ${opt} and txt is ${txt}`);
            
        }

        //------------saveAr
        function saveAr(){
            btnSaveAr.unbind();
            frmAr.submit(function(e){
                e.preventDefault();
                var data = $(this).serialize();
                var url = $(this).attr("action");
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    modal_status.html(rs.msg);

                    setTimeout(function(){
                        modal_status.html("Waiting....").fadeOut("slow");
                        showFormAr("edit_ar",rs.ar_id);
                        getSummary();
                    },2000);

                    
                });
            });
        }

        //---------Delete post
        function delAr(cmd,id){
            $(".btn-primary").remove();
            $(".conf_result").html("");
            var url = "<?php echo site_url("article/adminDelAr");?>";
            var data = {ar_id:id,cmd:cmd};
            
            switch(cmd){
                case"delete":
                    $(".modal-title").html("Success | item has been remove!");
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            //console.log(e);
                            conf_result.html(`
                                <div class="alert alert-success">
                                    <h1>Success | item has been Deleted!</h1>
                                </div>
                            `);
                            setTimeout(function(){
                                $(".btn-primary").fadeOut("slow");
                                getSummary();
                            },2000);
                        }
                    })
                break;
                default:
                    $.ajax({
                        type : "post",
                        url : url,
                        data : data,
                        success : function(e){
                            var rs = $.parseJSON(e);
                            $.each(rs.get_ar,function(i,v){
                                var btnDel = `<button class="btn btn-primary btnDelConf" data-del_id="${v.ar_id}">Delete!</button>`;
                                var rs_tmp = `
                                <div class="show-list">
                                <ul>
                                    <li>
                                        <div class="content-wrap">
                                            <h2>
                                            Do you want to delete "${v.ar_title}"?</h2>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="content-wrap">
                                            <p>
                                                ${v.ar_summary}
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="content-wrap">
                                            <p>
                                                ${v.ar_body}
                                            </p>
                                        </div>
                                        <br style="clear:both" />
                                        <hr />
                                    </li>
                                    <li>
                                        <div class="content-wrap">
                                            <h1>This operation cannot be undo!</h1>
                                            <p>
                                                <strong>
                                                    <u>
                                                        Are you sure you want to delete?
                                                    </u>
                                                </strong>
                                            </p>
                                        </div>
                                    </li>
                                </ul>

                                </div>
                                `;
                                conf_result.append(rs_tmp);
                                $(".btnConfClose").before(btnDel);
                                $(mdDelConf).modal("show");
                            });
                            
                        }
                    });
                break;
            }

        }

        function getSummary(){
            getNotApproveAr();
            getUserRecentPost();
            getAdminRecentPost();
        }

        function getEvent(){
            getSummary();

            //---approve pagin
            approve_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getNotApproveAr(cur_page);
            });

            //-------------User button click-------------------
            //----pagination user post
            usr_rc_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getUserRecentPost(cur_page);
            });

            usr_rc_post.delegate(".btnEditAr","click",function(){
                var id = $(this).attr("data-ar_id");
                showFormAr("edit_ar",id);
            });

            //---delete button click
            usr_rc_post.delegate(".btnDelAr","click",function(){
                var id = $(this).attr("data-ar_id");
                delAr(null,id);
            });
            //--------End of user
            //-----------------------------------------------------

            //---------------------Admin post button click---------
            //----button add new post
            btnAddAr.on("click",function(){
                showFormAr();
            });

            //--pagination admin post
            adm_rc_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getAdminRecentPost(cur_page);
            });

            //-----btnEdit click
            adm_rc_post.delegate(".btnEditAr","click",function(){
                var id = $(this).attr("data-ar_id");
                showFormAr("edit_ar",id);
            });

            //---btnDel click
            adm_rc_post.delegate(".btnDelAr","click",function(){
                var id = $(this).attr("data-ar_id");
                delAr("",id);
            });

            //----------------------End of admin button click--------------

            //---button addCat click
            btnAddCat.on("click",function(){
                catForm();
            });
            //--button lnCat_edit click
            lnCat_edit.on("click",function(){
                var id = $(this).attr("data-cat_id");
                catForm("edit",id);
            });

            //----button lnCat_del click
            lnCat_del.on("click",function(){
                var id = $(this).attr("data-cat_id");
                adminDelCat(null,id);
            });
            //---------------
            box_show_pub.on("change",function(){
                getBox("show_pub");
            });

            //---
            box_allow.on("change",function(){
                getBox("allow_change");
            });

            //-----------
            box_admin_allow.on("change",function(){
                getBox("admin_allow");
            });

            //---btnSaveCat is category form submit
            btnSaveCat.on("click",function(){
                saveCat();
            });

            btnSaveAr.on("click",function(){
                saveAr();
            });

            //---------------checkbox event---------
            box_approve.on("change",function(){
                setBoxAr("ar_approve");
            });

            box_public.on("change",function(){
                setBoxAr("ar_public");
            });

            box_index.on("change",function(){
                setBoxAr("ar_index");
            });


            //-----mdConf button delete click
            $(".modal-footer").delegate(".btnDelConf","click",function(){
                var id = $(this).attr("data-del_id");
                delAr("delete",id);
            });

            $(".modal-footer").delegate(".btnDelCat","click",function(){
                var id = $(this).attr("data-del_id");
                adminDelCat("delete",id);
            });

            //---------end of mdConf event---------------------------- 
            //---------------------------------------------------------------

        }//---end of getEvent
        return{getEvent:getEvent}
    })();


    //---call the method
    articleAdmin.getEvent();
});    

*/
//--End of jQuery--//
</script>
<script>

    //call jQuery
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
                            md_arTitle.html("Add new Article");
                            
                        //--clear form wed 23/5/2018
                            arFrm.trigger("reset");
                            arTitle.val("");

                        ar_pub.val(0);                        
                        pub_txt.addClass("label-warning");
                        pub_txt.val(`Not show public`);

                        approve.val(0);
                        ap_txt.addClass("label-warning")
                        .val("Not Approve");
                            
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
</script>

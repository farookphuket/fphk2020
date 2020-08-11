<section id="ustd">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-right">
                    <p class="alert alert-warning">
                        <?php echo"{$sysName} version {$sysVersion} date on {$sysDate}"; ?>
                    </p>
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="col-lg-12">
                <h1 class="text-center">
                    What going on? 
                <span class="alert alert-success">
                    <?php echo $user_name; ?>
                </span>
                </h1>
                <p>&nbsp;</p>
            </div>

            <div class="col-lg-12">
                <textarea class="form-control lnCreate"></textarea>
            </div>
            <div class="col-lg-12">
                <p>&nbsp;</p>
                <div class="float-right">
                    <div class="st_pagin">
                        
                    </div>
                </div>
                <p class="pt-5">&nbsp;</p>
                <div class="st_list">
                </div>
                <div class="float-right">
                    <div class="st_pagin">
                    
                    </div>
     
                </div>
                </div>

        </div>
    </div>
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">What is going on <?php echo $user_name ?></h1>
                   <button class="close" data-dismiss="modal">&times;</button> 
                </div>
                <div class="modal-body">

<?php
    $fr = "admin/ustd/_ustd_form";
    $this->load->view($fr);

?>         

                    
                    <div class="modal_status">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btnSave" form="frmStatus">Post</button>
                    <button class="btn btn-danger" data-dismiss="modal">Close</button>

                   
                </div>
            </div>
        </div>
    </div>
</section>

<script charset="utf-8">
    //-- version 1.30 date 15-Mar-2020
    $(function(){

        const $USTD = (function(){

            //--on page
            let lnCreate = getEl(".lnCreate");
            lnCreate.attr("placeholder","to create new post click here คลิกเพื่อสร้างโพสใหม่");
            let $st_list = getEl(".st_list");
            let $st_pagin = getEl(".st_pagin");

            //-- the modal element
            let $md = getEl(".md");
            let $mdTitle = getEl(".modal-title");
            let btnSave = getEl(".btnSave");
            let $modal_status = getEl(".modal_status");
            let $page_status = getEl(".status");
            //-- the form element
            let $frm = getEl("#frmStatus");
            let set_cat = getEl(".set_cat");
            let set_tmp = getEl(".set_tmp");
            let uniq_id = getEl(".uniq_id");
            let st_user_id = getEl(".st_user_id");
            let st_id = getEl(".st_id");
            let st_title = getEl(".st_title");

            /*
            let st_sum = getEl(".st_sum");
            let st_body = getEl(".st_body");
            */
            let st_sum = new Jodit(".st_sum",{placeholder:"USTD summary"});
            let st_body = new Jodit(".st_body",{placeholder:"USTD body detail"});

            let show_public = getEl(".show_public");
            let friend_only = getEl(".friend_only");
            let private_only = getEl(".private_only");


            let ck_ustd_page = Cookies.get("ck_ustd_page");//-- to set pagination page

            if(ck_ustd_page === undefined){
                    ck_ustd_page = 1;
            }


            function ustdGetList(ck_ustd_page){
                

                
                $st_list.html("");
                let url = "<?php echo site_url("ustd/adminGet/"); ?>"+ck_ustd_page;     
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get,(i,v)=>{

                        let yes = `<span class="alert alert-success">Yes</span>`;
                        let no = `<span class="alert alert-danger">No</span>`;
                        let st_pub = no;
                        let st_friend = no;
                        let st_pri = no;
                        if(parseInt(v.show_public) !== 0){
                            st_pub = yes;
                        }
                        
                        if(parseInt(v.private_only) !== 0){
                            st_pri = yes;
                        }
                        if(parseInt(v.friend_only) !== 0){
                            st_friend = yes;
                        }

                        let tmp = `<div class="card">
    <div class="card-header">
        <h2 class="text-center">${v.st_title}</h2>
    </div>
    <div class="card-body">
        <div class="conatiner">
            <p>${v.st_sum}</p>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Public</th>
                    <td>${st_pub}</td>
                </tr>
                <tr>
                    <th>Friend Only</th>
                    <td>${st_friend}</td>
                </tr>
                <tr>
                    <th>Private Only</th>
                    <td>${st_pri}</td>
                </tr>
                <tr>
                    <th>Post By</th>
                    <td>${v.name}</td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td>
                    <p>
                    Created | ${v.date_create} &nbsp; 
                    Update | ${v.date_update}
                    </p>
                    </td>
                </tr>

            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-st_id="${v.st_id}" >Edit</button>
            <button class="btn btn-danger lnDel" data-st_id="${v.st_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-3">&nbsp;</p>`;

                        $st_list.append(tmp);

                    });
                    if(rs.pagination){
                        $st_pagin.html(rs.pagination);
                    }
                }
                });
            }
            function ustdGetSummary(){
                setTimeout(()=>{
                    $page_status.html("page done...").fadeOut("slow");
                    ustdGetList(ck_ustd_page);

                },500);


            }
            function ustdCreate(){
                setTimeout(()=>{
                    set_cat.focus();
                    set_tmp.prop("disabled",false);

                    $frm.trigger("reset");
                    st_title.attr("placeholder","Enter Title");
                    $mdTitle.html("Create new Post");

                },1200);
                st_id.val(0);
                $($md).modal("show");
            }

            function ustdEdit(id){
               // alert(`will edit id ${id}`);
                let url = "<?php echo site_url("ustd/ustdGet/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get,(i,v)=>{
                        //set_cat.prop("disabled",true);
                    if(parseInt(v.show_public) !== 0){
                        show_public.prop("checked",true);
                    }
                    if(parseInt(v.private_only) !== 0){
                        private_only.prop("checked",true);
                    }
                    if(parseInt(v.friend_only) !== 0){
                        friend_only.prop("checked",true);
                    }




                        st_id.val(v.st_id);
                        set_cat.val(v.cat_id);
                        set_tmp.prop("disabled",true);
                        st_user_id.val(v.st_user_id);
                        st_title.val(v.st_title);

                        /*
                        tinymce.get("st_sum").setContent(v.st_sum);
                        tinymce.get("st_body").setContent(v.st_body);
                        remove tinymce 24-3-2020
                         */
                        st_sum.value = v.st_sum;
                        st_body.value = v.st_body;
                        $mdTitle.html(`editing ${v.st_title}...`);
                    });
                    $($md).modal("show");
                }
                });
                
            }

            function ustdSetCat(){
                let el = set_cat.find('option:selected');
                let id = el.val();
                set_tmp.html("");
                let url = "<?php echo site_url("ustd/ustdGetTemplate/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    let tm = "";
                    if(rs.get_tmp.length === 0){
                        tm = `<option value=0>No Template</option>`;

                        set_tmp.html(tm);
                    }else{
                        

                        $.each(rs.get_tmp,(i,v)=>{
                            
                        tm = `
                            <option value="${v.tmp_id}">${v.tmp_title}</option>`;
                            
                            set_tmp.append(tm);
                            setTimeout(()=>{
                                set_tmp.focus();
                            },1450);
                        });

                    }
                    
                    
                }
                });
                
            }

            function ustdSetTemplate(id){

                //console.log(`the id is ${id}`);

                let url = "<?php echo site_url("ustd/ustdSetTemplate/") ?>"+id;

                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        $.each(rs.set_tmp,(i,v)=>{
                            //tinymce.get("st_sum").setContent(v.st_)
                            //console.log(v);
                            st_title.val(v.tmp_title);
                            /*
                            tinymce.get("st_sum").setContent(v.tmp_des);
                            tinymce.get("st_body").setContent(v.tmp_body);
                             */
                            st_sum.value = v.tmp_des;
                            st_body.value = v.tmp_body;


                        });
                }
                });
                //-----------
                
            }

            function ustdSave(){
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize();
                    $.post(url,data,function(e){
                        let rs = $.parseJSON(e);
                        $modal_status.html(rs.msg).show();
                        ustdGetSummary();
                    });
                    
                });
            }
            function ustdDelete(id){
                //alert(`will delete the id ${id}`);
                let url = "<?php echo site_url("ustd/ustdAdminDelete/"); ?>"+id;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs =$.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        setTimeout(()=>{
                            $page_status.html("loading...").fadeOut("slow");
                            ustdGetSummary();
                        },2000);
                }
                });
            }

            function getEl(el){
                return $(el);
            }
            function getEvent(){
                $page_status.html("Loading...").show();
                ustdGetSummary();

                //-- lnCreate
                lnCreate.on("click",function(){
                    $frm.trigger("reset");
                    ustdCreate();
                });

                set_cat.on("change",function(){
                    
                   ustdSetCat(); 

                });

                set_tmp.on("blur",function(){
                    let li = $(this).find("option:selected");
                    let id = li.val();


                    ustdSetTemplate(id);
                });
                set_tmp.on("change",function(){
                    //ustdSetTemplate();
                    let li = $(this).find("option:selected");
                    let id = li.val();
                    //console.log(`this i swork the id is ${id}`);
                    ustdSetTemplate(id);
                });

                $st_list.delegate(".lnEdit","click",function(e){
                    e.preventDefault();
                    let id = $(this).attr("data-st_id");
                    ustdEdit(id);
                    //alert(`will edit ${id}`);
                });
                $st_list.delegate(".lnDel","click",function(e){
                    e.preventDefault();
                    let id = $(this).attr("data-st_id");
                    ustdDelete(id);
                });


                btnSave.on("click",function(){
                    ustdSave();
                });
                //--- pagination
                $st_pagin.delegate(".pagination a","click",function(e){
                    e.preventDefault();
                    let go_to_page = $(this).attr("data-ci-pagination-page");
                    if(go_to_page === undefined){
                        go_to_page = ck_ustd_page;
                    }
                    Cookies.set("ck_ustd_page",go_to_page); 
                    ustdGetList(go_to_page);
                });
            }
            return{getEvent:getEvent}
        })();
        $USTD.getEvent();
    });
</script>













<!-- Not in use 15-Mar-2020 -->
<!--
<script>
$(function(){
    var $ST = $("#ustd");
    var $page_status = $(".status");
    var ustd = (function(){
        var lnCreate = getEl(".lnCreate");
        var $st_list = getEl(".st_list");
        var $st_pagin = getEl(".st_pagin");
        var $modal_status = getEl(".modal_status");
        

        var $md = getEl(".md");
        var $mdTitle = getEl(".modal-title");
        var btnSave = getEl(".btnSave");

        var $fr = getEl("#frmStatus");
        var st_user_id = getEl(".st_user_id");
        var st_id = getEl(".st_id");
        var uniq_id = getEl(".uniq_id");
        var st_title = getEl(".st_title");
        var st_body = getEl(".st_body");

        var show_pub = getEl(".show_public");
        var friend_only = getEl(".friend_only");
        var private_only = getEl(".private_only");


        function getList(page=1){
           $st_list.html(""); 
            var url = "<?php //echo site_url("ustd/adminGet/"); ?>"+page;
            
            $.ajax({
            url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get,function(i,v){
                        var p = parseInt(v.show_public);

                        var yes = `<span class="badge badge-success">Yes</span>`;
                        var no  = `<span class="badge badge-danger">No</span>`;
                            
                        var pub = `<span class="badge badge-success">Show</span>`;
                        if(parseInt(v.show_public) === 0){
                            pub = `<span class="badge badge-danger">Hide</span>`;
                        }

                        var friend = parseInt(v.friend_only);
                        var pri = parseInt(v.private_only);

                        if(friend !== 0){
                            friend = yes;
                        }else{
                            friend = no;
                        }
                            
                         if(pri !== 0){
                            pri = yes;
                        }else{
                            pri = no;
                        }

                        var tmp = `<div class="container">
                            <div class="row">
                            ${v.st_body}
                                <div class="col-lg-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            ${pub}
                                        </div>
                                        <div class="col-md-2">
                                            Friend Only : ${friend}
                                        </div>
                                        <div class="col-md-2">
                                             Private Only : ${pri}
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-lg-12"> 
                                        <span class="float-right">
                                        <a class="btn btn-primary lnEdit" data-st_id="${v.st_id}" style="color:white;font-weight:bold;">Edit</a>

                                        <a class="btn btn-danger lnDel" data-st_id="${v.st_id}" style="color:white;font-weight:bold;">Delete</a>
                                        </span>
                                    </div>
                            
                                </div>
                            </div>
                            <p>&nbsp;</p>`;
                       $st_list.append(tmp); 
                    });
                    if(rs.pagination){
                        $st_pagin.html(rs.pagination);
                    }
                }
            });
        }
        function showForm(cmd,id){
            $fr.trigger("reset");
            tinymce.activeEditor.setMode("design");
                
            switch(cmd){
            case"edit":
                var url = "<?php //echo site_url("ustd/adminEdit/"); ?>"+id;
                $.ajax({
                url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        console.log(rs);
                        $.each(rs.get,function(i,v){
                            st_id.val(v.st_id);
                            st_user_id.val(v.st_user_id);
                            st_title.val(v.st_title);
                            tinymce.activeEditor.setContent(v.st_body);
                            //console.log(v.show_public);
                            if(parseInt(v.show_public) !== 0){
                                show_pub.prop("checked",true);
                            }

                            if(parseInt(v.friend_only) !== 0){
                                friend_only.prop("checked",true);
                            }

                            if(parseInt(v.private_only) !== 0){
                                private_only.prop("checked",true);
                            }

                        
                        });
                    }
                });
            break;
            default:
                setTimeout(function(){
                st_title.focus();
            },2000);
                st_id.val(0);

                $modal_status.html("Create new");
            break;
            }

            $($md).modal("show");

        }

        function setTemplate(){
            var today = new Date().toLocaleString();
            var st_name = "<?php //echo $user_name; ?>";
            var msgTitle = `Event Create by ${st_name} on ${today}`;
            var ps = `${st_title.val()} ${msgTitle}`;
            var sample_img1 = "https://lh3.googleusercontent.com/8KtecAxEYMdJjG2A4eSxA8kCQJZqjwYWV-_oGhQklPESUCPz_f6WUndv4jvH-IAax8VvYpqRbgHSpZYP4qgjvOiYAvxAwdzGGUxiOKe6yQ9UWmGx8XM6ccx_gJTLUIj_pXL9xJuI8Ec=w2400";
            if(parseInt(st_id.val()) === 0){
                if(st_title.val().length < 10){
                    st_title.val(ps);
                }
                var tmp = `<div class="card">
                    <div class="card-header">
                        <h1 class="text-center">
                            ${st_title.val()}
                        </h1>
                    </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img src="${sample_img1}" class="responsive">
                                    <p class="text-center">Your image title here you can simply remove this photo and replace by your.</p>
                                </div>
                                <div class="col-lg-8">
                                    <p>This is your text here just remove this text and put your text here</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                        <p class="alert alert-info">
                         ${st_title.val()}
                       </p> 
                        </div>
                    </div>`;
                    tinymce.activeEditor.setContent(tmp);
            }
        }

        function saveStatus(){
            btnSave.unbind();

            $fr.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    $modal_status.html(rs.msg).show();
                    setTimeout(function(){
                        $modal_status.html("");
                        getSummary();
                    },2000);
                });
            });
        }


        function stDel(id){
            var url = "<?php //echo site_url("ustd/adminDel/"); ?>"+id;
            $.ajax({
                url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        setTimeout(function(){
                            $page_status.html("loading...").fadeOut("slow");
                            getSummary();
                        },4000);
                    }
            });
        }

        function getSummary(){
            getList();
        }

        function getEl(el){
            return $ST.find(el);
        }
        function getEvent(){

            getSummary();
            lnCreate.on("click",function(){
                showForm();
            });

            st_title.on("blur",function(){
                setTemplate();
            });

            $st_list.delegate(".lnEdit","click",function(){
                var id = $(this).attr("data-st_id");
                showForm("edit",id);
            });

            $st_list.delegate(".lnDel","click",function(){
                var id = $(this).attr("data-st_id");
                stDel(id);
            });
            $st_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var page = $(this).attr("data-ci-pagination-page");
                getList(page);
            });

            btnSave.on("click",function(){
                saveStatus();
            });

        }
        return{getEvent:getEvent}
    })();
    ustd.getEvent();
});
-->
<!--
</script> 
-->

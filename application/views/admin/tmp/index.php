<section id="template">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">
                            <?php echo $sysName; ?>
                        </h1>
                        <p class="float-right">
                            <span class="badge badge-success">
                                system version <?php echo $sysVersion; ?>
                                system date <?php echo $sysDate; ?>
                            </span>
                        </p>
                    </div>
                     <div class="card-body">
                        <ul>
                            <li>
                                <p>Last update 27-Feb-2020 create</p>
                            </li>
                        </ul>
                        <p class="pt-4">&nbsp;</p>
                     </div>
                </div>
            </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
            </div>

            <!-- show template label -->
            <div class="col-lg-4">
                <div class="alert alert-success">
                    <h1 class="numAll">0</h1>
                </div>
                <p class="">All template</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-success">
                    <h1 class="numPub">0</h1>
                </div>
                <p class="">Public template</p>
            </div>

            <div class="col-lg-4">
                <div class="alert alert-warning">
                    <h1 class="numPri">0</h1>
                </div>
                <p class="">Private template</p>
            </div>

            <!-- End of label -->

            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
                <div class="float-right">
                    <a class="btn btn-primary lnCreate" style="color:white;font-weight:bold;">Create</a> 
                </div>
            </div>
            <div class="col-lg-12">
                <p class="pt-5">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <div class="tmp_list">
                    
                </div>
                <div class="tmp_pagin">
                    
                </div>
            </div>

        </div>
    </div>
    
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Title</h1>
                </div>
                <div class="modal-body">
<?php
    $frm = "admin/tmp/_frm_tmp";
    $this->load->view($frm);
?> 
                <p class="pt-4">&nbsp;</p>
                    <div class="modal_status">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button  type="submit" class="btn btn-primary btnSave" form="tmp">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script charset="utf-8">
    $(function(){
        const $P = $("#template");
        const $page_status = $(".status");
        const $tmp = (function(){


            //--- for the paginattion
            let page = Cookies.get("page");
            if(!page || page === 'undefined'){
                page = 1;
            }
            
            //--- the label
            let $numAll = getEl(".numAll");
            let $numPub = getEl(".numPub");
            let $numPri = getEl(".numPri");

            //--- create new tmp link
            let lnCreate = getEl(".lnCreate");
            let $tmp_list = getEl(".tmp_list");
            let $tmp_pagin = getEl(".tmp_pagin");
            
            //-- the modal
            let $md = getEl(".md");
            let $mdTitle = getEl(".modal-title");
            let btnSave = getEl(".btnSave");
            let $modal_status = getEl(".modal_status");

            //--- the form
            let $frm = getEl("#tmp");
            let tmp_uri = getEl(".tmp_uri");
            let set_cat = getEl(".set_cat");
            let tmp_id = getEl(".tmp_id");
            let cat_id = getEl(".cat_id");
            let tmp_user_id = getEl(".tmp_user_id");
            let my_id = "<?php echo $user_id; ?>";

            let tmp_title = getEl(".tmp_title");

            /*
            let tmp_des = getEl(".tmp_des");
            let tmp_body = getEl(".tmp_body");
            */
            let tmp_des = new Jodit(".tmp_des",{placeholder:"description of this template"});
            let tmp_body = new Jodit(".tmp_body",{placeholder:"This template body here..."});

            let is_pub = getEl(".is_pub");

            function showForm(cmd,id){
                $frm.trigger("reset");
                $modal_status.html("");
                $mdTitle.html("Create New Template");
                switch(cmd){
                case"edit":
                    let url = "<?php echo site_url("template/adminEdit/") ?>"+id;
                    $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        //console.log(rs);
                        $.each(rs.get,(i,v)=>{

                        if(parseInt(v.tmp_show_pub) !== 0){
                            is_pub.prop("checked",true);
                        }
                            set_cat.val(v.cat_id);
                            cat_id.val(v.cat_id);
                            tmp_title.val(v.tmp_title);

                            /*
                            tinymce.get("tmp_des").setContent(v.tmp_des);
                            tinymce.get("tmp_body").setContent(v.tmp_body);
                             */
                            tmp_des.value = v.tmp_des;
                            tmp_body.value = v.tmp_body;
                            tmp_user_id.val(v.tmp_user_id);
                            tmp_id.val(v.tmp_id);

                            tmp_uri.val(v.cat_uri);
                            $mdTitle.html(`Editing ${v.tmp_title}...`);
                            let msg_show = `<span class="alert alert-warning">Editing ${v.tmp_title}...</span>`;
                            $modal_status.html(msg_show).show();
                            
                        });
                    }
                    });
                break;
                default:
                    setTimeout(()=>{
                       set_cat.focus(); 
                       tmp_uri.attr("placeholder","DO NOT ENTER Anything HERE");
                    },800);
                break;
                }
                $($md).modal("show");    
            }


            function tmpSave(){
                //alert(my_id);
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize()+"&action_code="+my_id+"&cat_id="+cat_id.val();
                    $.post(url,data,function(e){
                        let rs = $.parseJSON(e);
                        $modal_status.html(rs.msg).show();
                        setTimeout(()=>{
                            showForm("edit",rs.tmp_id);
                            getSummary();
                        },450);
                    });

                });
            }
            //----------------
            //---   tmpDel
            function tmpDel(id){
                let url = "<?php echo site_url("template/adminDel/") ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    $page_status.html(rs.msg).show();
                    setTimeout(()=>{
                        $page_status.html("loading...").fadeOut("slow");
                        getSummary();
                    },2000);
                }
                });
            }
            //---   tmpList
            function tmpList(p=1){
                $tmp_list.html("");


                checkPageLocation(p);
                
                let url = "<?php echo site_url("template/getList/") ?>"+p;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //Cookies.set("page",1);
                    //console.log(rs);
                    let num_tmp = rs.get_all.length;
                    let num_pub = 0;
                    let num_pri = 0;

                    $numAll.html(num_tmp);
                    $.each(rs.get_all,(i,v)=>{
                        if(parseInt(v.tmp_show_pub) === 0){
                            num_pri++;
                        }else{
                            num_pub = num_tmp-num_pri;
                        }
                        $numPri.html(num_pri);
                        $numPub.html(num_pub);
                    });

                   $.each(rs.get_tmp,(i,v)=>{
                        let yes = "<span class='badge badge-success'>Yes</span>";
                        let no = "<span class='badge badge-danger'>NO</span>";
                       let tmp_pub = no; 
                        if(parseInt(v.tmp_show_pub) !== 0){
                            tmp_pub = yes;
                        }
                        let tmp = `<div class="card">
    <div class="card-header">
        <h1 class="">${v.tmp_title}</h1>
    </div>                           
    <div class="card-body">
        ${v.tmp_des}
        <p class="pt-3">&nbsp;</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Show Public</th>
                    <td>${tmp_pub}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-tmp_id="${v.tmp_id}">Edit</button>
            <button class="btn btn-danger lnDel" data-tmp_id="${v.tmp_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`;

                        
                        //console.log(`The page is ${page}`);
                        $tmp_list.append(tmp);
                    });
                    if(rs.pagination){
                        $tmp_pagin.html(rs.pagination);
                    }

                }
                });
            }
            //------------------
            //--- checkPageLocation
            function checkPageLocation(p){
                if(p !== page){
                    //Cookies.remove("page");
                    //alert(`The page is ${page}`);
                    console.log(`the p is ${p} the page is ${page}`);
                    p = 1;
                }else{
                    
                    //alert(`The page location is ${p}`);
                }
            }
            //---   getSummary
            function getSummary(){
                tmpList(page);
            }

            //----------------
            function getEl(el){
                return $P.find(el);
            }
            function getEvent(){
                //--- lnCreate click
                lnCreate.on("click",function(){
                    showForm();
                });

                //--- check if the category has select
                set_cat.on("blur",function(){
                    let v1 = set_cat.val();
                    if(parseInt(v1) === 0){
                        alert(`Error : you have to select the category!`);
                        setTimeout(()=>{
                            set_cat.focus();
                        },500);
                    }else{
                        cat_id.val(v1);
                        //alert(`you have select ${cat_id.val()}`);
                    }
                });

                //-- btnSave
                btnSave.on("click",function(){
                    tmpSave();
                });

                //--- getSummary
                getSummary();

                //-- edit 
                $tmp_list.delegate(".lnEdit","click",function(e){
                    let id = $(this).attr("data-tmp_id");
                    showForm("edit",id);
                });
                //--------------
                //-- delete
                $tmp_list.delegate(".lnDel","click",function(e){
                    let id = $(this).attr("data-tmp_id");
                    tmpDel(id);
                });

                //-- pagination
                $tmp_pagin.delegate(".pagination a","click",function(e){
                    e.preventDefault();
                    let page_lo = $(this).attr("data-ci-pagination-page");
                    Cookies.set("page",page_lo);
                    //alert(`will go to ${page_lo}`);
                    checkPageLocation(page_lo);
                    tmpList(page_lo);
                });

            }
            return{getEvent:getEvent}
        })();
        $tmp.getEvent();
    });
</script>

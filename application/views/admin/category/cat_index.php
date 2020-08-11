<section id="category">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">
                    <?php echo $sysName; ?>
                </h1>
                <ul>
                    <li>
                        <p>Create new category system 20-Feb-2020</p>
                    </li>
                </ul>
                <p class="pt-4">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <div class="float-right">
                    <button class="btn btn-primary lnCreate">Create</button>
                </div>
                <h1 class="text-center">
                    Category
                </h1>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="alert alert-info">
                            <h1 class="numAll">0</h1>
                        </div>
                        <p>All</p>
                    </div>

                    <div class="col-lg-6">
                        <div class="alert alert-warning">
                            <h1 class="numPub">0</h1>
                        </div>
                        <p>Public</p>
                    </div>


                </div>
            </div>
            <div class="col-lg-12">
            <p class="pt-4">&nbsp;</p>

            <h1 class="">
                    The login name  [<?php echo $user_name; ?>] type [<?php echo $user_type_text; ?>] the id is <?php echo $user_id; ?>
            </h1>
                <p class="pt-3">&nbsp;</p>
                <div class="cat_list">
                    
                </div>
                <div class="cat_pagin">
                    
                </div>
            </div>
        </div>
    </div>

    <!-- modal form start -->
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Create New Category</h1>
                </div>
                <div class="modal-body">
<?php
    $frm = "admin/category/_frm_cat";
    $this->load->view($frm);
?> 
                    <p class="pt-4">&nbsp;</p>
                    <div class="modal_status">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button class="btn btn-primary btnSave" type="submit" form="frmCat">Save</button>
                        <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <!-- mpdal form End -->

</section>
<script charset="utf-8">
$(function(){
    const $P = $("#category");
    const $page_status = $(".status");
    const $cat = (function(){


        //--- the hidden sess
        let my_id = "<?php echo $user_id; ?>";

        //-- link and place label
        let lnCreate = getEl(".lnCreate");
        let $numAll = getEl(".numAll");
        let $numPub = getEl(".numPub");
        let $cat_list = getEl(".cat_list");
        let $cat_pagin = getEl(".cat_pagin");

        //--- the modal form
        let $md = getEl(".md");
        let $mdTitle = getEl(".modal-title");
        let btnSave = getEl(".btnSave");
        let $modal_status = getEl(".modal_status");

        //------ the form
        let $frm = getEl("#frmCat");
        let c_id = getEl(".cat_id");
        let c_uri = getEl(".cat_uri");
        let c_title = getEl(".cat_title");
        let c_section = getEl(".cat_section");
        let c_sum = getEl(".cat_sum");

        //--- the checkbox
        let c_change = getEl(".allow_change");
        let c_show = getEl(".allow_show");
        let c_pub = getEl(".is_pub");


        //---   showLabel
        function showLabel(){
            let url = "<?php echo site_url("category/adminList"); ?>";
            $.ajax({
            url : url,
                success : (e)=>{
                    let rs = $.parseJSON(e);
                    let pub = 0;
                    $numAll.html(rs.get.length); 
                    $.each(rs.get,(i,v)=>{
                    if(parseInt(v.cat_show_public) !== 0){
                        pub++;
                    }
                    $numPub.html(pub);

                    });
            }
            });
        }
        //---   catList
        function catList(page=1){
            $cat_list.html("");
            $cat_pagin.hide();
            let url = "<?php echo site_url("category/adminList/"); ?>"+page;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                $.each(rs.get_cat,(i,v)=>{
                    let yes = `<span class="badge badge-success">Yes</span>`;
                    let no = `<span class="badge badge-danger">No</span>`;
                    let pub = yes;
                    let allow = yes;
                    let ad_allow = yes;
                    if(parseInt(v.cat_show_public) === 0){
                        pub = no;
                    }

                    if(parseInt(v.admin_allow_show) === 0){
                        ad_allow = no;
                    }
                    if(parseInt(v.allow_user_change) === 0){
                        allow = no;
                    }


                    let tmp = `<div class="card">
    <div class="card-header">
        <h1 class="text-center">${v.cat_title}</h1>
    </div>
    <div class="card-body">
        <p>Section : ${v.cat_section}</p>
       ${v.cat_des} 
       <p class="pt-3">&nbsp;</p>
       <div class="table-responsive">
           <table class="table table-striped table-bordered">
               
            <tr>
                <th>By</th>
                <td>${v.name}</td>
            </tr>
            <tr>
                <th>User Can Change</th>
                <td>${allow}</td>
            </tr>
            <tr>
                <th>Allow to show</th>
                <td>${ad_allow}</td>
            </tr>
            <tr>
                <th>Public</th>
                <td>${pub}</td>
            </tr>



            <tr>
                <th>Date</th>
                <td>
                    <p>Create : ${v.cat_date_create}</p>
                    <p>update : ${v.cat_date_update}</p>
                </td>
            </tr>

           </table>
       </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-cat_id="${v.cat_id}">Edit</button>
            <button class="btn btn-danger lnDel" data-cat_id="${v.cat_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`;
                    $cat_list.append(tmp);
                });
                if(rs.pagination){
                    $cat_pagin.html(rs.pagination).show();
                }
            }
            }); 
        }
        //------------------------
        function showForm(cmd,id){
            $mdTitle.html("Create New Category");
            $frm.trigger("reset");
            switch(cmd){
            case"edit":
                //alert("will edit "+id);
                let url = "<?php echo site_url("category/adminEdit/"); ?>"+id;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        //console.log(rs);
                        $.each(rs.get,(i,v)=>{
                        
                        if(parseInt(v.allow_user_change) !== 0){
                            c_change.prop("checked",true);
                        }

                        if(parseInt(v.cat_show_public) !== 0){
                            c_pub.prop("checked",true);
                        }
                        if(parseInt(v.admin_allow_show) !== 0){
                            c_show.prop("checked",true);
                        }

                            c_id.val(v.cat_id);
                            c_title.val(v.cat_title);
                            c_uri.val(v.cat_uri);
                            c_section.val(v.cat_section);
                            c_sum.val(v.cat_des);
                            $mdTitle.html(`Editing...${v.cat_title}`);
                            let ms = `<span class="alert alert-warning float-right">
    you are editing ${v.cat_title} from ${v.name}                               
</span>`;
                            $modal_status.html(ms).show();
                        });
                }
                });
            break;
            default:
                    $modal_status.html("");
                    c_id.val(0);
                    c_title.attr("placeholder","Enter the title");
            break;
            }
            $($md).modal("show");
        }
        //----------------
        //---   catSave
        function catSave(){
            btnSave.unbind();
            $frm.submit(function(e){
                e.preventDefault();
                //alert(`my id is ${my_id}`);
                let url = $(this).attr("action");
                let data = $(this).serialize()+"&action_code="+my_id;
                $.post(url,data,function(e){
                    let rs =$.parseJSON(e);
                    //console.log(rs);
                    $modal_status.html(rs.msg).show;
                    setTimeout(()=>{
                        getSummary();
                        showForm("edit",rs.cat_id);
                    },450);
                });
            });
        }
        //---------------------------
        //---   catDel
        function catDel(id){
            //alert("will delete "+id);
            let url = "<?php echo site_url("category/adminDel") ?>";
            let data = {
                id : id,
                action_code : my_id
            };
            $.ajax({
                type : "post",
                data :data,
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    $page_status.html(rs.msg).show();
                    setTimeout(()=>{
                        getSummary();
                        $page_status.html("loading...").fadeOut("slow");
                    },450);
            }
            });
        }
        //---   getSummary
        function getSummary(){
            catList();
            showLabel(); 
        }

        function getEl(el){
            return $P.find(el);
        }

        function getEvent(){
            lnCreate.on("click",function(){
                showForm();
            });

            //-- edit
            $cat_list.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-cat_id");
                showForm("edit",id);
            });

            //-- delete
            $cat_list.delegate(".lnDel","click",function(){
                let id = $(this).attr("data-cat_id");
                catDel(id);
            });



            //--- on save
            btnSave.on("click",function(){
                catSave();
            });

            //--- pagination
            $cat_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let page = $(this).attr("data-ci-pagination-page");
                catList(page);

            });
           getSummary(); 

        }
        return{getEvent:getEvent}
    })();
    $cat.getEvent();
});
</script>

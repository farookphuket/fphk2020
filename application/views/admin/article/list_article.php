<div class="masthead d-flex">
  <div class="container my-auto">
    <div class="row">
      <div class="col-lg-12 mx-auto">

        <div class="card">
            <div class="card-header">
                <h1 class="text-center">
<?php echo $sysName; ?>
                </h1>
                <div class="float-right">
                    <p>Last update <?php echo $sysDate; ?></p>
                </div>
            </div>
            <div class="card-body">
                    <ul>
                        <li>
                             
                            <p class="alert alert-success">22-Mar-2020 | completly remove tinymce as it not free</p>
                        </li>

                        <li>
                             
                            <p class="alert alert-success">Add "delete" feature for article system 7-Mar-2020 7:55 a.m.</p>
                        </li>

                        <li>
                             
                            <p class="alert alert-success">
                                Add the "Select Template" feature on 2-Mar-2020 6:20 p.m.
                            </p>
                        </li>

                        <li>
                             
                            <p class="alert alert-success">fix the problem add new feature.</p>
                        </li>
                        <li>
                             
                            <p>Add new label to show the status</p>
                        </li>
                        <li>
                             
                            <p>replace the default php with using ajax</p>
                        </li>
                        <li>
                                 
                            <p>Replace the var with const and let on 9-Jan-2019</p>
                        </li>
    

                    </ul>                


            </div>
        </div>


      </div>
    </div>
  </div>
</div>
<div class="col-lg-12">
    <p class="pt-4">&nbsp;</p>
</div>
<section id="man_article">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-right">
                    <button class="btn btn-primary lnCreate">Create</button>
                </div>
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">All Post
                  &nbsp;
                  <span class="badge badge-success numAllPost">0
                  </span>
                </h1>
                <hr class="my-4" />
            </div>
            <p>&nbsp;</p>
            <div class="col-md-3">
              <div class="alert alert-info">
                <h1 style="text-align:right;" class="numAllPost">0</h1>

              </div>
              <p style="text-align:right;">
                All post
              </p>
            </div>
            <div class="col-md-4">
              <div class="alert alert-info">
                <h1 style="text-align:right;" class="numNotApprovePost">0</h1>
              </div>
              <p style="text-align:right;">
                Not Approve
              </p>
            </div>
            <div class="col-md-4">
              <div class="alert alert-info">
                <h1 style="text-align:right;color:red;" class="numApprovePost">0</h1>
              </div>
              <p style="text-align:right;">
                Approve
              </p>
            </div>
            <div class="col-md-3">
              <div class="alert alert-info">
                <h1 style="text-align:right;" class="numPublicPost">0</h1>
              </div>
              <p style="text-align:right;color:green;">
                Public Post
              </p>
            </div>
            <div class="col-md-3">
              <div class="alert alert-info">
                <h1 style="text-align:right;" class="numPrivatePost">0</h1>
              </div>
              <p style="text-align:right;">
                Private Post
              </p>
            </div>
            <div class="col-md-3">
              <div class="alert alert-warning">
                <h1 style="text-align:right;" class="numIndexPost">0</h1>
              </div>
              <p style="text-align:right;">
                Index Post
              </p>
            </div>
            <div class="col-md-2">
              <div class="alert alert-info">
                <h1 style="text-align:right;color:green;" class="numMyPost">0</h1>
              </div>
              <p style="text-align:right">
              me <?php echo $user_name; ?> id <?php echo $user_id; ?>
              </p>
            </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
              <div class="ar_list">

              </div>
              <div class="ar_pagin">

              </div>
            </div>

        </div>

    </div>





    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Create new post</h1>
                    <button class="close" data-dismiss="modal">&times;
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $fr = "admin/article/_form_ar.php";
                    $this->load->view($fr);
                    ?>
                </div>
                <div class="modal-footer">
                <button class="btn btn-primary btnSave" type="submit" form="arForm">
                Save
                </button>
                <button class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</section>
<script>

$(function(){

    const $P = $("#man_article");
    const $page_status = $(".status");
    const $modal_status = $(".modal_status");

    const $ar = (function(){

        let $numAllPost = getEl(".numAllPost");
        let $numNotApprovePost = getEl(".numNotApprovePost");
        let $numApprovePost = getEl(".numApprovePost");
        let $numPublicPost = getEl(".numPublicPost");
        let $numPrivatePost = getEl(".numPrivatePost");
        let $numIndexPost = getEl(".numIndexPost");
        let $numMyPost = getEl(".numMyPost");
        
        let $ar_list = getEl(".ar_list");
        let $ar_pagin = getEl(".ar_pagin");

        let my_name = "<?php echo $user_name; ?>";
        //--- the link
        let lnCreate = getEl(".lnCreate");
        //---the modal
        let $md = getEl(".md");
        let $mdTitle = getEl(".modal-title");

        //--- The form
        let $frm = getEl("#arForm");

        //--- the hidden field
        let ar_id = getEl(".ar_id");
        let ar_user_id = getEl(".ar_user_id");
        let my_id = "<?php echo $user_id; ?>";
        let kw_id = getEl(".kw_id");

        //--- the meta tag
        let og_url = getEl(".og_url");
        let keyword = getEl(".keyword");
        let keydes = getEl(".keydes");

        //--- the post field
        let ar_title = getEl(".ar_title");
        let ar_sum = getEl(".ar_sum");
        let jdt1 = new Jodit(".ar_sum",{placeholder:'the article summary'});
        let jdt2 = new Jodit(".ar_body",{"height": 550});
        let ar_body = getEl(".ar_body");
        let is_pub = getEl(".is_pub");
        let is_approve = getEl(".is_approve");
        let is_index = getEl(".is_index");

        let set_cat = getEl(".set_cat");
        let set_tmp = getEl(".set_tmp");


        let btnSave = getEl(".btnSave");

        /*
            * Start using cookie to prevent page reload
            *
            *
         */
        let cookie_page = Cookies.get("cookie_page");
        parseInt(cookie_page);
        if(cookie_page === 0){
            cookie_page = 1;
        }
        
        function labelShowPost(){
            /*
                * only show the number of post in the label above the post list
                *
                * 10 Jan 2020
             */
            let url = "<?php echo site_url("article/adminGet"); ?>";
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                let all = rs.get_all.length;
                let mypost = 0;
                let ap = 0;
                let not_ap = 0;//--not approve
                let a_pub = 0;
                let a_pri = 0; 
                let in_post = 0;
                $numAllPost.html(all);
                $.each(rs.get_all,(i,v)=>{
                if(parseInt(v.ar_is_approve) !== 0){
                    ap++;
                }else{
                    not_ap++;
                }

                if(parseInt(v.ar_show_public)!== 0){
                    a_pub++;
                }else{
                    a_pri++;
                }
                if(parseInt(v.ar_show_index) !== 0){
               in_post++; 
                }
                if(v.ar_user_id === my_id){
                    mypost++;
                }

                $numApprovePost.html(ap);
                $numNotApprovePost.html(not_ap);
                $numPublicPost.html(a_pub);
                $numPrivatePost.html(a_pri);
                $numIndexPost.html(in_post);
                $numMyPost.html(mypost);
                });
            }
            });
        }
        //--------------------
        //--    setCategory
        function setCategory(){
            set_tmp.html("-- SELECT --");
            let choice = $('.set_cat option:selected').val();
            //console.log(`the choice is ${choice}`);
            let url = "<?php echo site_url("template/tmpGetByCategory/"); ?>"+choice;

            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                console.log(rs);
                $.each(rs.get,(i,v)=>{

                    let tmp = `<option value="${v.tmp_id}">${v.tmp_title} -> ${v.tmp_des}</option>`;
                    set_tmp.append(tmp);
                });
            }
            });

        }
        //--    showPostList
        function showPostList(cookie_page=1){
            $ar_list.html("");
            let url = "<?php echo site_url("article/adminGet/") ?>"+cookie_page;
            
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                if(rs.pagination){
                    $ar_pagin.html(rs.pagination);
                }
                $.each(rs.get_ar,(i,v)=>{

                let indexLabel = `<span class="badge badge-danger">No</span>`;
                let approveLabel = `<span class="badge badge-danger">No</span>`;
                let publicLabel = `<span class="badge badge-danger">No</span>`;

                
                if(parseInt(v.ar_is_approve) !== 0){
                    
                    approveLabel = `<span class="badge badge-success">Yes</span>`;
                }


                if(parseInt(v.ar_show_public) !== 0){
                    
                    publicLabel = `<span class="badge badge-success">Yes</span>`;
                }

                if(parseInt(v.ar_show_index) !== 0){
                    
                    indexLabel = `<span class="badge badge-success">Yes</span>`;
                }



                    

                let tmp = `<div class="card">
                    <div class="card-header bg-primary">
                    <h1 class="text-white">${v.ar_title}</h1>               
                    </div>
                    <div class="card-body">
                    ${v.ar_summary}
                    <p class="pt-2">&nbsp;</p>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>Post By</th>
                                <td>${v.ar_post_by}</td>
                            </tr>                
                            <tr>
                                <th>Post IP</th>
                                <td>${v.ar_post_ip}</td>
                            </tr>
                            <tr>
                                <th>Post date</th>
                                <td>
                                Create : ${v.date_add}
                                Update : ${v.date_edit}
                                
                                </td>
                            </tr>                
                            <tr>
                                <th>Post Status</th>
                                <td>
                                Index : ${indexLabel} &nbsp;
                                Approve : ${approveLabel}&nbsp; 
                                Public : ${publicLabel} 
                                </td>
                            </tr>
                        </table>                     
                    </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a class="btn btn-primary lnEdit" style="color:white;" data-ar_id="${v.ar_id}">View & Edit</a>                         
                            <a class="btn btn-danger lnDel" style="color:white;" data-ar_id="${v.ar_id}">Delete</a> 
                        </div>
                    </div>
                    </div><p class="pt-2">&nbsp;</p>`; 
                    $ar_list.append(tmp);
                });
            }
            }); 
        }
        //----------------------
        //---   setTemplate
        function setTemplate(){
            if(parseInt(ar_id.val()) === 0){
                //alert("this can set the template");
                let url = "<?php echo site_url("template/adminEdit/");  ?>"+set_tmp.val();

                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get,(i,v)=>{
                        ar_title.val(v.tmp_title);

                        /*
                        tinymce.get("ar_sum").setContent(v.tmp_des);
                        tinymce.get("ar_body").setContent(v.tmp_body);
                        */
                        jdt1.value = v.tmp_des;
                        jdt2.value = v.tmp_body;

                    });
                    
                }
                });

            }
            
            

        }
        //-------------------
        function showForm(cmd,id){
            $modal_status.html("");
            $frm.trigger("reset");

            switch(cmd){
            case"edit":
                let url = "<?php echo site_url("article/adminEdit/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    //console.log(e);
                    let rs = $.parseJSON(e);
                    $.each(rs.get_ar,(i,v)=>{
                      // console.log(v); 

                       //-- checkbox is public
                       if(parseInt(v.ar_show_public) !== 0){
                            is_pub.prop("checked",true);
                       }
                       //---checkbox approve
                       if(parseInt(v.ar_is_approve) !== 0){
                            is_approve.prop("checked",true);
                       }

                       //-- checkbox showIndex
                       if(parseInt(v.ar_show_index) !== 0){
                            is_index.prop("checked",true);
                       }
                        let warn_msg = `<span class="badge badge-warning">This post is from ${v.ar_post_by}</span>`;
                       if(v.ar_user_id === my_id){
                            warn_msg = `<span class="badge badge-success">This post is from you.</span>`;

                       }

                       let msg_to_show = `<div class="row">
                           <div class="col-md-6">
                                ${warn_msg}
                                </div>
                            <div class="col-md-6">
                                <span class="badge badge-warning">Editing ${v.ar_title}...</span>
                            </div>
                           </div>`;
                       ar_user_id.val(v.ar_user_id);
                        $mdTitle.html(`editing ${v.ar_title}...`);

                    jdt1.value = v.ar_summary;
                    jdt2.value  = v.ar_body;
                        /*
                        tinymce.get("ar_sum").setContent(v.ar_summary);
                        tinymce.get("ar_body").setContent(v.ar_body);
                    */


                        ar_id.val(v.ar_id);
                        ar_user_id.val(v.ar_user_id);
                        kw_id.val(v.kw_id);

                        set_tmp.prop("disabled",true);
                        set_cat.val(v.cat_id);
                        ar_title.val(v.ar_title);
                        og_url.val(v.og_url);
                        keyword.val(v.kw_page_keyword);
                        keydes.val(v.kw_page_des);
                        $modal_status.append(msg_to_show);
                    });
                }
                });
                break;
            default:
                
                setTimeout(()=>{
                        $mdTitle.html(`Dear ${my_name} you will creating "NEW POST" now.`);
                        ar_title.attr("placeholder",`Add new article by ${my_name}`);
                        set_cat.focus();
                        ar_id.val(0);
                        set_tmp.prop("disabled",false);

                },1200);
                break;
            }

            $($md).modal("show");
        }
        //----------------
        //---   saveAr
        function savePost(){
            btnSave.unbind();
            $frm.submit(function(e){
                e.preventDefault();
                let url = $(this).attr("action");
                let data = $(this).serialize();
                $.post(url,data,function(e){
                    let rs = $.parseJSON(e);
                    $modal_status.html(rs.msg).show();
                    setTimeout(()=>{
                        showForm("edit",rs.ar_id);
                        getSummary();
                    },2000);

                });
            });
        }
        //---   arDel
        function arDel(id){

            let url = "<?php echo site_url("article/adminDel/"); ?>"+id;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                $page_status.html(rs.msg).show();
                setTimeout(()=>{
                    $page_status.html("loading...").fadeOut("slow");
                    getSummary();
                },2000);
            }
            });
            
        }
        //---   getSummary
        function getSummary(){
            $page_status.html("Loading...").show();


            

            setTimeout(()=>{
                $page_status.html("done! page loaded.").fadeOut("slow");
                labelShowPost();
                showPostList(cookie_page);

            },400);

        }
        //---   getEl
        function getEl(el){
            return $P.find(el);
        }
        function getEvent(){

            //--- first load
            getSummary();

            //-- show form to create
            lnCreate.on("click",function(){
                showForm();
            });

            //--- Edit 
            $ar_list.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-ar_id");
                showForm("edit",id);
            });
            //---------------
            //--- Delete
            $ar_list.delegate(".lnDel","click",function(){
                let id = $(this).attr("data-ar_id");
                arDel(id);
            });

            //---- pagination
            $ar_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let go_page = $(this).attr("data-ci-pagination-page");
                page = go_page;
                Cookies.set("cookie_page",go_page);
                showPostList(page);
                //alert(`go to page ${go_page}`);
            });
            //--- on save
            btnSave.on("click",function(){
                savePost();
            });
            //----------
            //---   The user did not select category
            set_cat.on("change",function(){
               setCategory(); 

            });

            //---   set template
            set_tmp.on("change",function(){
                setTemplate();
            });
        }
        return{getEvent:getEvent}
    })();
    $ar.getEvent();
});


    /*
        *   Last edit on 19-Feb-2020
        *   Remove all unuse code below
        *
     */


</script>

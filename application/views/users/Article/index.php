<section id="article">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="float-right">
                    <a href="#" class="btn btn-primary lnAdd" style="color:white;">New Post</a>
                    <p class="pt-2">&nbsp;</p>
                </div>

                <h1 class="text-center">All my post
                    <span class="badge badge-success numPost">0</span> item(s).
</h1>
                
                <p class="">All post will be shown here</p>
                <p class="pt-3">&nbsp;</p>
                <div class="post_list">
                    
                </div>
                <div class="post_pagin">
                    
                </div>
            </div>
            <div class="pt-4">
               &nbsp; 
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">Public Post
                    <span class="badge badge-success numPub">0</span> item(s).
                </h1>
                <p class="pt-2">&nbsp;</p>
                <div class="pub_ls">
                    
                </div>
                <div class="pub_pagin">
                    
                </div>
                <p class="pt-4">&nbsp;</p>
            </div>
        </div>
    </div>
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Title</h1>
                    <button class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-body">
<?php
    $fr = "users/Article/_my_form";
    $this->load->view($fr);
?> 
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                       <button type="submit" form="myPost" class="btn btn-primary btnSave">Save</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script charset="utf-8">
$(function(){
    //-- last modified 7-Jan-2020
    const $AR = $("#article");
    const $page_status = $(".status");
    const $ar = (function(){

        const $my_post_list = getEl(".post_list");
        const $my_post_pagin = getEl(".post_pagin");
        const $my_post_num = getEl(".numPost");
        const $pub_list = getEl(".pub_ls");
        const $pub_pagin = getEl(".pub_pagin");
        const $pub_num = getEl(".numPub");


        //--- the modal
        let $md = getEl(".md");
        let $mdTitle = getEl(".modal-title");
        let lnAdd = getEl(".lnAdd");

        //--- The form
        let $frm = getEl("#myPost");
        let ar_title = getEl(".ar_title"); 
        let cat_id = getEl(".cat_id"); 
        let ar_id = getEl(".ar_id");
        let kw_id = getEl(".kw_id"); 
        let og_url = getEl(".og_url");
        let keyword = getEl(".keyword");
        let keydes = getEl(".keydes");
        let ar_sum = getEl(".ar_summary"); 
        let ar_body = getEl(".ar_body"); 
        let ar_show_pub = getEl(".is_pub");
        let $modal_status = getEl(".modal_status"); 
        let btnSave = getEl(".btnSave");



        //--- getPubPostList 
        function getPubPostList(page=1){
            $pub_list.html("");
            let url = "<?php echo site_url("article/uListPubPost/"); ?>"+page;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                console.log(rs);
                let pub_all = rs.get_all.length;
                $pub_num.html(pub_all);
                $.each(rs.get_pub,(i,v)=>{
                let readUrl = "<?php echo site_url("article/read/"); ?>"+v.uniq_id;
                let tmp = `<div class="card">
    <div class="card-header bg-info">
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
             <th>IP</th>
             <td>${v.ar_post_ip}</td>
         </tr>
            .
     </table>   
    </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <a href="${readUrl}" class="btn btn-primary lnRead" style="color:white" data-uniq_id="${v.uniq_id}" target="_blank">View</a>
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`; 
                $pub_list.append(tmp);
                });

                if(rs.pagination){
                    $pub_pagin.html(rs.pagination);
                }

            }
            });
        }

        //---getMyPostList
        function getMyPostList(page=1){

            $my_post_list.html("");
            let all_my = 0;
            let url = "<?php echo site_url("article/uList/"); ?>"+page;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                all_my = rs.get_all.length;
                $my_post_num.html(all_my);
                if(parseInt(all_my) !== 0){
                    $.each(rs.get_my,(i,v)=>{
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
                                        <th>Post date</th>
                                        <td>created ${v.date_add} update : ${v.date_edit}</td>
                                    </tr>
                                    <tr>
                                        <th>IP</th>
                                        <td>${v.ar_post_ip}</td>
                                    </tr>
                                    <tr>
                                        <th>has read</th>
                                        <td>${v.ar_read_count}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="float-right">
                                
                                <a href="#" class="btn btn-info lnRead" style="color:white;" data-ar_id="${v.ar_id}">View</a>
                                <a href="#" class="btn btn-primary lnEdit" style="color:white;" data-ar_id="${v.ar_id}">Edit</a>
                                <a href="#" class="btn btn-danger lnDel" style="color:white;" data-ar_id="${v.ar_id}">Delete</a>
                            </div>
                        </div>
                        </div>
                        <p class="pt-2">&nbsp;</p>`;
                    $my_post_list.append(tmp);
                });
                }

            }
            });
        }
        //----------------
        //----- viewMyPost
        function viewMyPost(id){
            let url = "<?php echo site_url("article/uViewPost/"); ?>"+id;
            window.open(url,"_blank");
        }
        //----- arFormShow
        function arFormShow(cmd,id){
            //let a_sum = `the summary fun fun`; 
            let m_status = `<span class="badge badge-warning">Creating new post</span>`; 
                //tinymce.get("ar_summary").setContent(a_sum);
            switch(cmd){
            case"edit":
                let url = "<?php echo site_url("article/uEditPost/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    //console.log(e);
                    let rs = $.parseJSON(e);
                    $.each(rs.get,(i,v)=>{
                                
                    let allowShow = "";
                    if(parseInt(v.ar_is_approve) === 0){
                        allowShow = `<span class="badge badge-danger">Your post is not approve yet! your post will not be shown in anywhere public unless it item has been approve by moderator</span>`;
                    } 
                    if(parseInt(v.ar_show_public) !== 0){
                        ar_show_pub.prop("checked",true);
                    }
                        m_status = `${allowShow}<span class="badge badge-warning">Updating ${v.ar_title}...click "Save" button when you done.</span>`; 
                        ar_id.val(v.ar_id);
                        kw_id.val(v.kw_id);
                        ar_title.val(v.ar_title);
                        og_url.val(v.og_url);
                        keyword.val(v.kw_page_keyword);
                        keydes.val(v.kw_page_des);
                        tinymce.get("ar_summary").setContent(v.ar_summary);
                        tinymce.get("ar_body").setContent(v.ar_body);
                        
                        $mdTitle.html(`Editing ${v.ar_title}...`);
                        $modal_status.html(m_status).show();         

                    });
                }
                });
                break;
            default:
                $frm.trigger("reset");
                og_url.attr("placeholder","Your share URL will be appear once you have press Save button");
                keyword.attr("placeholder","Your keyword eg:programming,book,love,living");
                keydes.attr("placeholder","Description about your keyword");
                ar_title.attr("placeholder","Enter Title");
                $mdTitle.html("Create new post");
                $modal_status.html("waiting...").show(); 
                   setTimeout(()=>{
                   ar_title.focus();
                   },2000);


                break;
            }

            $($md).modal("show");
        }


        //----saveMyPost
        function saveMyPost(){
            btnSave.unbind();
            $frm.submit(function(e){
                e.preventDefault();
                let url = $(this).attr("action");
                let data = $(this).serialize();
                $.post(url,data,function(e){
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $modal_status.html(rs.msg).show();
                    setTimeout(()=>{
                        getSummary();
                      arFormShow("edit",rs.ar_id);  
                    },500);
                });
            });
        }
        //---------------
        //--    delMyPost
        function delMyPost(id){
            let url = "<?php echo site_url("article/uDelPost/"); ?>"+id;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                $page_status.html(rs.msg).show();
                setTimeout(()=>{
                    $page_status.html("Loading...").fadeOut("slow");
                    getSummary();
                },2000);
            }
            });
        }
        //-- getSummary
        function getSummary(){
            getMyPostList();
            getPubPostList();
        }
        //---------
        function getEl(el){
            return $AR.find(el);
        }
        function getEvent(){
            getSummary();

            lnAdd.on("click",function(){
                arFormShow();
            });
            btnSave.on("click",function(){
                saveMyPost();
            });

            //---View my post
            $my_post_list.delegate(".lnRead","click",function(){
                let id = $(this).attr("data-ar_id");
                viewMyPost(id);
            });

            //---edit my post
            $my_post_list.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-ar_id");
                arFormShow("edit",id);
            });

            //---edit my post
            $my_post_list.delegate(".lnDel","click",function(){
                let id = $(this).attr("data-ar_id");
                delMyPost(id);
            });

            //---pub list
            $pub_pagin.delegate("a","click",function(e){
                e.preventDefault();
                let page = $(this).attr("data-ci-pagination-page");
                getPubPostList(page);
            });

        }
        return{getEvent:getEvent}
    })();
    $ar.getEvent();

});//-- End of jQuery
</script>

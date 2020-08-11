<section id="comment">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">
                    <?php echo"{$sysName} version {$sysVersion}"; ?>
                </h1>
                <p class="text-right">
                    Sytem Date <?php echo $sysDate; ?>
                </p>
                
            </div>

            <div class="col-lg-12">
                <p class="pt-5">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">
                    All Comment
                    <span class="badge badge-info numComment">
                    0
                    </span> item(s).
                </h1>
                <p>The last update on 3-Feb-2020</p>
                 <p class="pt-4">&nbsp;</p>
                <div class="ls_comment">

                </div>
                <div class="pg_comment">
                    
                </div>
            </div>
            
        </div>
    </div>


    <!-- the modal form -->
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h1 class="modal-title">Title</h1>
                </div>
                <!-- body -->
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="org_comment">
                                    
                                </div>
                                <p class="pt-4">&nbsp;</p>
<?php
    $frm = "admin/comment/_frm_reply";
    $this->load->view($frm);
?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End body -->
                <div class="modal-footer">
                    <div class="float-right">
                       <button class="btn btn-primary btnSave" type="submit" form="frmComment">Save</button> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of modal form -->
</section>
<script charset="utf-8">
$(function(){

        const $P = $("#comment");
        const $page_status = $(".status");
        const $cm = (function(){

            let $c_list = getEl(".ls_comment");
            let $c_pagin = getEl(".pg_comment");
            let $numComment = getEl(".numComment");


            let reply_by = "<?php echo $user_name ?>";

            let reply_date = "";
            let is_save = 1;
            //--    the modal 
            let $md = getEl(".md");
            let $org_comment = getEl(".org_comment");
            let $mdTitle = getEl(".modal-title");
            let btnSave = getEl(".btnSave");

            //--- the form
            let action_code = "";
            let $frm = getEl("#frmComment");
            let c_id = getEl(".c_id");
            let c_title = getEl(".c_title");
            let c_body = getEl(".c_body");
            let c_is_show = getEl(".c_is_show");

            function getCommentList(page=1){
                $c_list.html("");
                let url = "<?php echo site_url("comment/adminGetAllComment/"); ?>"+page;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    $numComment.html(rs.num_comment);
                    $.each(rs.get_comment,(i,v)=>{

                    let yes = `<span class="badge badge-success">Yes</span>`;
                    let no = `<span class="badge badge-danger">No</span>`;
                    let c_is_show = no;
                    if(parseInt(v.c_show) !== 0){
                        c_is_show = yes;
                    }

                    let tmp = `<div class="card">
    <div class="card-header bg-info">
        <h1 class="text-white">${v.c_comment_title}</h1>
    </div>
    <div class="card-body">
       ${v.c_comment_body} 
       <p class="pt-2">&nbsp;</p>
       <div class="table-responsive">
           <table class="table table-bordered">
               <tr>
                   <th>BY</th>
                   <td>${v.c_user_name}</td>
               </tr>
                <tr>
                   <th>Show on page</th>
                   <td>${c_is_show}</td>
               </tr>
                <tr>
                   <th>Section</th>
                   <td>
                    <p>
                        ${v.c_section_name}
                    </p> 
                   </td>
               </tr>
                <tr>
                    <th>Date</th>
                    <td>${v.c_date_create}</td>
                </tr>
           </table>
       </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
           <a class="btn btn-primary lnEdit" style="color:white;" data-c_id="${v.c_id}">Edit</a> 
            
           <a class="btn btn-danger lnDel" style="color:white;" data-c_id="${v.c_id}">Delete</a> 
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`;
                        $c_list.append(tmp);
                    });
                    if(rs.pagination){
                        $c_pagin.html(rs.pagination);
                    }
                }
                });
            }
            //---------------------
            //---   setReplyDate
            function setReplyDate(){
                return reply_date = new Date().toLocaleString();                

            }
            //--    commentEdit
            function commentEdit(id){
                //-- reset the last load in form
                $mdTitle.html("will show replying to name");
                $frm.trigger("reset");

                let url = "<?php echo site_url("comment/adminEdit/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    $.each(rs.get_comment,(i,v)=>{
                    action_code = v.c_user_uniq;
                    is_save = 0;
                    setReplyDate();
                    if(parseInt(v.c_show) !== 0){
                        c_is_show.prop("checked",true);
                    }
                    let org_tmp = `<div class="card">
    <div class="card-header">
        <h1>${v.c_comment_title}</h1>
    </div>
    <div class="card-body">
        ${v.c_comment_body}
    </div>
</div>`;
                    let reply_tmp = `${v.c_comment_body}<p class="pt-4">&nbsp;</p>
<hr class="my-4" />
<div class="card">
    <div class="card-header">
        <h1 class="text-center">
            Reply to ${v.c_user_name} by ${reply_by} 
        </h1>
    </div>
    <div class="card-body">
        <p>Your reply message</p>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <p>reply by : ${reply_by}  | reply date ${reply_date}</p>
        </div>
    </div>
</div>`;
                        c_id.val(v.c_id);
                        c_title.val(v.c_comment_title);
                        tinymce.get("c_body").setContent(reply_tmp);
                        $org_comment.html(org_tmp);    
                        $mdTitle.html(`Replying to...${v.c_user_name}`);
                        $($md).modal("show");
                    });
                }
                });
            }
            //-------------------
            //---   commentSave
            function commentSave(){
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize()+"&action_code="+action_code;
                    $.post(url,data,function(e){
                        let rs = $.parseJSON(e);
                        alert(rs.msg);
                        setTimeout(()=>{
                            getSummary();
                            commentEdit(rs.c_id);
                            
                        },2000);
                        
                        is_save = 1;
                    });
                });
            }
            //-----------------
            //--    commentDel
            function commentDel(id){
                let url = "<?php echo site_url("comment/adminDel/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    alert(rs.msg);
                    setTimeout(()=>{
                        getSummary();
                    },2000);
                }
                });
            }
            //--------------------------
            function getSummary(){
                getCommentList();
                 
            }
            function getEl(el){
                return $P.find(el);
            }
            function getEvent(){
                getSummary();
                //--- edit item
                $c_list.delegate(".lnEdit","click",function(){

                    let id = $(this).attr("data-c_id");
                    commentEdit(id);
                });
                //--- delete item
                $c_list.delegate(".lnDel","click",function(){
                    let id = $(this).attr("data-c_id");
                    commentDel(id);
                });

                $c_pagin.delegate(".pagination a","click",function(e){
                    e.preventDefault();
                    let page = $(this).attr("data-ci-pagination-page");
                    getCommentList(page);
                });


                btnSave.on("click",function(){
                    commentSave();
                });

            }
            return{getEvent : getEvent}
        })();
        $cm.getEvent();
});
</script>

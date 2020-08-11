<!--Last edit Wed 10 July 2019 -->
<section id="comment">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center"><?php echo $sysName." ".$sysVersion;?>&nbsp;
                    <span class="badge badge-success numAllComment">0</span>&nbsp;item(s).

                </h1>
                <hr class="my-4">
                <p>&nbsp;</p>
            </div>
            <div class="col-lg-3">
                <div class="alert alert-info">
                    <h1 class="numAllComment" style="text-align:right">0</h1>

                </div>
                <div>
                    <span class="float-right">
                        <a href="" class="btn btn-primary btn-sm lnShowAll">See Detail</a>
                    </span>
                    <p>All comment</p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="alert alert-success">
                    <h1 class="numShowComment" style="text-align:right">0</h1>

                </div>
                <p>Show public comment</p>
            </div>
            <div class="col-lg-3">
                <div class="alert alert-danger">
                    <h1 class="numNoShowComment" style="text-align:right">0</h1>

                </div>
                <p>NOT Show to public comment</p>
            </div>

            <!--tab start-->
            <div class="col-lg-12">
                <p>&nbsp;</p>
                <div class="show_comment">

                </div>
                <div class="comment_pagin">

                </div>
            </div>

            <!--end tab-->
        </div>
    </div>
    <!--Modal form-->
    <div class="modal fade mdEditComment" id="adminEdit">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    <h1 class="modal-title mdTitle">Edit Comment</h1>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!--form start-->
                    <?php
                        $f = "comment/_admin_frmComment";
                        $this->load->view($f);
                    ?>
                    <!--form End-->
                </div>
                <div class="modal-footer">
                    <div class="modal_status"></div>
                    <button class="btn btn-primary btnSaveComment" type="submit" form="frmComment">Save</button>
                </div>
            </div>
        </div>
    </div>
    <!--End of Modal Form-->
</section>
<script>
    $(function(){
        var $c = $("#comment");
        var $page_status = $(".status");

        //---comment admin JS
        var comment = (function(){
            var $numAllComment = $c.find(".numAllComment");
            var $numShowComment = $c.find(".numShowComment");
            var $numNoShowComment = $c.find(".numNoShowComment");

            var $show_comment = $c.find(".show_comment");
            var comment_pagin = $c.find(".comment_pagin");
            var noShow = 0;
            var show = 0;

            var set_to_show = 1;

            //---modal
            var mdEdit = $c.find("#adminEdit");
            var mdTitle = $c.find(".mdTitle");

            //---form comment
            var $f = $c.find("#frmComment");
            var c_id = $c.find(".c_id");
            var c_title = $c.find(".c_title");
            var c_body = $c.find(".c_body");
            var c_approve = $c.find(".c_approve");
            var approve_status = $c.find(".show_approve_status");
            var c_show = $c.find(".c_show");
            var btnSave = $c.find(".btnSaveComment");

            function showAllCommentList(page=1){
              $show_comment.html("");
              var url = "<?php echo site_url("comment/adminGetAllComment/");?>"+page;
              $.ajax({
                url : url,
                success : function(e){
                  var rs = $.parseJSON(e);
                  $numAllComment.html(rs.num_comment);

                  $.each(rs.get_comment,function(i,v){
                    if(parseInt(v.c_status) !== 2){
                      noShow++;
                    }else{
                      show++;
                    }

                    var lb_show = `<span class="badge badge-success">
                    Yes
                    </span>`;
                    if(parseInt(v.c_status) !== 2){
                      lb_show = `<span class="badge badge-danger">
                      No
                      </span>`;
                    }
                    var tmp = `
                    <div class="card">
                      <div class="card-header">
                        <span class="float-right">
                          <a class="btn btn-primary btn-sm lnReply" data-c_id="${v.c_id}">Reply</a>
                        </span>
                        <h1 class="text-center">${v.c_comment_title}</h1>

                      </div>
                      <div class="card-body">
                        ${v.c_comment_body}
                      </div>
                      <div class="card-footer">
                        <div class="row">
                          <div class="col-md-3">
                            show : ${lb_show}

                          </div>
                          <div class="col-md-4">
                            Name : ${v.c_user_name}<br />
                            Email : ${v.c_user_email}
                          </div>
                          <div class="col-md-4">
                            Date : ${v.c_date_create} ${v.c_comment_time}<br />
                            IP : ${v.c_user_ip}
                          </div>

                        </div>
                      </div>
                    </div>
                    <p>&nbsp;</p>
                    `;


                    $show_comment.append(tmp);

                  });
                  $numNoShowComment.html(noShow);
                  $numShowComment.html(show);
                  if(parseInt(rs.num_comment) !== 0){
                    comment_pagin.html(rs.pagination);
                  }
                }
              });
            }
            //------------
            //---replyComment 11-july-2019
            function replyComment(id){
              //alert("the id is "+id);
              $f.trigger("reset");
              tinymce.activeEditor.setMode("design");
              var url = "<?php echo site_url("comment/adminEditComment/");?>"+id;
              $.ajax({
                url : url,
                success : function(e){
                  var rs = $.parseJSON(e);
                  console.log(rs);
                  $.each(rs.get_comment,function(i,v){
                    var approve = 0;
                    if(parseInt(v.c_status) === 2){
                      approve = 2;
                      c_approve.prop("checked",true);
                    }
                    c_id.val(v.c_id);
                    mdTitle.html(`Editing ${v.c_comment_title}...`);
                    c_title.val(v.c_comment_title);
                    //c_body.val(v.c_comment_body);
                    tinymce.activeEditor.setContent(v.c_comment_body);

                  });
                  $(mdEdit).modal("show");
                }
              });
            }
            //-------------
            //--- saveComment
            function saveComment(){
              //---create on 11-july-2019
              btnSave.unbind();
              $f.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(o){
                  alert(o);
                });
              });
            }
            //----------------
            //---showApprove
            function showApprove(){
              var ap = 1;
              var st_text = `<div class="alert alert-danger">
              <h1>This Comment status is set to "<i>Wait</i>"</h1>
              </div>`;
              if(c_approve.is(":checked")){
                st_text = `<div class="alert alert-success">
                <h1>This Comment status is set to "<i>Approve</i>"</h1>
                </div>`;
                ap = 2;
              }
              c_approve.val(ap);
              approve_status.html(st_text);
            }

            //----getSummary
            function getSummary(){
              showAllCommentList();
            }
            //-------------

            //-------------
            function getEvent(){

                getSummary();

                //----
                //---list checkbox
                $show_comment.delegate(".lnReply","click",function(){
                  var id = $(this).attr("data-c_id");
                  replyComment(id);
                });
                //----
                //---c_approve
                c_approve.on("change",function(){
                  showApprove();
                });

                btnSave.on("click",function(){
                  saveComment();
                });

            }
            return{getEvent:getEvent}
        })();
        comment.getEvent();
    });
</script>

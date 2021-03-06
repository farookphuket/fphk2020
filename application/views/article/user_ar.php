<section id="my_post">
  <div class="container">
    <div class="row">

      <div class="col-lg-12">
        <div class="float-right">
          <a class="btn btn-primary lnNewPost">New Post</a>
          <p>&nbsp;</p>
        </div>

      </div>

      <div class="col-lg-3">
        <div class="alert alert-success">
          <h1 style="text-align:center;color:green;" class="numAll">0</h1>
        </div>
        <p style="text-align:right;">
          <a style="color:green;font-weight:bold;border:1px dotted #ff0000;" class="lnShowPubPost" href="#pubPost">
            Show Public Post
          </a>
        </p>
      </div>
        <div class="col-lg-3">
          <div class="alert alert-success">
            <h1 style="text-align:center;color:green;" class="numMy">0</h1>
          </div>
          <p>My post</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-warning">
            <h1 style="text-align:center;color:green;" class="numPri">0</h1>
          </div>
          <p>My Private Post</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-warning">
            <h1 style="text-align:center;color:red;" class="numNotApprove">0</h1>
          </div>
          <p>No approve</p>
        </div>

        <hr class="my-4">
        <div class="col-lg-12">
          <p>&nbsp;</p>
        </div>


      <div class="col-lg-12">
        <div class="mypost_list">

        </div>
        <div class="mypost_pagin">

        </div>
      </div>
      <p>&nbsp;</p>
      <div class="col-lg-12">
        <div id="pubPost">
          <div class="pub_list">

          </div>
          <div class="pub_pagin">

          </div>
        </div>
      </div>

    </div>
  </div>
  <div class="modal fade mdAr">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

          <h1 class="modal-title">Create New Post</h1>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <?php
              $f = "article/_u_frm";
              $this->load->view($f);
            ?>
          <div class="modal_status">

          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary btnSave" form="frmAr">Save</button>
          <button class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  /*
  $(function(){
    var $m = $("#my_post");
    var $page_status = $(".status");
    var $modal_status = $m.find(".modal_status");

    var my_post = (function(){
      var lnNewPost = $m.find(".lnNewPost");
      var $numMyPost = $m.find(".numMyPost");
      var $post_list = $m.find(".mypost_list");
      var $post_pagin = $m.find(".mypost_pagin");
      var $modal_status = $m.find(".modal_status");

      var $md = $m.find(".mdAr");
      var $mTitle = $m.find(".mTitle");

      //---form
      var $f = $m.find("#frmAr");
      var og_url = $m.find(".og_url");
      var keyword = $m.find(".keyword");
      var key_des = $m.find(".key_des");
      var key_id = $m.find(".key_id");
      var ar_id = $m.find(".ar_id");
      var ar_title = $m.find(".ar_title");

      //---summary box
      var $tmp_sum = $m.find(".tmp_sum");
      var ar_sum = $m.find(".ar_sum");
      var $sum_result = $m.find(".sum_result");
      //--count the word in summary box
      var $sumWordCount = $m.find(".sumWordCount");
      //---
      var ar_body = $m.find(".ar_body");
      var showPub = $m.find(".pub");
      var btnSave = $m.find(".btnSave");

      function showForm(cmd,id){
        tinymce.activeEditor.setMode("design");


        switch(cmd){
          case"edit":
            editPost(id);
            $($md).modal("show");
          break;
          default:
            $f.trigger("reset"); //--reset form
            $mTitle.html("Create New Post");
            //---reset the hidden field as this is the new key
            ar_id.val("");
            key_id.val("");

            //---show form in modal
            $($md).modal("show");
          break;
        }
      }

      //-----------
      //----showSumTmp---
      function putSumTmp(){
        //---will get the previous value
        //var old_sum = ar_sum.val();
        var show_tmp = "";
        var img_sample = "https://lh3.googleusercontent.com/rIiOa8EVWp3P_RnIiU3J0dB9c9on5Kwmk3SKVJBj_ggBLTGmSFkFFCImpQceXhkaES_8NUt3I1DnMGbMGMhtLzO9xNvfl4NcRcpZwgGgml0IpvHTuEM3DmcMyReirEKHP4xVXIe87hg=w2400";

        var tmp = `<div class="row">
          <div class="col-lg-4">
            <!--show image-->
            <a href="https://lh3.googleusercontent.com/rIiOa8EVWp3P_RnIiU3J0dB9c9on5Kwmk3SKVJBj_ggBLTGmSFkFFCImpQceXhkaES_8NUt3I1DnMGbMGMhtLzO9xNvfl4NcRcpZwgGgml0IpvHTuEM3DmcMyReirEKHP4xVXIe87hg=w2400" target="_blank">
              <img src="${img_sample}" class="responsive" />
            </a>
            <p class="text-center">
              replace this text with your text
            </p>
          </div>
          <div class="col-lg-8">
            <p>Just start your paragraph here in between tag "&lt;p&gt;between&lt;/p&gt;" the text can be long and multiple p tag.</p>
          </div>
        </div>
        `;
        if($tmp_sum.is(":checked")){
          //--checked the box
          show_tmp = tmp;
        }else{
          //console.log(old_sum);
          show_tmp = "remove this text and create it by your self or refresh page then click edit button again.";
        }
        ar_sum.val(show_tmp);
      }
      //-----------------
      //----sumWordCount
      function sumWordCount(){
        var numWord = ar_sum.val().length;
        $sumWordCount.html(numWord);
      }
      //----showSumResult
      function showSumResult(){
        sumWordCount();
        var tmp = `<p>&nbsp;</p>
        ${ar_sum.val()}
        <p>&nbsp;</p>`;
        $sum_result.html(tmp);
      }
      //----firstSave
      function firstSave(){
        if(ar_id.val() && key_id.val()){
          //--found ar_id and key_id from the hidden field this method will be not run
          return false;
        }else{
          //---there is no id and key so let create new one
          var url = "<?php echo site_url("article/uFirstSave");?>";
          var data = {ar_title : ar_title.val()};
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              var rs = $.parseJSON(e);
              key_id.val(rs.kw_id);
              ar_id.val(rs.ar_id);
              setTimeout(function(){
                //---create new key and go to edit the post
                editPost(rs.ar_id);
              },4000);


            }
          });
        }
      }
      //--editPost
      function editPost(id){
        var url = "<?php echo site_url("article/uEditAr/");?>"+id;
        $.ajax({
          url : url,
          success : function(e){
              var rs = $.parseJSON(e);
              $.each(rs.get_ar,function(i,v){
                //console.log(v);
                if(parseInt(v.ar_show_public) !== 0){
                  showPub.prop("checked",true);
                }
                $mTitle.html(`Editing ${v.ar_title}...`)
                ar_id.val(v.ar_id);
                key_id.val(v.kw_id);
                og_url.val(v.og_url);
                keyword.val(v.kw_page_keyword);
                key_des.val(v.kw_page_des);
                ar_title.val(v.ar_title);
                ar_sum.val(v.ar_summary);

                tinymce.activeEditor.setContent(v.ar_body);
              });
          }
        });

      }

      //-----------------
      //----savePost
      function savePost(){
        btnSave.unbind();
        $f.submit(function(e){
          e.preventDefault();
          var url = $(this).attr("action");
          var data = $(this).serialize();
          $.post(url,data,function(e){
            var rs = $.parseJSON(e);
            var msg = `<p>${rs.msg}</p>
            <p>You can close this window when you done</p>
            `;
            $modal_status.html(msg).show();
            setTimeout(function(){
              $modal_status.html("Loading...").fadeOut("slow");
              getSummary();
            },4000);

          });
        });
      }
      //-----------------
      //----getMyPostList
      function getMyPostList(page=1){
        var url = "<?php echo site_url("article/uGetMyPost/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            //console.log(rs);
            $numMyPost.html(rs.num_ar);
            $post_list.html("");
            if(rs.get_ar.length !== 0){

              $.each(rs.get_ar,function(i,v){

                var read_url = "<?php echo site_url("article/uViewPost/");?>"+v.ar_id;
                var approve = `
                <span class="badge badge-success">Yes</span>
                `;
                if(parseInt(v.ar_is_approve) === 0){
                  approve = `
                  <span class="badge badge-danger">No</span>
                  `;
                }
                var is_pub = `<span class="badge badge-success">Yes</span>`;
                if(parseInt(v.ar_show_public) === 0){
                  is_pub = `<span class="badge badge-danger">No</span>`;
                }
                var tmp = `
                <div class="card">
                  <div class="card-header">
                    <h1 class="text-center">${v.ar_title}</h1>
                  </div>
                  <div class="card-body">
                    ${v.ar_summary}
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                          <th>Date</th>
                          <td>
                            <strong>Create</strong> &nbsp;${v.date_add}&nbsp;
                            <strong>Update</strong>&nbsp;
                            ${v.date_edit}
                          </td>
                        </tr>
                        <tr>
                          <th>Status</th>
                          <td>
                            <strong>
                            Approve :
                            </strong>&nbsp;
                            ${approve} &nbsp;
                            <strong>
                            Public :
                            </strong>&nbsp;
                            ${is_pub}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="float-right">
                      <a class="btn btn-primary lnRead" data-ar_id="${v.ar_id}" href="${read_url}" target="_blank">View</a>
                      <a class="btn btn-warning lnEdit" data-ar_id="${v.ar_id}">Edit</a>
                      <a class="btn btn-danger lnDel" data-ar_id="${v.ar_id}">Delet</a>
                    </div>

                  </div>
                </div>
                <p>&nbsp;</p>
                `;
                $post_list.append(tmp);
              });
              $post_pagin.html(rs.pagination);
            }
          }
        });
      }

      //---delAr
      function delAr(cmd,id){
        var msg = `You are about to delete ID ${id} this operation cannot be undo!\n
        Are you sure to delete `;
        switch(cmd){
          case"delete":
            alert(`The ID ${id} has deleted!`);
          break;
          default:
            if(confirm(msg) === true){
              delAr("delete",id);
            }else{
              return false;
            }
          break;
        }
      }
      //---getSummary
      function getSummary(){
        //---will check what's has been change
        getMyPostList();
      }
      //---------
      function getEvent(){
        //---getSummary
        getSummary();
        //---create new Post
        lnNewPost.on("click",function(){
          showForm();
        });

        //--run uFirstSave
        ar_title.on("blur",function(){
          firstSave();
        });

        //---need template on Summary
        $tmp_sum.on("change",function(){
          putSumTmp();
        });

        //--show word count in sum text
        ar_sum.on("keyup",function(){
          sumWordCount();
        });
        //--ar_sum lost focus
        ar_sum.on("blur",function(){
          showSumResult();
        });

        //---edit Post
        $post_list.delegate(".lnEdit","click",function(){
          var id = $(this).attr("data-ar_id");
          showForm("edit",id);
        });

        $post_list.delegate(".lnDel","click",function(){
          var id = $(this).attr("data-ar_id");
          delAr(null,id);
        });

        //---pagination
        $post_pagin.delegate(".pagination a","click",function(e){
          e.preventDefault();
          var next_page = $(this).attr("data-ci-pagination-page");
          getMyPostList(next_page);
        });

        //---submit button Click
        btnSave.on("click",function(){
          savePost();
        });

      }
      return{getEvent:getEvent}
    })();
    my_post.getEvent();
  });
  */
  $(function(){
    var $ar = $("#my_post");
    var $page_status = $(".status");
    var my_post = (function(){

      var $lnCreate = getEl(".lnNewPost");
      var $post_list = getEl(".mypost_list");
      var $post_pagin = getEl(".mypost_pagin");

      //--- public post
      var $lnShowPubPost = getEl(".lnShowPubPost");
      var $pub_post = getEl("#pubPost");
      var $pub_list = getEl(".pub_list");
      var $pub_pagin = getEl(".pub_pagin");
      //$pub_post.html("");

      //---the label
      var $numAll = getEl(".numAll");
      var $numMy = getEl(".numMy");
      var $numPri = getEl(".numPri");
      var $numNotApprove = getEl(".numNotApprove");

      //---modal
      var $md = getEl(".mdAr");
      var $mdTitle = getEl(".modal-title");
      var btnSave = getEl(".btnSave");
      var $modal_status = getEl(".modal_status");

      //--- form ----
      var $f = getEl("#frmAr");
      var $fResult = getEl(".fResult");
      var ar_id = getEl(".ar_id");
      var kw_id = getEl(".key_id");
      var keyword = getEl(".keyword");
      var keydes = getEl(".key_des");
      var keyurl = getEl(".og_url");
      var ar_title = getEl(".ar_title");
      var ar_sum = getEl(".ar_sum");
      var ar_body = getEl(".ar_body");
      var chPub = getEl(".pub");

      //----showLabel
      function showPubLabel(){
        //---get to show the public pos not include this user id
        var all = 0;
        var url = "<?php echo site_url("article/uListPubPost");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            all = rs.get_all.length;
            $numAll.html(all);
          }
        });


      }
      //---------------
      //--- showPubList
      function showPubList(page=1){
        $pub_list.html("");
        var url  = "<?php echo site_url("article/uListPubPost/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            //console.log(rs);
            $.each(rs.get_pub,function(i,v){
              var read_url = "<?php echo site_url("article/read/");?>"+v.ar_id;
              var tmp = `
              <div class="card">
                <div class="card-header bg-primary">
                  <h1 class="text-center">
                    ${v.ar_title}
                  </h1>
                </div>
                <div class="card-body">
                  ${v.ar_summary}
                  <p>&nbsp;</p>
                  <div class="table-responsive">
                    <table class="table table-bordered">

                      <tr>
                        <th>Wrote By</th>
                        <td>
                          <strong>
                            ${v.name}
                          </strong>
                        </td>
                      </tr>
                      <tr>
                        <th>Date</th>
                        <td>
                          Created : ${v.date_add}&nbsp;
                          &nbsp; Update : ${v.date_edit}
                        </td>
                      </tr>

                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a class="btn btn-primary btn-xs lnReadPubPost" href="${read_url}" target="_blank" style="color:white;font-weight:bold;">
                    Read
                    </a>
                  </div>
                </div>
              </div>
              <p>&nbsp;</p>
              `;
              $pub_list.append(tmp);
            });
            if(rs.pagination){
              $pub_pagin.html(rs.pagination);
            }
          }
        });
      }
      //-----------
      //---- openPubPost
      function openPubPost(open){
        var hideMe = $pub_post.is(":hidden");
        var onMe = parseInt(open);
        if(hideMe){
          onMe = 1;
        }else{
          onMe = 0;
          $lnShowPubPost.html("Show Public Post");
        }
        //console.log(`the on me is ${onMe}`);
        $pub_post.slideToggle();
      }

      //-----------
      //------- myPostLabel
      function showMyPostLabel(){
        var all = 0;
        var pri = 0;
        var not = 0;
        var url = "<?php echo site_url("article/uList/");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            all = rs.get_all.length;
            $.each(rs.get_all,function(i,v){
              if(parseInt(v.ar_show_public) === 0){
                pri++;
              }
              if(parseInt(v.ar_is_approve) === 0){
                not++;
              }
            });
            $numPri.html(pri);
            $numNotApprove.html(not);
            $numMy.html(all);
          }
        });
      }
      //---------------
      //---- myPostList
      function myPostList(page=1){
        $post_list.html("");
        var url = "<?php echo site_url("article/uList/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            //console.log(rs);
            $.each(rs.get_my,function(i,v){
              //console.log(v);
              var stApp = `
              <span class="alert alert-success">
                Yes
              </span>
              `;
              if(parseInt(v.ar_is_approve) === 0){
                stApp = `
                <span class="alert alert-danger">
                  No
                </span>
                `;

              }


              //---msgShowStatus
              var msgShowStatus = `
              <div class="row">
                <div class="col-md-6">
                  <p class="alert alert-success">
                  Your post  will "BE SHOWN" to the public
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="alert alert-success">
                  โพสของคุณจะ "แสดง" ต่อสาธารณะ
                  </p>
                </div>
              </div>
              `;
              if(parseInt(v.ar_is_approve) === 0 || parseInt(v.ar_show_public) === 0){
                msgShowStatus = `
                <div class="row">
                  <div class="col-md-6">
                    <p class="alert alert-danger">
                    Your post will "NOT BE SHOWN" to the public
                    </p>
                  </div>
                  <div class="col-md-6">
                    <p class="alert alert-danger">
                    โพสของคุณจะ "ไม่แสดง" ต่อสาธารณะ
                    </p>
                  </div>
                </div>
                `;
              }
              var stPub = `<span class="alert alert-success">
                Yes
              </span>
              `;
              if(parseInt(v.ar_show_public) === 0){
                stPub = `<span class="alert alert-danger">
                  No
                </span>
                `;
              }

              //--- viewPost
              var uReadUrl = "<?php echo site_url("article/uViewPost/");?>"+v.ar_id;

              var tmp = `
              <div class="card">
                <div class="card-header bg-warning">
                  <h1> ${v.ar_title}</h1>
                </div>
                <div class="card-body">
                  ${v.ar_summary}
                  <p>&nbsp;</p>
                  ${msgShowStatus}
                  <p>&nbsp;</p>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr>
                        <th>
                          Date
                        </th>
                        <td>
                          Create : ${v.date_add}
                          &nbsp;Update :
                          ${v.date_edit}
                        </td>
                      </tr>
                      <tr>
                        <th>
                          Status
                        </th>
                        <td>
                          Approve : ${stApp} &nbsp; Public : ${stPub}
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                  <a class="btn btn-primary btn-xs" style="color:white;font-weight:bold;" href="${uReadUrl}" target="_blank">
                  View
                  </a>
                    <a class="btn btn-primary btn-xs lnEditMyPost" style="color:white;font-weight:bold;" data-ar_id="${v.ar_id}">
                    Edit
                    </a>
                    <a class="btn btn-danger btn-xs lnDelMyPost" style="color:white;font-weight:bold;" data-ar_id="${v.ar_id}">
                    Delete
                    </a>
                  </div>
                </div>
              </div>
              <p>&nbsp;</p>
              `;
              $post_list.append(tmp);
            });
            if(rs.pagination){
              $post_pagin.html(rs.pagination);
            }
          }
        });
      }
      //------ showForm
      function showForm(cmd,id){
        tinymce.activeEditor.setMode("design");
        $f.trigger("reset");
        $fResult.html("");
        switch(cmd){
          case"edit":
            var url = "<?php echo site_url("article/uEditPost/");?>"+id;
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                $.each(rs.get,function(i,v){
                  //console.log(v);
                  if(parseInt(v.ar_show_public) !== 0){
                    chPub.prop("checked",true);
                  }
                  ar_id.val(v.ar_id);
                  kw_id.val(v.kw_id);
                  ar_title.val(v.ar_title);
                  ar_sum.val(v.ar_summary);
                  tinymce.activeEditor.setContent(v.ar_body);

                  keyword.val(v.kw_page_keyword);
                  keydes.val(v.kw_page_des);
                  keyurl.val(v.kw_canonical);

                  var showMsg = `<span class="alert alert-warning">Editing ${v.ar_title}...`;
                  $mdTitle.html(`Editing ${v.ar_title}...`);
                  $modal_status.html(showMsg);
                  var tmp = `
                  <div class="card">
                    <div class="card-header">
                      <h1 class="text-center">
                        ${v.ar_title}
                      </h1>
                    </div>
                    <div class="card-body">
                      <p>${v.ar_summary}</p>
                      <p>&nbsp;</p>
                      <p>${v.ar_body}</p>
                    </div>
                    <div class="card-footer">
                      <p>to see your change please click "Save" button. คลิกปุ่ม "Save" เพื่อจัดเก็บ</p>
                    </div>
                  </div>
                  <p>&nbsp;</p>
                  `;
                  $fResult.append(tmp);
                });
              }
            });
          break;
          default:
            $mdTitle.html("Create New Post | สร้างโพสใหม่");
            var showMsg = `<span class="alert alert-info">
            Create new Post
            </span>
            `;
            ar_id.val(0);
            $modal_status.html(showMsg);
          break;
        }
        $($md).modal("show");
      }
      //-------------------
      //------  uFirstSave
      function uFirstSave(){

        var edit_id = ar_id.val();
        var msg = "";

        if(parseInt(edit_id) === 0){
          if(ar_title.val().length > 10){

            //--- save the post
            var url = "<?php echo site_url("article/uFirstSave");?>";
            var data = {ar_title : ar_title.val()};
            $.post(url,data,function(e){
              var rs = $.parseJSON(e);
              //console.log(rs);
              autoAddTemplate();
              ar_id.val(rs.ar_id);
              kw_id.val(rs.kw_id);
            });


            //---- show in the modal status
            msg = `
            <span class="alert alert-success">
            Creating new Post  | สร้างโพสใหม่...
            </span>
            `;


          }else{
            msg = `
            <span class="alert alert-danger">
            Warning : your title is too short ! หัวข้อเรื่องของคุณสั้นเกินไป
            </span>
            `;
          }
        }else{
          msg = `<span class="alert alert-warning">
          Editing ${ar_title.val()}...
          </span>
          `;
        }

        $modal_status.html(msg);
      }
      //-------------------
      //------  autoAddTemplate
      function autoAddTemplate(){
        $fResult.html("");
        //----create
        var de_img_url = "https://lh3.googleusercontent.com/mTUhDv93aFUkYpZRrgmXibd54kTjki7L5A_KMfTcXI2xbMxmda9CkYO2V3PTNagAsUPgkMYKscyRjW0l8Mvqvbnv4dEwo_XLqXKOP-C35NmgP8rVpMR7nh9vEFMmE7HwpFUhczraNIo=w2400";

        var samplePic_1 = "https://lh3.googleusercontent.com/yr1sY36OskC_Hf61ucbmTc4r8pDFwYosPneWOGWSB9902lJ3F5sLFARZpxwFZRWuaLKD-dqppAoAIQI9mif3veCL10KK37nnRbkKEqBfv-UDxYYh8924EmAqohD2RPkxoez_YJByT9U=w2400";

        var samplePic_2 = "https://lh3.googleusercontent.com/yao85Jr_D7FRdhQWCQ7fArNSygR1eEaj7cj1ai_kcLsrcJBbRConaCQL5rTW1NjgRYnG-EWQBo2WbFUHru0gyUwGsxike73c2Dt6tFCP0f1uP2CIGrGOV5hnI0DRfonrsGa-CI2t_Ak=w2400"; //--butterfly

        var samplePic_3 = "https://lh3.googleusercontent.com/NgShM0O8z5mEJvhFyRlCoPVHgD-4IzPVuGICswg5I0kfBXYg1zrCEjXG-m2DHnstWmP8ewmvwB4YW1ky4jdgrgN_rGRgnMjXlPXIardXO9LfrkfjOrsU2sm2vQr8zs-88pn2W2Xry54=w2400"; //--long tail boat in koh yao yai


        var sum_tmp = `<div class="row">
          <div class="col-lg-4">
            <img src="${de_img_url}" class="responsive" />
            <p class="text-center">Your photo title or just remove this tag.</p>
          </div>
          <div class="col-lg-8">
            <p>
              This is the default template for  "${ar_title.val()}" you can edit this to how ever you would like it to be but it is better to being in the of this formatting.
            </p>
          </div>
        </div>
        `;
        //------body template
        var body_tmp = `<section id="ar_body">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="text-center">Title default for "${ar_title.val()}" just feel free to edit it</h1>
              <p>Anything you want to put for the body.</p>
              <img src="${samplePic_1}" class="responsive" />
              <p class="text-center">Your image title or just remove this tag.</p>
            </div>
            <div class="col-lg-5">
              <img src="${samplePic_2}" class="responsive" />
              <p class="text-center">Your image title or just remove this tag.</p>
            </div>
            <div class="col-lg-7">
              <p>The two columns is just create the left column by "div" TAG with the class of "col-lg-4" and the other div on the right will be "div class=col-lg-8 " for the text in one paragraph just put it in the "p TAG".<br />
              Keep in mind that if you want to create the two columns like this the div tag has to wrap by div with the class of "row".
              </p>
              <p>
                To having a space in between the element you have to create an empty p tag or div tag with the class of col-lg-12 and inside of div you need to p tag with the "&nbsp;" tag to make a space
              </p>
            </div>
            <div class="col-lg-12">
              <p>&nbsp;</p>
            </div>
            <div class="col-lg-12">
              <img src="${samplePic_3}" class="responsive"/>
              <p class="text-center">Photo is taken in Koh Yao Yai Thailand</p>
            </div>
          </div>
        </div>
        </section>
        `;
        ar_sum.val(sum_tmp);
        tinymce.activeEditor.setContent(body_tmp);
        var showTemplate = `<div class="card">
          <div class="card-header bg-success">
            <h1>This is the default template</h1>
          </div>
          <div class="card-body">
            <p>${sum_tmp}</p>
            <p>
              ${body_tmp}
            </p>
          </div>
        </div>
        `;
        $fResult.append(showTemplate);
      }
      //------------------
      //------ uSavePost
      function uSavePost(){
        btnSave.unbind();
        $f.submit(function(e){
          e.preventDefault();
          var url = $(this).attr("action");
          var data = $(this).serialize();
          $.post(url,data,function(e){
            //alert(e);
            var rs = $.parseJSON(e);
            var showMsg = `<span class="alert alert-success">Success : data has been save</span>`;
            $modal_status.html(showMsg);
            setTimeout(function(){
              getSummary();
              showForm("edit",rs.ar_id);
            },3000);
          });
        });
      }
      //-------------------
      //------ uDelPost
      function uDelPost(id){
        var msg = `You are about to delete ${id}! this operation cannot be UNDO are you sure you want to proceed?`;
        if(confirm(msg) === true){
          var url = "<?php echo site_url("article/uDelPost/");?>"+id;
          $.ajax({
            url : url,
            success : function(e){
              var rs = $.parseJSON(e);
              $page_status.html(`item has been delated! there are ${rs.last_num} item(s) since last count.`).show();
              setTimeout(function(){
                $page_status.html("loading...").fadeOut("slow");
                getSummary();
              },3000);
            }
          });
        }else{
          return false;
        }
      }
      //------getSummary
      function getSummary(){
          showPubLabel();

          //--- show public post
          showPubList();
          openPubPost();
          //-----------
          //--showMyPostLabel
          showMyPostLabel();
          //-----------
          //--- show my post
          myPostList();
      }
      //----------------
      //---getEl
      function getEl(el){
        return $ar.find(el);
      }
      function getEvent(){
        $lnCreate.on("click",function(){
          showForm();
        });
        getSummary();

        //--- show pub post
        $lnShowPubPost.on("click",function(){
          $lnShowPubPost.html("Hide Public Post");
          $pub_post.html();
          openPubPost(1);
        });

        //--- user lost focus on title
        ar_title.on("blur",function(){
          uFirstSave();
        });
        //---edit my post
        $post_list.delegate(".lnEditMyPost","click",function(){
          var id = $(this).attr("data-ar_id");
          showForm("edit",id);
        });
        //----------
        //---- user delete his post
        $post_list.delegate(".lnDelMyPost","click",function(){
          var id = $(this).attr("data-ar_id");
          uDelPost(id);
        });

        //---pagination my post
        $post_pagin.delegate(".pagination a","click",function(e){
          e.preventDefault();
          var page = $(this).attr("data-ci-pagination-page");
          myPostList(page);
        });

        //---pagination for pub post
        $pub_pagin.delegate(".pagination a","click",function(e){
          e.preventDefault();
          var page = $(this).attr("data-ci-pagination-page");
          showPubList(page);
        });

        //---- savePost
        btnSave.on("click",function(){
          uSavePost();
        });
      }
      return{getEvent:getEvent}
    })();
    my_post.getEvent();
  });

</script>

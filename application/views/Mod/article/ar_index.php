<div class="col-lg-12">
  <h1 class="text-center">
    System info  : <?php echo $sysName;?>
  </h1>
  <p class="text-right">
    version : <?php echo $sysVersion;?>
  </p>
  <p class="text-right">last update <?php echo $sysDate;?></p>
  <ul>
    <li class="alert alert-danger">
      <p>
        Add folder "Mod" in the view
      </p>
    </li>
    <li class="alert alert-info">
      <p>
        Change the menu set it to responsive
      </p>
    </li>
    <li class="alert alert-info">
      <p>
        Moderate have abillity to "ADD ,EDIT ,DELETE" post.
      </p>
    </li>
  </ul>
</div>
<p>&nbsp;</p>
<section id="article">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center ">
          <?php echo $sysName;?>
        </h1>

      </div>

      <!-- show label START -->
      <div class="col-lg-4">
        <div class="alert alert-info ">
          <h1 style="text-align:right;color:green;" class="numAll">0</h1>
        </div>
        <p class="text-center">All Post</p>
      </div>

      <div class="col-lg-4">
        <div class="alert alert-info ">
          <h1 style="text-align:right;color:red;" class="numPri">0</h1>
        </div>
        <p class="text-center">Private Post</p>
      </div>

      <div class="col-lg-4">
        <div class="alert alert-success ">
          <h1 style="text-align:right;color:blue;" class="numPub">0</h1>
        </div>
        <p class="text-center">Public Post</p>
      </div>

      <div class="col-lg-3">
        <div class="alert alert-warning ">
          <h1 style="text-align:right;color:red;" class="numNotApprove">0</h1>
        </div>
        <p class="text-center">NOT Approve</p>
      </div>

      <div class="col-lg-3">
        <div class="alert alert-success">
          <h1 style="text-align:right;color:blue;" class="numApprove">0</h1>
        </div>
        <p class="text-center">Approve Post</p>
      </div>

      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 style="text-align:right;color:red;" class="numIndex">0</h1>
        </div>
        <p class="text-center">Show Index Page</p>
      </div>

      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 style="text-align:right;color:red;" class="numMy">0</h1>
        </div>
        <p class="text-center">Post By <?php echo $user_name;?></p>
      </div>

      <!-- show label END -->
      <!-- show list START -->
      <p>&nbsp;</p>
      <div class="col-lg-12">
        <div class="float-right">
          <a class="btn btn-primary lnCreate" style="color:white;">Create New post</a>
        </div>
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-12">
        <p>&nbsp;</p>
        <div class="ar_list">

        </div>
        <div class="ar_pagin">

        </div>
        <p>&nbsp;</p>
      </div>
      <!-- End of show list -->


    </div>
  </div>

  <div class="modal fade md">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title">Create New Post</h1>
          <button class="close" data-dismiss="modal">
            <span class="badge badge-danger">
              &times;
            </span>
          </button>
        </div>
        <div class="modal-body">
            <?php
              $f = "Mod/article/_frm_ar";
              $this->load->view($f);
            ?>


            <p>&nbsp;</p>
            <div class="modal_status">

            </div>
        </div>
        <div class="modal-footer">
          <div class="float-right">
            <button class="btn btn-primary btnSave" type="submit" form="ar_form">Save</button>
            <button class="btn btn-danger " data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(function(){
    var $a = $("#article");
    var $page_status = $(".status");
    var ar = (function(){
      var lnCreate = getEl(".lnCreate");
      var $ar_list = getEl(".ar_list");
      var $ar_pagin = getEl(".ar_pagin");
      //---label
      var $numAll = getEl(".numAll");
      var $numMy = getEl(".numMy");
      var $numApprove = getEl(".numApprove");
      var $numNotApprove = getEl(".numNotApprove");
      var $numPri = getEl(".numPri");
      var $numPub = getEl(".numPub");
      var $numIndex = getEl(".numIndex");

      var all,inD = 0;
      var pub = 0;
      var pri = 0;
      var approve = 0;
      var notApprove = 0;
      var my = 0;

      var myId = "<?php echo $user_id;?>";

      //---modal
      var $md = getEl(".md");
      var $mdTitle = getEl(".modal-title");
      var modal_status = getEl(".modal_status");
      var $fResult = getEl(".fResult");

      //--- form
      var $f = getEl("#ar_form");
      var keyword = getEl(".keyword");
      var keydes = getEl(".keydes");
      var ar_id = getEl(".ar_id");
      var kw_id = getEl(".kw_id");
      var ar_user_id = getEl(".ar_user_id");
      var title = getEl(".ar_title");
      var sum = getEl(".ar_sum");
      var body = getEl(".ar_body");
      var chApprove = getEl(".chApprove");
      var chPublic = getEl(".chPublic");
      var chIndex = getEl(".chIndex");
      var btnSave = getEl(".btnSave");

      function showLabel(){

        var url = "<?php echo site_url("article/modListPost/");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            all = rs.get_all.length;
            $.each(rs.get_all,function(i,v){

              if(parseInt(v.ar_show_index) !== 0){
                inD++;
              }
              if(parseInt(v.ar_show_public) !== 0){
                pub++;
              }else{
                pri++;
              }
              if(parseInt(v.ar_is_approve) !== 0){
                approve++;
              }else{
                notApprove++;
              }
              if(parseInt(myId) === parseInt(v.ar_user_id)){
                my++;
              }
            });
            $numAll.html(all);
            $numMy.html(my);
            $numIndex.html(inD);
            $numPub.html(pub);
            $numPri.html(pri);
            $numApprove.html(approve);
            $numNotApprove.html(notApprove);
          }
        });
      }
      //-----------------------
      //------getList
      function getList(page=1){
        $ar_list.html("");
        var url = "<?php echo site_url("article/modListPost/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            $.each(rs.get_ar,function(i,v){

              //---
              var show_index = `
              <span class="badge badge-success">
              Yes
              </span>
              `;
              if(parseInt(v.ar_show_index) == 0){
                show_index = `
                <span class="badge badge-danger">
                No
                </span>
                `;
              }

              //--- approve status
              var approve = `
              <span class="badge badge-success">
              Yes
              </span>
              `;
              if(parseInt(v.ar_is_approve) === 0){
                approve = `
                <span class="badge badge-danger">
                  No
                </span>
                `;
              }


              //--- approve status
           var pub = `
              <span class="badge badge-success">
              Yes
              </span>
              `;
              if(parseInt(v.ar_show_public) === 0){
                pub = `
                <span class="badge badge-danger">
                  No
                </span>
                `;
              }


              var tmp = `
              <div class="card">
                <div class="card-header">
                  <h1 class="text-center">${v.ar_title}</h1>
                </div>
                <div class="card-body">
                  ${v.ar_summary}
                  <p>&nbsp;</p>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr>
                        <th>By</th>
                        <td>${v.ar_post_by}</td>
                      </tr>
                      <tr>
                        <th>Date</th>
                        <td>
                          <strong>Create :</strong> &nbsp;${v.date_add} &nbsp;
                          <strong>Edit :</strong> ${v.date_edit}
                        </td>
                      </tr>
                      <tr>
                        <th>Read</th>
                        <td>${v.ar_read_count}</td>
                      </tr>
                      <tr>
                        <th>Status</th>
                        <td>
                          <p>
                          <strong>
                            Show Index Page
                          </strong>
                          ${show_index}&nbsp;
                          <strong>
                            Approve
                          </strong>
                          ${approve}&nbsp;
                          <strong>
                            Show as Public
                          </strong>
                          ${pub}&nbsp;


                          </p>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <a style="color:white;" class="btn btn-primary btn-sm lnEdit" data-ar_id="${v.ar_id}">Edit</a>
                    <a style="color:white;" class="btn btn-danger btn-sm lnDel" data-ar_id="${v.ar_id}">Delete</a>
                  </div>
                </div>
              </div>
              <p>&nbsp;</p>
              `;
              $ar_list.append(tmp);
            });
            if(rs.pagination){
              $ar_pagin.html(rs.pagination);
            }
          }

        });
      }
      //-----------------
      //-------setToZero
      function setToZero(){
        //--set everything to Zeo statge
          all = 0;
          inD = 0;
          pub = 0;
          pri = 0;
          approve = 0;
          notApprove = 0;
          my = 0;
      }
      //---------------------
      //-----showForm
      function showForm(cmd,id){
        modal_status.html("");
        tinymce.activeEditor.setMode("design");
        $mdTitle.html("Create New Post | สร้างโพสใหม่");
        var url = "<?php echo site_url("article/modEditPost/");?>"+id;
        switch(cmd){
          case"edit":
          /*
            var url = "<?php //echo site_url("article/modEditPost/");?>"+id;
            */
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                //console.log(rs);
                $.each(rs.get,function(i,v){
                  //console.log(v);
                  $mdTitle.html(`Editing ${v.ar_title}...ปรับปรุง`);
                  if(parseInt(v.ar_is_approve) !== 0){
                    chApprove.prop("checked",true);
                  }
                  if(parseInt(v.ar_show_public) !== 0){
                    chPublic.prop("checked",true);
                  }
                  if(parseInt(v.ar_show_index) !== 0){
                    chIndex.prop("checked",true);
                  }
                  ar_id.val(v.ar_id);
                  kw_id.val(v.kw_id);
                  ar_user_id.val(v.id);
                  keyword.val(v.kw_page_keyword);
                  keydes.val(v.kw_page_des);
                  title.val(v.ar_title);
                  sum.val(v.ar_summary);
                  tinymce.activeEditor.setContent(v.ar_body);

                  var sIn = `<span class="alert alert-warning">
                  Editing ${v.ar_title}...
                  </span>
                  `;
                  modal_status.html(sIn).show();
                  var showResult = `
                  <div class="container">
                    <div class="row">
                      <div class="col-lg-12">
                        ${v.ar_summary}
                      </div>
                      <div class="col-lg-12">
                        ${v.ar_body}
                      </div>
                    </div>
                  </div>
                  `;
                  $fResult.html(showResult);
                });
              }
            });
          break;
          default :
            $f.trigger("reset");
            ar_id.val("");
            ar_user_id.val(myId);
            kw_id.val(0);
            title.attr("placeholder","Post Title").val("");
          break;

        }
        //console.log(`the url is ${url}`);
        $($md).modal("show"); //-- call the modal
      }
      //------------------------
      function firstSave(){
        var t_num = title.val().length;
        var max = 15;
        var a_id = ar_id.val();
        if(a_id){
          //showForm("edit",a_id);
          ar_id.val(a_id);
        }else{

          if(t_num > max){
            var url = "<?php echo site_url("article/modFirstSave");?>";
            var data = {ar_title : title.val()};
            $.ajax({
              type : "post",
              url : url,
              data : data,
              success : function(e){
                var rs = $.parseJSON(e);
                ar_id.val(rs.ar_id);
                kw_id.val(rs.kw_id);

                var s_msg = `<span class="alert alert-success">
                Your post has been created.
                </span>`;
                modal_status.html(s_msg).show();
                setTimeout(function(){
                  getSummary();
                  showForm("edit",rs.ar_id);
                },3000);


              }
            });
          }
        }
      }
      //-------------
      function savePost(){
        btnSave.unbind();
        $f.submit(function(e){
          e.preventDefault();
          var url = $(this).attr("action");
          var data = $(this).serialize();
          $.post(url,data,function(e){
            var rs = $.parseJSON(e);

            var sIn = `<span class="alert alert-success">
            success : data has been save.
            </span>
            `;
            modal_status.html(sIn).show();
            setTimeout(function(){

              showForm("edit",rs.ar_id);
              getSummary();
            },3000);

          });
        });
      }
      //--------------------------
      //-------modDel
      function modDel(cmd,id){
        switch(cmd){
          case"delete":
            var url = "<?php echo site_url("article/modDelPost/");?>"+id;
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                var today = "<?php echo $today_andTime;?>";
                var msg = `DELETED : There are ${rs.num} item(s) from ${today} as the last update`;
                alert(msg);
                setTimeout(function(){
                  getSummary();
                },4000);
              }
            });
          break;
          default:
            var msg = `You are about to delete ${id}! This action cannot be UNDO\n Are you sure you want to delete ${id}?`;
            if(confirm(msg) === true){
              modDel("delete",id);
            }else{
              getSummary();
            }
          break;
        }
      }

      //-------------
      function getSummary(){
        setToZero();
        showLabel();
        getList();
      }
      //-----
      function getEl(el){
        return $a.find(el);
      }
      function getEvent(){
        getSummary();
        //---lnCreate click
        lnCreate.on("click",function(){
            showForm();
        });

        //--edit button click
        $ar_list.delegate(".lnEdit","click",function(){
          var id = $(this).attr("data-ar_id");
          console.log(`the edit id is ${id}`);
          showForm("edit",id);
        });

        //--delete button click
        $ar_list.delegate(".lnDel","click",function(){
          var id = $(this).attr("data-ar_id");
          modDel(null,id);
        });

        $ar_pagin.delegate(".pagination a","click",function(e){
          e.preventDefault();
          var page = $(this).attr("data-ci-pagination-page");
          getList(page);
        });

        //---title
        title.on("blur",function(){
          firstSave();
        });

        //--------
        //---btnSave on Click
        btnSave.on("click",function(){
          savePost();
        });
      }
      return{getEvent:getEvent}
    })();
    ar.getEvent();
  });
</script>

<!-- NO COPY START -->
<div class="col-lg-12">
  <h1 class="text-center">
    Sys Info <?php echo $sysName;?>
  </h1>
  <div class="float-right">
    <p>
      <span class="alert alert-info">
      <?php echo $sysName;?>
    </span> version <?php echo $sysVersion;?> date on <?php echo $sysDate;?>
    </p>
  </div>
  <p>&nbsp;</p>
  <ul>
    <li class="alert alert-success">
      <p>
        Moderate can change or delete user.
      </p>
    </li>
    <li class="alert alert-warning">
      <p>
        Moderate Cannot "Add new user".
      </p>
    </li>
    <li class="alert alert-danger">
      <p>
        Moderate Cannot "View" admin or any other "Moderator"
      </p>
    </li>
  </ul>
  <p>&nbsp;</p>
  <div class="table-responsive">
    <table class="table table-bordered">
      <tr>
        <th>Last update</th>
        <td>2-Aug-2019</td>
      </tr>
    </table>
  </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<!-- NO COPY END -->
<section id="man_user">
  <div class="container">
    <div class="row">
      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 style="text-align:right;" class="numAll">0</h1>
        </div>
        <p class="text-center">All user</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-success">
          <h1 style="text-align:right;" class="numActive">0</h1>
        </div>
        <p class="text-center">Active User</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-danger">
          <h1 style="text-align:right;color:red;" class="numNotActive">0</h1>
        </div>
        <p class="text-center">Not Active User</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-danger">
          <h1 style="text-align:right;color:red;" class="numBan">0</h1>
        </div>
        <p class="text-center">Ban user</p>
      </div>
      <div class="col-lg-12">
        <p>&nbsp;</p>
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-12">
        <div class="user_list">

        </div>
        <div class="user_pagin">

        </div>
      </div>
    </div>
  </div>

  <!-- form modal 2-aug-2019 -->
  <div class="modal fade md">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title"></h1>
          <button class="close" data-dismiss="modal">
            &times;
          </button>
        </div>
        <div class="modal-body">
          <?php
            $f = "Mod/users/_frm_user";
            $this->load->view($f);
          ?>
          <p>&nbsp;</p>
          <div class="modal_status">

          </div>
        </div>
        <div class="modal-footer">
          <div class="float-right">
            <button type="submit" class="btn btn-primary btnSave" form="userForm">
              Save
            </button>
            <button class="btn btn-danger" data-dismiss="modal">
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End of form modal -->
</section>
<script>
  $(function(){
      var $u = $("#man_user");
      var $page_status = $(".status");
      var user = (function(){

        var $numAllUser = getEl(".numAll");
        var $numActive = getEl(".numActive");
        var $numNotActive = getEl(".numNotActive");
        var $numBan = getEl(".numBan");

        //--- moderator cannot add user but he can edit
        $user_list = getEl(".user_list");
        $user_pagin = getEl(".user_pagin");

        //-------modal
        var $md = getEl(".md");
        var $mdTitle = getEl(".modal-title");
        var $modal_status = getEl(".modal_status");
        var btnSave = getEl(".btnSave");

        //---form
        var $f = getEl("#userForm");
        var u_id = getEl(".user_id");
        var u_name = getEl(".user_name");
        var u_email = getEl(".user_email");
        var u_tel = getEl(".user_tel");
        var u_active = getEl(".active");
        var u_ban = getEl(".ban");
        //------showUserLabel
        function showUserLabel(){
          var all = 0;
          var active = 0;
          var notActive = 0;
          var ban = 0;

          var url = "<?php echo site_url("users/modList");?>";
          $.ajax({
            url : url,
            success : function(e){
              var rs = $.parseJSON(e);
              //console.log(rs);
              all = rs.get_all.length;
              $.each(rs.get_all,function(i,v){
                if(parseInt(v.is_activated) !== 0){
                  active++;
                }else{
                  notActive++;
                }
                if(parseInt(v.is_ban) !== 0){
                  ban++;
                }
              });
              $numAllUser.html(all);
              $numActive.html(active);
              $numNotActive.html(notActive);
              $numBan.html(ban);
            }
          });
        }
        //------getList
        function getList(page=1){
          $user_list.html("");
          var url = "<?php echo site_url("users/modList/");?>"+page;
          $.ajax({
            url : url,
            success : function(e){
              var rs = $.parseJSON(e);
              $.each(rs.get_user,function(i,v){
                var banShow = `<span class="badge badge-success">No</span>`;
                if(parseInt(v.is_ban) !== 0){
                  banShow = `<span class="badge badge-danger">Yes</span>`;
                }
                var activeShow = `<span class="badge badge-success">Yes</span>`;
                if(parseInt(v.is_activated) === 0){
                  activeShow = `<span class="badge badge-danger">No</span>`;
                }

                var tmp = `
                <div class="card">
                  <div class="card-header">
                    <h1>${v.name}</h1>
                  </div>
                  <div class="card-body">

                    <p>&nbsp;</p>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                        <tr>
                          <th>Date</th>
                          <td>
                            Register : ${v.date_register}
                          </td>
                        </tr>
                        <tr>
                          <th>Status</th>
                          <td>
                          Actived : ${activeShow} &nbsp;
                          Ban : ${banShow}
                          </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="float-right">
                      <a style="color:white;" class="btn btn-primary btn-sm lnEdit" data-u_id="${v.id}">Edit</a>
                      <a style="color:white;" class="btn btn-danger btn-sm lnDel" data-u_id="${v.id}">Delete</a>
                    </div>
                  </div>
                </div>
                <p>&nbsp;</p>
                `;

                $user_list.append(tmp);

              });
              if(rs.pagination){
                $user_pagin.html(rs.pagination);
              }
            }
          });
        }
        //---------------------
        //-----modEditUser
        function modEditUser(id){
          $f.trigger("reset");
          $mdTitle.html("Loading...");
          var url = "<?php echo site_url("users/modEditUser/");?>"+id;
          $.ajax({
            url : url,
            success : function(e){
              var rs = $.parseJSON(e);
              $.each(rs.get,function(i,v){
                $mdTitle.html(`Editing ${v.name}...`);
                if(parseInt(v.is_ban) !== 0){
                  u_ban.prop("checked",true);
                }
                if(parseInt(v.is_activated) !== 0){
                  u_active.prop("checked",true);
                }
                u_id.val(v.id);
                u_name.val(v.name);
                u_email.val(v.email);
                u_tel.val(v.tel);
                btnSave.html("Update User");
                var msgShow = `<span class="alert alert-warning">Editing ${v.name}...`;
                $modal_status.html(msgShow).show();
              });
              $($md).modal("show");
            }
          });
        }
        //----------------------
        //------modSaveUser
        function modSaveUser(){
          btnSave.html("Change Saved!").unbind();
          $f.submit(function(e){
            e.preventDefault();
            var url = $(this).attr("action");
            var data = $(this).serialize();
            $.post(url,data,function(e){
              var rs = $.parseJSON(e);
              //console.log(rs);
              var msgShow = `<span class="alert alert-success">Change Success! you can close this window if you need.</span>`;
              $modal_status.html(msgShow).show();
              setTimeout(function(){
                modEditUser(rs.user_id);
                getSummary();
              },3000);
            });
          });
        }
        //--------------------
        //-------modDelUser
        function modDelUser(id){
          var msg = `you are about to delete ${id} this operation cannot be undo! \nAre you sure you want to DELETE?`;
          if(confirm(msg) === true){
            var url = "<?php echo site_url("users/modDelUser/");?>"+id;
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                var mShow = `DELETED : there are ${rs.last_num} user account in database.`;
                $page_status.html(mShow).show();
                setTimeout(function(){
                  $page_status.html("loading...").fadeOut("slow");
                  getSummary();
                },2000);
              }
            });
          }else{
            return false;
          }
        }
        //-----getSummary
        function getSummary(){
          showUserLabel();
          getList();
        }
        //------------------
        function getEl(el){
          return $u.find(el);
        }
        //------------------
        function getEvent(){
          getSummary();
          //--edit user
          $user_list.delegate(".lnEdit","click",function(){
            var id = $(this).attr("data-u_id");
            modEditUser(id);
          });

          //--delete user
          $user_list.delegate(".lnDel","click",function(){
            var id = $(this).attr("data-u_id");
            modDelUser(id);
          });

          //---pagination
          $user_pagin.delegate(".pagination a","click",function(e){
            e.preventDefault();
            var page = $(this).attr("data-ci-pagination-page");
            getList(page);
          });

          //---btnSave
          btnSave.on("click",function(){
            modSaveUser();
          });
        }
        return{getEvent:getEvent}
      })();
      user.getEvent();
  });
</script>

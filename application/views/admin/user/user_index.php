<section id="user">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <a class="btn btn-primary lnCreate">Create New user</a>
        </div>
        <h1 class="text-center">
          <?php echo $sysInfo;?>&nbsp;
          <span class="badge badge-success numAllUser">0</span> user(s).
        </h1>
        <p>Last update 23-july-2019 9:25 a.m.</p>
        <p>-set "required" for the new user form to prevent submit by accident</p>
      </div>
      <!--space-->
      <div class="col-lg-12">
        <p>&nbsp;</p>
      </div>
      <!--end space-->
      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 class="numAllUser" style="text-align:right;color:green;">0</h1>
        </div>
        <p>All Users</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-success">
          <h1 class="numActiveUser" style="text-align:right;color:blue;">0</h1>
        </div>
        <p>Actived User</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-warning">
          <h1 class="numModUser" style="text-align:right;color:red;">0</h1>
        </div>
        <p>Moderator</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-danger">
          <h1 class="numBanUser" style="text-align:right;color:red;">0</h1>
        </div>
        <p>Ban User</p>
      </div>
      <!--space-->
      <div class="col-lg-12">
        <p>&nbsp;</p>
      </div>
      <!--end space-->
      <!--list user -->
      <div class="col-lg-12">
        <p>&nbsp;</p>
        <div class="user_list">

        </div>
        <div class="user_pagin">

        </div>
      </div>
      <!--End list user -->

    </div>
  </div>
  <div class="modal fade mdUser">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">

          <h1 class="modal-title mdTitle">Create New user</h1>
          <button class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <?php
            $f = "admin/user/_frm_user";
            $this->load->view($f);
          ?>
          <div class="modal_status">

          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary btnSave" type="submit" form="frmUser">Save</button>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(function(){
    var $u = $("#user");
    var $page_status = $(".status");

    var user = (function(){
      //---html
      var lnCreate = $u.find(".lnCreate");
      var $numAllUser = $u.find(".numAllUser");
      var $numActiveUser = $u.find(".numActiveUser");
      var $numBanUser = $u.find(".numBanUser");
      var $numModUser = $u.find(".numModUser");

      var all = 0;
      var ban = 0;
      var mod = 0;
      var active = 0;

      //---user as list
      var $user_list = $u.find(".user_list");
      var $user_pagin = $u.find(".user_pagin");
      //---modal
      var $md = $u.find(".mdUser");
      var $mdTitle = $u.find(".mdTitle");
      var modal_status = $u.find(".modal_status");

      //----form edit users
      var $f = $u.find("#frmUser");
      var u_id = $u.find(".user_id");
      var u_name = $u.find(".user_name");
      var u_email = $u.find(".user_email");
      var u_tel = $u.find(".user_tel");
      var u_about = $u.find(".about_user");
      var aboutResult = $u.find(".aboutResult");
      var is_mod = $u.find(".user_mod");
      var is_active = $u.find(".user_active");
      var is_ban = $u.find(".user_ban");
      var btnSave = $u.find(".btnSave");

      //---about tmp
      var about_tmp = $u.find(".about_tmp");

      //-------getNumUser
      function getNumUser(){
        active = 0;
        mod = 0;
        ban = 0;
        var url = "<?php echo site_url("users/adminListUser");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            all = rs.get_all.length;

            $.each(rs.get_all,function(i,v){
              if(parseInt(v.is_activated) !== 0){
                active++;
              }
              if(parseInt(v.moderate) !== 0){
                mod++;
              }
              if(parseInt(v.is_ban) !== 0){
                  ban++;
              }


            });
            $numAllUser.html(all);
            $numActiveUser.html(active);
            $numModUser.html(mod);
            $numBanUser.html(ban);

          }
        });
      }
      //---------------
      //-------userListAll
      function userListAll(page=1){
        var url = "<?php echo site_url("users/adminListUser/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            //console.log(rs);
            //all = rs.get_all.length;
            $user_list.html("");
            $.each(rs.get_users,function(i,v){
              //console.log(v);
              var lb_ban = `<span class="badge badge-success">No</span>`;
              if(parseInt(v.is_ban) !== 0){
                lb_ban = `<span class="badge badge-danger">Yes</span>`;
              }
              var lb_mod = `<span class="badge badge-success">Yes</span>`;
              if(parseInt(v.moderate) === 0){
                lb_mod = `<span class="badge badge-danger">No</span>`;
              }


              var tmp = `
              <div class="card">
                <div class="card-header">
                  <h1 class="text-center">${v.name}</h1>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-4">
                      <p>${v.name}</p>
                      <p>${v.email}</p>
                      <p>in the future will be replace here with the user image</p>
                    </div>
                    <div class="col-lg-8">
                      <div class="table-resposive">
                        <table class="table table-bordered">
                          <tr>
                          <th>
                            Ban
                          </th>
                          <td>${lb_ban}</td>
                          </tr>
                          <tr>
                          <th>
                            Moderate
                          </th>
                          <td>${lb_mod}</td>
                          </tr>
                          <tr>
                          <th>
                            Date Register
                          </th>
                          <td>${v.date_register}&nbsp;
                          <strong>Update</strong> ${v.last_update}
                          </td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer">
                  <div class="float-right">
                    <a class="btn btn-primary btn-sm lnEdit" data-u_id="${v.id}">Edit</a>
                    <a class="btn btn-danger btn-sm lnDel" data-u_id="${v.id}">Delete</a>
                  </div>

                </div>
              </div>
              <p>&nbsp;</p>
              `;
              $user_list.append(tmp);
            });
            if(rs.pagination.length !== 0){
              $user_pagin.html(rs.pagination);
            }

          }
        });
      }

      //----------------------
      //--------showUserForm
      function showUserForm(cmd,id){
        $f.trigger("reset");
        aboutResult.html("");
        $mdTitle.html("");
        switch (cmd) {
          case "edit":
            //alert("will edit user "+id);
            var url = "<?php echo site_url("users/adminEditUser/");?>"+id;
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                console.log(rs);
                $.each(rs.get_user,function(i,v){
                  u_about.val(v.about_user);
                  u_id.val(v.id);
                  u_email.val(v.email);
                  u_tel.val(v.tel);
                  u_name.val(v.name);
                  $mdTitle.html(`Editing ${v.name}...`);
                  if(parseInt(v.is_activated) !== 0){
                    is_active.prop("checked",true);
                  }
                  if(parseInt(v.moderate) !== 0){
                    is_mod.prop("checked",true);
                  }
                  if(parseInt(v.is_ban) !== 0){
                    is_ban.prop("checked",true);
                  }
                });
                $($md).modal("show");
              }
            });
          break;
          default:
            $mdTitle.html(`Create New User`);
            $($md).modal("show");
          break;
        }
      }
      //------------
      //-----showAboutTemplate
      function showAboutTemplate(){
        var txt = `It is way more easier to use the template`;
        if(about_tmp.is(":checked")){
          txt = `<div class="container">
          <div class="row">
            <div class="col-lg-12">
              <h1 class="text-center">Your user Account is insecure!</h1>
            </div>
            <div class="col-lg-12">
              <h1 class="text-center">บัญชีของคุณไม่ปลอดภัย</h1>
            </div>
          </div>
          </div>`;
        }
        u_about.val(txt);
      }

      //---------------
      //-----showAboutResult
      function showAboutResult(){
        aboutResult.html(u_about.val());
      }
      //--------------
      //---saveUser
      function saveUser(){
        btnSave.unbind();
        $f.submit(function(o){
          o.preventDefault();
          var url = $(this).attr("action");
          var data = $(this).serialize();
          $.post(url,data,function(e){
            var rs = $.parseJSON(e);
            modal_status.html(rs.msg).show();
            setTimeout(function(){
              modal_status.html("loading...").fadeOut("slow");

              getSummary();
              $($md).modal("hide");
            },4000);
          });
        });
      }
      //-------------------
      //-----getSummary
      function getSummary(){
        userListAll();
        getNumUser();
      }
      //-----------------
      function getEvent(){
        //---getSummary
        getSummary();

        //---edit user
        $user_list.delegate(".lnEdit","click",function(){
          var id = $(this).attr("data-u_id");
          showUserForm("edit",id);
        });

        //---delete user
        $user_list.delegate(".lnDel","click",function(){
          var id = $(this).attr("data-u_id");
          alert("Delete user "+id);
        });
        //---pagination click action
        $user_pagin.delegate(".pagination a","click",function(e){
          e.preventDefault();
          var page = $(this).attr("data-ci-pagination-page");
          userListAll(page);
        });
        //---click action
        lnCreate.on("click",function(){
          showUserForm();
        });

        //---need about template
        about_tmp.on("change",function(){
          showAboutTemplate();
        });

        //---u_about on blur
        u_about.on("blur",function(){
          showAboutResult();
        });

        //---btnSave on click
        btnSave.on("click",function(){
          saveUser();
        });

      }
      return{getEvent:getEvent}
    })();

    user.getEvent();
  });
</script>

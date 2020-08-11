<!-- NO COPY START -->
<section id="noShowLive">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">
          System Info <?php echo $sysName;?>
        </h1>
        <p>"Moderate" section update 2-Aug-2019.</p>
        <p>&nbsp;</p>
        <div class="float-right">
          <p>
            <strong>
              <?php echo $sysName;?>
            </strong>&nbsp;
            <strong>
              version :
            </strong>
            <?php echo $sysVersion;?>&nbsp;
            <strong>
              Date On
            </strong>
            <?php echo $sysDate;?>
          </p>
        </div>

      </div>
      <div class="col-lg-6">
        <p>
          <strong>Moderate</strong> will be call "mod" from now on.
        </p>
        <ul>
          <li class="alert alert-success">
            mod can change his profile.
          </li>
        </ul>
      </div>
      <div class="col-lg-6">
        <p class="text-center">Moderate คือ ผู้ช่วยผู้ดูแลระบบ จากนี้ไปขอเรียกว่า "mod"</p>
        <ul>
          <li class="alert alert-success">
            mod สามารถแก้ไขข้อมูลของตัวเอง
          </li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- No COPY END -->

<p>&nbsp;</p>
<p>&nbsp;</p>
<section id="about_me">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="text-center">View Profile</h1>
      <div class="text-center">
        <a style="color:white;font-weight:bold;" class="btn btn-primary lnShowProfile btn-lg">view my profile</a>
      </div>
      <p>&nbsp;</p>
    </div>
    <div class="profile_wrap">
      <div class="row">
        <div class="col-lg-6">
          <div class="frmResult">

          </div>
        </div>
        <div class="col-lg-6">
          <?php
            $fr = "Mod/_frm_profile";
            $this->load->view($fr);
          ?>
        </div>

      </div>

    </div>
  </div>
</section>
<script>
  $(function(){
    var $m = $("#about_me");
    var $page_status = $(".status");

    var about = (function(){
      var $lnShowProfile = getEl(".lnShowProfile");
      var $profile_wrap = getEl(".profile_wrap");
      var $f = getEl("#myProfile");
      var mId = getEl(".mId");
      var mName = getEl(".mName");
      var mEmail = getEl(".mEmail");
      var mTel = getEl(".mTel");
      var mAbout = getEl(".about_user");
      var newPass = getEl(".newPass");
      var passConf = getEl(".passConf");

      var btnSave = getEl(".btnSave");


      var $res = getEl(".frmResult");


      //----- expandMe()
      function expandMe(open){

        var onMe = parseInt(open);
        var hP = $profile_wrap.is(":hidden");
        if(hP){
          onMe = 1;
          $lnShowProfile.html("Close");
        }else{
          onMe = 0;
          $lnShowProfile.html("view my profile");
        }
        $profile_wrap.slideToggle("slow");

      }
      //-----------------
      function getMyProfile(){
        $res.html("");
        var url = "<?php echo site_url("mod/editMyProfile/");?>";
        $.ajax({
          url: url,
          success : function(e){
            var rs = $.parseJSON(e);
            console.log(rs);
            $.each(rs.get,function(i,v){
              mName.val(v.name);
              mId.val(v.id);
              mEmail.val(v.email);
              mAbout.val(v.about_user);
              mTel.val(v.tel);
              var tmp = `
              <div class="card">
                <div class="card-header">
                  <h1 class="text-center">
                    Profile ${v.name}
                  </h1>
                </div>
                <div class="card-body">
                  ${v.about_user}
                  <p>&nbsp;</p>
                  <div class="table-resposive">
                    <table class="table table-bordered">
                      <tr>
                        <th>Name</th>
                        <td>${v.name}</td>
                      </tr>
                      <tr>
                        <th>Email</th>
                        <td>${v.email}</td>
                      </tr>
                      <tr>
                        <th>Tel</th>
                        <td>${v.tel}</td>
                      </tr>
                    </table>
                  </dtv>
                </div>
              </div>
              `;
              $res.append(tmp);
            });
          }

        });
      }
      //-------------
      function checkPass(){
        $page_status.html("");
        btnSave.html("Checking your password").prop("disabled",true);
        var url = "<?php echo site_url("mod/modCheckPass");?>";
        var data = {
          passConf : passConf.val()
        };
        $.post(url,data,function(e){
          var rs = $.parseJSON(e);
          var msg = '';
          if(parseInt(rs.match) === 0){
            //--wrong password
            msg = `Error : your password is incorrect!`;
            $page_status.html(msg).show();
            btnSave.html(`Wrong password!`);
          }else{
            //---password is match
            btnSave.html("Save Change").prop("disabled",false);
          }

          setTimeout(function(){
            $page_status.html("loading...").fadeOut("slow");
          },2000);

        });
      }
      //------------
      //---saveMyProfile
      function saveMyProfile(){
        btnSave.unbind();

      }
      //-----------------
      //----getSummary
      function getSummary(){
        getMyProfile();
        btnSave.html("ENTER confirm password!").prop("disabled",true);
      }
      //--------------
      function getEl(el){
        return $m.find(el);
      }
      //-----
      function getEvent(){
        //---hide the profile
        $profile_wrap.hide();

        //---when user click the "show" button view show the profile
        $lnShowProfile.on("click",function(){
          expandMe(1);
        });
        getSummary();

        //---check the password
        passConf.on("blur",function(){
          checkPass();
        });

        //---btnSave click
        btnSave.on("click",function(){
          saveMyProfile();
        });
      }
      return{getEvent:getEvent}
    })();
    about.getEvent();
  });
</script>

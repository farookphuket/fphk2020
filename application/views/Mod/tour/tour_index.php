<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="text-center">
        <?php echo $sysName;?>
      </h1>
      <p style="text-align:right;color:red;font-weight:bold;">
        version <?php echo $sysVersion;?> last update <?php echo $sysDate;?>
      </p>
      <ul>
        <li>
          <p class="alert alert-info">
            Update Moderate on 31-july-2019
          </p>
        </li>
      </ul>
    </div>
  </div>
</div>
<div class="col-lg-12">
  <p>&nbsp;</p>
  <p>&nbsp;</p>

</div>
<section id="tour">
  <div class="row">

    <div class="col-lg-4">
      <div class="alert alert-info">
        <h1 class="numAll" style="text-align:right;color:green;">0</h1>
      </div>
      <p class="text-right">All tour</p>
    </div>

    <div class="col-lg-4">
      <div class="alert alert-success">
        <h1 class="numOnSale" style="text-align:right;color:green;">0</h1>
      </div>
      <p class="text-right">tour on sale</p>
    </div>

    <div class="col-lg-4">
      <div class="alert alert-warning">
        <h1 class="numDraft" style="text-align:right;color:red;">0</h1>
      </div>
      <p class="text-right">Save As draft.</p>
    </div>

    <div class="col-lg-12">
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <div class="float-right">
        <a style="color:white;font-weight:bold;" class="btn btn-primary btn-lg lnCreate">Add New Tour</a>
        <p>&nbsp;</p>
      </div>

    </div>

    <div class="col-lg-12">
      <div class="tour_list">

      </div>
      <div class="tour_pagin">

      </div>
    </div>
  </div>

<div class="modal fade md">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title"></h1>
        <button class="close" data-dismiss="modal">
          <span class="badge badge-danger">
            &times;
          </span>
        </button>
      </div>
      <div class="modal-body">

        <?php
          $f = "Mod/tour/_tour_form";
          $this->load->view($f);
        ?>
        <p>&nbsp;</p>
        <div class="modal_status">

        </div>
      </div>
      <div class="modal-footer">
        <div class="float-right">
          <button type="submit" class="btn btn-primary btnSave" form="fTour">Save</button>
          <button  class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


</section>
<script>
  $(function(){
    var $t = $("#tour");
    var $page_status = $(".status");
    var tour = (function(){

      var $numOnSale = getEl(".numOnSale");
      var $numAllTour = getEl(".numAll");
      var $numDraft = getEl(".numDraft");

      //----tour list
      var $tour_list = getEl(".tour_list");
      var $tour_pagin = getEl(".tour_pagin");

      var lnCreate = getEl(".lnCreate");

      //----modal
      var $md = getEl(".md");
      var $mdTitle = getEl(".modal-title");
      var $modal_status = getEl(".modal_status");
      var btnSave = getEl(".btnSave");

      //----form
      var $f = getEl("#fTour");
      var $fResult = getEl(".tourResult");
      var t_id = getEl(".tour_id");

      var kw_id = getEl(".kw_id");
      var user_id = getEl(".user_id");
      var myId = "<?php echo $user_id;?>";

      var keyword = getEl(".keyword");
      var keydes = getEl(".keydes");
      var keyurl = getEl(".url");

      var input_title = getEl(".title");
      var sum = getEl(".sum");
      var body = getEl(".body");
      var draft = getEl(".draft");
      var full_price = getEl(".fullprice");
      var input_location = getEl(".location");
      var input_duration = getEl(".duration");



      //-------
      function showTourLabel(){
        var onSale = 0;
        var allTour = 0;
        var onDraft = 0;
        var url = "<?php echo site_url("tour/modList");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            $.each(rs.get_all,function(i,v){
              //console.log(v);
              if(parseInt(v.mark_draft) === 0){
                onSale++;
              }else{
                onDraft++;
              }
            });
            allTour = rs.get_all.length;
            $numAllTour.html(allTour);
            $numOnSale.html(onSale);
            $numDraft.html(onDraft);
          }
        });
      }
      //---------------
      //-------getList -------
      function getList(page=1){
        $tour_list.html("");
        var url = "<?php echo site_url("tour/modList/");?>"+page;
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            $.each(rs.get_tour,function(i,v){

              var onSale = `<span class="badge badge-success">Yes</span>`;
              if(parseInt(v.mark_draft)!== 0){
                onSale = `<span class="badge badge-danger">No</span>`;
              }
              var tmp = `<div class="card">
                <div class="card-header">
                  <h1 class="text-center">${v.t_name}</h1>
                </div>
                <div class="card-body">
                  ${v.t_summary}
                  <p>&nbsp;</p>
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tr>
                        <th>Tour Name</th>
                        <td>${v.t_name}</td>
                      </tr>
                      <tr>
                        <th>Price</th>
                        <td>${v.full_price}</td>
                      </tr>
                      <tr>
                        <th>Destination</th>
                        <td>${v.t_destination}</td>
                      </tr>
                      <tr>
                        <th>Duration</th>
                        <td>${v.t_duration}</td>
                      </tr>
                      <tr>
                        <th>On Sale</th>
                        <td>${onSale}</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                  <div class="float-right">
                    <button class="btn btn-primary btn-sm lnEdit" data-t_id="${v.t_id}">
                      Edit
                    </button>
                    <button class="btn btn-danger btn-sm lnDel" data-t_id="${v.t_id}">
                      Delete
                    </button>
                  </div>
                </div>
              </div>
              <p>&nbsp;</p>
              `;
              $tour_list.append(tmp);
            });

          }
        });
      }
      //--------------
      //---showForm
      function showForm(cmd,id){
        $modal_status.html("");
        tinymce.activeEditor.setMode("design");
        $f.trigger("reset");
        switch(cmd){
          case"edit":

            var url = "<?php echo site_url("tour/modEdit/");?>"+id;
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                $.each(rs.get,function(i,v){
                  //console.log(v);
                  var mTitle = `Editing ${v.t_name}...`;
                  $mdTitle.html(mTitle);
                  var df = parseInt(v.mark_draft);
                  draft.val(df);
                  input_title.val(v.t_name);
                  keyurl.val(v.og_url);
                  keyword.val(v.kw_page_keyword);
                  keydes.val(v.kw_page_des);
                  sum.val(v.t_summary);
                  tinymce.activeEditor.setContent(v.t_program);
                  full_price.val(v.full_price);
                  input_location.val(v.t_destination);
                  input_duration.val(v.t_duration);

                  user_id.val(v.id);
                  t_id.val(v.t_id);
                  kw_id.val(v.kw_id);
                  var showM = `<span class="alert alert-warning">Editing ${v.t_name}...
                  `;
                  $modal_status.html(showM).show();
                });
              }
            });
          break;
          default:
            var title = "Add New Tour | เพิ่มทัวร์ใหม่";
            $mdTitle.html(title);
            user_id.val(myId);
            t_id.val(0);
            var showM = `<span class="alert alert-info">
            Creating mode...
            </span>
            `;
            $modal_status.html(showM).show();
          break;
        }

        $($md).modal("show");
      }
      //------------
      //---firstSave
      function firstSave(){
        var id = t_id.val();
        var num = input_title.val().length;
        var old = input_title.val();
        if(parseInt(id) !== 0){
          //console.log(`not zero the id is ${id}`);
          //showForm("edit",id);
          return false;
        }else{
          //-- check if he type 10 letters before save
          if(parseInt(num) > 10){
            console.log(`you have type ${input_title.val()} ready`);
            var url = "<?php echo site_url("tour/modFirstSave");?>";
            var data = {title : input_title.val()};
            $.post(url,data,function(e){
              var rs = $.parseJSON(e);
              var id = rs.t_id;
              var key = rs.kw_id;
              showForm("edit",id);
            });
          }else{
            //---another code
            //---add this msg to form in 4 millisecond.
            var needMore = `${old} ++please edit me! I want more than 10 letters!++`;
            setTimeout(function(){
              input_title.val(needMore).focus();
            },4000);
          }
        }
      }
      //----------------
      //---modSave
      function modSave(){
        btnSave.unbind();
        $f.submit(function(e){
          e.preventDefault();
          var data = $(this).serialize();
          var url = $(this).attr("action");
          $.post(url,data,function(e){
            var rs = $.parseJSON(e);
            var msgShow = `<span class="alert alert-success">
            Success : your change have been save.
            </span>`;
            $modal_status.html(msgShow).show();
            setTimeout(function(){
              getSummary();
              showForm("edit",rs.t_id);
            },4000);
          });
        });
      }
      //----------------
      //-----modDel
      function modDel(cmd,id){
        var url = "<?php echo site_url("tour/modDel/");?>"+id;
        switch(cmd){
          case"delete":
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                $page_status.html(rs.msg).show();
                setTimeout(function(){
                  $page_status.html("loading...").fadeOut("slow");
                  getSummary();
                },2000);
              }
            });
          break;
          default:
            var conf = `You are about to delete ${id}`;
            if(confirm(conf) === true){
              modDel("delete",id);
            }else{
              return false;
            }
          break;
        }
      }


      //------------
      //----getSummary
      function getSummary(){
        showTourLabel();
        getList();
      }
      //--- getEl
      function getEl(el){
        return $t.find(el);
      }

      //------
      function getEvent(){
        getSummary();

        //---create
        lnCreate.on("click",function(){
          showForm();
        });

        //--title blur
        input_title.on("blur",function(){
          firstSave();
        });
        //--edit tour
        $tour_list.delegate(".lnEdit","click",function(){
          var id = $(this).attr("data-t_id");
          showForm("edit",id);
        });

        //--delete tour
        $tour_list.delegate(".lnDel","click",function(){
          var id = $(this).attr("data-t_id");
          modDel(null,id);
        });

        //---btn save click
        btnSave.on("click",function(){
          modSave();
        });
      }
      return{getEvent:getEvent}
    })();
    tour.getEvent();
  });
</script>

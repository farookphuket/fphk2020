<script>



$(function(){

  var $el = $(".container");
  var page_status = $el.find(".status");
  var modal_status = $el.find(".modal_status");

  var product = (function(){

    var pd_cat = $el.find(".pd_cat");
    var pd_section = $el.find(".pd_section");
    var cat_id = $el.find(".cat_id");
    var btnSaveCat = $el.find(".btnSaveCat");

    var show_cat_list = $el.find("#cat_list");
    var lnViewCat = $el.find(".lnViewCat");
    var lnEditCat = $el.find(".lnEditCat");

    //get the button for product
    var show_product_list = $el.find(".product_list");

    //the modal product
    var frm_product_show = $el.find(".frm_product_show");
    var mdProduct = $el.find(".mdProduct");
    var pd_id = $el.find(".pd_id");
    var pd_title = $el.find(".pd_title");
    var pd_body = $el.find(".pd_body");
    var sel_cat = $el.find(".sel_cat");
    var btnSaveP = $el.find(".btnSaveP");
    var btnCancel = $el.find(".btnCancel");

  //the modal confirm
  var mdConfirm = $el.find(".mdConfirm");
  var btnDelP = $el.find(".btnDelP");

    var url = "<?php echo site_url("product/admin_product_api");?>";

    function getCatData(){
      var data = {
        pd_cat :pd_cat.val(),
        pd_section : pd_section.val()
      };
      return data;
    }

    function addCat(catData){
      // var c_title =  " "+
      //                       "<li>"+
      //                           catData.cat_id+
      //                           "<button data-id=' "+catData.cat_id+"'  type='button'  class='label label-info lnEditCat'>Edit</button> "
      //                       +"</li>";

      var c_title = catData.cat_title;
      var c_id = catData.cat_id;
      var btnShow = "<button class='label label-default lnViewCat' data-id='"+c_id+"'>"+c_title+"</button>";
      var btnEdit = "<button class='label label-info lnEditCat' data-id='"+c_id+"'>Edit</button>";
      var btnDel = "<button class='label label-danger lnDelCat' data-id='"+c_id+"'>Delete</button>";
      var tmp =  ""+"<li>"+btnShow+btnEdit+btnDel+"</li>";
      $("#cat_list").append(tmp);
    }
    function getCatList(){
      var url = "<?php echo site_url("product/admin_api");?>";
      var data = {
        command : "get_cat_list"
      };
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          //alert(e);
          var rs = $.parseJSON(e);
          $.each(rs.get_cat,function(i,v){

            //use this addCat method to run
            addCat(v);
          });
        }
      });
    }

    function viewCatDetail(id){
      //alert("The category to view is "+id);
      $(".product_list").empty();
      var url = "<?php echo site_url("product/admin_api");?>";
      var data = {
        cat_id : id,
        command : "get_cat"
      };
        $.ajax({
          type : "post",
          url : url,
          data : data,
          success : function(e){
            var rs = $.parseJSON(e);
            console.log(rs);
            if(parseInt(rs.num_p) === 0){
              $(".product_list").append("There are no data in this category!");
            }
            $.each(rs.get_p,function(i,v){

                addProduct(v);
            });
          }
        });
    }
    function editCat(id){
      $(".btnSaveCat").unbind("click");
      var c_id = id;
      var data = {
        cat_id : c_id,
        command : "edit_cat"
      };
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          var rs = $.parseJSON(e);
        //  console.log("data",rs);
          $.each(rs.get_cat,function(i,v){
            $(".frm_cat_title").html("Edit "+v.cat_title);
            pd_cat.val(v.cat_title);
            pd_section.val(v.cat_section);
            btnSaveCat.html("Update")
                              .on("click",function(){
                                saveCat("update",v.cat_id);
                              });
          });
        }
      });

    }

    function saveCat(c,v){

      var data = getCatData();

      switch(c){
        case"add":
          data.command = "add_cat";

          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              var rs = $.parseJSON(e);
              //console.log(rs);
              $.each(rs.get_cat,function(i,v){
                addCat(v);
              });
              //addCat(rs);
            }
          });
        break;
        case"update":
          btnSaveCat.html("processing...")
                          .prop("disabled",true);
            data.cat_id = v;
            data.command = "update_cat";
            $.ajax({
              type : "post",
              url : url,
              data : data,
              success : function(e){
                //alert(e);
                btnSaveCat.html("Success!");
                var rs = $.parseJSON(e);
                if(parseInt(rs.error) === 1){
                  page_status.html(rs.msg).fadeIn("slow");

                }else{
                  page_status.html(rs.msg).fadeIn("slow");


                }
                setTimeout(function(){
                  location.reload();
                },4000);
              }
            });
        break;
      }
    }
    function delCat(c,v){

      //console.log(c);
      btnDelP.unbind();
      var data = {
        cat_id : v
      };
      switch(c){
        case"del_conf":
          data.command = "cat_del_conf";

                        //just incse the page no reload
                        //empty the .modal-body .modal-title
                        $(".modal-title").empty();
                        $(".conf_msg").empty();
                        $(".pd_title").empty();

                        //remove the button that create by jQuery
                        $(".bCancel").remove();
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){


              var bCancel = "<button class='btn btn-default bCancel'>Cancel</button>";
              var rs = $.parseJSON(e);
              var num_pd = 0;
              var c_id = "";
              $.each(rs.get_pd,function(i,v){
                num_pd++;

                  $(".pd_title").append("<li>[<b>"+num_pd+"</b>] "+v.pd_title+"</li>");
              });
              var num_cat = 0;
              $.each(rs.get_cat,function(i,v){
                  c_id = v.cat_id;
                  cat_id.val(c_id);
                var b = ""+"<div class='row'><div class='alert alert-danger'><p>The category  <b>["+v.cat_title+"]</b> whitch has "+num_pd+" items. of it content will be delete </p><p>This operation cannot be UNDO ! Are you sure to delete  "+v.cat_title+" ?</p>The cat id is "+v.cat_id+"</div></div>";
                $(".conf_msg").append(b);
                $(".modal-title").append("Confirm to DELETE "+v.cat_title+" ?");
              });


              $(".modal-footer").delegate('.bCancel','click',function(){
                location.reload();
              });
              $(".btnDelP").addClass("btn-danger")
              .html("Yes, I know");
              btnDelP.on("click",function(){
                delCat("delete_cat",c_id);
              });
              $(".modal-footer").append(bCancel);
              $(mdConfirm).modal("show");
            }
          });
        break;
        case"delete_cat":
            data.cat_id = cat_id.val();
            data.command = "delete_cat"
            $.ajax({
              type : "post",
              data : data,
              url : url,
              success : function(e){
                alert(e);
                setTimeout(function(){location.reload();},2000);
              }
            });
        break;
      }
    }



    function frm_product(id=false){
      $(".show_product_detail").empty();
      tinymce.activeEditor.setMode("design");

      if(id){
        modal_status.html("Edit mode is ready ,if there is any change click 'Update ' button to save change").show();
        var p_title = id.pd_title;
        var p_body = id.pd_body;
        var tmp = ""+"<div class='page-header'><h2>"+p_title+"</h2></div><pre>"+p_body+"</pre>";
        $(".show_product_detail").append(tmp);
        $(".modal-title").html("edit "+id.pd_title);
        sel_cat.val(id.cat_id);
        pd_title.val(id.pd_title);
        pd_body.val(tinymce.activeEditor.setContent(id.pd_body));
        pd_id.val(id.pd_id);

        btnSaveP.html("Update Product")
        .on("click",function(){
          saveProduct("update",id.pd_id);
        });
        btnCancel.html("Close");
      }else{
        $(".show_product_detail").empty();
        $(".modal-title").html("Add new product");
        pd_title.val("");
        sel_cat.val(0);
        tinymce.activeEditor.setContent("");
        btnSaveP.html("Create New Product")
        .on("click",function(){
          saveProduct("add");
        });
      }


      $(mdProduct).modal("show");
    }
    function getProductCat(v){
      //console.log("cat this is "+v.val());
      //alert("id is "+v);
      var c_id = v;
      sel_cat.val(v);
      return c_id;
    }
    function getProductData(){
      var data = {
        pd_title : pd_title.val(),
        pd_body : pd_body.val(),
        cat_id : sel_cat.val()
      };
      return data;
    }
    function viewProuct(id){
      btnSaveP.unbind();
      btnSaveP.html("Update Product");
      var data = {
        pd_id : id,
        command : "get_product"
      };
      $.ajax({
        type : "post",
        url : url,
        data : data,
        success : function(e){
          var rs = $.parseJSON(e);
          $.each(rs.get_product,function(i,v){
            frm_product(v);
          });
        }
      });
    }
    function addProduct(v){
        var p_title = v.pd_title;
        var p_id = v.pd_id;
        var cat_id = v.cat_id;
        var cr_date = ""+"<span class='label label-warning'>Create "+v.date_add+"</span>";
        var btnEditP = ""+"<button class='label label-info lnEditP' data-id='"+p_id+"'>"+p_title+"</button>";
        var btnDelP = ""+"<button class='label label-danger lnDelP' data-id='"+p_id+"'>Delete</button>";

        var tmp = ""+"<li>"+btnEditP+btnDelP+cr_date+"</li>";

        $(".product_list").append(tmp);
    }
    function saveProduct(c,v=false){

      var data = getProductData();
      switch(c){
        case"add":
          data.command = "add_product";
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              var rs = $.parseJSON(e);
              modal_status.html("Data has been create").show();
              $.each(rs.get_product,function(i,v){
                  frm_product(v);
              });
            }
          });
        break;
        case"update":
          // alert("The update product is "+v);
          $(".show_product_detail").empty();
          $(".btnCancel").removeClass("btn-default")
          .addClass("btn-danger");
          data.command = "update_product";
          data.pd_id = v;
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              var rs = $.parseJSON(e);
              modal_status.html("Data has been UPDATE ,please click 'Close' button to close this dialog").show();
              $.each(rs.get_product,function(i,v){
                  frm_product(v);
              });
            }
          });

        break;
      }
    }

    function delProduct(c,v){

      var data = {
        pd_id : v
      };
      switch(c){
        case"del_conf":
            data.command = "get_product";
            $.ajax({
              type : "post",
              data : data,
              url : url,
              success : function(e){
                //alert(e);
                //show the dialog to confirm delete
                var rs = $.parseJSON(e);
                $.each(rs.get_product,function(i,v){
                  modalConfirm("product_del",v);
                });
              }
            });
        break;
        case"delete":
          data.command = "product_del";
          data.pd_id = v.pd_id;
          $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
              //alert(e);
              var rs = $.parseJSON(e);
              modal_status.html(rs.msg).show();
              setTimeout(function(){
                location.reload();
              },2000);
            }
          })

        break;
      }
    }



    function modalConfirm(c,v){
      var btnCancel = "<button class='btn btn-default btnCancel' type='button'>Cancel</button>";
      btnDelP.unbind();
      $(".modal-body").empty();
      $(".modal-title").empty();
      $(".btnCancel").remove();
      //$(".modal-footer").empty();
      switch (c) {

        case "product_del":
        console.log(v);
        var title = "<h2>Confirm delete "+v.pd_title+" ?</h2>";
        var body = ""+"<div class='page-header'><span class='alert alert-danger'>You are about to DELETE "+v.pd_title+" ! ,This operation is cannot be UNDO</span></div><div class='row'><pre>"+v.pd_body+"</pre></div>";
          var tmp = ""+"<div>"+body+"</div>";
          pd_id.val(v.pd_id);
          cat_id.val(v.cat_id);
          var del = {
            pd_id : v.pd_id,
            cat_id : v.cat_id
          };
            $(".modal-title").append(title);
            $(".modal-body").append(tmp);
            $(".btnDelP").addClass("btn-danger")
            .html("Yes, I want to delete this");
            btnDelP.on("click",function(){
              delProduct("delete",del);
            });
            //$(".modal-footer").append(btnDelP);
            $('.modal-footer').delegate('.btnCancel',"click",function(){
              location.reload();}
            );
            $(".modal-footer").append(btnCancel);
            $(mdConfirm).modal("show");
          break;
        default:

      }
    }
    function getEvent(){

      getCatList();
      btnSaveCat.on("click",function(){
        saveCat("add");
      });

      show_cat_list.delegate('.lnEditCat',"click",function(){
        var c_id = $(this).attr("data-id");
          editCat(c_id);
      });
      show_cat_list.delegate('.lnViewCat','click',function(){
        var c_id = $(this).attr("data-id");
        viewCatDetail(c_id);
      });
      show_cat_list.delegate('.lnDelCat','click',function(){
        var c_id = $(this).attr("data-id");
        delCat("del_conf",c_id);
      });

      frm_product_show.on("click",function(){
        frm_product();
      });
      sel_cat.on("change",function(){
        getProductCat($(this).val());
      });
      btnCancel.on("click",function(){location.reload();});

      //show product list and it button
      show_product_list.delegate('.lnEditP','click',function(){
        var p_id = $(this).attr("data-id");
        viewProuct(p_id);
      });
      show_product_list.delegate('.lnDelP','click',function(){
        var p_id = $(this).attr("data-id");
        delProduct("del_conf",p_id);
      });
    }//end of getEvent
    return{getEvent : getEvent}
  })();
  product.getEvent();



/*
  var show_cat_list = $("#cat_list");
  $.ajax({
    url : "<?php //echo site_url("product/admin_api");?>",
    success : function(e){
      //alert(e);
      var rs = $.parseJSON(e);
      //console.log(rs);
      $.each(rs.get_cat,function(i,v){
        show_cat_list.append("<li>"+v.cat_title+"<button class='btnEdit' data-id='"+v.cat_id+"'>Edit</button></li>");
        //console.log("cat id is "+v.cat_id);
      });
    }

  });
  show_cat_list.delegate('.btnEdit','click',function(){
    var id = $(this).attr("data-id");
    alert("id is "+id);
  });

  */

});
</script>

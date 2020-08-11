
<?php
//this file will be include in cat_index.php
//create on Thu-3-Aug-2017
//
?>
<script>

    $(function(){


        var $el = $(".container");
        var modal_status = $el.find(".modal_status");
        var page_status = $el.find(".status");
        var category = (function(){

            var modalCat = $el.find(".modalCat");
            var cat_title = $el.find(".cat_title");
            var cat_section = $el.find(".cat_section");

            var cat_change = $el.find(".cat_change");
            var cat_pub = $el.find(".cat_pub");
            var pub_txt = $el.find(".pub_txt");
            var change_txt = $el.find(".change_txt");
            pub_txt.prop("disabled",true);
            change_txt.prop("disabled",true);

            var cat_id = $el.find(".cat_id");

            var btnAddCat = $el.find(".btnAddCat");
            var btnEditCat = $el.find(".btnEditCat");
            var btnDelCat = $el.find(".btnDelCat");


            var btnSaveCat = $el.find(".btnSaveCat");
            btnSaveCat.html("process form fill")
            .prop("disabled",true);
            var btnCancle = $el.find(".btnCancle");


            var modalConf = $el.find(".modalConf");
            var btnOK = $el.find(".btnOK");
            var url = "<?php echo site_url("admin/category");?>";

            function getData(){
                var data = {
                    cat_title : cat_title.val(),
                    cat_section : cat_section.val(),
                    cat_pub : setCatOption("public",cat_pub),
                    cat_change : setCatOption("allow",cat_change)
                };
                return data;
            }


            function setCatOption(c,v=false){
                var st = 0;
                var p_txt = "Private";
                var ch_txt = "NOT ALLOW";
                if(v.prop("checked")){
                    st = 1;
                }

                switch(c){
                    case"public":
                        var p = 0;
                        if(parseInt(st) === 1){

                            p_txt = "Public";
                            p = 1;
                        }
                        pub_txt.val(p_txt);
                        console.log("p is "+p);
                        return parseInt(p);
                    break;
                    case"allow":
                        var a = 0;
                        if(parseInt(st) === 1){
                            ch_txt  = "ALLOW";
                            a = 1;
                        }
                        change_txt.val(ch_txt);
                        console.log("allow is "+a);
                        return parseInt(a);
                    break;

                }
            }
            function catForm(c,v){
                var data = getData();
                data.cat_id = v;
                switch(c){
                    case"edit":

                        data.command = "edit";
                        $.ajax({
                            type :"post",
                            url : url,
                            data : data,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                cat_title.val(rs.cat_title);
                                cat_section.val(rs.cat_section);
                                cat_id.val(rs.cat_id);

                                var p_txt = "Private";
                                var ch_txt = "NOT ALLOW";


                                if(parseInt(rs.cat_pub) === 1){
                                    p_txt = "Public";
                                    cat_pub.prop("checked",true);
                                }
                                pub_txt.val(p_txt);

                                if(parseInt(rs.cat_change) === 1){
                                    ch_txt = "ALLOW EDIT";
                                    cat_change.prop("checked",true);
                                }
                                change_txt.val(ch_txt);

                                btnSaveCat.html("Update Data")
                                    .on("click",function(){
                                    saveCat("update",rs.cat_id);
                                })
                                .prop("disabled",false);
                                $(modalCat).modal("show");
                            }
                        });

                    break;
                    default:
                        $(modalCat).modal("show");
                        setTimeout(function(){cat_title.focus();},2000);
                        btnSaveCat.on("click",function(){
                            saveCat();
                        });
                    break;
                }
            }
            function check(c,v){

                switch(c){
                    case"title":
                        var t = "Please enter the Title";
                        if(!v || v.length < 4){
                            modal_status.html("Please enter the Title").show();

                            setTimeout(function(){
                                cat_title.attr("placeholder",t);
                                cat_title.focus();
                                modal_status.fadeOut("slow");
                            },2000);
                        }else{
                            return true;
                        }
                    break;
                    case"section":
                        var sect = "Please Enter the section";
                        if(!v || v.length < 4){
                            modal_status.html("Please enter the SECTION").show();

                            setTimeout(function(){
                                cat_section.attr("placeholder",sect);
                                cat_section.focus();
                                modal_status.fadeOut("slow");
                            },2000);
                        }else{
                            btnSaveCat.html("Save Data")
                            .prop("disabled",false);
                            return true;
                        }
                    break;
                }
            }
            function saveCat(c,v){
                var data = getData();
                btnSaveCat.html("processing...")
                .prop("disabled",true);
                data.cat_id = v;
                //data.cat_pub = setCatOption("public",cat_pub);
                //data.cat_change = setCatOption("allow",cat_change);



                switch(c){
                    case"update":
                        data.command = "update";
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                //alert(e);
                                btnSaveCat.html("Done!");

                                var rs = $.parseJSON(e);
                                if(parseInt(rs.error) === 1){
                                  alert(rs.msg+" !");

                                }else{
                                  modal_status.html(rs.msg).show();

                                }
                                setTimeout(function(){
                                  location.reload();
                                },4000);
                            }
                        });


                    break;
                    default:

                        data.command = "add";
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                if(parseInt(rs.error) === 1){
                                    modal_status.html(rs.msg).show();
                                    btnCancle.html("Error : code 1");

                                }else{
                                    modal_status.html(rs.msg).show();
                                    btnSaveCat.html("Success");

                                }
                                setTimeout(function(){
                                    modal_status.fadeOut("slow");
                                    location.reload();
                                },2000);
                            }

                        });
                    break;


                }


            }//end saveCat
            function delCat(c,v){

                var data = getData();
                data.cat_id = v;

                switch(c){
                    case"confirm":
                        data.command = "del_conf";
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                $(".modal-title").html(rs.title);
                                $(".conf_result").html(rs.body);
                                $(modalConf).modal("show");
                                //console.log("body is "+rs.get_ar);
                                $.each(rs.get_ar,function(i,v){
                                    //console.log("ar title is "+v.ar_title);
                                    var ar_title = "<li>"+v.ar_title+"</li>";
                                    $(".ar_show").append(ar_title);
                                });
                                btnOK.on("click",function(){
                                    delCat("delete",rs.cat_id);
                                });

                            }
                        });

                    break;
                    case"delete":
                        data.command = "delete";
                        btnOK.html("processing...")
                            .prop("disabled",true);
                        btnCancle.prop("disabled",true);
                        $.ajax({
                            type : "post",
                            data : data,
                            url : url,
                            success : function(e){
                                //alert(e);
                                var rs = $.parseJSON(e);
                                if(parseInt(rs.error) === 1){
                                    modal_status.html(rs.msg).show();
                                }else{
                                    $(".ar_show").slideToggle();
                                    setTimeout(function(){
                                        $(".conf_result").html(rs.msg)
                                        .fadeIn("slow");
                                        btnOK.html("Success!");
                                        btnCancle.html("Close")
                                            .prop("disabled",false);
                                        $(".modal-title").html("The operation has been complete successfully!").fadeIn("slow");
                                    },4000);
                                }
                            }
                        });
                    break;
                }
            }//end of delCat
            function getEvent(){

                btnAddCat.on("click",function(){
                    catForm();
                });
                btnCancle.on("click",function(){
                    location.reload();
                });
                btnEditCat.on("click",function(){
                    catForm("edit",$(this).attr("id"));
                });
                cat_pub.on("change",function(){
                    setCatOption("public",$(this));
                });
                cat_change.on("change",function(){
                    setCatOption("allow",$(this));
                });

                cat_title.on("blur",function(){
                    check("title",$(this).val());
                });

                cat_section.on("blur",function(){
                    check("section",$(this).val());
                });
                btnDelCat.on("click",function(){
                    delCat("confirm",$(this).attr("id"));
                });

            }
           return{getEvent : getEvent}
        })();
        category.getEvent();
    });
</script>

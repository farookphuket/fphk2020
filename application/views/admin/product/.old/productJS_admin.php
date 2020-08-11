<script>

    //using jQuery
    $(function(){
        var $el = $(".container");
        var page_status = $el.find(".status");
        var modal_status = $el.find(".modal_status");
        
        var Template = function(){
            this.__construct = function(){
                
            };
            this.category = function(obj){
                var output = "";
                output += "<div class='panel panel-info' data-cat_id='"+obj.cat_id+"'>";
                output += '<div class="panel-heading">';
                output += obj.cat_title;
                output += " <span> has "+obj.cat_has_content+" item(s).</span>";
                output += "<p><span>";
                output += '<button class="label label-danger pull-right lnDelCat" data-del_id="'+obj.cat_id+'">Delete';
                output += "</button>";
                output += '<button class="label label-primary pull-right lnEditCat" data-edit_id="'+obj.cat_id+'">Edit';
                output += "</button>";
                output += '<button class="label label-info pull-right lnViewCat" data-view_id="'+obj.cat_id+'">View';
                output += "</button>";
                output += "</span></p>";
                output += "</div>";
                output += "<div class='panel-body'>";
                output += obj.cat_des;
                
                output += "</div>";
                output += "</div>";
                return output;
            };
            
            this.pd_list = function(obj){
                var output = "";
                
                output += "<div class='panel panel-info'>";
                output += "<div class='panel-heading'>";
                output += obj.pd_title;
                //adding button
                output += "<p>";
                output += "<span class='pull-right'>";
                output += "<button class='btn btn-info btn-sm lnEditP' data-edit_id="+obj.pd_id+">";
                output += "<span class='glyphicon glyphicon-edit'></span> Edit";
                output += "</button>";
                output += "</span>";
                output += "<span class='pull-right'>";
                output += "<button class='btn btn-danger btn-sm lnDelP' data-del_id='"+obj.pd_id+"'>";
                output += "<span class='glyphicon glyphicon-trash'></span> Delete";
                output += "</button>";
                output += "</span>";
                output += "</p>";
                //---end of button
                output += "</div>";
                output += "<div class='panel-body'>";
                output += obj.pd_body;
                output += "</div>";
                output += "</div>";
                return output;
            }

            this.modal_conf = function(obj){
                var output = "";
                output += "<div class='panel panel-warning'>";
                output += "<div class='panel-heading'>";
                output +=   obj.pd_title;
                output += "</div>";
                output += "<div class='panel-body'>";
                output +=  obj.pd_body;
                output += "</div>";
                output += "</div>";

                return output;
            }
            this.__construct();
        };
        
        var manProduct = (function(){
        
            Template = new Template();
            var frmCat = $el.find("#pCatFrm");
            var catTitle = $el.find(".pdCat-title");
            catTitle.attr("placeholder","45 letters maximum!");
            var btnCat = $el.find(".btnCat");
            var cat_id = $el.find(".cat_id");
            var catDes = $el.find(".pdCat-des");
            catDes.attr("placeholder","just for the reminder!");
            var cat_list = $el.find(".pcat-list");
            var pd_list = $el.find(".pd-list");

            var btnClose = $el.find('.btnClose');
            var btnCancle = $el.find('.btnCancle');
            
            var frmProduct = $el.find(".frmProduct");
            var pdForm = $el.find("#productFrm");
            var sel_cat = $el.find(".sel_cat");
            var pd_id = $el.find(".pd_id");
            var pd_title = $el.find(".pd-title");
            var pd_body = $el.find(".pd-body");
            var lnAddP = $el.find(".lnAddP");
            var btnSaveP = $el.find('.btnSaveP');
            
            var modalConf = $el.find('#modalConf');
            var btnConf = $el.find('.btnConf');
            //-----------------------------------
            function getCatList(){
                cat_list.empty();
                var url = "<?php echo site_url("product/getCat");?>";
                $.ajax({
                    type : "get",
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs);
                        if(rs.num_cat !== 0){
                            $.each(rs.get_cat,function(i,v){
                               // console.log(v);
                                cat_list.append(Template.category(v));
                            });
                        }else{
                            var tmp = "<span class='alert alert-danger'>There is no Data</span>";
                            cat_list.append(tmp);
                        }
                        
                    }
                });
                
            }
            //------------------------------
            
            function viewCat(c_id){
                //alert("the id is "+c_id);
                pd_list.empty();
                var url = "<?php echo site_url("product/getCat");?>/"+c_id;
                $.ajax({
                    type : "get",
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs.get_cat);
                        $.each(rs.get_p,function(i,v){
                            pd_list.append(Template.pd_list(v));
                        });
                        
                    }
                });
            }
            //---------------------------function 
            function editCat(c_id){
                btnCat.unbind();
                var url = "<?php echo site_url("product/getCat");?>/"+c_id;
                var data = {
                    cat_id : c_id
                    
                };
                $.ajax({
                   type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs);
                        $.each(rs.get_cat,function(i,v){
                            catTitle.val(v.cat_title);
                            catDes.val(v.cat_des);
                            cat_id.val(v.cat_id);
                            btnCat.html("Update")
                            .on('click',function(){
                                saveCat();
                            });
                        });
                    }
                });
            }
            
            //------------------------------------
            function saveCat(){
                //alert("Data has been save! page is reloading...");
                
                btnCat.unbind();
                
                cat_list.empty();
                frmCat.submit(function(evt){
                    evt.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        //clear the form
                        frmCat.trigger("reset");
                        
                        //show the list of category
                        getCatList();
                    },'json');
                });

                //-----Wed 20 Sep 2017
                /*
                // there is no a better way than to reload page
                //the page will be reload in 4 second
                */
                setTimeout(function(){
                    location.reload();
                },4000);
            }
            //--------------------------
            function delCat(cmd,c_id){
                
                switch(cmd){
                    case"conf":
                        //show dialog box to confirm delete
                        //alert('the del cat id is '+c_id);
                        //modalConf.empty();
                        var url = "<?php echo site_url('product/getCat');?>/"+c_id;
                        $.ajax({
                            type : "get",
                            url : url,
                            success : function(e){
                                //console.log(e);
                                var rs = $.parseJSON(e);
                                var cat_id = 0;
                                var num_product = parseInt(rs.num_p);
                                //console.log('num p is '+num_product);
                                var conf = 'There are '+num_product+' item(s) will be delete';
                                //console.log(rs);
                                
                                $.each(rs.get_cat,function(i,v){
                                    cat_id = v.cat_id;
                                });
                                btnConf.addClass('btn-danger')
                                .on('click',function(){
                                    delCat('del',cat_id);
                                });

                                if(num_product !== 0){
                                    //show the product list to confirm delete
                                    $('.modal-title').append(conf);
                                    
                                    $.each(rs.get_p,function(i,v){
                                        var output = "";
                                        output = Template.modal_conf(v);
                                        $('.modal-body').append(output);
                                        
                                        $(modalConf).modal('show');
                                    });
                                   
                                }else{
                                    //there is no product in this category
                                    //no need to ask for the confirm!
                                    
                                    $.each(rs.get_cat,function(i,v){
                                        cat_id = v.cat_id;
                                        //console.log('cat id is '+cat_id);
                                        delCat('del',cat_id);
                                    });
                                }
                            }
                        });
                    break;
                    case"del":
                        //delete the category
                        //alert('cat to del '+c_id);
                        var url = "<?php echo site_url("product/product_admin_api/del_cat");?>/"+c_id;
                        var data = {cat_id : c_id};
                        $.ajax({
                            type : "post",
                            url : url,
                            data : data,
                            success : function(e){
                                //console.log(e);
                                getCatList();
                            }
                        });
                    break;
                }
                //
            }
            //-------------------
            function showFrmP(id=false){
                //the form will be show in modal
                $(frmProduct).modal("show");
                tinymce.activeEditor.setMode('design');
            }
            //----function editProduct
            function editProduct(id){
                //console.log('edit this '+id);
                var url = "<?php echo site_url('product/getProduct');?>/"+id;
                $.ajax({
                    type : "get",
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs.get_p);
                        $.each(rs.get_p,function(i,v){
                            //console.log('v.pd_id is '+v.pd_id);
                            pd_id.val(v.pd_id);
                            sel_cat.val(v.cat_id);
                            pd_title.val(v.pd_title);
                            tinymce.activeEditor.setMode("design");
                            tinymce.activeEditor.setContent(v.pd_body);
                            btnSaveP.html("Update");
                            $(".modal-title").html('editing..'+v.pd_title);
                            $(frmProduct).modal("show");
                            
                        });
                    }
                });
            }
            //---function saveProduct
            function saveProduct(){
                //the submit button has been click
                btnSaveP.unbind();
                pdForm.submit(function(evt){
                    evt.preventDefault();
                    var url = $(this).attr('action');
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        //console.log(e);
                        editProduct(e.pd_id);
                        getCatList();
                        viewCat(e.cat_id);
                    },'json');
                });
                
            }
            //------------function delP delete the product
            function delP(id){
                
                var url = "<?php echo site_url("product/product_admin_api/del_p/");?>/"+id;
               //console.log("url is "+url);
                $.ajax({
                    type : "get",
                    url : url,
                    success : function(e){
                        //delete the product from the current category;
                        var rs = $.parseJSON(e);
                        $.each(rs.get_cat,function(i,v){
                            getCatList();
                            viewCat(v.cat_id);
                            
                        });
                        
                    }
                });

            }
            //--------------------
            function getEvent(){
                btnCat.on("click",function(){
                    saveCat();
                });
                getCatList();
                
                cat_list.delegate('.lnEditCat','click',function(){
                    var cat_id = $(this).attr("data-edit_id");
                    editCat(cat_id);
                });
                //----------------
                cat_list.delegate('.lnViewCat','click',function(){
                    var cat_id = $(this).attr("data-view_id");
                    viewCat(cat_id);
                });
                //-----------------------
                cat_list.delegate('.lnDelCat','click',function(){
                    var cat_id = $(this).attr("data-del_id");
                    //console.log('to send is '+cat_id);
                    delCat('conf',cat_id);
                });
                //--------------------------------
                
                lnAddP.on("click",function(){
                    showFrmP();
                });
                btnSaveP.on("click",function(){
                    saveProduct();
                });
                pd_list.delegate('.lnEditP','click',function(){
                    var p_id = $(this).attr("data-edit_id");
                    editProduct(p_id);
                });
                pd_list.delegate('.lnDelP','click',function(){
                    var p_id = $(this).attr("data-del_id");
                    delP(p_id);
                });

                btnClose.on('click',function(){
                    location.reload();
                });
                btnCancle.on('click',function(){
                    location.reload();
                });
            }
            //-------------------------
            return{getEvent : getEvent}
        })();
        
        manProduct.getEvent();
        
    });
</script>
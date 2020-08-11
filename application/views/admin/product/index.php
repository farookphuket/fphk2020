<section id="product">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h1 class="text-center">
                        <?php echo $sysName; ?>
                        </h1>
                        <div class="float-right">
                            <p>
                            Version <?php echo $sysVersion; ?>
                                                            system date : 
                                <span class="alert alert-warning">
            <?php 

                echo $sysDate;
            ?>
                                </span>
                            </p>


                </div>

                    </div>
                    <div class="card-body">
                        <p>
                            The uri text <?php echo $uri_text; ?>
                        </p>
                        <ul>
                            <li>
                                <p>
                                    last update on laptop 29-Feb-2020 
                                </p>
                            </li>
                            <li>
                                <p>add template system to form</p>
                            </li>
<li>
                                <p>
                                Create admin panel 21-Feb-2020 2:34 p.m.
                                </p>
                            </li>

                        </ul>

         
                    </div>
                </div>
                

                

                <p class="pt-5">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <div class="float-right">
                    <a  class="btn btn-lg btn-primary lnCreate" style="color:white;font-weight:bold;">Add Product</a>
                </div>
            </div>
            <div class="col-lg-12">
                <p>&nbsp;</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-success">
                    <h1 class="numAll" style="color:blue;text-align:right;">0</h1>

                </div>
                <p style="text-align:right;color:green;">All product</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-info">
                    <h1 class="numSale" style="color:blue;text-align:right;">0</h1>

                </div>
                <p style="text-align:right;color:green;">product on sale</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-danger">
                    <h1 class="notSale" style="color:red;text-align:right;">0</h1>

                </div>
                <p style="text-align:right;color:green;">product MUTE</p>
            </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
            </div>

            <div class="col-lg-12">
                <div class="p_list"></div>
                <div class="p_pagin"></div>
            </div>
        </div>
    </div>



    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">

                    </h1>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <?php
                        $f = "admin/product/_frm_product";
                        $this->load->view($f);
                    ?>
                    <p class="pt-4">&nbsp;</p>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button class="btn btn-primary btnSave" type="submit" form="sProduct">Save</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
<script>

    /*
        *   Create script on 21-Feb-2020 
        *   admin script
        *
     */

$(function(){
    const $P = $("#product");
    const $page_status = $(".status");

    const $pd = (function(){

        //--- on page
        let lnCreate = getEl(".lnCreate");
        let $numAll = getEl(".numAll");
        let $numSale = getEl(".numSale");
        let $notSale = getEl(".notSale");
        let $pd_list = getEl(".p_list");
        let $pd_pagin = getEl(".p_pagin");

        //--- the modal
        let $md = getEl(".md");
        let $mdTitle = getEl(".modal-title");
        let btnSave = getEl(".btnSave");
        let $modal_status = getEl(".modal_status");
        let $fResult = getEl(".fResult");


        //---   The form
        let $frm = getEl("#sProduct");

        //--- The hidden field
        let kw_id = getEl(".kw_id");
        let pd_id = getEl(".p_id");
        let cat_id = getEl(".cat_id");

        //--- last add 29-Feb-2020
        //--- @coffe shop
        let set_tmp = getEl(".set_tmp");
        let tmp_id  = getEl(".tmp_id");
        //--- use cookie to get the current page after reload page
        let page = 1;
        page  = Cookies.get("page");


        let pd_user_id = getEl(".pd_user_id");
        let my_id = "<?php echo $user_id; ?>";
        let app_uri = "<?php echo $uri_text; ?>";

        //--- seo
        let og_url = getEl(".og_url");
        let keyword = getEl(".keyword");
        let keydes = getEl(".keydes");

        //---   product
        let p_name = getEl(".p_name");
        let p_sum = getEl(".p_sum");
        let p_body = getEl(".p_body");
        let p_price = getEl(".p_price");
        let p_sale = getEl(".onSale");

        function showLabel(){
            let url = "<?php echo site_url("product/adminList"); ?>";
            $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);

                        let num_all = rs.get_all.length;
                        let num_sale = 0;
                        let num_mute = 0;


                    $.each(rs.get_all,(i,v)=>{
                            num_sale++;
                        if(parseInt(v.pd_public) === 0){
                            num_mute++;
                            
                        } 
                        num_sale = num_all-num_mute;
                        });

                        $numAll.html(num_all);
                        $numSale.html(num_sale);
                        $notSale.html(num_mute);


            }
            });
        }
        //---------------------
        //---   productList
        function productList(p=1){
            $pd_list.html("");

            checkPageLocation(p);
            let url = "<?php echo site_url("product/adminList/") ?>"+p;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                if(rs.get_all.length !== 0){
                    //console.log(rs);
                    if(rs.pagination){
                        $pd_pagin.html(rs.pagination);
                    }
                    $.each(rs.get_p,(i,v)=>{

                    let yes = `<p class="badge badge-success">Yes</p>`;
                    let no = `<p class="badge badge-danger">No</p>`;
                    let onSale = yes;
                    if(parseInt(v.pd_public) === 0){
                        onSale = no;
                    }

                    let tmp = `<div class="card">
    <div class="card-header">
        <h1 class="text-center">
            ${v.pd_title}
        </h1>
        <p>${v.cat_section}</p>
    </div>
    <div class="card-body">
        ${v.pd_summary}
        <p class="pt-4">&nbsp;</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>Post by</th>
                    <td>
                        ${v.name} >> ${v.email}
                    </td>
                </tr>
                <tr>
                    <th>Post Date</th>
                    <td>
                        <p>Create : ${v.pd_date_create}
                        | Update : ${v.pd_date_update}</p>
                    </td>
                </tr>
                <tr>
                    <th>On sale</th>
                    <td>
                        ${onSale}
                    </td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>
                        ${v.cat_section} >> ${v.cat_title}
                    </td>
                </tr>
                 <tr>
                    <th>price</th>
                    <td>
                        ${v.pd_price} 
                    </td>
                </tr>


<!--
                    <tr>
                    <th>Category</th>
                    <td>
                        ${v.cat_section} >> ${v.cat_title}
                    </td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>
                        ${v.cat_section} >> ${v.cat_title}
                    </td>
                </tr>
  --> 



            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-pd_id="${v.pd_id}">Edit</button>
            <button class="btn btn-danger lnDel" data-pd_id="${v.pd_uniq_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-3">&nbsp;</p>`;
                       $pd_list.append(tmp); 
                    });
                }
            }
            }); 
        }
        //-----------------------
        //---   checkPageLocation
        function checkPageLocation(p){
            if(!p || p === 'undefined'){
                p = page;
            }
            console.log(`will go to page ${p}`);
        }
        //---   showForm
        function showForm(cmd,id){

           $frm.trigger("reset"); 
           $mdTitle.html("Create new Product");

            switch(cmd){
            case"edit":
                let url = "<?php echo site_url("product/adminEdit/"); ?>"+id;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        console.log(rs);
                        $.each(rs.get,(i,v)=>{
                            kw_id.val(v.kw_id);
                            pd_id.val(v.pd_id);
                            pd_user_id.val(v.pd_user_id);
                            cat_id.val(v.cat_id);
                            
                            set_tmp.val(v.tmp_id).prop("disabled",true);
                            og_url.val(v.og_url);
                            keyword.val(v.kw_page_keyword);
                            keydes.val(v.kw_page_des);

                            p_name.val(v.pd_title);
                            tinymce.get("p_sum").setContent(v.pd_summary);
                            tinymce.get("p_body").setContent(v.pd_body);
                            if(parseInt(v.pd_public) !== 0){
                                p_sale.prop("checked",true);                    
                            }
                            
                            p_price.val(v.pd_price);

                            $mdTitle.html(`Editing ${v.pd_title}...`);
                            $modal_status.html(`Editing ${v.pd_title}...`);
                        });
                }
                });
            break;
            default:
                
            setTimeout(()=>{
                
                cat_id.focus();            
                pd_id.val(0);
                og_url.attr("placeholder","No need to fill anything");
                p_name.attr("placeholder","Enter title");
                $modal_status.html("");
 

            },500);


                
            break;
            }
            $($md).modal("show");
        }
        //-------------------
        //---   setTemplate
        function setTemplate(){
            let id = set_tmp.val();
            let url = "<?php echo site_url("template/adminEdit/"); ?>"+id;
            $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    $.each(rs.get,(i,v)=>{
                        tinymce.get("p_sum").setContent(v.tmp_des);
                        tinymce.get("p_body").setContent(v.tmp_body);
                    });
            }
            });
            


        }


        //---   productSave
        function productSave(){
            btnSave.unbind();
            $frm.submit(function(e){
                e.preventDefault();
                //alert("submit");
                let url = $(this).attr("action");
                let data = $(this).serialize()+"&action_code="+my_id+"&app_uri="+app_uri;
                $.post(url,data,function(e){
                    let rs = $.parseJSON(e);
                    $modal_status.html(rs.msg).show();
                    setTimeout(()=>{
                        getSummary();
                        showForm("edit",rs.pd_id);
                    },450);
                });

            });
        }
        //------------------
        //---   productDel
        function productDel(id){
            let url = "<?php echo site_url("product/adminDel/"); ?>"+id;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                //console.log(rs);
                $page_status.html(rs.msg).show();
                setTimeout(()=>{
                    $page_status.html("Loading...").fadeOut("slow");
                    getSummary();
                },450);
            }
            });
        }

        //-------------------
        function getSummary(){
            showLabel();
            if(!page || page === 'undefined'){
                page = 1;
            }
            productList(page);
        }
        function getEl(el){
            return $P.find(el);
        }
        function getEvent(){
            getSummary();
            //--- lnCreate
            lnCreate.on("click",function(){
                showForm();
            });

            //--- edit
            $pd_list.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-pd_id");
                showForm("edit",id);
            });
            //------------
            //--- delete
            $pd_list.delegate(".lnDel","click",function(){
                let id = $(this).attr("data-pd_id");
                productDel(id);
            });
            //----------------
            //---   cat_id on blur
            cat_id.on("blur",function(){
                
                id = $(this).val();
                cat_id.val(id);
                //console.log(`the cat select is ${id}`);
            });
            //---   pagination
            $pd_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let page_lo = $(this).attr("data-ci-pagination-page");
                page = Cookies.set("page",page_lo);
                productList(page_lo);
            });
            //--- product save
            btnSave.on("click",function(){
                productSave();
            });


            //--- set_tmp
            set_tmp.on("change",function(){
                setTemplate();
            });


        }
        return{getEvent:getEvent}
    })();
    $pd.getEvent();
});
</script>

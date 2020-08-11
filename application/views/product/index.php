<section id="product">
  <div class="container">
  <div class="row">
    <div class="col-lg-12">
        <h1 class="text-center">Product category</h1>
            <p class="pt-3">&nbsp;</p>            
            <ul class="nav nav-pills flex-column">
<?php
        if($get_cat):
            //var_dump($get_cat);
            $cat_title = "";
            $cat_section = "";
            $cat_id = "";
            foreach($get_cat as $row):
                $cat_title = $row->cat_title;
                $cat_section = $row->cat_section;
                $cat_id = $row->cat_id;
?>

    <li class="nav-item">
        <p>
            <input type="hidden" name="cat_section" id="cat_section" class="cat_section">
            <input type="hidden" name="cat_id" id="cat_id" class="cat_id">

        <a style="color:blue;" class="nav-link lnViewCat" data-cat_id="<?php echo $row->cat_id; ?>" data-cat_section="<?php echo $row->cat_section; ?>" href="#">
        <?php echo"{$cat_section} >> {$cat_title} >> {$row->cat_des}"; ?>
            </a>
            
        </p>
    </li>


<?php
                endforeach;
            endif;
?>
                
                </ul>
            </div>
            
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
                <div class="text-center">
                    <button class="btn btn-primary lnClearCookie">Show All Product</button>
                </div>
                <p class="pt-4">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <div class="pd_list">
                    
                </div>
                <div class="pd_pagin">
                    
                </div>
            </div>

  </div>
  
  </div>


</section>
<script charset="utf-8">
    $(function(){
        const $P = $("#product");
        const $pr = (function(){

            let $pd_list = getEl(".pd_list");
            let $pd_pagin = getEl(".pd_pagin");
            let $lnClearCookie = getEl(".lnClearCookie");
            

            //--- use cookie for the page info
            let cat_id = getEl(".cat_id");
            let cat_section = getEl(".cat_section");

            //--- we need the current url just to delete the cookie
            let home_url = "<?php echo site_url(); ?>";
            let cur_url = "<?php echo current_url(); ?>";
            
            let cookie_product_cat_id = Cookies.get("cookie_product_cat_id");
            let cookie_product_cat_section = Cookies.get("cookie_product_cat_section");
            let product_cookie_url = Cookies.get("product_cookie_url");

            let page = 1;
            page = Cookies.get("page");

             
            


            //--- lnViewCat
            let lnViewCat = getEl(".lnViewCat");

            
            //---   getProductList 
            function getProductList(p=1){
                $pd_list.html("");

                if(page){
                    p = page;
                }

                let url = "<?php echo site_url("product/getProductList/"); ?>"+p;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        //console.log(rs);
                        $.each(rs.get_p,(i,v)=>{
                            
                             let tmp = `<div class="card">
    <div class="card-header">
        <h1 class="text-center">
            ${v.pd_title}
        </h1>
        <div class="float-right">
        <p class="">
            ${v.cat_section} >> ${v.cat_des}
        </p>
        </div>
    </div>
    <div class="card-body">
       ${v.pd_summary} 
    </div>
    <div class="card-footer">
        <div class="float-right">
            <a class="btn btn-primary lnRead" data-pd_id="${v.pd_uniq_id}">
                See More
            </a>
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`;

                    $pd_list.append(tmp);

                        });
                       
                }
                });
            }
            //-----------------
            //---   showByCat
            function showByCat(p=1){
                $pd_list.html("");

                if(page){
                    p = page;
                }

                
                
                let data = {
                    cookie_product_cat_id : cookie_product_cat_id
                };
                
                let url = "<?php echo site_url("product/getByCat/") ?>"+p;

                if(!product_cookie_url || product_cookie_url === 'undefined'){
                    Cookies.set("product_cookie_url",url);
                }else{
                    url = product_cookie_url;
                }
                $.ajax({
                type : "post",
                data : data,
                url : url,
                success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get,(i,v)=>{
                        
                        let tmp = `<div class="card">
    <div class="card-header">
        <h1>${v.pd_title}</h1>
        <p>by ${v.name} | section ${v.cat_section}</p>
    </div>
    <div class="card-body">
       ${v.pd_summary} 
    </div>
    <div class="card-footer">
        <div class="float-right">
            <a class="btn btn-primary lnRead" data-pd_id="${v.pd_uniq_id}">
                See More
            </a>
        </div>
    </div>

</div><p class="pt-2">&nbsp;</p>`;
                        $pd_list.append(tmp);
                    });
                    
                    $lnClearCookie.show();
                }
                });
                

               
            }
            //---   productRead
            function productRead(id){
                let url = "<?php echo site_url("product/detail/"); ?>"+id;
               window.open(url,"_blank"); 
            }
            //------------------
            function getSummary(){
                if(!product_cookie_url || product_cookie_url === 'undefined'){
                    //console.log(`There is no product_cookie_url getSummary`);
                    getProductList(page);
                }else{
                    //console.log(`The ck_uri is ${product_cookie_url} cat id is ${cookie_product_cat_id} | getSummary`);
                    showByCat(page);

                }

                
            }

            function getEl(el){
                return $P.find(el);

            }
            function getEvent(){
                getSummary();    
                $lnClearCookie.hide();
                $pd_list.delegate(".lnRead","click",function(){
                    let id = $(this).attr("data-pd_id");
                    productRead(id);
                });

                //--- view by category
                lnViewCat.on("click",function(e){
                    e.preventDefault();
                    let id = $(this).attr("data-cat_id");
                    let section = $(this).attr("data-cat_section");

                    if(parseInt(cookie_product_cat_id) !== parseInt(id)){
                        Cookies.set("cookie_product_cat_id",id);
                        Cookies.set("cookie_product_cat_section",section);
                        //console.log(`The cookie just set | the go to page is ${id}`);
                        cat_id.val(id);
                        setTimeout(()=>{
                        location.reload();
                        },450);
                    }else{
                        cat_id.val(id);
                        //console.log(`The cookie is ${cookie_product_cat_id} go to page is ${id}`);
                    }

                    showByCat(page);

                });

                $lnClearCookie.on("click",function(){

                    let lsCookies = Cookies.get();
                    Cookies.remove("product_cookie_url");
                    Cookies.remove("cookie_product_cat_id");
                    Cookies.remove("cookie_product_cat_section");

                    setTimeout(()=>{
                        location.reload();
                    },400);                   


                });


            }
            //--------------
            return{getEvent:getEvent}
        })();
        $pr.getEvent();
    }); 
</script>

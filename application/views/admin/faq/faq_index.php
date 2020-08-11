<div class="col-lg-12">
    <h1 class="text-center">
<?php echo"{$sysName} version {$sysVersion}"; ?>
</h1>
    <p><?php echo"Date on {$sysDate}"; ?></p>
    <p>
        <strong>
            Last 
        </strong>
        update on 19-Mar-2020
    </p>
    <ul>
        <li>- edit input from user remove the script tag from the js code 18-Feb-2020 6:50 p.m.</li>
        <li>Change Javascript to ES6 style(14-Dec-2019)</li>
        <li>Remove file "_layout_admin.php"</li>
        <li>Edit admin faq</li>
        <li>add "send email notice to user" once he have done his post.</li>
        <li>- user must confirm he is the real user by sent confirmation link into his email 13-Feb-2020</li>
    </ul>
</div>
<p>&nbsp;</p>
<section id="faq_admin">
    <div class="container">
        <div class="row">
            
            <!-- faq label start -->
            <div class="col-lg-4">
                <div class="alert alert-info">
                    <h1 style="text-align:right;color:blue;" class="numAll">0</h1>
                </div>
                <p class="text-right">All Faq</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-success">
                    <h1 style="text-align:right;color:blue;" class="numShow">0</h1>
                </div>
                <p class="text-right">Show on page</p>
            </div>
            <div class="col-lg-4">
                <div class="alert alert-danger">
                    <h1 style="text-align:right;color:red;" class="numNotShow">0</h1>
                </div>
                <p class="text-right">Not show on page</p>
            </div>


            <!-- end of show faq label --> 
            <div class="col-lg-12">
                <p>&nbsp;</p>
                
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">Faq List
                <span class="badge badge-info numAll">
                0
                </span> item(s).
                </h1>
                <p class="pt-4">&nbsp;</p>
                <div class="faq_list">
                </div>
                <div class="faq_pagin"></div>
            </div>
        </div>
    </div>

    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title mdTitle">
                        Reply F.A.Q
                    </h1>
                </div>
                <div class="modal-body">
                    <?php 
                        $f = "admin/faq/_frm_faq_edit";
                        $this->load->view($f);
                    ?>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btnSave" type="submit" form="replyFaq">Save</button>
                    <button class="btn btn-danger btnClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

</section>
<script>

/*
    * F.A.Q admin  last edit 19-Mar-2020
    *
    */
$(function(){

    const $FAQ = (function(){

        //-- page_status
        $page_status = getEl(".status");
        //--- the label on page
        let $num_all = getEl(".numAll");
        let $num_show = getEl(".numShow");
        let $num_notshow = getEl(".numNotShow");

        let $faq_list = getEl(".faq_list");
        let $faq_pagin = getEl(".faq_pagin");

        //-- for cookies page
        let ck_faq_page = Cookies.get("ck_faq_page");

        let $md  = getEl(".md");
        let $mdTitle = getEl(".modal-title");
        let $modal_status = getEl(".modal_status");
        let $frm = getEl("#replyFaq");
        let faq_title = getEl(".faq_title");
        let faq_id = getEl(".faq_id");
        let faq_email = getEl(".faq_email");
        let faq_body = getEl(".faq_body");
        let jdt1 = new Jodit(".faq_body");
        let is_show = getEl(".is_show");
        let btnSave = getEl(".btnSave");

        function faqGetList(ck_faq_page){
            $faq_list.html("");
            if(ck_faq_page === undefined){
                ck_faq_page = 1;
            }
            let  url = "<?php echo site_url("faq/faqAdminGet/"); ?>"+ck_faq_page;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                console.log(rs);

                let all_faq = rs.get.length;
                $num_all.html(all_faq);


                let faq_show = 0;
                let faq_not_show = 0;

                $.each(rs.get,(i,v)=>{
                    if(parseInt(v.faq_is_show) !== 0){
                        faq_show++;
                    }else{
                        faq_not_show = all_faq-faq_show;
                    }

                });

                    //console.log(`not show is ${faq_not_show} faq show is ${faq_show}`);
                    $num_show.html(faq_show);
                    $num_notshow.html(faq_not_show);
                //--- show as list
                $.each(rs.get_faq,(i,v)=>{

                    let yes = `<span class="alert alert-success">Yes</span>`;
                    let no  = `<span class="alert alert-danger">No</span>`;
                    
                    let faq_show = no;
                    if(parseInt(v.faq_is_show) !== 0){
                        faq_show = yes;
                    }                    
                    let tmp = `<div class="card">
    <div class="card-header">
        <h1 class="text-center">${v.faq_title}</h1>
        <div class="float-right">
            <p>By : ${v.faq_name}  | 
            Date : ${v.faq_date_create}</p>
        </div>
    </div>
    <div class="card-body">
        ${v.faq_body}
        <p class="pt-3">&nbsp;</p>
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>show</th>
                    <td>${faq_show}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-faq_id="${v.faq_id}">Reply</button>

            <button class="btn btn-danger lnDel" data-faq_id="${v.faq_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-3">&nbsp;</p>`;

                $faq_list.append(tmp);
                });
                    if(rs.pagination){
                        $faq_pagin.html(rs.pagination);
                    }
            }
            });

        }

        //----
        //----- faqReply
        function faqReply(id){
            $frm.trigger("reset");
            btnSave.html("loading...");
            $modal_status.html("");
            let url = "<?php echo site_url("faq/faqAdminEdit/"); ?>"+id;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                console.log(rs);
                $.each(rs.get,(i,v)=>{
                    faq_id.val(v.faq_id);
                    faq_email.val(v.faq_email);
                    faq_title.val(v.faq_title);
                    jdt1.value = v.faq_body;
                    btnSave.html("Update")
                        .prop("disabled",false);
                    $mdTitle.html(`Reply to ${v.faq_name}`);
                    if(parseInt(v.faq_is_show) !== 0){
                        is_show.prop("checked",true);
                    }
                });
                $($md).modal("show");
            }
            });
        }

        //-----
        //--- faqSave
        function faqSave(){

            btnSave.html('Saving...').unbind();
            $frm.submit(function(e){
                e.preventDefault();
                let url = $(this).attr('action');
                let data = $(this).serialize();
                $.post(url,data,function(e){
                    //alert(e);
                    let rs = $.parseJSON(e);
                    $modal_status.html(rs.msg);
                    btnSave.html('success').prop("disabled",false);
                    setTimeout(()=>{
                        btnSave.html("loading...");
                        getSummary();
                        faqReply(rs.faq_id);
                    },1200);


                });
            }); 
            

        }
        //---------
        //---- faqDel
        function faqDel(id){
            let url = "<?php echo site_url("faq/faqAdminDel/"); ?>"+id;

            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                console.log(rs);
                $page_status.html(rs.msg).show();
                setTimeout(()=>{
                    $page_status.html("loading...").fadeOut("slow");
                    getSummary();
                },2000);
            }
            });
        }
        //-----------
        function getSummary(){
            faqGetList(ck_faq_page);
        }

        function getEl(el){
            return $(el);
        }
        function getEvent(){
            getSummary();
            $faq_list.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-faq_id");
                faqReply(id);
            });

            //------
            $faq_list.delegate(".lnDel","click",function(){
                let id = $(this).attr("data-faq_id");
                faqDel(id);
            });


            btnSave.on("click",function(){
                faqSave();
            });
            //--- pagination
            $faq_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let page = $(this).attr("data-ci-pagination-page");
                if(page === undefined){
                    page = 1;
                }
                Cookies.set("ck_faq_page",page);
                faqGetList(page);

            });
        }
        return{getEvent:getEvent}
    })();
    $FAQ.getEvent();
});


</script>

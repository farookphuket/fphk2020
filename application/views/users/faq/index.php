<section id="faq_user">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">
                            <?php echo $sysName; ?>
                        </h2>
                        <div class="float-right">
                        <p>System Date <?php echo $sysDate; ?></p>
                        </div>
                    </div>
                    <div class="card-body">
                        
                    </div>
                    <div class="card-footer">
                        <p>&nbsp;</p>
                    </div>
                    
                </div>
                
                <p class="pt-2">&nbsp;</p>
            </div>
<!-- List user faq from another -->
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Title</th>
                            <th>Reply By</th>
                            <th>Date</th>
                        </tr>
                        <tbody class="faq_list">

                        </tbody>
                        
                        <tr class="faq_pagin">

                        </tr>                        
                    </table>
                </div>
<?php
    $u_email = "unknow";
    $u_name = "unknow";
    if($get_user):
        //var_dump($get_user);
        foreach($get_user as $row):
            $u_email = $row->faq_email;
            $u_name = $row->faq_name;
        endforeach;
    endif;
?>
                <p class="pt-3">&nbsp;</p>
            </div>
<!-- end of other faq -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-warning">
                        <h2 class="text-center">Create New F.A.Q.</h2>
                    </div>
                    <div class="card-body">
<?php
    $frm = "users/faq/_frm_user_faq";
    $this->load->view($frm);
?>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                        <button class="btn btn-primary btnSave" type="submit" form="frmFaq">Sent by <?php echo $user_name; ?></button>
                        
                        </div>
                        <p>you will receive the email from us in your mail box as you given {<?php echo $user_email; ?>}<br /> if this is not your email please let us know!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">view</h1>
                    <button  class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="md_show_faq">
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script charset="utf-8">
    $(function(){
        const $FAQ = (function(){

            let $page_status = getEl(".status");

            let my_id = "<?php echo $user_id; ?>";
            let my_name = "<?php echo $user_name; ?>";
            let my_email = "<?php echo $user_email; ?>";
            let default_msg = `<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="text-center">dear ${my_name}</h1>
            <p>
                <strong>Please Note :</strong>
                &nbsp;your message will not be appear on the page please click the confirm link that sent to your email ${my_email} in 30 minute.
                |<br /> 
THAI >> ข้อความของท่านยังจะไม่เผยแพร่จนกว่าจะได้รับการตรวจสอบจากเจ้าหน้าที่ 
            </p>
            <p>you can replace you message here before you start to type in please feel free to delete this message.|<br />
 THAI >> ท่านสามารถลบหรือแทนที่ข้อความเหล่านี้ได้           
</p>
            <p style="color:blue;text-align:center;">
            we will sent you a confirmation link via ${my_email} please make sure you click the link that you have receive in your mailbox. |<br />THAI >> ทางเราจะส่งลิ้งค์สำหรับการยืนยันไปทางอีเมลที่ท่านได้สมัครไว้กับเวปนี้ โปรดคลิกลิ้งภายใน 30 นาทีเพื่อยืนยัน
            </p>
            <p class="pt-3">&nbsp;</p>
        </div>
        <div class="col-lg-4">
            <img src="https://lh3.googleusercontent.com/yO98MLaMvX6MJWMhKThc4vPaHSs4h7cizNlKtuqvEkl-BaC4YjuvK9QB79ZSFoLbueTdSiboWZ062NGQXHmp4CHFcOGNOz6hKq5yAJ1BCc9TWd8j7BMLw9KZlZLSqIHQvLvhAqQhUi8=w2400" class="responsive" />
            <p class="text-center">You can replace your photo here click on photo <br />ต้องการเปลี่ยนรูป คลิกที่รูป->คลิกที่รูปปากกา</p>
        </div>
        <div class="col-lg-8">
            <h2 class="text-center">To change the photo</h2>
            <p>simply click on the photo then paste your new photo url to replace in it url.</p>
        </div>
    </div>
</div>`;
            let $jdt1 = new Jodit("#faq_body",{"height":500});
            $jdt1.value = `${default_msg}`;

            let ck_faq_page = Cookies.get("ck_faq_page");


            //--- place
            let $faq_list = getEl(".faq_list");
            let $faq_pagin = getEl(".faq_pagin");

            //--- the modal
            let $md = getEl(".md");
            let $mdTitle = getEl(".modal-title");
            let $mdShowFaq = getEl(".md_show_faq");

            //-- the form element
            let $frm = getEl("#frmFaq");
            let faq_title = getEl(".faq_title");
            let faq_body = getEl(".faq_body");
            let faq_id = getEl(".faq_id");
            let faq_user_id = getEl(".faq_user_id");
            let btnSave = getEl(".btnSave");

            if(ck_faq_page === undefined){
                ck_faq_page = 1;
            }
            function faqGetMyFaqList(ck_faq_page){
                if(ck_faq_page === undefined){
                    ck_faq_page = 1;
                }
                let url = "<?php echo site_url("faq/faqUserGetList/") ?>"+ck_faq_page;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    let tmp = `
    <td colspan=3>
        <div class="alert alert-danger">
            <p>There is no data yet!</p>
        </div>
    </td>
`;
                    if(rs.get_my_faq.length === 0){
                        $faq_list.append(tmp);                    
                    }else{
                        $.each(rs.get_my_faq,(i,v)=>{


                        let tmp = `<tr>
                            <td>
                            <a data-faq_uniq_id="${v.faq_uniq_id}" class="lnview btn-pay" style="color:white;font-weight:bold;">
                            ${v.faq_title}
                            </a>
                            </td>
                            <td>${v.faq_answer_by}</td>
                            <td>${v.faq_date_create}</td>
</tr>`;
                        $faq_list.append(tmp);
                    });
                    }
                }
                });
                
            }

            function faqSave(){
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize()+"&faq_user_email="+my_email+"&faq_user_id="+my_id+"&faq_user_name="+my_name;
                    $.post(url,data,function(e){
                        //alert(e);
                        let rs = $.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        setTimeout(()=>{
                            $page_status.html("loading...").fadeOut("slow");
                            faqGetSummary();
                        },1200);
                    });
                });

            }
            //--------------
            //-- faqViewMyFaq
            function faqViewMyFaq(id){
                //alert(`the id to view is ${id}`);
                $mdShowFaq.html("");
                let url = "<?php echo site_url("faq/faqUserViewFaq/") ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get,(i,v)=>{
                    let tmp = `<div class="card">
    <div class="card-header">
        <h2 class="text-center">${v.faq_title}</h2>
    </div>
    <div class="card-body">
        ${v.faq_body}
    </div>
    <div class="card-footer">
        <div class="float-right">
            <p>Date : ${v.faq_date_create}</p>
        </div>
    </div>
</div>`;
                    $mdShowFaq.append(tmp);
                    $mdTitle.html(`${v.faq_title}`);
                    $($md).modal("show");
                    });
                }
                });

            }



            function faqGetSummary(){
                faqGetMyFaqList();
                let today = new Date().toLocaleString();
                let bb = `New F.A.Q from ${my_email} on ${today}`;
                faq_title.attr("placeholder",bb);
            }
            function getEl(el){
                return $(el);
            }
            function getEvent(){
                faqGetSummary();

                $faq_list.delegate(".lnview","click",function(e){
                    e.preventDefault();
                    let id = $(this).attr("data-faq_uniq_id");
                    //alert(`click ${id} now`);
                    faqViewMyFaq(id);
                });

                btnSave.on("click",function(){
                    faqSave();
                    //alert("test");
                });
            }
            return{getEvent:getEvent}
        })();
        $FAQ.getEvent();
    });
</script>

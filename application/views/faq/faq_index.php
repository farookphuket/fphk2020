
<section id="faq">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">
                    Contact our team ติดต่อทีมงาน
                </h1>
                <p class="pt-4">&nbsp;</p>
                <?php 

                        $far_img = site_url("public/img/Contact/Farook_wed-19-Sep-2018.png");

                        $tom_img = site_url("public/img/Contact/Tom_wed-19-Sep-2018.png");
                        $tee_img = site_url("public/img/Contact/Tee_wed-19-Sep-2018.png");
                ?>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <img src="<?php echo $far_img;?>" class="card-img-top responsive" alt="farook">
                    <div class="card-header">
                        <h1 class="text-center">
                            Farook
                        </h1>
                        
                    </div>
                    <div class="card-body">
                        
                        <p>
                            Tel. +66 81 397 4489 or +66 95954 39207&nbsp; </p><p style="color:white;"><span style="color:white;" class="badge badge-warning">do not make a call but please text me.</span>
                        </p>
                        <p>
                            E-mail : farookphuket@gmail.com
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="float-right">
                            <a href="https://hangouts.google.com/group/5IMnME8WHmcL1umD3" title="Talk to farook in Hangout as a group chat" class="btn btn-info btn-sm" target="_blank">Hangout Chat</a>
                            
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-lg-4">
                <div class="card">
                    <img src="<?php echo $tom_img;?>" class="card-img-top responsive" alt="tom">
                    <div class="card-header">
                        <h1 class="text-center">
                            Tom
                        </h1>
                        
                    </div>
                    <div class="card-body">
                        <p>
                            Tel. +66  862 2432589
                        </p>
                        <p>
                            E-mail : 
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="float-right">
                            <a href="https://hangouts.google.com/group/5IMnME8WHmcL1umD3" title="Talk to farook in Hangout as a group chat" class="btn btn-info btn-sm" target="_blank">
                                Hangout Chat
                            </a>
                            <a class="btn btn-primary btn-sm btnFBContact" href="https://m.me/nipon.pannoi" target="_blank">
                             Tom facebook 
                            </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


    <!-- Tee -->
            <div class="col-lg-4">
                <div class="card">
                    <img src="<?php echo $tee_img;?>" class="card-img-top responsive" alt="tee">
                    <div class="card-header">
                        <h1 class="text-center">
                            Tee
                        </h1>
                        
                    </div>
                    <div class="card-body">
                        <p>
                            Tel. 
                        </p>
                        <p>
                            E-mail : 
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="float-right">
                            
                            
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Tee -->
            <div class="col-lg-12">
                <p class="pt-5">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">
                F.A.Q
                    <span class="badge badge-success numAllFaq">0</span> item(s).
                </h1>
                <p class="pt-5">&nbsp;</p>
                <div class="faq_list"></div>
                <div class="faq_pagin"></div>
            </div>
            <div class="col-lg-12">
                <p class="pt-5">&nbsp;</p>
            </div>




<!--
            <div class="col-lg-12">
                <h1 class="text-center">Ask your question</h1>
                <p class="pt-4">&nbsp;</p>
                <div class="row">
                    <div class="col-md-5">
                        <div class="alert alert-warning">
                            <p>
                                <strong>Dear friend</strong>&nbsp;
                                before you start typing anything I want you to know that I am very appreciate to having you here visiting us.
                            </p>
                            <ul>
                                <li>Your message will be not show please wait for us to approve it.</li>
                            </ul>

                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="alert alert-warning">
                            <p>
                                <strong>ถึงทุกๆ ท่านที่เคารพ</strong>&nbsp;
                                ก่อนที่ท่านจะเริ่มพิมพ์ข้อความใดๆ นั้น เราอยากบอกท่านว่าเรารู้สึกเป็นเกียรติอย่างยิ่ง ที่ท่านเข้ามาเยี่ยมชมเรา
                            </p>
                            <ul>
                                <li>ทุกท่านครับ ข้อความของท่านยังไม่ "ปรากฏ" ในหน้านี้ กรุณารอให้ทางเราได้ "พิสูจน์" ข้อความของท่านก่อน</li>
                            </ul>

                        </div>
                    </div>


                </div>
            </div>
-->



            <div class="col-lg-12">
            <!-- form start --> 
                <?php 
                    $f = "faq/_frm_visitor";
                    $this->load->view($f);
                ?>
            <!-- end form -->
            </div>
            
            <div class="col-lg-12 faqResult">
         

            </div>

        </div>
    </div>

    <!-- the modal START 21-3-2020 -->
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Need your confirm</h1>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
<?php
    $frmConfirm = "faq/_frm_email_confirm";
    $this->load->view($frmConfirm);
?>    
                    <div class="modal_status">
                        
                    </div>
                </div>
                 <div class="modal-footer">
                     <div class="float-right">
                         <button id="btnConf" type="submit" class="btn btn-primary" form="frmFaqConfirm">Sent Request</button>
                     </div>
                 </div>
            </div>
        </div>
    </div>
    <!-- the modal END 21-3-2020 -->
</section>

<script charset="utf-8">

$(function(){
    const $FAQ = (function(){


        //--- get user by session
        let faq_user_confirm = "<?php echo $faq_user_confirm; ?>"; 
        let faq_user_name = "<?php echo $faq_user_name; ?>";
        let faq_user_email = "<?php echo $faq_user_email; ?>";

        //--- show on page
        let $numAllFaq = getEl(".numAllFaq");
        let $faq_list = getEl(".faq_list");
        let $faq_pagin = getEl(".faq_pagin");

        //----
        let rd_only = true;
        let jdt1 = new Jodit("#faq_body",{"readonly": rd_only});
        jdt1.value = `<div class="container">
    <div class="alert alert-warning">
        <h1 class="text-center">Please confirm if you are not a robot!</h1>
    </div>
</div>`;


    //-- the faq form
    let $frmFaq = getEl("#frmFaq");
    let faq_id = getEl("#faq_id");
    let faq_title = getEl(".faq_title");
    let faq_body = getEl(".faq_body");
    let btnFaqSave = getEl(".btnFaqSave");

    //--- the modal
    let $md = getEl(".md");
    let $mdTitle = getEl(".modal-title");

    //--- the confirm form
    let $frmConfirm = getEl("#frmFaqConfirm");
    let faq_name = getEl(".faq_user_name");
    let faq_email = getEl(".faq_user_email");
    let btnConf = getEl("#btnConf");

    let $modal_status = getEl(".modal_status");
    let $page_status = getEl(".status");


    //--- use cookie for page load
    let ck_faq_page = Cookies.get("ck_faq_page");

    function getFaqList(ck_faq_page=1){
        $faq_list.html("");
        let url = "<?php echo site_url("faq/faqGuestList/") ?>"+ck_faq_page;
        $.ajax({
        url : url,
            success : (e)=>{
            let rs = $.parseJSON(e);
            $numAllFaq.html(rs.get_all.length);
            console.log(rs);
            $.each(rs.get_faq,(i,v)=>{

                let tmp = `<div class="card">
    <div class="card-header bg-primary">
        <h1 class="text-center">${v.faq_title}</h1>
    </div>
    <div class="card-body">
       ${v.faq_body} 
    </div>
</div><p class="pt-3">&nbsp;</p>`;

                $faq_list.append(tmp);
            });
        }
        });
    }
        //---- needConfirm
        function needConfirm(){

            if(parseInt(faq_user_confirm) === 1){
                faq_title.focus();
                checkUserSess();

                return false;
            }else{

                $mdTitle.html(`Please confirm!`);
            setTimeout(()=>{
                faq_name.focus();

                checkUserSess();
            },550);
                $($md).modal("show");
            }
            
        }
    //---------------
    //-- sent request 
    function faqSentRequest(){

        btnConf.html("sending...")
            .prop("disabled",true)
            .unbind();
        
        $frmConfirm.submit(function(e){
            e.preventDefault();
            let url = $(this).attr("action");
            let data = $(this).serialize();
            $.post(url,data,function(e){
                //console.log(e);
                let rs = $.parseJSON(e);
                $modal_status.html(rs.msg);
                btnConf.html(`check your mailbox`);
                setTimeout(()=>{
                    location.reload();
                },20000);

            });

        }); 

        
    }

    function checkUserSess(){

        let time1 = "";
        let time_count = 0;
        if(parseInt(faq_user_confirm) === 1){
            //console.log(`time out is clear ${faq_user_email}`);
            jdt1.value = `<div class="alert alert-success">
                <h1 class="text-center">Dear ${faq_user_name}</h1>
    <p>please feel free to ask anything we will get back to you as soon as possible.</p>
</div>`;
            jdt1.setReadOnly(false);
            faq_title.on("click",function(){
                return false;
            });
            clearTimeout(time1);

        }else{

            time1 = setInterval(()=>{
            time_count++;
            parseInt(time_count);
            console.log(`there is no user ${faq_user_name} the time count is ${time_count}`);

            if(parseInt(time_count) > 3){
                console.log(`the timer is ${time_count} now is stop`);
                clearTimeout(time1);
            } 


        },20000);

                 

        }

        

    }

    //--------
    //--- faqSave
    function faqSave(){
        btnFaqSave.unbind();
        $frmFaq.submit(function(e){
            e.preventDefault();
            //alert('submit now');
            let url = $(this).attr("action");
            let data = $(this).serialize()+"&faq_name="+faq_user_name+"&faq_email="+faq_user_email+"&faq_id="+faq_id;
            $.post(url,data,function(e){
                let rs = $.parseJSON(e);

                //alert(rs.msg);
                $page_status.html(rs.msg).show();
                setTimeout(()=>{
                    $page_status.html("loading...").fadeOut("slow");
                    location.reload();
                },2000);
            });
        }); 
    }


        function getEl(el){
            return $(el);
        }

        function getEvent(){
            faq_title.on("click",function(){
                needConfirm();

            });
            
            if(ck_faq_page === undefined){
                ck_faq_page = 1;
            }
            getFaqList(ck_faq_page);

            //-- make a request
            btnConf.on("click",function(){
                
                if(!faq_name.val() || !faq_email.val()){
                    err = 1;
                    alert(`All field is REQUIRED Please check form`);
                }else{
                    err = 0;

                    faqSentRequest();
                } 

            });

            btnFaqSave.on("click",function(){
                faqSave();
            });
            
        }
        return{getEvent:getEvent}
    })();
    $FAQ.getEvent();
});    
</script>


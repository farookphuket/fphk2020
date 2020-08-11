<section id="comment">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">
                    Leave your comment.
                </h1>
                <hr class="my-4" />
            </div>
            <div class="col-lg-6">
                <p>Note to all of my belove visitor</p>
                <ul>
                    <li class="alert alert-warning">
                        <p>Your comment will not be shown here unless it has been approve by admin.</p>
                        <p>We expected that you will pay more respect to the other people while you leave any comment of anything.</p>
                    </li>

                    
                </ul>
            </div>
            <div class="col-lg-6">
                <p>ฝากถึงทุกๆ ท่านครับ</p>
                <ul>
                    <li class="alert alert-warning">
                        <p>คอมเม้นต์ของท่านจะยังไม่โชว์จนกว่าจะได้ผ่านการตรวจสอบครับทั้งนี้เพื่อป้องกันเกรียนคีย์บอร์ด</p>
                        <p>เราแค่หวังว่าท่านจะให้เกียรติบุคคลอื่นๆ ที่เค้ามีความเห็นไม่ตรงกับท่าน เราเพียงหวังให้ท่านเขียนวิจารณ์ความคิดของคนอื่นๆ ที่ท่านอาจจะรู้สึกไม่ชอบ ด้วยความเคารพต่อกัน</p>
                    </li>
                </ul>
            </div>
            <div class="col-lg-12">
                <p class="">your action code : 
<?php
    echo $this->session->userdata("action_code");
?>
                </p>
                <p class="pt-5">&nbsp;</p>
            </div>
             <div class="col-lg-12">
<?php
    $frm = "comment/_u_frmComment";
    $this->load->view($frm);
?>
             </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <h1 class="text-center">
                Comment
                <span class="badge badge-info numComment">0</span> item(s).
                </h1>
                <hr class="my-4" />
            </div>
            <div class="col-lg-12">
                <p class="pt-4">&nbsp;</p>
            </div>
            <div class="col-lg-12">
                <div class="comt_list">
                    
                </div>
                <div class="comt_pagin">
                    
                </div>
            </div>
            <div class="col-lg-12">
                <p class="pt-5">&nbsp;</p>
            </div>



       </div> 
    </div>
</section>


    <script>

    $(function(){
        const $P = $("#comment");
        const $page_status = $(".status");
        const $cmt = (function(){


            //--    owner_email
            let owner_email = Cookies.get("owner_email");
            //---   comment to where
            let cur_url = "<?php echo current_url(); ?>";
            let sec_name = "<?php echo $this->uri->segment(1); ?>";
            let sec_id = "<?php echo $this->uri->segment(3); ?>";

            //--    comment show list
            let $numComment = getEl(".numComment");
            let $comt_list = getEl(".comt_list");
            let $comt_pagin = getEl(".comt_pagin");

            //---   user confirm
            let c_user_name = getEl(".c_user_name");
            let c_user_email = getEl(".c_user_email");
            let lnSent = getEl(".lnSent");
            let sess_name = "<?php echo $this->session->userdata("sess_user_name"); ?>";
            let sess_email = "<?php echo $this->session->userdata("sess_user_email"); ?>";
            let action_code = "<?php echo $this->session->userdata("action_code"); ?>";

            //--- the form
            let $frm = getEl("#commentForm");
            let c_title = getEl(".c_title");
            let c_body = getEl(".c_body");
            let c_id = getEl(".c_id");
            let btnSave = getEl(".btnSave");

            function sentConfirm(){
                let f_name = "";
                let fo = 0;
                if(!c_user_name.val()){
                    fo = 1;
                    f_name = c_user_name;
                }else if(!c_user_email.val()){
                    fo = 1;
                    f_name = c_user_email;
                }else{
                    //--- sent user link
                    //alert(`The sec name is ${sec_name} the sec id is ${sec_id} the url is ${cur_url}`);
                    let url = "<?php echo site_url("comment/sentUserLink"); ?>";
                    let data = {
                            c_user_name : c_user_name.val(),
                            c_user_email : c_user_email.val(),
                            cur_url : cur_url,
                            sec_name : sec_name,
                            sec_id : sec_id

                    };
                    $.post(url,data,function(e){
                        //alert(e);
                        let rs = $.parseJSON(e);
                        alert(rs.msg);
                    });

                }
                if(parseInt(fo) !== 0){
                    f_name.focus();
                }
            }

            function isRealUser(){
                if(action_code){
                    c_user_name.val(sess_name);
                    c_user_email.val(sess_email);
                    lnSent.html(`action : ${action_code}`).addClass("disabled");
                    
                    c_title.focus();
                }
                               
            }

            function commentEdit(ac){
                let url = "<?php echo site_url("comment/uEdit/") ?>"+ac;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    $.each(rs.get,(i,v)=>{

                        if(v.c_item_id !== sec_id){
                            c_title.attr("placeholder","Enter the title");
                            let ph = `Dear ${sess_name} we hope that you will pay the respect to another people even if their thougth is something that you do not like it.`;
                            c_body.attr("placeholder",ph);
                        }else{

                            c_id.val(v.c_id);
                            c_title.val(v.c_comment_title);
                            c_body.val(v.c_comment_body);

                        }

                        console.log(v);
                    });
                }
                });
            }
            //---------------------
            //--    commentSave
            function commentSave(){
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize()+"&owner_email="+owner_email+"&action_code="+action_code+"&sec_name="+sec_name+"&sec_id="+sec_id+"&cur_url="+cur_url;

                    $.post(url,data,function(e){
                        let rs = $.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        setTimeout(()=>{
                            $page_status.html("Loading...").fadeOut("slow");
                           getSummary(); 
                        },2000);

                    });

                });
                
            }
            //---------------------
            //---   getCommentList
            function getCommentList(page=1){
                $comt_list.html("");
                let url = "<?php echo site_url("comment/getCommentList/"); ?>"+page;
                let data = {
                    sec_name : sec_name,
                        item_id : sec_id
                };
                $.ajax({
                type : "post",
                url : url,
                data : data,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $numComment.html(rs.get_all.length);
                    $.each(rs.get_all,(i,v)=>{
                    let tmp = `<div class="card">
                    <div class="card-header bg-primary">
                    <h1 class="text-white">${v.c_comment_title}</h1>
                    </div>
                    <div class="card-body">
                        ${v.c_comment_body}
                    </div>
                    <div class="card-footer">
                        <p>BY : ${v.c_user_name} ${v.c_date_create}</p>
                    </div>
                    </div><p class="pt-2">&nbsp;</p>`;
                        $comt_list.append(tmp);
                    });
                    
                }
                });
            }
            //----------------------
            function getSummary(){
                isRealUser();
                if(action_code){
                    commentEdit(action_code);
                }
                getCommentList();
            }
            function getEl(el){
                return $P.find(el);
            }
            function getEvent(){
                getSummary();

                lnSent.on("click",function(){
                    sentConfirm();
                });

                //--- save btn click
                btnSave.on("click",function(){
                    commentSave();
                });

            }
            return{getEvent:getEvent}
        })();
        $cmt.getEvent();
    });
    </script>

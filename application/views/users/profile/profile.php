<section id="profile">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">
                <?php echo $user_name; ?>
                </h1>
                <p class="pt-2">&nbsp;</p>

                <div class="profile_preview"> 
                   

                </div>

            </div>



        </div>
    </div>
    

    <!-- modal Start -->
    <div class="modal fade md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">
                        The modal
                    </h1>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="text-center alert alert-warning">
                                    Warning!
                                </h1>    
                                <div class="alert alert-warning">
                                    <p>This will reset your account activation <br /> after you make change to your profile you will have to check your e-mail that you have register with this website(shown in your profile info) to re-activate your profile again.</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
<?php
    $frm = "users/profile/_frm_user_profile";
    $this->load->view($frm);
?> 
                            </div>
                        </div>
                    </div>





                </div>
                <div class="modal-footer">
                    <div class="float-right">
                        <button class="btn btn-primary btnSave" type="submit" form="userProfile">Save</button>
                        <button class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal END -->
</section>
<script charset="utf-8">
$(function(){

    const $prof = (function(){

        let error_code = 0;

        let $profile_preview = getEl(".profile_preview");

        let my_id = "<?php echo $user_id; ?>";

        //--- the modal
        let $md = getEl(".md");
        let $mdTitle = getEl(".modal-title");
        let btnSave = getEl(".btnSave");

        //--- the form element
        let $frm = getEl("#userProfile");
        let u_name = getEl(".u_name");
        let u_tel = getEl(".u_tel");
        let u_email = getEl(".u_email");
        let u_id = getEl(".u_id");

        //--- about password
        let oldPass = getEl(".oldPass");
        let newPass = getEl(".newPass");
        let passConfirm = getEl(".passConfirm");


        let $modal_status = getEl(".modal_status");

        function getProfile(){

            $profile_preview.html("");
            let url = "<?php echo site_url("profile/userGetProfile/"); ?>"+my_id;
            $.ajax({
                url : url,
                    success : (e)=>{

                    let rs = $.parseJSON(e);
                    $.each(rs.get,(i,v)=>{

                    let tmp = `<div class="card">
    <div class="card-header">
        <h2 class="text-center">
        ${v.name}'s profile
        </h2>
    </div>
    <div class="card-body">
        <p>${v.about_user}</p>
        <div class="table-resposive">
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Date</th>
                    <td>${v.date_register}</td>
                </tr>
            </table>
        </div>
    
    </div>
        <div class="card-footer">
            <div class="float-right">
                <button class="btn btn-primary lnEdit" data-u_id="${v.id}">
                    Edit
                </button>
            </div>
        </div>


</div>
<p class="pt-4">&nbsp;</p>`;

                    $profile_preview.append(tmp);
                
                    });


            }

            });
        }
        //---------------


        //---  profileEdit
        function profileEdit(id){
            //alert(`edit id ${id}`);
            let url = "<?php echo site_url("profile/userProfileEdit/"); ?>"+id;
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                $.each(rs.get,(i,v)=>{
                    console.log(v);   
                     u_name.val(v.name);
                     u_email.val(v.email);
                     u_tel.val(v.tel);
                     tinymce.get("u_about").setContent(v.about_user);
                     u_id.val(v.id);
                     oldPass.val(v.passwd);
                     $mdTitle.html(`editing ${v.name}'s profile...'`);
                 let msg_show = `<span class="alert alert-warning float-right">Editing ${v.name}'s profile...</span>`;
                 $modal_status.html(msg_show);
                });
                $($md).modal("show");
            }
            });
    

        }


        function profileSave(){
            btnSave.unbind();
            passConfirm.val("");

            $frm.submit(function(e){
                e.preventDefault();
                let url = $(this).attr("action");
                let cP = passConfirm.val();
                let nP = newPass.val();
                let oP = oldPass.val();
                let data = $(this).serialize()+"&newPass="+nP+"&passConfirm="+cP+"&oldPass"+oP;
                $.post(url,data,(e)=>{
                    let rs = $.parseJSON(e);

                    
                    let logout = "<?php echo site_url("users/logout"); ?>";
                    error_code = rs.error_code;
                    if(parseInt(error_code) === 1){
                        
                        profileEdit(my_id);  
                    }else{
                        setTimeout(()=>{
                        $modal_status.html("loading..."+error_code);
                        location.href = logout;
                        
                        },5000);

                    }

                    //console.log(rs);
                    let msg_show = `<span class="float-right">${rs.msg}</span>`;
                    $modal_status.html(msg_show);


                    
                });


            });
        }

        function getEl(el){
            return $(el);
        }
        function getEvent(){
            getProfile();
            $profile_preview.delegate(".lnEdit","click",function(){
                let id = $(this).attr("data-u_id");
                profileEdit(id);
            });

            btnSave.on("click",function(){
                profileSave();
            });
        }
        return{ getEvent : getEvent }
    })();

    $prof.getEvent();
});
</script>




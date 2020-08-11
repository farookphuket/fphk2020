<script>

//-----jQuery sat 5 Jan 2018 
$(function(){

    var $el = $(".users");
    var user = (function(){
            
            var $user_list = $el.find(".user_list");
            var $user_pagin = $el.find(".user_pagin");
            var $user_num = $el.find(".user_num");

            //---form user
            var $frm_head = $el.find(".frm_head");
            

        function getUserList(page=1){
            $user_list.html("");
            var url = "<?php echo site_url("users/adminListUser/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    $user_num.html(rs.num_user);
                    $.each(rs.get_users,function(i,v){
                        var tmp = `
                        <div class="card">
                            <div class="card-header bg-info">
                                <h2 class="text-white">${v.name}</h2>
                            </div>
                            <div class="card-body">

                            </div>

                            <div class="card-footer">
                                <button class="btn btn-info btnViewUser" data-user_id="${v.id}">view</button>
                                <button class="btn btn-primary btnEditUser" data-user_id="${v.id}">edit</button>
                            </div>
                        </div>
                        <hr class="my-4"/>
                        <br />
                        `;

                        $user_list.append(tmp);
                    });
                    $user_pagin.html(rs.pagination);
                }
            });
        }

        //----------------
        //---------modViewUser
        function modViewUser(id){
            
            var url = "<?php echo site_url("users/modViewUser/");?>"+id;
            
            var win = window.open(url, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
           
            
            
            
        }
        //------------------
        function getSummary(){
            getUserList();
        }
        //----------------
        function getEvent(){
            getSummary();

            //---view user
            $user_list.delegate(".btnViewUser","click",function(){
                var id = $(this).attr("data-user_id");
                modViewUser(id);
            });

            //---btnBack
            $user_list.delegate(".btnBack","click",function(){
                getUserList();
                $user_pagin.show();
            });
            //---pagination
            $user_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var page = $(this).attr("data-ci-pagination-page");
                getUserList(page);
            });
        }
        return{getEvent:getEvent}
    })();
    user.getEvent();

});

</script>
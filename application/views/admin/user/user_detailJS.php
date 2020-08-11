<script>

//---jQuery
$(function(){

var $el = $("#users");

var $photo = $("#photo");

var u_info = (function(){

    var $btnGetProfile = $el.find(".btnGetProfile");

    var $btnGetPost = $el.find(".btnGetPost");
    //var $post_num = $el.find(".post_num");
    var $label_right = $el.find(".label_right");
    var $post_list = $el.find(".post_list");
    var $post_pagin = $el.find(".post_pagin");

    var $btnGetPhoto = $el.find(".btnGetPhoto");
    var $photo_list = $photo.find(".photo_list");

    var $u_id = "<?php echo $u_id;?>";

    function getUserProfile(){
        $post_list.html("");
        $label_right.html("");
        var url = "<?php echo site_url("users/uGetUserInfo/");?>"+$u_id;
        $.ajax({
            url : url,
            success : function(e){
                var rs = $.parseJSON(e);
                $.each(rs.user_info,function(i,v){

                    var tmp = `
                    <div class="card">
                        <div class="card-header bg-info">
                            <h2>${v.name}</h2>
                        </div>
                    </div>
                    `;
                    $label_right.html(`Profile of ${v.name}`);
                    $post_list.append(tmp);
                    $post_pagin.hide();
                });
            }
        });
    }

    function getPhotoList(page=1){
        $photo_list.html("");
        var url = "<?php echo site_url("gallery/uGetPhotoList/");?>"+page;
        var data = {u_id : $u_id};
        $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
                var rs = $.parseJSON(e);
                console.log(rs.get_pic);
                
                $.each(rs.get_pic,function(i,v){
                    var full_pic_url = "<?php echo site_url("public/image/");?>"+v.pic_name;
                    var tmp = `
                        <div class="col-lg-4 col-sm-6">
                            <img src="${full_pic_url}" class="img-fluid responsive"/>
                        </div>
                    `;
                    $photo_list.append(tmp);
                });
            }
        });
    }

    function getPostList(page=1){
        $post_list.html("");
        var url = "<?php echo site_url("article/uGetPostList/");?>"+page;
        var data = {u_id : $u_id};
        $.ajax({
            type : "post",
            url : url,
            data : data,
            success : function(e){
                var rs = $.parseJSON(e);
                $.each(rs.get_ar,function(i,v){
                    var tmp = `
                    <div class="card">
                        <div class="card-header bg-primary">
                            <h2>${v.ar_title}</h2>
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary btnViewAr" data-ar_id="${v.ar_id}">Read</button>
                        </div>
                    </div>
                    `;
                    $post_list.append(tmp);
                });
                $label_right.html(`Post ${rs.num_ar} item(s)`);
                //$post_num.html(rs.num_ar);
            }
        });
    }
    //-------------
    //-----getSummary
    function getSummary(){
        getPhotoList();
        getUserProfile();
    }
    //----------
    function getEvent(){
        getSummary();

        //---btnGetProfile
        $btnGetProfile.on("click",function(e){
            e.preventDefault();
            getUserProfile();
        });
        //----btnGetPost
        $btnGetPost.on("click",function(e){
            e.preventDefault();
            getPostList();
        });

        //---btnGetPhoto
        /*
        $btnGetPhoto.on("click",function(e){
            e.preventDefault();
            getPhotoList();
        });
        */
        //---btnViewAr
        $post_list.delegate(".btnViewAr","click",function(e){
            e.preventDefault();
            var id = $(this).attr("data-ar_id");
            alert("read item "+id);
        });
    }
    return{getEvent:getEvent}
})();
u_info.getEvent();

});

</script>
<script>

//---jQuery
$(function(){
    var $el = $(".user_post");
    var userPost = (function(){

        var $post_list = $el.find(".post_list");
        var $post_pagin = $el.find(".post_pagin");
        var $post_num = $el.find(".post_num");
        var $post_head = $el.find(".post_head");

        //---menu link
        var $ln_pubPost = $el.find(".ln_pubPost");

        function getPubList(page=1){
            $post_list.html("");
            $post_head.html("");
            var url = "<?php echo site_url("article/getPublicPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    
                    $post_head.html(`Public Post ${rs.num_ar} item(s).`);
                    //$post_num.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){
                        var tmp = `
                        <div class="card">
                            <div class="card-header bg-success">
                                <h2 class="text-white">${v.ar_title}</h2>
                            </div>
                        </div>
                        `;
                        $post_list.append(tmp);
                    });
                }
            });
        }
        function getMyPostList(page=1){
            $post_list.html("");
            var url = "<?php echo site_url("article/uGetPostList/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get_ar,function(i,v){
                        var ap = `
                        <span class="badge badge-danger">Not Approve</span>
                        `;
                        if(parseInt(v.ar_is_approve) !== 0){
                            ap = `
                        <span class="badge badge-success">Approve</span>
                        `;
                        }
                        var tmp = `
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h2>${v.ar_title}</h2>
                            </div>
                            <div class="card-body">
                                
                                <div class="row">
                                    <div class="col-sm-8">
                                        ${v.ar_summary}
                                    </div>
                                    <div class="col-sm-4 table-responsive">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th>Date Wrote</th>
                                                <td>${v.date_add}</td>
                                            </tr>
                                            <tr>
                                                <th>Has Read</th>
                                                <td>${v.ar_read_count}</td>
                                            </tr>
                                            <tr>
                                                <th>Last Read</th>
                                                <td>${v.last_view_date}</td>
                                            </tr>
                                            <tr>
                                                <th>Approve</th>
                                                <td>${ap}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-info btnReadPost" data-ar_id="${v.ar_id}">Read</button>
                                <button class="btn btn-primary btnEditPost" data-ar_id="${v.ar_id}">edit</button>
                                <button class="btn btn-danger btnDelPost" data-ar_id="${v.ar_id}">delete</button>

                            </div>
                        </div>
                        <hr class="my-4" />
                        <br style="clear:both" />
                        `;
                        $post_list.append(tmp);
                    });
                    $post_num.html(rs.num_ar);
                }
            });
        }
        function getSummary(){
            getMyPostList();
        }
        function getEvent(){
            getSummary();
            $ln_pubPost.on("click",function(e){
                e.preventDefault();
                getPubList();
            });
        }
        return{getEvent:getEvent}
    })();
    //---call userPost
    userPost.getEvent();
});

</script>
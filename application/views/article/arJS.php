<script>

//---jQuery
$(function(){

    var $el = $("#container");
    var page_status = $el.find(".status");

    var emp_div = `
    <div class="col-md-10">
        <h1 class="alert alert-danger">There is no data</h1>
    </div>
    `;
    var articleV = (function(){
        //---ar list

        var div_ar_list = $el.find(".div_ar_list");
        var div_ar_pagin = $el.find(".div_ar_pagin");
        var sp_num_post = $el.find(".sp_num_post");
        //-----
        function arGetList(page=1){
            var url = "<?php echo site_url("article/visiter/");?>"+page;
            var data = {cmd:"lastAr"};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs  = $.parseJSON(e);
                    arShowList(rs);
                    
                }
            });
        }
        //----ar show list
        function arShowList(obj){
            //console.log(obj);
            div_ar_list.html("");
           
            var ar_items = obj.get_ar;
            var ar_num = obj.num_ar;

            sp_num_post.html(ar_num);
            if(!ar_items || ar_items.length === 0){
                div_ar_list.html(emp_div).show();
            }else{
                $.each(ar_items,function(i,v){
                    var read_url = "<?php echo site_url("article/read/");?>"+v.ar_id;
                    var tmp = `
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h2>${v.ar_title}</h2>
                        </div>
                        <div class="panel-body">
                            <div class="article_box">${v.ar_summary}</div>
                            <a class="btn-pay" href="${read_url}" target="_blank" title="read more">Read More</a>
                        </div>
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-sm-4">
                                        <h5>
                                            Date Create <span class="label label-default">${v.date_add}</span>
                                        </h5>
                                </div>

                                    <div class="col-sm-4">
                                        <h5>
                                            Post By <span class="label label-info">${v.ar_post_by}</span>
                                        </h5>
                                    </div>

                                    <div class="col-sm-4">
                                        <h5>
                                            Post By IP <span class="label label-info">${v.ar_post_ip}</span>
                                        </h5>
                                    </div>
                                    

                                    <div class="col-sm-4">
                                        <h5>
                                            View <span class="label label-default">${v.ar_read_count}</span>
                                        </h5>
                                    </div>

                                    <div class="col-sm-4">
                                        <h5>
                                           Last Read <span class="label label-primary">${v.last_view_date}</span>
                                        </h5>
                                    </div>

                                    <div class="col-sm-4">
                                        <h5>
                                            Last Read IP <span class="label label-default">${v.last_view_ip}</span>
                                        </h5>
                                    </div>

                            </div>
                        </div>
                    </div>
                    `;
                    
                    div_ar_list.append(tmp);
                });

                div_ar_pagin.html(obj.pagination);

            }
            
            
        }
        //------
        function arSummary(){
            //--- summary or change
            arGetList(1);
        }
        function getEvent(){
            arSummary();
            div_ar_pagin.delegate(".pagination a","click",function(o){
                o.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                arGetList(cur_page);
            });
        }
        return{getEvent:getEvent}
    })();

    articleV.getEvent();

});
</script>
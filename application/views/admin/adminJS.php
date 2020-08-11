<script>

$(function(){
    
    var $page_status = $(".status");

    //----tour start
    var $Tour = $("#tour");

    var vTour = (function(){
        var tourHead = $Tour.find(".tour_head");

        //---
        var $tour_list = $Tour.find(".tour_list");
        var $tour_pagin = $Tour.find(".tour_pagin");

        function getTourList(page=1){
            $tour_list.html("");
            var url = "<?php echo site_url("tour/modGetTourList/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    //console.log(e);
                    var rs = $.parseJSON(e);
                    tourHead.html(`Tour list ${rs.num_tour} item(s).`);
                    $.each(rs.get_tour,function(i,v){
                        var onsale = `<span class="badge badge-success">Yes</span>`;

                        if(parseInt(v.mark_draft) !== 0){
                            onsale = `<span class="badge badge-danger">No</span>`; 
                        }
                        var editUrl = "<?php echo site_url("tour/create/");?>"+v.t_id;
                        var tmp = `
                        <div class="list-group-item">
                        <a href="${editUrl}">${v.t_name}</a><br />
                        <hr class="my-4" />
                        Duration <span class="badge badge-warning">${v.t_duration}</span> | Price <span class="badge badge-warning">${v.full_price}</span>|Tour on salse ${onsale}
                        </div><br />
                        `;

                        $tour_list.append(tmp);
                    });

                    if(parseInt(rs.pagination) !== 0){
                        $tour_pagin.html(rs.pagination);
                    }
                        
                    
                }
            });
        }
        //------------
        function getEvent(){
            getTourList();
            $tour_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getTourList(cur_page);
            });
        }
        return{getEvent: getEvent}
    })();
    vTour.getEvent();
    //---------end of tour
    //--------------------
    //-------------------
    //------method user start
    //------create on 12/4/19 10:40 a.m.
    var $pUser = $("#user");
    var indexUser = (function(){

        var $user_list = $pUser.find(".user_list");
        var $user_pagin = $pUser.find(".user_pagin");
        var $userHead = $pUser.find(".userHead");

        function getEvent(){
            $userHead.html(`Listing user`);
        }
        return{getEvent:getEvent}
    })();
    indexUser.getEvent();
    //---end of method user

});

</script>
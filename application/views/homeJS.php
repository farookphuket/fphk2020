<script>

//-------jQuery get Sun 14 oct 2018
$(function(){

    var $el = $("#article");
    var $t = $("#tour");
    var $page_status = $(".status");








    var recent_post = (function(){

        //----post list and pagination
        var $post_recent = $el.find(".post_recent");
        var $num_post = $el.find(".num_post");
        var $post_pagin = $el.find(".post_pagin");

        //---show tour list in the landing page
        var $tour_list = $t.find(".tour_list");
        var $tour_pagin = $t.find(".tour_pagin");
        var $num_tour = $t.find(".num_tour");

        function getTourList(page=1){
            $tour_list.html("");
            var url = "<?php echo site_url("home/getTourList/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);

                    $num_tour.html(rs.num_tour);
                    $.each(rs.get_tour,function(i,v){
                        var read_tour = "<?php echo site_url("tour/detail/");?>"+v.t_id;
                        var tmp = `


                            <div class="card">
                                <div class="card-heading bg-info">
                                    <h2 class="section-heading text-white mx-auto">
                                        ${v.t_name}
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            ${v.t_summary}
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Where do we go</th>
                                                        <td>${v.t_destination}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>How long</th>
                                                        <td>${v.t_duration}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Price</th>
                                                        <td>${v.full_price}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-primary btnReadTour" data-t_id="${v.t_id}">read more</button>

                                </div>
                            </div>
                            <br />
                            <hr class="my-4" />
                            <br />
                        `;

                        $tour_list.append(tmp);
                    });

                    $tour_pagin.html(rs.pagination);

                }
            });
        }


        //-----------------------
        function readTour(id){
            //alert(`will open the page ${id} now`);
            var url = "<?php echo site_url("tour/detail/");?>"+id;
            var win = window.open(`${url}`, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }
        //----------End of tour section

        function getPostSummary(page=1){
            $post_recent.html("");

            var url = "<?php echo site_url("home/getRecentPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);

                    $num_post.html(rs.num_ar);
                    $.each(rs.get_ar,function(i,v){
                        var read_url = "<?php echo site_url("article/read/");?>"+v.uniq_id;
                        var tmp = `
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h1>${v.ar_title}</h1>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            ${v.ar_summary}
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">

                                                <tr>
                                                        <th>
                                                            Wrote By
                                                        </th>
                                                        <td>
                                                            ${v.name}
                                                        </td>
                                                    </tr>

                                                <tr>
                                                        <th>
                                                            Date Create
                                                        </th>
                                                        <td>
                                                            ${v.date_add}
                                                        </td>
                                                    </tr>


                                                <tr>
                                                        <th>
                                                            Last edit
                                                        </th>
                                                        <td>
                                                            ${v.date_edit}
                                                        </td>
                                                    </tr>


                                                    <tr>
                                                        <th>
                                                            Read
                                                        </th>
                                                        <td>
                                                            ${v.ar_read_count}
                                                        </td>
                                                    </tr>



                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button class="btn btn-primary btnReadAr" data-ar_id="${v.uniq_id}">Read More</button>
                                </div>
                            </div>
                          <br />


                        `;

                        $post_recent.append(tmp);
                    });

                    $post_pagin.html(rs.pagination);

                }
            });

        }
        //------------------------
        //---uReadAr
        function uReadAr(id){
            //sat 26 Jan 19
            var url = "<?php echo site_url("article/read/");?>"+id;
            var win = window.open(url, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        }

        function getEvent(){
            getPostSummary();
            getTourList();

            //---tour pagination
            $tour_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                getTourList(cur_page);
            });

            //---btn read more click
            $post_recent.delegate(".btnReadAr","click",function(){
                var id = $(this).attr("data-ar_id");
                uReadAr(id);
            });

            //---post pagination
            $post_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var go_url = $(this).attr("data-ci-pagination-page");
                getPostSummary(go_url);
            });

            //---btn read tour
            $tour_list.delegate(".btnReadTour","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-t_id");
                readTour(id);
            });
        }
        return{getEvent:getEvent}
    })();
    recent_post.getEvent();


});
</script>

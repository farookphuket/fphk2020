<script>
    //---7-2-19
    $(function(){

        var $el = $("#tour");

        var manTour = (function(){

            var $tour_list = $el.find(".tour_list");
            var $tour_pagin = $el.find(".tour_pagin");

            var mdTour = $el.find(".mdTour");

            var $fTour = $el.find("#fTour");

            //---form seo
            var meta_url = $el.find(".meta_url");
            var keyword = $el.find(".meta_keyword");
            var des = $el.find(".meta_description");

            //---tour
            var title = $el.find(".tour_title");
            var summary = $el.find(".tour_summary");
            var price = $el.find(".tour_fullprice");
            var location = $el.find(".tour_location");
            var duration = $el.find(".tour_duration");
            var program = $el.find(".tour_detail");
            var mark = $el.find(".mark_draft");
            var t_id = $el.find(".tour_id");
            var kw_id = $el.find(".kw_id");

            var btnSave = $el.find(".btnSave");

            //---tour result
            var $tourResult = $el.find(".tourResult");

            function getTourList(page=1){
                $tour_list.html("");
                var url = "<?php echo site_url("tour/modGetTourList/");?>"+page;
                $.ajax({
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs);
                        
                        $.each(rs.get_tour,function(i,v){

                            var onsale = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            if(parseInt(v.mark_draft) !== 0){
                                onsale = `
                            <span class="badge badge-danger">No</span>
                            `; 
                            }
                            var tmp = `
    <div class="card">
        <div class="card-header">
            <h2 class="text-center">${v.t_name}</h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-8">
                    ${v.t_summary}
                </div>
                
                <div class="col-lg-4">
                  <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Destination</th>
                            <td>${v.t_destination}</td>
                        </tr>

                        <tr>
                            <th>how long</th>
                            <td>${v.t_duration}</td>
                        </tr>
                        
                        <tr>
                            <th>Price</th>
                            <td>${v.full_price}</td>
                        </tr>
                        <tr>
                            <th>Program on sale</th>
                            <td>${onsale}</td>
                        </tr>
                    </table>
                  </div>  
                </div>


            </div>
        </div>  
        <div class="card-footer">
            <button class="btn btn-primary btnEditTour" data-t_id="${v.t_id}">
            Edit
            </button>
        </div>               
    </div>
    <br />
                            `;

                            $tour_list.append(tmp);
                        });
                    }
                });
            }

            function showForm(cmd,id){
                $fTour.trigger("reset");
                tinymce.activeEditor.setMode("design");
                switch(cmd){
                    case"edit":
                        var url = "<?php echo site_url("tour/modEditTour/");?>"+id;
                        $.ajax({
                            url : url,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                console.log(rs);
                                
                                $.each(rs.get_tour,function(i,v){
                                    var pub = parseInt(v.mark_draft);
                                    if(pub !== 0){
                                        mark.val(1);
                                    }
                                    t_id.val(v.t_id);
                                    kw_id.val(v.kw_id);

                                    meta_url.val(v.og_url);
                                    var d = tinymce.activeEditor.setContent(v.t_program);
                                    program.val(d);
                                    title.val(v.t_name);
                                    price.val(v.full_price);

                                    summary.val(v.t_summary);

                                    duration.val(v.t_duration);

                                    location.val(v.t_destination);

                                    keyword.val(v.kw_page_keyword);
                                    des.val(v.kw_page_des);

                                    $(mdTour).modal("show");
                                });
                            }
                        });
                    break;
                }
            }

            function saveTour(){
                btnSave.unbind();
                $tourResult.html("");
                $fTour.submit(function(e){
                    e.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        var rs = $.parseJSON(e);
                        $tourResult.html(rs.msg);
                        setTimeout(function(){
                            $tourResult.html("");
                            getSummary();
                        },2000);
                    });
                });
            }
            function getSummary(){
                getTourList();
            }
            function getEvent(){
                getSummary();

                $tour_list.delegate(".btnEditTour","click",function(){
                    var id = $(this).attr("data-t_id");
                    showForm("edit",id);
                });

                btnSave.on("click",function(){
                    saveTour();
                });
            }
            return{getEvent : getEvent}
        })();

        manTour.getEvent();
    });

</script>
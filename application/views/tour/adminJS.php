



<script>
    

    $(function(){
        var $el = $("#tour");

        var manTour = (function(){
            var $tour_list = $el.find(".tour_list");
            var $tour_pagin = $el.find(".tour_pagin");
            var $left_head = $el.find(".left_head");

            var lnAddTour = $el.find(".lnAddTour");
            //---modal tour from
            var $mdTourForm = $el.find(".mdTourForm");
            var $mdFormTitle = $el.find(".frmHead");

            //---form tour
            var $frmTour = $el.find("#frmTour");

            var tour_title = $el.find(".tour_title");
            
            var tour_id = $el.find(".tour_id");
            var tour_fullprice = $el.find(".tour_fullprice");
            var tour_duration = $el.find(".tour_duration");
            var tour_des = $el.find(".tour_location");

            var tour_summary = $el.find(".tour_summary");
            var tour_detail = $el.find(".tour_detail");
            var $tourResult = $el.find(".tourResult");
            var mark_draft = $el.find(".mark_draft");
            var btnSave = $el.find(".btnSave");

            var kw_id = $el.find(".kw_id");
            var meta_keyword = $el.find(".meta_keyword");
            var meta_url = $el.find(".meta_url");
            var meta_des = $el.find(".meta_description");
            
            
            
            

            //---------------
            function getTourList(page=1){
                $tour_list.html("");
                var url = "<?php echo site_url("tour/modGetTourList/");?>"+page;
                $.ajax({
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        $.each(rs.get_tour,function(i,v){
                            
                            var onSale = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            if(parseInt(v.mark_draft) !==0){
                                onSale = `
                                <span class="badge badge-danger">No</span>
                                `;
                            }
                            var tmp = `
                            <div class="card">
                                <div class="card-header bg-info">
                                    <h2 class="text-white text-center">${v.t_name}</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-7">
                                            ${v.t_summary}
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Destination</th>
                                                        <td>${v.t_destination}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tour Duration</th>
                                                        <td>${v.t_duration}</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                        <th>price</th>
                                                        <td>${v.full_price}</td>
                                                    </tr>

                                                    <tr>
                                                        
                                                        <th>On sale status</th>
                                                        <td>${onSale}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-primary btnViewTour" data-tour_id="${v.t_id}">View and Edit</button>
                                    <button class="btn btn-danger btnDelTour" data-tour_id="${v.t_id}">delete</button>
                                </div>
                            </div>
                            
                            <br />
                            <hr class="my-4" />
                            `;
                            $tour_list.append(tmp);
                        });
                    }
                });
            }
            //----------------
            //---------show_form
            function showForm(cmd,id){
                //tinymce.activeEditor.setMode("design");
                $frmTour.trigger("reset");
                switch(cmd){
                    case"edit":
                        var url = "<?php echo site_url("tour/modEditTour/");?>"+id;
                        $.ajax({
                            url : url,
                            success : function(e){
                                var rs = $.parseJSON(e);
                                console.log(rs.get_tour);
                                
                                $.each(rs.get_tour,function(i,v){
                                    tour_id.val(v.t_id);
                                    tour_title.val(v.t_name);
                                    
                                    tour_fullprice.val(v.full_price);
                                    tour_duration.val(v.t_duration);
                                    tour_des.val(v.t_destination);
                                    
                                    tour_summary.val(v.t_summary);
                                    //var t_detail = tinymce.activeEditor.setContent(v.t_program);
                                    tour_detail.val(v.t_program);
                                    meta_keyword.val(v.kw_page_keyword);
                                    meta_des.val(v.kw_page_des);
                                    meta_url.val(v.og_url);
                                    kw_id.val(v.kw_id);
                                    mark_draft.val(v.mark_draft);
                                    $mdFormTitle.html(`Editing... ${v.t_name}`);
                                    $($mdTourForm).modal("show");
                                });
                            }
                        });

                    break;
                    case"add":
                        var url = "<?php echo site_url("tour/seoFirstSave");?>";
                        $.ajax({
                            url : url,
                            success : function(e){
                                //console.log(e);
                                var rs = $.parseJSON(e);
                                $tourResult.html(rs.msg);
                                $.each(rs.get_tour,function(i,v){
                                    meta_url.val(v.og_url);
                                    kw_id.val(v.kw_id);
                                    tour_id.val(v.t_id);
                                });
                                setTimeout(function(){
                                    $tourResult.html("").fadeOut("slow");
                                },4000);
                            }
                        });
                        $mdFormTitle.html("Add New Tour");
                        $($mdTourForm).modal("show");
                    break;
                }

            }

            //--------------
            //----seoAutoSave
            function seoAutoSave(id){
                $tourResult.html("");
               var url = "<?php echo site_url("tour/seoAutoSave/");?>"+id;
               var data = {
                    t_title : tour_title.val(),
                    kw_id : kw_id.val(),
                    t_id : tour_id.val(),
                    keyword : meta_keyword.val(),
                    keydes : meta_des.val(),
                    keyurl : meta_url.val(),
               };
               $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        var tmp_msg = `
                        <span class="badge badge-success">
                        ${rs.msg}
                        </span>
                        `;
                        $tourResult.html(tmp_msg);
                        showForm("edit",rs.t_id);
                    }
               });
            }
            //--------------------
            //--------saveAsDraft
            function saveAsDraft(id){
                $tourResult.html("");
                var opt = 0;
                if(parseInt(mark_draft.val()) !== 0){
                    opt = 1;
                }
                mark_draft.val(opt);
                var url = "<?php echo site_url("tour/seoAutoSave/");?>"+id;
                var data = {
                    mark_draft : opt,
                    t_id : tour_id.val(),
                    set_mark : true
                };
                //alert(`tour id is ${id} mark is ${opt}`);
                $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        var tmp = `
                        <span class="badge badge-success">
                        ${rs.msg}
                        </span>
                        `;
                        $tourResult.html(tmp);
                        //console.log(mark_draft.val(opt));
                        mark_draft.val(opt);
                    }
                });
                
            }
            //------------
            function saveTour(){
                btnSave.unbind();
                $tourResult.html("");
                $frmTour.submit(function(o){
                    o.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize()+"&mark_draft="+mark_draft.val();
                    $.post(url,data,function(e){
                        var rs = $.parseJSON(e);
                        var tmp = `
                        <span class="badge badge-success">
                        ${rs.msg}
                        </span>
                        `;
                        $tourResult.html(tmp);
                    });
                });

            }

            //---------------
            function getSummary(){
                getTourList();
            }
            //------------------
            function getEvent(){
                getSummary();


                //--------------
                //-------mark as draft
                mark_draft.on("change",function(){
                    var id = tour_id.val();
                    saveAsDraft(id);
                });

                //-----------
                //---add tour btn click
                lnAddTour.on("click",function(){
                    showForm("add");
                });

                //---button view and edit click
                $tour_list.delegate(".btnViewTour","click",function(e){
                    var id = $(this).attr("data-tour_id");
                    showForm("edit",id);
                });

                
                //---run firstSave when the user type in tour title box
                tour_title.on("blur",function(){
                    var id = tour_id.val();
                    seoAutoSave(id);
                });

                btnSave.on("click",function(){
                    saveTour();
                });
            }
            return{getEvent:getEvent}
        })();
        manTour.getEvent();
    });
</script>

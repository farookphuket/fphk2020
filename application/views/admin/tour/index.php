<section id="tour">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-4">
                    <div class="alert alert-info">
                        <h1 class="numAll">0</h1>
                        
                    </div>
                    <p>All tour</p>
                </div>
                <div class="col-lg-4">
                    <div class="alert alert-warning">
                        <h1 class="numDraft">0</h1>
                        
                    </div>
                    <p>Draft</p>
                </div>



            </div>
        </div>
        <div class="col-lg-12">
            <div class="pt-4">
                <p>&nbsp;</p>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="float-right">
                <a class="btn btn-primary lnCreate" style="color:white;font-weight:bold">Create</a>
            </div>

            <h1 class="text-center">Tour Program</h1>
        </div>
        <div class="col-lg-12">
            <div class="tour_list">
                
            </div>
            <div class="tour_pagin">
                
            </div>
        </div>
    </div>
</div>

<div class="modal fade md">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Title</h1>
            </div>
            <div class="modal-body">
<?php
    $fr = "admin/tour/_frm_tour";
    $this->load->view($fr);
?>
                <p class="pt-4">&nbsp;</p>
                <div class="float-right">
                    <span class="modal_status"></span>
                </div>
            </div>
            <div class="modal-footer">
                <div class="float-right">
                    <button type="submit" form="fTour" class="btn btn-primary btnSave">Save</button>
                    <button class="btnSave btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script charset="utf-8">
    $(function(){
        const $P = $("#tour");
        const $page_status = $(".status");


        const $t = (function(){

            //---   The label
            let $numAll = getEl(".numAll");
            let $numDraft = getEl(".numDraft");
            //---   The place
            let $tour_list = getEl(".tour_list"); 
            let $tour_pagin = getEl(".tour_pagin"); 
            let lnCreate = getEl(".lnCreate");

            //---   The form
            let $frm = getEl("#fTour");
            let kw_id = getEl(".kw_id");
            let t_id = getEl(".t_id");
            let og_url = getEl(".og_url");
            let keyword = getEl(".keyword");
            let keydes = getEl(".keydes");

            let t_title = getEl(".title"); //--- tour title
            let t_summary = getEl(".summary"); //--- tour summary
            let t_body = getEl(".body"); //--- tour body

            //--- location duration price
            let full_price  = getEl(".full_price"); //--- tour price
            let t_location = getEl(".location");
            let t_duration = getEl(".duration");

            
            //--- my_id
            let my_id = "<?php echo $user_id; ?>";

            //---   The Modal
            let $md = getEl(".md");
            let $mdTitle = getEl(".modal-title");
            let $modal_status = getEl(".modal_status");
            let $frmResult = getEl("result_body");
            let $markDraft = getEl(".mark_draft");
            let btnSave = getEl(".btnSave");



            function labelShow(){
                let url = "<?php echo site_url("tour/adminGetList"); ?>";
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    if(rs.get_all.length !== 0){
                        $numAll.html(rs.get_all.length);
                        $.each(rs.get_all,(i,v)=>{
                            //console.log(v);
                            let  dft = 0;
                            if(parseInt(v.mark_draft) !== 0){
                                dft++;
                            }else{
                                dft--;
                                if(parseInt(dft) < 1){
                                    dft = 0;
                                }
                            }
                            $numDraft.html(dft);
                            
                        });
                    }else{
                        console.log("No data");
                        let no = `<div class="alert alert-danger"><h1 class="text-center">There is no Data</h1></div>`;
                        $tour_list.html(no); 
                    }
                    


                }
                });

            }

            //----------------
            //---   listTour
            function listTour(page=1){
                $tour_list.html("");

                let url = "<?php echo site_url("tour/adminGetList/"); ?>"+page;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        console.log(rs);
                        if(rs.get_all.length !== 0){
                            $.each(rs.get_tour,(i,v)=>{

                            let yes  = `<span class="alert alert-success">Yes</span>`;
                            let no  = `<span class="alert alert-danger">No</span>`;
                            let df = yes;
                            if(parseInt(v.mark_draft) !== 0){
                                df = no;
                            }

                            let tmp = `<div class="card">
    <div class="card-header bg-primary">
        <h1 class="text-center">${v.t_name}</h1>
    </div>
    <div class="card-body">
        ${v.t_summary}
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <tr>
                    <th>By</th>
                    <td>${v.name}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>${v.email}</td>
                </tr>
                <tr>
                    <th>Date </th>
                    <td>
                        <p>Create : ${v.t_create}</p>
                        <p>Update : ${v.t_update}</p>
                    </td>
                </tr>
                <tr>
                    <th>Publish</th>
                    <td>${df}</td>
                </tr>

            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <button class="btn btn-primary lnEdit" data-t_id="${v.t_id}">Edit</button>
            <button class="btn btn-danger lnDel" data-t_id="${v.t_id}">Delete</button>
        </div>
    </div>
</div><p class="pt-2">&nbsp;</p>`;

                            
                            $tour_list.append(tmp);
                        });
                        }

                }
                });
            }
            //---   showForm
            function showForm(cmd,id){
                $frm.trigger("reset");
                switch(cmd){
                case"edit":
                    //alert("the id to edit "+id);
                    editTour(id);
                    
                    break;
                default:
                        og_url.attr("placeholder","Leave this field blank");
                        if(parseInt(t_id.val()) !== 0){
                            t_id.val(0);


                            getTemplate();
                        }
                        //alert(`my id is ${my_id}`);
                        $($md).modal("show");
                    break;
                }
            }
            //------------
            //---   getTemplate
            function getTemplate(){
                if(parseInt(t_id.val()) === 0){
                    let tmp_sum = ``;
                    tinymce.get("tour_summary").setContent(tmp_sum);
                }else{
                    alert("not allow!");
                }
            }
            //---   editTour
            function editTour(id){
                $frm.trigger("reset");
                let url = "<?php echo site_url("tour/adminEdit/"); ?>"+id;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    console.log(rs);
                    $.each(rs.get,(i,v)=>{
                    if(parseInt(v.mark_draft) !== 0){
                        $markDraft.prop("checked",true);
                    }
                        t_id.val(v.t_id);
                        kw_id.val(v.kw_id);

                        t_title.val(v.t_name); 
                        
                        og_url.val(v.og_url);
                        keyword.val(v.kw_page_keyword);
                        keydes.val(v.kw_page_des);

                        full_price.val(v.full_price);
                        t_duration.val(v.t_duration);
                        t_location.val(v.t_destination);

                        tinymce.get("tour_summary").setContent(v.t_summary);
                        tinymce.get("tour_detail").setContent(v.t_program);
                        let st_show = `<div class='alert alert-warning'>
<p>Editing...${v.t_name}</p>
</div>`;
                        $modal_status.html(st_show);
                        $($md).modal("show");
                    });

                }
                });
            }
            //---   saveTour
            function saveTour(){
                btnSave.unbind();
                $frm.submit(function(e){
                    e.preventDefault();
                    let url = $(this).attr("action");
                    let data = $(this).serialize()+"&action_id="+my_id;
                    $.post(url,data,(e)=>{
                        let rs = $.parseJSON(e);
                        $modal_status.html(`${rs.msg}`).show();
                        setTimeout(()=>{
                            $modal_status.html(`loading....`);
                            showForm("edit",rs.t_id); 
                            getSummary();
                        },2000);
                        //console.log(rs);
                    });
                });
            }
            //-------------
            //---   delTour
            function delTour(id){
                let url = "<?php echo site_url("tour/adminDel/"); ?>"+id;
                $.ajax({
                    url : url,
                        success : (e)=>{
                        let rs = $.parseJSON(e);
                        $page_status.html(rs.msg).show();
                        setTimeout(()=>{
                            $page_status.html("Loading...").fadeOut("slow");
                            getSummary();
                        },4000);
                }
                });
                
            }

            //-----------------
            function getSummary(){
                labelShow();
                listTour();
            }
            function getEl(el){
                return $P.find(el);
            }
            function getEvent(){
                getSummary();

                //--- lnCreate
                lnCreate.on("click",function(){
                    showForm();
                });

                //--- edit
                $tour_list.delegate(".lnEdit","click",function(){
                    let id = $(this).attr("data-t_id");
                    editTour(id);
                });


                //--- Delete
                $tour_list.delegate(".lnDel","click",function(){
                    let id = $(this).attr("data-t_id");
                    delTour(id);
                });


                //--- btnSave
                btnSave.on("click",function(){
                    saveTour();
                });
            }
            return {getEvent : getEvent}
        })();

        $t.getEvent();
    });
</script>

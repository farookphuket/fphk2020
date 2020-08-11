<script>

$(function(){
    var $el = $(".container");


    var booking = (function(){

        var $tk_list = $el.find(".tk_list");
        var $tk_pagin = $el.find(".tk_pagin");
        var $num_tk = $el.find(".num_tk");

        var bk_id = $el.find(".bk_id");

        //---form sent payment
        var frmReqPayment = $el.find("#frmSentPayment");
        var userfile = $el.find(".userfile");
        var cf_email = $el.find(".cf_email");
        var $img_preview = $el.find(".upload_img_preview");
        var $frmResult = $el.find(".frmResult");
        //----modal sent payment
        var $mdPayment = $el.find(".mdSentPayment");
        var $mdPlaceShowDetail = $el.find(".mdPlaceShowDetail");
        var btnSentPayment = $el.find(".btnSentPayment");

        function getMyTicketList(page=1){
            $tk_list.html("");
            var url = "<?php echo site_url("booking/getMyTicketList");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $num_tk.html(rs.num_ticket);
                    $.each(rs.get_ticket,function(i,v){

                        var tk_conf = `
                        <span class="badge badge-danger">Not Confirm</span>
                        `;
                        var btnConf = `
                        <button class="btn btn-primary btnConf" data-bk_id="${v.bk_id}">Sent my Payment</button>
                        `;
                        var btnPrint = `
                        <button class="btn btn-success btnPrint" data-bk_id="${v.bk_id}">Print My Ticket</button>
                        `;
                        var show_btn = btnConf;

                        if(parseInt(v.bk_confirm) !== 0){
                            tk_conf = `
                                <span class="badge badge-success"> Confirmed</span>
                            `;
                            show_btn = btnPrint;
                        }



                        var tmp = `
                        <div class="card">
                            <div class="card-header bg-primary">
                                <h3>${v.tour_name}</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>booking on</th>
                                            <td>${v.bk_datetime}</td>
                                        </tr>

                                        <tr>
                                            <th>Date of Departure</th>
                                            <td>${v.going_date}</td>
                                        </tr>

                                        <tr>
                                            <th>Ticket Status</th>
                                            <td>${tk_conf}</td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary btnView" data-bk_id="${v.bk_id}">Detail</button>
                                ${show_btn}
                            </div>
                        </div>
                        <hr class="my-4"/>
                        `;
                        $tk_list.append(tmp);

                    });
                }
            })
        }
        //-------------------------
        //---------viewMyTicket
        function viewMyTicket(id){
            $tk_list.html("");
            var url = "<?php echo site_url("booking/viewMyTicket/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.detail,function(i,v){
                        var tmp = `
                        <div class="card">
                            <div class="card-header bg-info">
                                <h3>${v.tour_name}</h3>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Name</th>
                                            <td>
                                                ${v.bk_user_name}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>email</th>
                                            <td>
                                                ${v.bk_email}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>pay Status</th>
                                            <td>
                                                ${v.bk_pay_status}
                                            </td>
                                        </tr>

                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button class="btn btn-primary btnBack">Back</button>
                            </div>
                        </div>
                        `;

                        $tk_list.append(tmp);
                    });
                    
                }
            });
        }
        //--------------------------
        //----------showInDetail
        function showInDetail(obj,showPlace){
            var rs = $.parseJSON(obj);
            showPlace.html("");
            console.log(rs);
            $.each(rs.detail,function(i,v){

                var img_path = "<?php echo site_url("public/payment_confirm/");?>"+v.user_payment_img;
                var tmp = `
                <div class="card">
                    <div class="card-header bg-primary">
                        <h2>${v.tour_name}</h2>
                    </div>
                    
                    <div class="card-body">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <img class="responsive" src="${img_path}" width="250"/>
                            </div>
                            <div class="col-md-6">

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Departure Date</th>
                                            <td>${v.going_date}</td>
                                        </tr>
                                    </table>
                                </div>


                            </div>
                        </div>
                        
                            
                        
                        
                    
                    
                        </div>


                </div>
                
                
                `;
                showPlace.append(tmp);
            });
            
        }

        //-----frmShowModal
        function frmSentPayment(id){
            var url = "<?php echo site_url("booking/viewMyTicket/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //showInDetail(e,$mdPlaceShowDetail);
                    //$($mdPayment).modal("show");
                    $.each(rs.detail,function(i,v){
                        var img_path = "<?php echo site_url("public/payment_confirm/");?>"+v.user_payment_img;

                        $mdPlaceShowDetail.html("");
                        var people = parseInt(v.bk_num_people);
                        var pTag = "person";
                        if(people > 1){
                            pTag = "people";
                        }
                        var tmp = `
                            <div class="card">
                                <div class="card-header">
                                    <h2>${v.tour_name}</h2>
                                </div>
                                
                                <div class="card-body">
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <img class="responsive" src="${img_path}" />
                                        </div>
                                        <div class="col-md-8 table-responsive">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Email</th>
                                                    <td>${v.bk_user_email}</td>
                                                </tr>

                                                <tr>
                                                    <th>Tour Name | ชื่อทัวร์</th>
                                                    <td>${v.tour_name}</td>
                                                </tr>

                                                <tr>
                                                    <th>people amount | จำนวนคน</th>
                                                    <td>${people} ${pTag}.</td>
                                                </tr>

                                                <tr>
                                                    <th>Price | ราคา</th>
                                                    <td>${v.pay_full_price}</td>
                                                </tr>


                                                <tr>
                                                    <th>Date Departure | วันเดินทาง</th>
                                                    <td>${v.going_date}</td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div>


                                </div>

                            </div>
                        `;
                        bk_id.val(v.bk_id);
                        cf_email.val(v.bk_user_email);
                        $mdPlaceShowDetail.append(tmp);
                        $($mdPayment).modal("show");
                    });
                 }
            });
        }
        //-----------------------
        //-----userSentPayment
        function userSentPayment(){
            btnSentPayment.unbind();
            $frmResult.html("");
            
            frmReqPayment.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var formData = new FormData(this);
                
                var req = new XMLHttpRequest();
                req.open("post",url);
                req.send(formData);
                req.onreadystatechange = function(){
                    if(req.readyState === 4){
                        if(req.status === 200){
                            var rs = req.responseText;
                            var p = JSON.parse(rs);
                            console.log(p);
                            $frmResult.html(p.msg);
                            setTimeout(function(){
                                $frmResult.html(`Loading...`).fadeOut("slow");
                                $img_preview.html("");
                                frmReqPayment.trigger("reset");
                                frmSentPayment(p.bk_id);
                                
                            },2000);
                            
                            
                            
                        }else{
                            console.log("req fail");
                            
                        }
                    }
                };

            });
            
        }

        //-----getSummary
        function getSummary(){
            getMyTicketList();
        }
        //-------------------------
        function getEvent(){
            getSummary();

            //----user click Detail button
            $tk_list.delegate(".btnView","click",function(){
                var id = $(this).attr("data-bk_id");
                viewMyTicket(id);
            });

            //------user click back
            $tk_list.delegate(".btnBack","click",function(){
                getMyTicketList();
            });

            //---user click print button
            $tk_list.delegate(".btnPrint","click",function(){
                var id = $(this).attr("data-bk_id");
                alert("print "+id);
            });

             //---user click sent payment button
             $tk_list.delegate(".btnConf","click",function(){
                var id = $(this).attr("data-bk_id");
                frmSentPayment(id);
            });


            //--show preview when user select file before upload
            userfile.on("change",function(e){
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var tmp = `<img src="${e.target.result}" class="responsive">`;

                    //--show image preview before upload
                    $(".upload_img_preview").html(tmp);
                };
            });

            //---user click submit button
            btnSentPayment.on("click",function(){
                userSentPayment();
            });

        }
        return{getEvent:getEvent}
    })();

    booking.getEvent();
});
</script>
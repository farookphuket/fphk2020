
<script>
    //-----------myBooking 1-2-19
    $(function(){
        var $el = $("#checkBooking");
        var myBooking = (function(){

            var $frmCh = $el.find("#check_my_booking");
            var email = $el.find(".ch_email");
            var btnCheck = $el.find(".btnCheck");

            //---modal sent payment
            var mdSent = $el.find(".mdSent");
            var h_payment = $el.find(".h_payment");
            var btnSent = $el.find(".btnSent");
            var bk_id = $el.find(".bk_id");
            var cf_email = $el.find(".cf_email");

            //--form id
            var frmReqPayment = $el.find("#sentPayment");
            var userfile = $el.find(".userfile");
            var $frmResult = $el.find(".frmResult");
            
            //--image preview
            var $img_preview = $el.find(".upload_img_preview");
            //--button in sent form
            var btnSentPayment = $el.find(".btnSentPayment");
            //---check_result
            var check_result = $el.find(".check_result");
            function chBooking(){
                btnCheck.unbind();
                check_result.html("");
                $frmCh.submit(function(e){
                    e.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        var rs = $.parseJSON(e);
                        var no_book = `
                        <div class="alert alert-danger">
                            <h2 class="text-center">${rs.msg}</h2>
                        </div>
                        `;
                        if(parseInt(rs.num_booking) !== 0){
                            //---found booking
                            console.log(rs.get_booking);
                            $.each(rs.get_booking,function(i,v){
                                
                                var pic_url = "<?php echo site_url("public/payment_confirm/");?>"+v.user_payment_img;

                                var btnShow = "";
                                var btnPrint = `
                                <button class="btn btn-success btnPrint" data-bk_id="${v.bk_id}">Print</button>
                                `;
                                var btnSentPayment = `
                                <button class="btn btn-warning btnSentPayMent" data-bk_id="${v.bk_id}">Sent My Payment</button>
                                `;
                                if(parseInt(v.bk_confirm) !== 0){
                                    btnShow = btnPrint;
                                }else{
                                    btnShow = btnSentPayment;
                                }

                                var ticket_status = `<span class="alert alert-danger">not confirm</span>`;
                                if(parseInt(v.bk_confirm) !==0){
                                    ticket_status = `<span class="alert alert-success"> confirm</span>`;
                                }

                                var tmp = `
                                <div class="card">
                                    <div class="card-header bg-info">
                                        <h2 class="text-center">${v.tour_name}&nbsp;
                                        <span class="bg-danger">${v.going_date}</span>
                                        </h2>
                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                    <img src="${pic_url} " class="responsive" />
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <tr>
                                                            <th>Name</th>
                                                            <td>${v.bk_user_name}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>Booking for</th>
                                                            <td>${v.tour_name}</td>
                                                        </tr>

                                                        <tr>
                                                            <th>people amount</th>
                                                            <td>${v.bk_num_people}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Ticket status</th>
                                                            <td>
                                                            ${ticket_status}
                                                            </td>
                                                        </tr>
                                                    </table>
                                            </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <h2 class="text-center">
                                                Dear customer '${v.bk_user_name}'
                                                </h2>
                                                <p>if you have paid or deposite your ticket but it is still say "not confirm" please contact our team immediately!</p>
                                            </div>
                                        </div>
                                        
                                    </div>

                                    <div class="card-footer">
                                        ${btnShow}
                                    </div>
                                </div>
                                `;
                                check_result.append(tmp);
                            });
                            
                        }else{
                            check_result.html(no_book);
                        }
                    });
                });
            }

            //----------user sent payment
            function sentPayment(id){
                //---load the modal upload pic form
                var url = "<?php echo site_url("booking/viewMyTicket/");?>"+id;
                $.ajax({
                    url : url,
                    success : function(e){
                        //console.log(e);
                        var rs = $.parseJSON(e);
                        
                        $.each(rs.detail,function(i,v){
                            cf_email.val(v.bk_email);
                            bk_id.val(v.bk_id);
                            h_payment.html(`sent confirm payment for ${v.bk_email}`);
                            $(mdSent).modal("show");
                        });
                        
                        
                    }
                });
            }
            //---------------------
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
                                //console.log(p);
                                $frmResult.html(p.msg);
                                setTimeout(function(){
                                    $frmResult.html(`Loading...`).fadeOut("slow");
                                    $img_preview.html("");
                                    frmReqPayment.trigger("reset");
                                    frmSentPayment(p.bk_id);
                                    
                                },9000);
                                
                                
                                
                            }else{
                                console.log("req fail");
                                
                            }
                        }
                    };

                });
                
            }

            //---printTicket
            //---14/4/19
            function printTicket(id){
                var url = "<?php echo site_url("booking/userPrintTicket/");?>"+id;
                //---open new tab
                var win = window.open(url, '_blank');
                if (win) {
                    //Browser has allowed it to be opened
                    win.focus();
                } else {
                    //Browser has blocked it
                    alert('Please allow popups for this website');
                }
            }

            //------------
            function getEvent(){
                btnCheck.on("click",function(){
                    chBooking();
                });

                //---anonymous sent payment
                check_result.delegate(".btnSentPayMent","click",function(){
                    var id = $(this).attr("data-bk_id");
                    sentPayment(id);
                });

                check_result.delegate(".btnPrint","click",function(){
                    var id = $(this).attr("data-bk_id");
                    printTicket(id);
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
                //----------------------------
                //---user sent payment button click
                btnSentPayment.on("click",function(){
                    userSentPayment();
                });
            }
            return{getEvent : getEvent}
        })();
       //---call object
       myBooking.getEvent();


    });
</script>
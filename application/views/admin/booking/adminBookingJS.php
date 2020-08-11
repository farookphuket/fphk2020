<script>

    $(function(){

        var $el = $("#ticket");

        var manBooking = (function(){
            var $bk_list = $el.find(".ticket_list");
            var $bk_paging = $el.find(".ticket_pagin");
            var $num_bk = $el.find(".num_bk");


            //----modal form edit
            var $md1 = $el.find(".mdEditTicket");
            var $md1Title = $el.find(".md1Title")
            var $mdResult = $el.find(".show_result");

            var $frmEdit = $el.find("#frmEditBooking");
            var bk_id = $el.find(".bk_id");
            var full_price = $el.find(".full_price");
            var cus_has_paid = $el.find(".cus_has_paid");
            var cus_pay_result = $el.find(".cus_pay_result");
            var num_p = $el.find(".num_people");
            var must_collect = $el.find(".must_collect");

            //---select
            var set_pay_option = $el.find(".set_pay_option");
            
            //---input pay_status
            var pay_status = $el.find(".pay_status");

            var set_conf = $el.find(".set_conf");
            var conf_txt = $el.find(".conf_txt");
            var conf_label = $el.find(".conf_label");
            conf_txt.attr("placeholder","Not confirm leave uncheck");
            var btnSave = $el.find(".btnSave");

            var pay_pic = "";
            var pax = "";
            


            function getBookingList(page=1){
                $bk_list.html("");
                var url = "<?php echo site_url("booking/adminGetBookingList/");?>"+page;
                $.ajax({
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        $num_bk.html(rs.num_bk);
                        //console.log(rs);
                        
                        $.each(rs.get_bk,function(i,v){
                            var bk_conf = `
                            <span class="badge badge-danger">Not Confirm</span>
                            `;
                            if(parseInt(v.bk_confirm) !== 0){
                                bk_conf = `
                            <span class="badge badge-success">Confirm</span>
                            `;
                            }

                            var show_img_url = "<?php echo site_url("public/payment_confirm/");?>"+v.user_payment_img;
                            var pic_url = "<?php echo site_url("public/payment_confirm/");?>"+v.user_payment_img;
                            var user_payment_pic = `
                                
                                
                                <a href="${show_img_url}" target="_blank">
                                    <img src="${pic_url}" class="responsive" width="85"/>
                                </a>
                            `;

                            var tmp = `
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tr>
                                        <th>
                                            Tour Name
                                        </th>
                                        <td>
                                            ${v.tour_name}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            ${v.bk_email}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Date Departure
                                        </th>
                                        <td>
                                            ${v.going_date}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Confirm Status
                                        </th>
                                        <td>
                                            ${bk_conf}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            User payment image
                                        </th>
                                        <td>
                                            ${user_payment_pic}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Manage
                                        </th>
                                        <td>
                                            <button class="btn btn-primary btnEdit" data-bk_id="${v.bk_id}">Edit</button>
                                        </td>
                                    </tr>



                                </table>
                            </div>
                            <hr class="my-4" />
                            `;

                            $bk_list.append(tmp);

                        });
                        $bk_paging.html(rs.pagination);
                    }
                });
            }


            //--------editTicket
            function editTicket(id){
                $mdResult.html("");
                var url = "<?php echo site_url("booking/modViewBooking/");?>"+id;
                $.ajax({
                    url : url,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        //console.log(rs.get_booking);
                        
                        $.each(rs.get_booking,function(i,v){
                            
                            pay_pic = v.user_payment_img;
                            var pic = "<?php echo site_url("public/payment_confirm/");?>"+pay_pic;
                            var num_people = parseInt(v.bk_num_people);
                            var num_label = "person";
                            if(num_people > 1){
                                num_label = "people";
                            }
                            pax = `${num_people} ${num_label}`;
                            var tmp = `
                            <div class="card">
                                <div class="card-header bg-primary">
                                    <h2>${v.tour_name}</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <img src="${pic}" class="responsive" width="150" />
                                        </div>

                                        <div class="col-md-9 table-responsive">
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Email</th>
                                                    <td>${v.bk_email}</td>
                                                </tr>
                                                <tr>
                                                    <th>Booking Date</th>
                                                    <td>${v.bk_datetime}</td>
                                                </tr>

                                                <tr>
                                                    <th>Booking for</th>
                                                    <td>${pax}</td>
                                                </tr>

                                                <tr>
                                                    <th>Date Departure</th>
                                                    <td>${v.going_date}</td>
                                                </tr>

                                                <tr>
                                                    <th>Pay Status</th>
                                                    <td>${v.bk_pay_status}</td>
                                                </tr>

                                               
                                            </table>
                                        </div>

                                    </div>
                                    
                                    
                                </div>
                            </div>
                            <br />
                            <br style="clear:both" />
                            
                            `;
                            $mdResult.append(tmp);

                            var add_title = `${v.tour_name}&nbsp; 
                            <span class="badge badge-danger">
                            date departure ${v.going_date}
                            </span>
                            !`;
                            $md1Title.html(add_title);
                            full_price.html(v.pay_full_price);
                            full_price.val(v.pay_full_price);
                            num_p.val(num_people);
                            bk_id.val(v.bk_id);
                            set_pay_option.val(v.pay_status);
                            cus_has_paid.val(v.pay_deposite);
                            
                            //---checkbox
                           if(parseInt(v.bk_confirm) !== 0){
                               conf_txt.val(`Confirmed`);
                               set_conf.prop("checked",true);
                           }else{
                                conf_txt.val(`Not Confirm`);
                                set_conf.prop("checked",false);
                           }
                           show_inForm();
                            $($md1).modal("show");
                        });
                    }
                })
            }

            //---------
            //--------show_inForm
            function show_inForm(){
                var has_pay = parseInt(cus_has_paid.val());
                var f_price = parseInt(full_price.val());
                var col_result = f_price-has_pay;

                
                cus_pay_result.html(has_pay);
                must_collect.html(col_result);
                must_collect.val(col_result);
            }
            //-----------
            //------setConfirm
            function setConfirm(){
                var opt = 0;
                var label = "";
                var tmp = ``;
                conf_label.html("");
                if(set_conf.is(":checked")){
                    opt = 1;
                    label = "Confirmed";
                    tmp = `
                    <div class="alert alert-success">
                    This booking is Confirmed!
                    </div>
                    `;
                }else{
                    opt = 0;
                    label = "Not Confirm";
                    tmp = `
                    <div class="alert alert-danger">
                    This booking is NOT Confirme!
                    </div>
                    `;
                }

                conf_txt.val(label);
                conf_label.html(tmp);
                set_conf.val(opt);
                //var show = `The option is ${opt} and label is ${label}`;
                //console.log(show);
                
            }
            //--------------
            //------setPayStatus
            function setPayStatus(){
                var full_p = parseInt(full_price.val());
                var cus_pay = parseInt(cus_has_paid.val());

                var must_depo = full_p/2;
                var opt = "";
                var pay = "wait_for_pay";
                if(cus_pay === full_p){
                    opt = 2;
                    pay = "paid";
                }else if(cus_pay !== 0){
                    pay = "deposit";
                    opt = 1;
                }else{
                    opt = 0;
                    pay = "never pay yet";
                }

                pay_status.val(pay);
                set_pay_option.val(opt);
            }
            //--------------
            function modSaveBooking(){
                btnSave.unbind();
                conf_label.html("").fadeOut("slow");
                $frmEdit.submit(function(o){
                    o.preventDefault();
                    var url = $(this).attr("action");
                    var data = $(this).serialize();
                    $.post(url,data,function(e){
                        var rs = $.parseJSON(e);

                        var bk_id = rs.bk_id;
                        var tmp = `<div class="alert alert-success">
                            <p>${rs.msg}</p>
                        </div>`;
                        conf_label.html(tmp).fadeIn("slow");
                        setTimeout(function(){
                            conf_label.html("").fadeOut("slow");
                            getSummary();
                            editTicket(bk_id);
                            
                        },4000);
                    });
                });
            }

            //-------------------
            function getSummary(){
                getBookingList();
            }
            function getEvent(){
                getSummary();

                //---edit button click
                $bk_list.delegate(".btnEdit","click",function(){
                    var id = $(this).attr("data-bk_id");
                    editTicket(id);
                });

                //--------pagination
                $bk_paging.delegate(".pagination a","click",function(e){
                    e.preventDefault();
                    var id = $(this).attr("data-ci-pagination-page");
                    getBookingList(id);
                });

                //---edit in form
                cus_has_paid.on("keyup",function(){
                    show_inForm();
                });

                cus_has_paid.on("blur",function(){
                    setPayStatus();
                });

                //----set confirm status
                set_conf.on("change",function(){
                    setConfirm();
                });

                //---btnSave click
                btnSave.on("click",function(){
                    modSaveBooking();
                });
            }
            return{
                getEvent : getEvent
            }
        })();

        manBooking.getEvent();
    });
    

</script>
<script>


//-------------
/////////////////////////////////////////////////////////
///////     14 Jan 2019     /////////////////////
//////////////////////////////////////////////////////
$(function(){
    var $el = $("#booking");

    var booking = (function(){

        var $frmBooking = $el.find("#bookingTour");
        var meta_url = $el.find(".meta_url");
        var bk_name = $el.find(".bk_name");
        var bk_email = $el.find(".bk_email");
        var bk_num = $el.find(".bk_num");
        var bk_price = $el.find(".bk_price");
        var bk_dep = $el.find(".bk_dep");
        var btnSaveBooking = $el.find(".btnSaveBooking")

        //---select
        var tour_list = $el.find(".tour_list");

        var tour_id = "<?php echo $this->uri->segment(3);?>";
        var $bookResult = $el.find(".bookResult");

        //----put the current date 
        var date = new Date().getDate();
        var month = new Date().getMonth()+1;
        var year = new Date().getFullYear();
        var cur_day = `${month}/${date}/${year}`;

        var $bookingMsgStatus = $el.find("#booking_message_status");
        var btnHide = $el.find(".btnHideBox");
        
        //---------------------------
        //-----uChooseTour
        function uChooseTour(id){
            tour_list.html("");
            var url = "<?php echo site_url("tour/uChooseTour/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    //console.log(e);
                    var rs = $.parseJSON(e);
                    $.each(rs.get_tour,function(i,v){
                        var tmp = `
                        <a class="dropdown-item lnViewTour" data-tour_id="${v.t_id}" href="#">${v.t_name}</a>
                        `;
                        tour_list.append(tmp);
                    });
                    
                }
            });
        }
        //----------------------------
        function uViewTour(id){
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
        //--------------------
        //-------uSaveBooking 16 jan 19
        function uSaveBooking(){
            btnSaveBooking.unbind();
            $frmBooking.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    console.log(rs);
                    var full_pay = 0;
                    var deposite = 0;
                    var tmp = "";
                    $(".msgResult").html("");
                    $.each(rs.get_booking,function(i,v){
                        full_pay = v.pay_full_price;
                        deposite = v.must_pay_deposite;
                        tmp = `
                        <p class="card-text">
                        dear <span class="badge badge-success">
                        ${v.bk_user_name}
                        </span>
                        your booking has been send but there will be not confirm! unless you have to make a payment as deposite at ${deposite} THB. or full pay at ${full_pay} THB. by choosing one of the payment method below. 
                        </p>
                        `;
                    });
                    
                    if(parseInt(rs.error) !== 1){
                        btnSaveBooking.prop("disabled",true);
                        $(".msgResult").append(tmp);
                        $bookingMsgStatus.show();
                    }else{
                        
                        $bookResult.html(msg);
                    }
                });
            });
        }

        //------------------------
        //-------showUserPrice
        function showUserPrice(){
            var num_people = bk_num.val();
            bk_price.val(0);

            var url = "<?php echo site_url("booking/uGetPayTag/");?>"+tour_id;

            $.ajax({
                type : "post",
                url : url,
                data : {bk_num: num_people},
                success : function(e){
                    var rs = $.parseJSON(e);
                    var price = parseInt(rs.full_price);
                    
                    bk_price.val(price);
                }
            });
            
        }

        //----------------
        //------getToutPrice
        function getTourPrice(id){
            //alert(`show price on tour id ${id}`);
            bk_price.val(0);
            var url = "<?php echo site_url("booking/uGetPayTag/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    var price = parseInt(rs.full_price);
                    bk_price.val(price);
                    var tour_name = rs.tour_name;
                    meta_url.val(tour_name);
                }
            });
        }
        /////////////////////////////////////////////
        ////////-------setDateBooking
        function setDateBooking(){
                $bookResult.html("");
                var url = "<?php echo site_url("booking/uSetDateBooking");?>";
                $.ajax({
                    type : "post",
                    url : url,
                    data : {bk_dep : bk_dep.val()},
                    success : function(e){
                        var rs = $.parseJSON(e);
                        var showMsg = `
                        <span class="badge badge-danger">${rs.msg}</span>
                        `;
                        if(parseInt(rs.error) !== 0){
                            showMsg = `
                        <span class="badge badge-danger">${rs.msg}</span>
                        `;
                        }else{
                            showMsg = `
                        <span class="badge badge-success">
                        ${rs.msg} 
                        </span>
                        `;
                        }
                        $bookResult.html(showMsg);
                    }
                });
        }
        /////////////////////////////////////
        function getEvent(){
            //---by default show today
            bk_dep.val(cur_day);
            $(".bk_dep").datepicker({
                onSelect : function(d,i){
                    if(d !== i.lastVal){
                        setDateBooking();
                    }
                }
            });

            //----hide the booking message status at page load
            $bookingMsgStatus.hide();

            //--btnHide
            btnHide.on("click",function(){
                $bookingMsgStatus.slideToggle();
                $frmBooking.trigger("reset");
            });
            //---------------
            uChooseTour(0);
            //----------------
            //------lnViewTour
            tour_list.delegate(".lnViewTour","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-tour_id");
               uViewTour(id);
            });
            getTourPrice(tour_id);
            //--------trigger bk_num
            bk_num.on("change",function(){
                showUserPrice();
            });
            //--------------
            //-----btnSaveBooking
            btnSaveBooking.on("click",function(){
                uSaveBooking();
            });
            //-------------
            $bookResult.html(`waiting...`);
        }
        return{getEvent : getEvent}
    })();
    booking.getEvent();
});



////////////////////////////////////////////////////////
//-----------------------
/*
$(function(){

    var $bk_el = $("#booking_form");
    var $booking = (function(){

        var bk_name = $bk_el.find(".bk_name");
        var btnSave = $bk_el.find(".btn_book");
        var $go_day = $bk_el.find(".go_day");


        //---current day
        var d = new Date().getDate();
        var m = new Date().getMonth()+1;
        var y = new Date().getFullYear();
        var cur_day = `${m}/${d}/${y}`;


        function check_name(){
            var cur_url = "<?php echo current_url();?>";
            var n = bk_name.val();
            alert(`The name is ${n} the url is ${cur_url} and the date is ${$go_day.val()}`);
        }
        function getEvent(){

            //---set the pick up date
            $($go_day).datepicker({
                onSelect : function(d,i){
                    if(d !== i.lastVal){
                        //set the pick date
                        
                    }
                }
            });

            //---get the current day to show
            $go_day.val(cur_day);

            //--submit
            btnSave.on("click",function(){
                check_name();
            });
        }
        return{getEvent:getEvent}
    })();
    $booking.getEvent();
});
*/
/*
$(function(){

    var $el = $("#booking_form");
   // var page_status = $el.find(".status");
   // var modal_status = $el.find(".modal_status");

    function showErrorMessage(f){
        var err = 0;
        var time = 7000;
        var msg = f.msg;
        if(f.time !== undefined){
            time = f.time
        }
        if(f.err === 0){
            msg = `
            <div class="alert alert-success">
            ${msg}
            </div>
            `;
        }else{
            msg = `
            <div class="alert alert-danger">
            ${msg}
            </div>
            `;
        }
        modal_status.html(msg).show();
        setTimeout(function(){
            modal_status.fadeOut("slow");
        },time);

    }

    var booking = (function(){

        //---booking form
        var bookingFrm = $el.find("#bookingFrm");
        var btnSave = $el.find(".btn_book");
        var btnCancle = $el.find(".btnCancle");
        btnSave.html("Please process the form").prop("disabled",true);

        var bk_name = $el.find(".bk_name");
        bk_name.attr("placeholder","Please enter your name");

        var bk_email = $el.find(".bk_email");
        bk_email.attr("placeholder","Please enter your E-Mail");

        var book_num = $el.find(".bk_num");

        //------------
        var $ch_email = $el.find(".tk_email");

        //--choose_tour
        //--comment out not use  var choose_tour = $el.find(".choose_tour");
        //---------------
        
        

        //--mon 14 may 2018
        var sel_tour = $el.find(".sel_tour");
        var tour_sum = $el.find(".tour_sum");

        //--input hidden
        var h_full_price = $el.find(".h_full_price");
        var h_min_price = $el.find(".h_min_price");
        var tour_name = $el.find(".tour_name");

        //text fill go_day
        var go_day = $el.find(".go_day");


        var date = new Date().getDate();
        var month = new Date().getMonth()+1;
        var year = new Date().getFullYear();


        //---textarea more detail
        var bk_detail = $el.find(".bk_more");
        bk_detail.attr("placeholder","Please enter more detail")
        .val("");
        //--------------------


        //---modal book confirm will show if the user done the booking in the correct way
        var mdConf = $el.find(".mdBookConfirm");
        var mdConfTitle = $el.find(".conf-title");
        var bk_ready = $el.find(".bk_ready");
        var btnClose = $el.find(".btnClose");
        var btnReload = $el.find(".btnReload");

        //-----save booking
        function saveBooking(){
            btnSave.unbind();
            
            bookingFrm.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(o){
                    //console.log(o);
                    var rs = $.parseJSON(o);
                    var errMsg = "<span class='alert alert-danger'>";
                    errMsg += rs.msg+"</span>";
                    
                    var successMsg = "<div class='alert'>"+rs.msg+"</div>";
                    if(parseInt(rs.err) === 1){
                        page_status.html(errMsg).show();
                        setTimeout(function(){
                            page_status.fadeOut("slow");
                            //show error on page
                        },2000);
                    }else{
                        //--booking is complete call a modal to show user
                        bk_ready.append(rs.msg);
                        $(mdConf).modal("show");

                    }
                });
            });
            

            
        }

        //---check the name
        function check_name(){
            var err = 0;
            var msg = "";
            var str = bk_name.val();
            if(!str || str.length < 3){
                err = 1;
                msg = "Error : name is empty or too short!";
            }

            if(parseInt(err) != 1){
                //modal_status.html("please enter your email").show();
                bk_email.focus();
            }else{
                alert(msg);
                setTimeout(function(){
                    bk_name.focus();
                },400);
            }
            
        }
        //-----------
        function check_email(){

            var msg = "";
            var err = 0;

            if(!bk_email.val()){
                err = 1;
                msg = "Error : please enter your email!";
            }else{
                var url = "<?php echo site_url("booking/check_booking");?>";
                var data = {cmd : "check_email",bk_email : bk_email.val()};
                $.ajax({
                    type : "post",
                    url : url,
                    data : data,
                    success : function(e){
                        var rs = $.parseJSON(e);
                        var errMsg = "<span class='alert alert-danger'>";
                        errMsg += rs.msg+"</span>";
                        if(parseInt(rs.err) === 1){
                            page_status.html(errMsg).show();
                            setTimeout(function(){
                                page_status.fadeOut("slow");
                                bk_email.focus();
                            },2000);
                        }else{
                            //book_num.focus();
                            //last_check();
                            sel_tour.focus();
                        }
                        

                    }
                });
            }

            modal_status.html(msg).show();
            
        }

        //---fetch the tour list to select list
        function getTourList(){
            var url = "<?php echo site_url("tour/getListTour");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get_tour_list,function(i,v){
                        var tmp = `
                            <option value="${v.t_id}">${v.t_name}</option>
                        `;
                        sel_tour.append(tmp);
                    });
                    
                }
            });
        }

        //--set tour
        function setTour(t){
            //alert(`you will go ${t}`);
            choose_tour.val(t);
        }

        //---
        //--mon 14 may 2018
        function ajaxSetTour(){
            tour_sum.html("");
            var t = sel_tour.val();
            
            var url = "<?php echo site_url("booking/ajaxGetTour");?>";
            var data = {t_id : t};
            $.ajax({
                type : "post",
                url : url,
                data :data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get,function(i,v){

                        var ln = "<?php echo site_url("tour/detail/");?>"+v.t_id;
                        var tmp = `
                        <div class="row">
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h2>You have choose
                                    <span class="label label-primary">
                                    ${v.t_name}
                                    </span>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                <p>
                                ${v.t_summary}
                                </p>
                                <p>
                                Please 
                                &nbsp;<a href="${ln}" target="_blank">Click here</a>&nbsp;
                                 to read all detail about your program
                                </p>
                                <h4>
                                price per person
                                &nbsp;<span class="label label-info">${v.full_price}</span>&nbsp; THAIBATH.
                                </h4>
                                <h4>
                                deposite per person
                                &nbsp;<span class="label label-warning">${v.min_price}</span>&nbsp; THAIBATH.
                                </h4>
                                </div>
                            
                            </div>
                            <div class="panel panel-info">
                                <div class="panel-heading">
                                    <h2>คุณได้เลือก
                                    <span class="label label-primary">
                                    ${v.t_name}
                                    </span>
                                    </h2>
                                </div>
                                <div class="panel-body">
                                <p>
                                ${v.t_summary}
                                </p>
                                <p>
                                โปรด 
                                &nbsp;<a href="${ln}" target="_blank">คลิกที่นี่</a>&nbsp;
                                 เพื่ออ่านรายละเอียด
                                </p>
                                <h4>
                                ราคาต่อ 1 คน 
                                &nbsp;<span class="label label-info">${v.full_price}</span>&nbsp; เงินบาทไทย
                                </h4>
                                <h4>
                                ต้องจ่ายมัดจำต่อ 1 ท่าน
                                &nbsp;<span class="label label-warning">${v.min_price}</span>&nbsp; เงินบาทไทย.
                                </h4>
                                </div>
                            
                            </div>
                        </div>
                        `;

                        tour_sum.append(tmp);
                        sel_tour.val(v.t_id);
                        h_min_price.val(v.min_price);
                        h_full_price.val(v.full_price);
                        tour_name.val(v.t_name);

                    });
                }
            });
        }

        //----
        function showFormDate(){
            var d = date;
            var m = month;
            var y = year;
            var f_result = m+"/"+d+"/"+y;
            go_day.val(f_result);
        }
        //------
        function setDateBooking(){
            
            var book_day = go_day.val();
            var url = "<?php echo site_url("booking/check_booking");?>";
            var data = {cmd : "pick_date",go_day : book_day};
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    var rs = $.parseJSON(e);
                    if(parseInt(rs.err) === 1){
                        var errMsg = "<span class='alert alert-danger'>";
                        errMsg += rs.msg+"</span>";
                        page_status.html(errMsg).show();
                        setTimeout(function(){
                            page_status.fadeOut("slow");
                            go_day.focus();
                        },2000);

                    }else{
                        last_check();
                    }
                }
            });
            
        }
        //--Add on thu 17 may 2018
        //-----thu 17 may 2018
        function letterCount(field){
            //alert(field.val().length);
            
            var num = parseInt(field.val().length);
            //var num = 0;

            parseInt(num);
            var msg = "";
            var tmp = ``;
            if(num < 15){
                msg = `<span class="label label-danger">${num}&nbsp;letter(s).</span>`;
            }else{
                msg = `<span class="label label-default">${num}&nbsp;letter(s).</span>`; 
            }
            tmp = `<h4>${msg}</h4>`;
            var show = `${tmp}`;
            
            modal_status.html(show);
        }
        //-----------
        function last_check(){
            var f = btnSave;
            var msg = "";
            var err = 0;
            btnSave.html("please process te form")
            .prop("disabled",true);
            if(!bk_name.val()){
                f = bk_name;
                msg = `Error : please check name field`;
                err = 1;
            }else if(!bk_email.val()){
                f = bk_email;
                msg = `Error : please check email field`;
                err = 1;
            }else if (!bk_detail.val()){
                err = 1;
                f = bk_detail;
                msg = `please fill your info such as your hotel,room number ,please note that this is important!`;
                
            }else{
                err = 0;
                msg = `you are ready to go ,please click the submit button.`;
                btnSave.html("Make Booking").prop("disabled",false);
            }
            showErrorMessage({err:err,msg:msg});
            setTimeout(function(){
                f.focus();
            },4000);
        }

        //------------
        //-----getCurrentUserInfo to put the name and email of the loged in user into the booking form
        function getCurrentUserInfo(){
            bk_name.attr("placeholder","PLEASE Enter YOUR Name");
            bk_email.attr("placeholder","PLEASE Enter YOUR EMAIL");
            var url = "<?php echo site_url("booking/getCurrentUserInfo");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.get_user,function(i,v){
                        if(v.passwd){
                            delete(v.passwd);
                            delete(v.about_user);
                            bk_name.val(v.name);
                            bk_email.val(v.email);
                            $ch_email.val(v.email);
                        }
                        //console.log(v);
                        
                    });
                    
                }
            });
        }
        //-----------
        
        //-----------
        function getEvent(){
            //show today in the select
            showFormDate();
            $(".go_day").datepicker({
                onSelect : function(d,i){
                    if(d !== i.lastVal){
                        setDateBooking();
                    }
                }
            });
            //----------------
            //----get the current user info Thu 11 Oct 2018
            getCurrentUserInfo();
            //--------------------------
            //check the name
            bk_name.on("blur",function(){
                check_name();
            });

            //--
            bk_detail.on("keyup",function(){
                //add 17 may 2018
                letterCount(bk_detail);
            });
            bk_detail.on("blur",function(){
                last_check();
            });

            //check the email
            bk_email.on("blur",function(){
                check_email();
            });
            
            /*
            choose_tour.on("change",function(){
                var tName = $(this).filter(":checked").val();
                setTour(tName);
            });
            comment out as no longer use
            */
            /*
            sel_tour.on("change",function(){
                //--add this on Mon 14/5/2018
                ajaxSetTour();
            });

            //----get the tour program into the list form
            getTourList();

            //---refresh page
            btnCancle.on("click",function(){
                location.reload();
            });
            

            btnSave.on("click",function(){
                
                saveBooking();
                
            });

            //$(mdConf).modal("show");
            //----Reload the page
            btnReload.on("click",function(){
                location.reload();
            });
        }
        return{getEvent : getEvent}
    })();
//////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////
////////////////////////------------Check booking

/*
    var checkBook = (function(){
        var showRes = $el.find(".showRes");

        var frmCheck = $el.find("#frmCheckBookingStatus");
        var tk_email = $el.find(".tk_email");
        var btnSub = $el.find(".btnSub");
        btnSub.prop("disabled",true);

        //---modal send payment
        var mdConfPayment = $el.find(".mdReqConf");
        var mdPaymentTitle = $el.find(".mdReqTitle");
        var ftReqConf = $el.find(".ftReqConf");//---not use
        var btnSentReq = $el.find(".btnSentReq");

        var frmReqConfirm = $el.find("#frmReqConfirm");
        
        //--file select
        var userfile = $el.find(".userfile");
        var bk_conf_id = $el.find(".bk_conf_id");
        var bk_conf_email = $el.find(".bk_conf_email");

        //---show the percent
        var progress_bar = $el.find(".progress-bar");
        var show_prog = $el.find(".show_prog");
        show_prog.html(0+"%");

        //-----------------div not found result
        

        function checkBooking(){
            btnSub.unbind();
            showRes.html("submiting...");

            frmCheck.submit(function(o){
                o.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(e){
                   // console.log(e);
                    var res = $.parseJSON(e);
                    var no = `
                    <h3>
                    Sorry! we haven't found any booking match by email 
                    <span class="label label-info">${tk_email.val()}</span>&nbsp;yet!
                    </h3>
                    `;
                    var y = `<h3>
                    you have made ${res.num_book} booking(s).
                    </h3>`;
                    if(parseInt(res.num_book) !== 0){
                            showRes.html(y);

                            var num = 0;
                            $.each(res.get_book,function(i,v){
                                num++;
                                var conf = `<h4>
                                <span class="label label-success">Confirmed</span>
                                </h4>`;
                                if(parseInt(v.bk_confirm) === 0){
                                    conf = `<h4>
                                                        <span class="label label-danger">
                                                            NOT Confirm
                                                        </span>
                                                        </h4>
                                                        <p>Apologize! Your ticket status is flag as "NOT confirm" because you haven't pay to activate your booking please contact us immediately if you already paid or deposite your ticket with us.</p>

                                                        <p>
                                                        ขออภัยค่ะ บัตรของท่านยังไม่ได้รับการรับรอง สาเหตุเป็นเพราะว่าท่านยังไม่ได้จ่ายเงินเพื่อยืนยันสิทธิ์ของท่าน หากท่านได้ชำระเงินไว้แล้ว กรุณาติดต่อกลับมาด่วนที่สุดค่ะ เพื่อเจ้าหน้าที่จะได้แก้ไขบัตรของท่านให้เรียบร้อย ต้องกราบขออภัยในความไม่สะดวกค่ะ.
                                                        </p>
                                                        `;
                                }
                                var tmp = `
                                <div class="table-responsive">
                                        <table class='table table-striped'>
                                            <tr>
                                                <th width=25%>Tour name</th>
                                                <td>${num}).${v.tour_name}</td>
                                            </tr>
                                            <tr>
                                                <th>Departure Date</th>
                                                <td>${v.going_date}</td>
                                            </tr>
                                            <tr>
                                                <th>Booking Status</th>
                                                <td>${conf}</td>
                                            </tr>

                                            <tr>
                                                <th>Sent my payment confirm</th>
                                                <td>
                                                    <p>
                                                        <a class="btn-pay btnReqPayment" href="#" data-bk_id="${v.bk_id}">Sent my payment</a>&nbsp;
                                                        
                                                        <a class="btn-pay btnPrintPayment" href="#" data-bk_id="${v.bk_id}">Print my Receipt พิมพ์ใบเสร็จ</a>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>&nbsp;</th>
                                                <td>&nbsp;</td>
                                            </tr>
                                        </table>    
                                </div>
                                `;
                                showRes.append(tmp);
                            });
                    }else{
                        showRes.html(no);
                    }
                    
                });    
            });
            
        }

        //---------------------------------
        //------sendConfBooking
        function sendConfBooking(id){
            
            var url = "<?php echo site_url("booking/userSendConfBooking/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs.get_booking);
                    
                    $.each(rs.get_booking,function(i,v){
                        bk_conf_id.val(v.bk_id);
                        bk_conf_email.val(v.bk_email);
                        $(mdConfPayment).modal("show");
                    });
                    
                    
                    //$(mdConfPayment).modal("show");
                    
                }
            })
        }
        //---------------------
        //-----------sendPaymentReq
        function sendPaymentReq(){
            //alert("woll upload picture for "+id);
            btnSentReq.unbind();
            btnSentReq.prop("disabled",true);

            frmReqConfirm.submit(function(e){
                e.preventDefault();

                var url = $(this).attr("action");
                var data = new FormData(this);
                
                var req = new XMLHttpRequest();
                req.upload.addEventListener('progress',function(e){
                    var percent = Math.round(e.loaded/e.total * 100);
                    
                    progress_bar.width(percent+"%").html(percent+"%");
                    show_prog.html(percent+"%");
                    //frm.find(".progress-bar").width(percent+"%");
                });

                req.addEventListener("load",function(e){
                    progress_bar.addClass("progress-bar-success").html("Upload Successfully...");
                });
                

                req.open("post",url);
                req.send(data);

                req.onreadystatechange = function(){
                    if(req.readyState === 4){
                        if(req.status === 200){
                            var rs = req.responseText;
                            var p = JSON.parse(rs);
                            //console.log(rs);
                            var msg_show = `
                            <h4>
                                <span class="label label-success">
                                    ${rs.msg}
                                </span>
                            </h4>
                            `;
                            mdPaymentTitle.html(rs.msg);
                            modal_status.html(msg_show);
                            setTimeout(function(){
                                modal_status.html("");
                                mdPaymentTitle.html("operation has completed!");
                                frmReqConfirm.trigger("reset");

                                show_prog.html(0+"%");
                                $(".preview").html("Your photo has uploaded! please close this window.");
                                progress_bar.removeClass("progress-bar-success")
                                    .width(0+"%")
                                    .html("Ready for new upload");

                            },2000);
                            
                            
                            
                        }else{
                            console.log("req fail");
                            
                        }
                    }
                };



            });
            

        }
        //----------------------------------
        //-----------userPrintReciept
        function userPrintReceipt(id){
            //alert(`The id ${id} will be print`);
            var url  = "<?php echo site_url("booking/userPrintReceipt/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    //console.log(rs);
                    var err_msg = `
                    <div class="row">
                        <div class="col-sm-10">
                            <h1 class="alert alert-danger">
                                Error !
                            </h1> 
                            <div class="alert alert-danger">
                                <p>
                                    There is none of the booking receipt that you have been loooking for.
                                </p> 
                                <p>
                                if you already paid for your confirm and you have send your payment to us,then please Urgent call or text +66 81-7346712 or +66 81 3974489 right now! 
                                </p>
                            </div>
                            
                            <br style="clear:both"/>
                        </div>
                      </div>
                    
                    `;
                    if(rs.get_book.length === 0){
                        
                        page_status.html(err_msg).show();
                    }else{
                        $.each(rs.get_book,function(i,v){
                            var rcp_id = v.bk_id;
                            var url = "<?php echo site_url("booking/printMyReceipt/");?>"+rcp_id;
                            var win = window.open(`${url}`,"_blank");
                            if(win){
                                win.focus();
                            }else{
                                alert(`Please ALLOW the popups window for this page!`);
                            }
                        });
                    }
                    
                }
            });
        }

        //----------------------------------
        function getEvent(){
            tk_email.on("focus",function(){
                btnSub.prop("disabled",false);
            });

            btnSub.on("click",function(){
                checkBooking();
            });

            showRes.delegate(".btnReqPayment","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-bk_id");
                //alert("send report "+id);
                sendConfBooking(id);
            });

            //-----printPayment event
            showRes.delegate(".btnPrintPayment","click",function(e){
                e.preventDefault();
                var id = $(this).attr("data-bk_id");
                userPrintReceipt(id);
            });

            //---button sentReq event
            btnSentReq.on("click",function(){
                sendPaymentReq();
            });
           


            //--show preview when user select file before upload
            userfile.on("change",function(e){
                var file = this.files[0];
                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e){
                    var tmp = `<img src="${e.target.result}" class="responsive">`;

                    //--show image preview before upload
                    $(".preview").html(tmp);
                };
            });

        }
        return{getEvent : getEvent}
    })();
    
    //--call check boking
    checkBook.getEvent();

    //---call booking
    booking.getEvent();
});
*/

</script>

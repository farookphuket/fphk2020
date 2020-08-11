<script>




$(function(){

    var $el = $(".container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");

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

        //--choose_tour
        //--comment out not use  var choose_tour = $el.find(".choose_tour");

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
        //---
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
            //check the name
            bk_name.on("blur",function(){
                check_name();
            });

            //--
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

            sel_tour.on("change",function(){
                //--add this on Mon 14/5/2018
                ajaxSetTour();
            });

            //---refresh page
            btnCancle.on("click",function(){
                location.reload();
            });
            

            btnSave.on("click",function(){
                
                saveBooking();
                
            });

            bk_detail.on("keyup",function(){
                letterCount(bk_detail);
            });

            //$(mdConf).modal("show");
            //----Reload the page
            btnReload.on("click",function(){
                location.reload();
            });
        }
        return{getEvent : getEvent}
    })();

    booking.getEvent();
});

</script>

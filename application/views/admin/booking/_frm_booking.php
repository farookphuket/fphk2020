<section id="booking">
    <div class="container">
        <h1 class="text-center frmHead">
        Edit Booking
        </h1>
        <hr class="my-4" />
    </div>
    <div class="container-fluid">
        <div class="list-group">
            <?php 
                //var_dump($get);
                $bk_name = "";
                $bk_id = "";
                $bk_email = "";
                $pay_status = 0;
                $pay_txt = "";
                $pay_img = "";
                $bk_fullprice = "";
                $has_pay = 0;
                $bk_more = "";
                $people = "";

                $going_date = "";
                $tour_name = "";
                $bk_conf = 0;
                
                foreach($get  as $row):
                    $bk_name = $row->bk_user_name;
                    $bk_email = $row->bk_email;
                    $pay_img = $row->user_payment_img;
                    $going_date = $row->going_date;
                    $bk_more = $row->bk_user_more;
                    $bk_fullprice = $row->pay_full_price;
                    $tour_name = $row->tour_name;
                    $people = $row->bk_num_people;
                    $pay_txt = $row->user_pay_as;
                    $bk_id = $row->bk_id;
                    $bk_conf = $row->bk_confirm;
                    $has_pay = $row->pay_deposite;
                endforeach;
                $img_url = site_url("public/payment_confirm/{$pay_img}");
            ?>
            
        </div>

        


        <div class="card">
            <img class="card-img-top responsive" src="<?php echo $img_url;?>"/>
            <div class="card-header">
                <h2 class="text-center">
                    Booking <?php echo $bk_name;?>
                </h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>
                                <?php echo $bk_name;?>
                            </td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <?php echo $bk_email;?>
                            </td>
                        </tr>
                        <tr>
                            <th>Tour Name</th>
                            <td>
                                <?php echo $tour_name;?>
                            </td>
                        </tr>
                        <tr>
                            <th>Going Date</th>
                            <td>
                                <span class="badge badge-danger">
                                <h4>
                                <?php echo $going_date;?>
                                </h4>
                                </span>
                                Booking on <?php 
                                    echo $row->bk_datetime;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>People on tour</th>
                            <td>
                                <?php 
                                    echo $people;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Full price</th>
                            <td>
                                <?php echo $bk_fullprice;?>
                            </td>
                        </tr>
                        <tr>
                            <th>Pay As</th>
                            <td>
                                <?php echo $pay_txt;?>
                            </td>
                        </tr>
                        
                    </table>
                </div>
                <div class="list-group">
                    <p>
                    User more info :
                    </p>
                    <span class="list-group-item">
                        <?php 
                            echo $bk_more;
                        ?>
                    </span>
                </div>
            </div>
        </div>
        <!--form to edit booking-->
        <h2>&nbsp;</h2>
        <form action="<?php echo site_url("booking/adminSaveBooking");?>" id="booking_frm">
            <!--input hidden--> 
            <input type="hidden" name="bk_id" class="bk_id" value="<?php echo $bk_id;?>" />
            <input type="hidden" name="num_people" class="num_people" value="<?php echo $people;?>" />
            <input type="hidden" name="full_price" class="full_price" value="<?php echo $bk_fullprice;?>" />

            <div class="form-group">
                <label for="user_pay">User Pay</label>
                <input type="number" name="user_pay" class="form-control user_pay" value="<?php echo $has_pay;?>"/>
            </div>
            <div class="form-group">
                <label for="pay_option">User Pay As</label>
                <select id="pay_option" class="form-control pay_option" name="pay_option">
                <?php 
                    if($pay_txt):
                        ?>
                <option value="<?php echo $pay_txt;?>">
                <?php echo $pay_txt;?>
                </option>
                        <?php
                    endif;
                ?>
                <option value="never_pay">Never pay</option>
                <option value="deposite">Deposite</option>
                <option value="paid">Pay full price</option>
                
                </select>
            </div>
            <br />
            <div class="input-group mb-3">
                
                <div class="input-group-prepend">
                    <div class="input-group-text">
                    <input type="checkbox" name="set_conf" class="set_conf" id="set_conf"  aria-label="Checkbox for following text input">
                    
                    </div>
                </div>
                <input type="text" class="form-control" value="Please check this box to confirm the ticket" disabled>
            </div>
            <div class="form-group">
                <label for="">&nbsp;</label>
                <div class="float-right">
                    <button class="btn btn-sm btn-primary btnSave" type="submit" form="booking_frm">Save</button>
                </div>
            </div>
            <div class="list-group">
                <div class='list-group-item'>
                    
                    The full price is <span class="badge badge-info full_txt">
                    0
                    </span>
                     - user has pay <span class="badge badge-warning depo_txt">0</span> = Will be collect more <span class="badge badge-info res_txt">0</span> Thaibath.
                </div>
                
            </div>

        </form>

        <!--end of form-->
    </div>

</section>
<script>

$(function(){


    var $page_status = $(".status");
    var $el = $("#booking");

    var editBooking = (function(){

        var $bHead = $el.find(".frmHead");
        var bk_name = "<?php echo $bk_name;?>";
        var $f = $el.find("#booking_frm");
        var bk_id = "<?php echo $bk_id;?>";
        var user_pay = $el.find(".user_pay");
        var pay_option = $el.find(".pay_option");
        var pay_txt = "<?php echo $pay_txt;?>"+2;
        var bk_conf = "<?php echo $bk_conf;?>";
        var set_conf = $el.find(".set_conf");
        var btnSave = $el.find(".btnSave");


        //---
        var fullPrice = "<?php echo $bk_fullprice;?>";

        //---text label
        var full_txt = $el.find(".full_txt");
        var depo_txt = $el.find(".depo_txt");
        var res_txt = $el.find(".res_txt");
        
        //---------------
        function getEditBooking(){
            if(parseInt(bk_conf) !== 0){
                set_conf.prop("checked",true);
            }
            $bHead.html(`Edit booking of ${bk_name}`);
            //pay_option.val(pay_txt);
            var cal = fullPrice-user_pay.val();
            full_txt.html(`${fullPrice}`);
            res_txt.html(cal);
        }
        //----------
        function showRes(){
            var pay = user_pay.val();
            var full = fullPrice;
            var cal = full-pay;

            
            depo_txt.html(pay);
            res_txt.html(cal);
        }
        //----saveBooking
        function saveBooking(){
            btnSave.unbind();
            $f.submit(function(e){
                e.preventDefault();
                var url = $(this).attr("action");
                var data = $(this).serialize();
                $.post(url,data,function(e){
                    var rs = $.parseJSON(e);
                    $page_status.html(rs.msg).show();
                    setTimeout(function(){
                        $page_status.html("loading...");
                        location.reload();
                    },2000);
                });
            });
        }
        //-------------
        function getEvent(){
            getEditBooking();

            //---show result on the screen
            user_pay.on("keyup",function(){
                showRes();
            });

            btnSave.on("click",function(){
                saveBooking();
            });
        }
        return{getEvent:getEvent}
    })();
    editBooking.getEvent();
});
</script>
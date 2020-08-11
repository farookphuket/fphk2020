
    <div class="jumbotron">
        <h1>Booking on <?php echo $today; ?></h1>
    </div>
<ul>
    
    <li class="alert alert-danger">
    This website never ask you to pay or input your personal information or credit card in any form,you have to pay throught "paypal","promtpay" or "7-eleven" only!
    </li>
    <li class="alert alert-danger">
    เราไม่เคยถามข้อมูลส่วนตัว หรือบัตรเครดิตของท่าน เว๊ปไซต์นี้ไม่รับจ่ายเงินกับทางเว๊บ ท่านต้องจ่ายผ่าน "paypal","promtpay","7-eleven" เท่านั้น
    </li>
</ul>


    <div class="page-header">
        <h1>Please Note! ได้โปรดอ่านก่อน!</h1>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <ol>
                <li>
                    This is not an automatic sytem!
                </li>
                <li>
                    Your booking will be flag as "NOT CONFIRM" after it has been save
                </li>
                <li>
                    to "CONFIRM" the booking you have to pay the deposit.
                </li>
                <li>
                    the deposit will be 1000 THB/person.
                </li>
                <li>
                    you will recieve the email from 
                    
                    <span class="label label-default">
                        <?php echo $admin_email;?>
                    </span>&nbsp;
                     in your mail box.this e-mail will inform you how you can pay your ticket.
                </li>
                <li>You can pay throught paypal,promtpay,7-evelen after your booking has create</li>


            </ol>
        </div>
         
        <div class="col-sm-6">
            <ol>
                <li>นี่ไม่ใช่ระบบอัตโนมัติ</li>
                <li>ท่านสามารถจองทัวร์กับทาง Web ได้</li>
                <li>กรุณาชำระค่ามัดจำ ค่ามัดจำ 1000 บาท/1 คน</li>
                <li>
                    หลังจากการสำรองที่นั่งของท่านได้รับการตรวจสอบแล้ว ท่านจะได้รับ ข้อความอีเมลจาก 
                    <span class="label label-default">
                        <?php echo $admin_email;?>
                    </span>&nbsp;
                     ที่ inbox ของท่านเพื่อไปสู่ขั้นตอนการจ่ายเงิน
                </li>
                <li>ท่านสามารถจ่ายเงินผ่านบัญชี paypal ,promtpay ,7-eleven เมื่อการจองของท่านเสร็จสิ้น</li>

            </ol>
        </div>
        

    </div>


<div class="col-sm-10">
        <div class="page-header">
            <h1>Make my booking</h1>
        </div>
       
        <form class="form-horizontal" action="<?php echo site_url("booking/save_booking");?>" id="bookingFrm">
            <div class="form-group">
                <label class="label-control col-sm-4">Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control bk_name" name="bk_name">
                    <input type="hidden" class="bk_ip" name="bk_ip" value="<?php echo $ip;?>" />
                    <input type="hidden" class="bk_num" name="bk_num"/>
                    <input type="hidden" class="h_full_price" name="h_full_price">
                    <input type="hidden" class="h_min_price" name="h_min_price">
                    <input type="hidden" class="tour_name" name="tour_name">
                </div>
            </div>
            <div class="form-group">
                
                <div class="well">
                <p>Please input the valid e-mail we will use this e-mail to contact you.</p>
                <p>
                กรุณาระบุอีเมลของท่าน เราจะติดต่อท่านผ่านอีเมลนี้
                </p>
                </div>
            </div>           
            <div class="form-group">
                <label class="label-control col-sm-4">E-Mail</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control bk_email" name="bk_email">
                </div>
            </div>
            <div class="form-group">
                <label class="label-control col-sm-4">What the tour program</label>
                <div class="col-sm-6">
                    <select class="form-control sel_tour" name="sel_tour">
                        <?php 
                            if($num_tour == 0):
                                ?>
                        <option value=0>--There is no program yet!--</option>
                                <?php
                            endif;

                        ?>
                        <option value=0>--Choose tour program--</option>
                        <?php 
                            $num = 0;
                            foreach($get_tour as $row):
                                $num++;
                                ?>
                        <option value="<?php echo $row->t_id;?>">
                            <?php echo"{$num}.{$row->t_name}";?>
                        </option>
                                <?php
                            endforeach;
                        ?>
                    </select>
                    
                    
                </div>
            </div>
            <div class="form-group">
                <div class="tour_sum">
                
                </div>
            </div>
             

            <div class="form-group">
                <label class="label-control col-sm-4">Number of People
</label>
                <div class="col-sm-6">
                    <select class="form-control bk_num" name="bk_num">
                <option value="1">1 person</option>
                <?php 
                    for($i=2;$i<71;$i++):

?>
    <option value="<?php echo $i;?>"><?php echo $i;?> People</option>
<?php
                    endfor;
                ?>

                    </select>
                </div>
            </div>  
            <div class="form-group">
                <label class="label-control col-sm-4">Dept. Date</label>
                <div class="col-sm-4">
                <p>Please choose the day</p>
                </div>
                <div class="col-sm-2">
                    <input type="text" class="form-control go_day" id="go_day" name="go_day">
                </div>
            </div>
            <div class="form-group">
                
                <div class="well">
                <p>
                if you are more than one person ,then please put every one name,age,food alergic(if any)
                <h4><span class="label label-danger">(food alergic mean something that if you eat you will die not that you do not like to eat)</span></h4> ,room number or where do you want us to pick you up this is very important so please do it as clear as possible in the below textbox.
                </p>
                <p>
                หากท่านมีสมาชิกมากกว่าหนึ่งคน กรุณาระบุ ชื่อ, อายุ, การแพ้อาหาร(ถ้ามี)<h4><span class="label label-danger">(แพ้อาหารหมายถึงสิ่งที่ท่านกิินเข้าไปแล้วท่านตาย ไม่ใช่สิ่งที่ท่านไม่ชอบกิน)</span></h4>,เบอร์ห้องหรือสถานที่ที่เราสามารถไปรับท่านได้ มันสำคัญมากโปรดระบุให้ชัดเจน ในช่องด้านล่าง
                </p>
                </div>
            </div> 
            <div class="form-group">
                <label class="label-control col-sm-4">MORE</label>
                <div class="col-sm-6">
                <textarea class="form-control bk_more" name="bk_more">
                </textarea>
                
                </div>
            </div>  
            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                <button class="btn btn-info btn_book" type="submit" form="bookingFrm">
                Booking
                </button>
                <button class="btn btn-default btnCancle" type="button">
                Cancle
                </button>
                </div>
            </div>  
            <div class="form-group">
                <label class="label-control col-sm-4">&nbsp;</label>
                <div class="col-sm-6">
                    <div class="modal_status">
                    
                    
                    </div>
                </div>
            </div>  
        </form>
    </div>

    <div class="modal fade mdBookConfirm">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal">
                    &times;
                    </button>
                    <h1 class="modal-title conf-title">your request has Done!</h1>
                </div>
                <div class="modal-body bk_ready">
                <!--dynamic content--> 
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success btnClose" type="button" data-dismiss="modal">
                    Hide Window
                    </button>
                    <button class="btn btn-danger btnReload" type="button">
                    Reload Page
                    </button>
                </div>
            </div>
        </div>
    
    </div>





<?php
require("bookingJS.php");

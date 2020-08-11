<div class="page-header">
    <h1>
    <span class="label label-default">
        <?php echo $this->user_type;?>
    </span>
     &nbsp;
     <span class="label label-success">
        <?php echo $user_name; ?>
     </span>&nbsp;Booking 
     <span class="label label-default booking_num">
                0
            </span>&nbsp; 
            item(s).
     </h1>
</div>
<br style="clear:both" />


<div class="row show-list">
    <ul class="booking_list">

    </ul>
    <div class="booking_pagin">
        <!--dynamic pagination-->
    </div>

</div>



<!--modal edit form--> 
<div class="modal fade mdEditBooking">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-header">
                    <button class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title mdEditTitle">
                        Edit form
                    </h1>
            </div>


            <div class="modal-body"><!--modal body start-->
                
                <div class="row">
                    <div class="col-md-6">
                        <h2>
                            Payment photo will show here
                        </h2>
                        <p class="payment_photo">
                            
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive tb_booking_detail">
                            
                        </div>
                    </div>
                </div>

                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h1>Please make sure this user has done payment!</h1>
                    </div>
                    <div class="panel-body">
                        
                        <!--warning start-->
                        <div class="row">
                            <div class="col-md-6">
                                <h2>Please read</h2>
                                <p>Make sure that you have check with the bank before you operate </p>
                            </div>
                            <div class="col-md-6">
                                <h2>โปรดทำความเข้าใจ</h2>
                                <p>
                                    โปรดตรวจสอบรายการจากธนาคารให้แน่ใจก่อนทำการอนุมัติ                                
                                 </p>
                            </div>
                            <br style="clear:both"/>
                        </div>
                        <!--Warning end end div.row--> 
                        <br />
                        <br style="clear:both" />
                            <!--form start-->
                            <form class="form-horizontal" id="frmBooking" action="<?php echo site_url("booking/adminSaveBooking");?>"> 
                                
                            <div class="form-group">
                                    <label class="label-control col-sm-4">Price in total</label>
                                    <div class="col-sm-6">
                                        <h3>
                                            <span class="label label-warning res_full_price">0</span>
                                        </h3>
                                        
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">User have paid</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="user_has_paid" class="form-control user_has_paid">

                                        <input type="hidden" name="bk_id" class="bk_id" />
                                        <input type="hidden" name="full_price" class="full_price" />
                                        
                                    </div>
                                    <span class="col-sm-2 res_user_paid">0</span>
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">Collect from Customer</label>
                                    <div class="col-sm-2">
                                        <input type="number" name="user_must_pay" class="form-control user_must_pay" disabled />
                                        <input type="hidden" name="user_must_pay" class="user_must_pay"/>
                                    </div>
                                    
                                    <br style="clear:both" />
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">Result</label>
                                    <div class="col-sm-2">
                                        <span class=" res_full_price">0</span> - 
                                        <span class=" res_user_paid">0</span> = 
                                        <span class=" res_pay_more">0</span>
                                        <br style="clear:both" />

                                    </div>
                                    
                                </div>

                                

                               
                                <br style="clear:both" />

                                <!--radio button for payment status start-->
                                <div class="form-group">
                                    <label class="label-control col-sm-4">Payment Status</label>
                                    <div class="col-sm-6">
                                        
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="pay_status" class="pay_status" value="bk_pay_deposite">
                                                Deposite paid
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label><input type="radio" name="pay_status" 
                                            class="pay_status" 
                                            value="bk_full_paid">
                                                booking has been Paid
                                            </label>
                                        </div>

                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="pay_status" class="pay_status"  value="bk_wait_pay">
                                                Waiting for payment
                                            </label>
                                        </div>

                                    </div>



                                </div>
                                <!--radio button for payment status End-->

                                <div class="form-group">
                                    <label class="label-control col-sm-4">Mark as on board</label>
                                    <div class="col-sm-6 input-group">
                                        <span class="input-group-addon">
                                            <input type="checkbox" name="mark_as_done" class="mark_as_done">
                                        </span>
                                        <span class="input-group-addon mark_txt">
                                            Mark as customer on board
                                        </span>

                                        <span class="input-group-addon">
                                            <input type="checkbox" name="booking_is_cancle" class="booking_is_cancle">
                                        </span>
                                        <span class="input-group-addon bkCancle_txt">
                                            Booking has cancle
                                        </span>
                                    </div>
                                </div>

                            </form>
                        <!--form end-->

                    </div><!--end of panel-body-->
                </div><!--end of form panel-->

                <!--panel booking result start-->
                <div class="booking_result">
                    
                </div>
                <!--panel booking result end-->
                
            </div><!--modal body end-->

            <div class="modal-footer">
                <div class="modal_status"></div>
                <button class="btn btn-primary btnSave" type="submit" form="frmBooking">
                    Save Booking
                </button>&nbsp;
                <button class="btn btn-danger btnClose" type="button" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>

</div>


<!--end modal edit form-->


<?php 
    require("moderateJS.php");
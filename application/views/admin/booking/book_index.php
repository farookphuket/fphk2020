<section class="p-0 ticket_admin">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-3">
                <h2>Admin Menu</h2>
                <ul class="list-group text-center">
                    <li class="list-group-item ">
                        <a href="#">Menu1</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Menu2</a>
                    </li>
                    <li class="list-group-item">
                        <a href="#">Menu3</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-8">
                <h2>Ticket Content
                <span class="badge badge-warning num_bk">0</span>&nbsp;item(s).
                </h2>
                <div class="ticket_list"></div>
                <div class="ticket_pagin"></div>
            </div>
        </div>
    </div>

    <!--modal--> 
    <div class="modal fade mdEditTicket">
        <div class="modal-dialog modal-lg">
            <div class="modal-content ">
                <div class="modal-header">
                    
                    <h3 class="modal-title md1Title">Modal title</h3>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="container">
                        <div class="row ">
                                <div class="col-md-10 show_result">
                                
                                </div>

                        </div>
                    </div>
                    <div class="container">
                        <div class="col-md-10">
                            <form class="form-horizontal" action="<?php echo site_url("booking/modSaveBooking");?>" id="frmEditBooking">
                            <input type="hidden" name="num_people" class="num_people"/>
                            <input type="hidden" name="bk_id" class="bk_id"/>
                            <input type="hidden" name="pay_status" class="pay_status"/>
                                

                                <div class="form-group">
                                    <label class="label-control col-sm-3">Full price</label>
                                    <div class="col-sm-4">
                                            <h3>
                                                <span class="badge badge-info full_price"></span>&nbsp;THB.
                                            </h3>
                                            
                                        <input type="hidden" name="full_price" class="full_price" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-3">Customer has pay</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control cus_has_paid" name="cus_has_paid" width="4"/>
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">Payment option</label>
                                    <div class="col-sm-3">
                                        <select class="form-control set_pay_option " name="pay_option" required>
                                        <option value="">--Select--</option>
                                        <option value="0">Never Pay Yet</option>
                                            <option value="1">Deposite</option>
                                            <option value="2">Paid</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">Confirm</label>
                                    <div class="col-sm-6 input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                            <input type="checkbox" aria-label="Checkbox for following text input" name="set_conf" class="set_conf">
                                            </div>
                                        </div>
                                        <input type="text" class="form-control conf_txt" aria-label="Text input with checkbox">
                                        
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="label-control col-sm-4">&nbsp;</label>
                                    <div class="col-sm-6">
                                        <span class="conf_label"></span>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="label-control col-sm-3">
                                    Summary
                                    </label>
                                    <div class="col-sm-6">
                                    <span class="full_price">0</span> - 
                                    <span class="cus_pay_result">0</span> = 
                                    <input type="hidden" class="must_collect" name="must_collect" />
                                    <span class="must_collect">0</span> THB.
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btnSave" type="submit" form="frmEditBooking">Save</button>

                </div>
            </div>
        </div>
    </div>

    <!--end of modal-->
</section>
<?php 
    $bkJs = "admin/booking/adminBookingJS.php";
    $this->load->view($bkJs);
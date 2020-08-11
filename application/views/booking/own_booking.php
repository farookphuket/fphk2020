<section class="user_ticket" id="user_ticket">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2 class="page-header">Recent Ticket for <?php echo $user_name;?>
                &nbsp;
                <span class="badge badge-info num_tk">0</span>&nbsp;item(s).
                </h2>
                <div class="ticket_u">
                    <div class="tk_list">
                        <!--dynamic list call by ajax-->
                    </div>
                    <div class="tk_pagin">
                        <!--dynamic pagination-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <!--modal form sent payment Start-->
        <div class="modal fade mdSentPayment">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title tl_sendPayment">Sent my payment</h2>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="mdPlaceShowDetail">
                        </div>
                    
                        <br style="clear:both" />
                        <form class="form-horizontal" id="frmSentPayment" action="<?php echo site_url("booking/userSentPayment");?>" enctype="multipart/form-data">
                        
                            <div class="form-group">
                                <label class="label-control col-sm-4">Email</label>
                                <div class="col-sm-6">
                                    <input type="email" name="cf_email" class="form-control cf_email" />
                                    <input type="hidden" name="bk_id" class="bk_id" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-control col-sm-4">Select your payment file</label>
                                <div class="col-sm-6">
                                    <input type="file" name="userfile" class="form-control userfile" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-control col-sm-4">Your Photo </label>
                                <div class="col-sm-6">
                                    <div class="upload_img_preview"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="label-control col-sm-4">&nbsp;</label>
                                <div class="col-sm-6">
                                    <div class="frmResult"></div>
                                </div>
                            </div>

                        </form>
                    
                    
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary btnSentPayment" type="submit" form="frmSentPayment">Sent My Payment</button> 
                    </div>
                </div>
            </div>
        </div>
        <!--modal form sent payment-->
    </div>
</section>
<?php 
    $tkJS = "booking/own_bookingJS.php";
    $this->load->view($tkJS);
?>
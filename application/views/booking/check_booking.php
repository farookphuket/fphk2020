<section id="checkBooking">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">Check My Booking</h1>
        <hr class="my-4" />
        <!-- fixed the layout problem on 8-Aug-2019 -->
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-12">
        <?php
          $f = "booking/_frm_checkbooking";
          $this->load->view($f);
        ?>
      </div>
    </div>
  </div>





    <div class="modal fade mdSent">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title h_payment">Sent my payment</h2>
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <!--form uploade pic-->

                <form class="form-horizontal" id="sentPayment" action="<?php echo site_url("booking/userSentPayment");?>" enctype="multipart/form-data">
                    <input type="hidden" class="cf_email" name="cf_email" />
                    <input type="hidden" name="bk_id" class="bk_id" />

                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input userfile" name="userfile" id="userfile" required>
                            <label class="custom-file-label" for="userfile">Choose file</label>
                        </div>


                    </div>
                    <br />
                    <div class="input-group">
                        <label class="label-control col-sm-4">Your Photo </label>
                        <div class="col-sm-6">
                            <div class="upload_img_preview"></div>
                        </div>
                    </div>
                    <br />
                    <div class="input-group">
                        <label class="label-control col-sm-4">&nbsp;</label>
                        <div class="col-sm-6">
                            <div class="frmResult"></div>
                        </div>
                    </div>

                </form>
                    <!--end form-->
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary btnSentPayment" type="submit" form="sentPayment">Sent</button>
                    <button class="btn btn-danger btnClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    </div>


</section>

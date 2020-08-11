<div class="container">
    <form id="check_my_booking" action="<?php echo site_url("booking/checkMyBooking");?>">
        <div class="row">
            <div class="col">
            <input type="email" class="form-control ch_email" id="ch_email" name="ch_email" placeholder="example@email.com" required>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary btnCheck" form="check_my_booking">
                    Check my booking
                </button>
            </div>
        </div> 
    </form>
</div>
<br />
<br />
<div class="row">
    <div class="container">
        <div class="check_result">

        </div>
    
    </div>
    
</div>


<?php 
    $js = "booking/_JS_check_booking.php";
    $this->load->view($js);
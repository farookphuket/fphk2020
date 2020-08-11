
<div class="container">

<?php 
    $t_id = $this->uri->segment(3);
?>
<form id="bookingTour" class="form-horizontal" action="<?php echo site_url("booking/uSaveBooking");?>">

    <label for="meta_url">Booking for</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="input_1">
            <?php echo site_url(); ?>
            </span>
        </div>
        <input type="text" class="form-control meta_url" name="meta_url" id="meta_url" aria-describedby="input_1" value="<?php echo current_url();?>">
        
        <!--tour id key-->
        <input type="hidden" name="tour_id" class="tour_id" value="<?php echo $t_id;?>"/>
            
            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Choose tour program</button>
                <div class="dropdown-menu tour_list">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                    <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                </div>
            </div>

    </div>

    <label for="bk_name">Name</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon2">your name</span>
        </div>
        <input type="text" class="form-control bk_name" id="bk_name" name="bk_name"  aria-label="bk_name" aria-describedby="basic-addon2" required>
    </div>  

    <label for="bk_email">E-mail</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon3">you@email.com</span>
        </div>
        <input type="email" class="form-control bk_email" id="bk_email" name="bk_email"  aria-label="bk_email" aria-describedby="basic-addon3" required>
    </div>

    <label for="bk_num">Amount</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon4">number of people on tour</span>
        </div>
        <input type="number" class="form-control bk_num" id="bk_num" name="bk_num"  aria-label="bk_num" aria-describedby="basic-addon4" value=2>
        <div class="input-group-append">
            <label class="input-group-text" for="bk_num">people</label>
        </div>
    </div>

    <label for="bk_dep">Date Departure</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon5">Depature</span>
        </div>
        <input type="text" class="form-control bk_dep" id="bk_dep" name="bk_dep"  aria-label="bk_dep" aria-describedby="basic-addon5">
    </div>

    <label for="bk_pickup">where do we meet?</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon6">Pickup from</span>
        </div>
        <textarea class="form-control bk_pickup" aria-label="bk_pickup" id="bk_pickup" name="bk_pickup" aria-describedby="basic-addon6"></textarea>
    </div>

    <br />
    <label for="bk_price">total price</label>
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text" id="basic-addon7">total price</span>
        </div>
        <input type="number" class="form-control bk_price" id="bk_price" name="bk_price"  aria-label="bk_price" aria-describedby="basic-addon7">
        <div class="input-group-append">
            <label class="input-group-text" for="bk_price">THAIBATH.</label>
        </div>
    </div>

    
    
        
    


</form>

</div>
<br />
<br />
<div class="container" id="booking_message_status">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header bg-warning">
                <h2 class="text-center text-white">Thank you for booking with us</h2>
            </div>
            <div class="card-body msgResult">
                <p class="card-text">Dear <span class="badge badge-success bk_name">customer</span>
                your booking has been successfully send 
                </p>
                <p class="card-text">but your booking will not be confirm unless you have pay </p>
            </div>
            <div class="card-footer">
                <span class="float-right">
                    <button class="btn btn-primary btnHideBox">Yes,I know it</button>
                    
                </span>
                
            </div>
        </div>
    </div>
</div>

<?php 
    $bkJS = "booking/bookingJS.php";
    $this->load->view($bkJS);


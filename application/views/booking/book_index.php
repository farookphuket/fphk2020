<section id="booking">

    <div class="row">
            <div class="col-lg-12">
                <!--load form here--> 
                <div class="card">
                    <div class="card-heading bg-info">
                        <h1 class="text-center text-white">Make Your Booking</h1>
                    </div>
                    <div class="card-body">
                        <?php 
                        $frmBooking = "booking/_frm_booking.php";
                        $this->load->view($frmBooking);
                    ?>
                    </div>
                    <div class="card-footer">
                        <span class="bookResult"></span>
                        <span class="float-right">
                            <button class="btn btn-primary btnSaveBooking" form="bookingTour" type="submit">Booking</button>
                        </span>
                        
                    </div>
                </div>
                


            </div>

    </div>

</section>
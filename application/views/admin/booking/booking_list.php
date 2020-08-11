<section id="booking">
    <div class="container">
        <h1 class="text-center bookHead">Booking list</h1>
        <hr class="my-4" />
    </div>
    <div class="container-fluid">
        <div class="booking_list"></div>
        <div class="booking_pagin"></div>
    </div>
</section>
<script>
    //--jQuery 12/4/19 5:12 p.m. 

    $(function(){

        var $el = $("#booking");
        var $page_status = $(".status");

        var mBooking = (function(){

            var $book_list = $el.find(".booking_list");
            var $book_pagin = $el.find(".booking_pagin");
            //----getBookingList
            function getBookingList(page=1){
                var url = "<?php echo site_url("booking/adminGetBookingList/");?>"+page;
                $.ajax({
                    url : url,
                    success : function(e){
                        
                        $book_list.html("");
                        var rs = $.parseJSON(e);
                        //console.log(rs);
                        
                        $.each(rs.get_bk,function(i,v){
                            var editUrl = "<?php echo site_url("booking/adminEditBooking/");?>"+v.bk_id;
                            var confirm = `
                            <span class="badge badge-success">Yes</span>
                            `;
                            if(parseInt(v.bk_confirm) === 0){
                                confirm = `
                            <span class="badge badge-danger">No</span>
                            `;
                            }
                            var tmp = `
                            <div class="list-group">
                                <div class="list-group-item">
                                <div>
                                click 
                                <a class="btn btn-info btn-sm" href="${editUrl}">
                                    ${v.bk_user_name}
                                </a>
                                 to view the detail.
                                </div>
                                <p>&nbsp;</p>
                                <div class="table-responsive">
                                <table class="table table-bordered">
                                <tr>
                                    <th>
                                    Date going
                                    </th>
                                    <td>
                                    
                                    <span class="badge badge-danger">
                                        ${v.going_date}
                                    </span>
                                    
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                    Date Booking
                                    </th>
                                    <td>
                                    
                                    <span class="badge badge-warning">
                                        ${v.book_record_day}
                                    </span>
                                    
                                    
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                    Booking confirm
                                    </th>
                                    <td>
                                    
                                    
                                        ${confirm}
                                    
                                    
                                    
                                    </td>
                                </tr>
                                </table>
                                
                                </div>
                                </div>
                                
                            </div>
                            <br />
                            `;
                            $book_list.append(tmp);
                        });
                        
                    }
                });
            }
            //----------
            function getEvent(){
                getBookingList();
            }
            return{getEvent:getEvent}
        })();

        mBooking.getEvent();
    });

</script>
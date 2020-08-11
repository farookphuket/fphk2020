<script>

$(function(){
    //---Create Wed 3 Oct 2018

    var $el = $(".container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");

    var $user = (function(){

        var user_id = "<?php echo $user_id;?>";
        var $user_info = $el.find(".user_info");
       
       //----user post
       var $user_post = $el.find(".user_post");
       var $num_post = $el.find(".num_post");
       var $post_pagin = $el.find(".post_pagin");

       //------booking
       var $booking_list = $el.find(".booking_list");
       var $book_pagin = $el.find(".book_pagin");
       var $num_booking = $el.find(".num_booking");

       //------picture
       var $pic_list = $el.find(".pic_list");
        

        var no_data = `
            <div class="alert alert-danger">
                <h2>There is no data found!</h2>
            </div>
        `;

        //----------------------
        function uGetUserInfo(id){
            $user_info.html("");
            var url = "<?php echo site_url("users/uGetUserInfo/");?>"+id;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $.each(rs.user_info,function(i,v){
                        
                        var tmp = `
                           <div class="panel-heading">
                            <h2>${v.name}</h2>
                           </div>
                           <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bodered">
                                    <tr>
                                        <th>
                                            Name
                                        </th>
                                        <td>
                                            ${v.name}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            ${v.email}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            Date register
                                        </th>
                                        <td>
                                            ${v.date_register}
                                        </td>
                                    </tr>
                                </table>
                            </div>    
                        

                           </div>
                           
                            
                        `;
                        $user_info.append(tmp);
                    });
                }
            });
        }
        //--------------
        //------ uGetUserPost
        function uGetUserPost(page=1){
            $user_post.html("");
            var url = "<?php echo site_url("users/uGetPost/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $num_post.html(rs.num_post);
                    if(parseInt(rs.num_post) == 0){
                        //console.log(`num is ${rs.num_post}`);
                        $user_post.html(no_data);
                    }else{
                        $.each(rs.get_post,function(i,v){
                            var ln_read = "<?php echo site_url("article/read/");?>"+v.ar_id;
                            var tmp = `
                            
                                <li>
                                    <div class="content-wrap">
                                        <h3>
                                            <a href="${ln_read}" target="_blank" title="click to read more">
                                                ${v.ar_title}
                                            </a>
                                        
                                        
                                        </h3>
                                        <p>
                                            ${v.ar_summary}
                                        </p>
                                        <p>
                                            Date Create ${v.date_add} 
                                        </p>
                                        <p>
                                            date edit ${v.date_edit}
                                        </p>
                                    </div>
                                </li>
                                <br style="clear:both"/>
                            `;

                            $user_post.append(tmp);
                        });
                        $post_pagin.html(rs.pagination);
                    }
                }
            });
        }
        //-----------------------
        //-----------uGetBooking
        function uGetBooking(page=1){
            var url = "<?php echo site_url("users/uGetBooking/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    $booking_list.html("");
                    $.each(rs.user_info,function(i,v){
                        if(v.passwd){
                            delete(v.passwd);
                            delete(v.about_user);
                        }
                    });
                    //console.log(rs.user_info);
                    
                    if(parseInt(rs.num_booking) !== 0){
                        $num_booking.html(rs.num_booking);
                        $.each(rs.get_booking,function(i,v){
                            var people = "person";
                            if(parseInt(v.bk_num_people) > 1){
                                people = "people";
                            }
                            
                            var tmp = `
                                <li>
                                    <div class="content-wrap">
                                        <h2>
                                        
                                            ${v.tour_name}
                                       
                                        
                                        </h2>
                                        <p>Date Departure ${v.going_date}</p>
                                        <p>Booking on ${v.book_record_day}</p>
                                        <p>Booking for ${v.bk_num_people} ${people}.</p>
                                        <br style="clear:both" />
                                        <hr />
                                        
                                    </div>
                                </li>
                            `;

                            $booking_list.append(tmp);
                        });
                    }else{
                        $booking_list.html(no_data).show();
                    }
                    
                    
                }
            });
        }
        //------------------------
        //------uGetPhoto
        function uGetPhoto(page=1){
            var url = "<?php echo site_url("users/uGetPhoto/");?>"+page;
            $.ajax({
                url : url,
                success : function(e){
                    //console.log(e);
                    $pic_list.html("");
                    var rs = $.parseJSON(e);

                    //console.log(rs);
                    $.each(rs.user_info,function(i,v){
                        if(v.passwd){
                            delete(v.passwd);
                            delete(v.about_user);
                        }
                    });
                    $.each(rs.get_photo,function(i,v){
                        var img_url = "<?php echo site_url("public/image/thumb/");?>"+v.thumb_name;
                        var tmp = `
                        <li>
                            <div class="content-wrap">
                                <h2>${v.pic_title}</h2>
                                <p>
                                <img src="${img_url}" class="responsive"/>
                                </p>
                                <p>Date Add ${v.date_add}</p>
                            </div>
                        </li>
                        `;
                        $pic_list.append(tmp);
                    });
                }
            });

        }
        //-------------------------
        function getSummary(){
            uGetUserInfo(user_id);
            uGetUserPost();
            uGetBooking();
            uGetPhoto();
        }
        //----------------------------
        //-----------------------------
        function getEvent(){
            getSummary();

            //------pagiantiuon
            $post_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                var cur_page = $(this).attr("data-ci-pagination-page");
                uGetUserPost(cur_page);
                
            });
        }
        return{getEvent : getEvent}
    })();

    $user.getEvent();
});
//-------------------------------
/*
$(function(){

    var $el = $(".container");
    var page_status = $el.find(".status");
    var modal_status = $el.find(".modal_status");
    var memberSummary = (function(){

        /*
        ##---User show summary after they have login
        ##---will show the notification 
        ##---booking or article 
        ##---Last update on Thu 26 Apr 2018
        */
        /*
        var ar_show_list = $el.find(".ar_summary_list");

        var faq_show_list = $el.find(".faq_summary_list");

        function getSummary(){
            var url = "<?php echo site_url("users/ajaxUserSummary");?>";
            var data = {
                user_id : "<?php echo $user_id;?>",

            };
            $.ajax({
                type : "post",
                url : url,
                data : data,
                success : function(e){
                    
                    var rs = $.parseJSON(e);
                    console.log(rs);
                    
                    var showAr = `
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    All article
                                </th>
                                <td>
                                    <h4>
                                    <span class="label label-default">
                                        ${rs.get_ar.num_all_ar}
                                    </span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Public
                                </th>
                                <td>
                                    <h4>
                                    <span class="label label-success">
                                        ${rs.get_ar.num_pub_ar}
                                    </span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Approve
                                </th>
                                <td>
                                    <h4>
                                    <span class="label label-success">
                                        ${rs.get_ar.approve}
                                    </span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Private Article
                                </th>
                                <td>
                                    <h4>
                                    <span class="label label-warning">
                                        ${rs.get_ar.num_pri_ar}
                                    </span>
                                    </h4>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Not Approve
                                </th>
                                <td>
                                    <h4>
                                    <span class="label label-danger">
                                        ${rs.get_ar.not_approve}
                                    </span>
                                    </h4>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                    `;

                    var showFaq = `
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>
                                    All Message
                                </th>
                                <td>
                                    <h4>
                                        <span class="label label-default">
                                            ${rs.get_faq.all_faq}
                                        </span>
                                    </h4>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Has reply
                                </th>
                                <td>
                                    <h4>
                                        <span class="label label-success">
                                            ${rs.get_faq.has_reply}
                                        </span>
                                    </h4>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Not reply
                                </th>
                                <td>
                                    <h4>
                                        <span class="label label-danger">
                                            ${rs.get_faq.no_reply}
                                        </span>
                                    </h4>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    `;
                    
                    
                    ar_show_list.append(showAr);
                    faq_show_list.append(showFaq);

                }
            })
        }

        function getEvent(){
            //console.log(`member summary is run`);
            getSummary();
            
        }
        return{getEvent : getEvent}
    })(); 
    memberSummary.getEvent();

});
*/
//----------------------------------

</script>
<script>

$(function(){
    
    var $el = $("#container");

    var book = (function(){

        //--booking show list
        var bk_list = $el.find(".book_summary_list");
        //var url = "<?php //echo site_url("booking/summary");?>";

        //---------
        function bookSummary(){
            var url = "<?php echo site_url("booking/summary");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    var tmp = `
                    <table class="table table-striped">
                    <tr>
                    <th>All booking รายการบุ๊กกิ้งทั้งหมด</th>
                    <td>
                    ${rs.book_all}
                    </td>
                    </tr>
                    <tr>
                    <th>booking has Confirm จ่ายเงิน หรือ จ่ายมัดจำแล้ว</th>
                    <td>
                    
                        <h4>
                            <span class="label label-success">
                                ${rs.confirm}
                            </span>
                        </h4>
                    </td>
                    </tr>
                    <tr>
                    <th>booking not Confirm ยังไม่จ่าย</th>
                    <td>
                        <h4>
                            <span class="label label-danger">
                            ${rs.not_confirm}
                            </span>
                        </h4>
                    
                    </td>
                    </tr>
                    </table>
                    
                    `;

                    bk_list.append(tmp);
                    
                }
            });
        }
        //---------
        function getEvent(){
            bookSummary();
        }
        return{getEvent : getEvent}
    })();

    //--call booking
    book.getEvent();

    //--article 
    var article = (function(){
        
        var ar_summary_list = $el.find(".ar_summary_list");

        function articleSummary(){
            var url = "<?php echo site_url("article/summary");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    var tmp = `
                    <table class="table table-striped">
                    <tr>
                    <th>
                    All Article บทความทั้งหมด
                    </th>
                    <td>
                        <h4>
                        <span class="label label-default">
                        ${rs.all}
                        </span>
                        </h4>
                    </td>
                    </tr>
                    <tr>
                    <th>
                    Not Approve ยังไม่ได้ตรวจสอบ
                    </th>
                    <td>
                        <h4>
                        <span class="label label-danger">
                        ${rs.not_approve}
                        </span>
                        </h4>
                    </td>
                    </tr>
                    </table>
                    `;
                    ar_summary_list.append(tmp);
                }
            });
        }
        //----
        function getEvent(){
            articleSummary();
        }
        return{getEvent : getEvent}
    })();

    article.getEvent();
    //----end article
    var tour = (function(){

        var tour_list = $el.find(".tour_summary_list");
        
        function tourSummary(){
            var url = "<?php echo site_url("tour/summary");?>";
            $.ajax({
                url : url,
                success : function(e){
                    var rs = $.parseJSON(e);
                    var tmp = `
                    <table class="table table-striped">
                    <tr>
                    <th>
                    All program | รายการทัวร์ทั้งหมด
                    </th>
                    <td>
                    <h4>
                    <span class="label label-info">
                        ${rs.all_tour}
                    </span> 
                    </h4>
                    </td>
                    </tr>
                    </table>
                    `;
                    tour_list.append(tmp);
                }
            });

        }
        function getEvent(){
            tourSummary();
        }
        return{getEvent : getEvent}
    })();
    tour.getEvent();

});


</script>
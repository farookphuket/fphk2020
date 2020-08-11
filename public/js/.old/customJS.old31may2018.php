<script>



function count_visit(){

    //console.log("This is the visitor count");
    var $el = $(".container");
    var pl = $el.find("#visiter");

    var url = "<?php echo site_url("visiter/summary");?>";
    $.ajax({
        url : url,
        success : function(e){
            var rs = $.parseJSON(e);
            var ip = "<?php echo $ip;?>";
            var tmp = `
                <h4>
                   ${rs.ap_name} : <span class="label label-primary">
                   ${rs.ap_version}
                   </span>&nbsp;
                   IP : <span class="label label-default">
                   ${ip}
                   </span>&nbsp;
                   All visit : <span class="label label-success">
                   ${rs.all_visit}
                   </span>&nbsp;
                   today visit : <span class="label label-info">
                   ${rs.today_visit}
                   </span>&nbsp;
                   month visit   : <span class="label label-info">
                   ${rs.month_visit}
                   </span>&nbsp;
                   year visit : <span class="label label-info">
                   ${rs.year_visit}
                   </span>&nbsp;
                </h4>
            `;
            pl.html(tmp);
        }
    });
    
}

count_visit();

</script>




    

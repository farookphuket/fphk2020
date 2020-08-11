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
                <div class="row">
                    <div class="col-sm-4">
                    ${rs.ap_name} : 
                    <span class="label label-primary">
                        ${rs.ap_version}
                    </span>
                    </div>
                    <div class="col-sm-4">
                    IP  : 
                    <span class="label label-default">
                        ${ip}
                    </span>
                    </div>
                    <div class="col-sm-4">
                        All Visitor : 
                        <span class="label label-success">
                            ${rs.all_visit}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        Tody Visitor : 
                        <span class="label label-info">
                            ${rs.today_visit}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        Month Visitor : 
                        <span class="label label-info">
                            ${rs.month_visit}
                        </span>
                    </div>
                    <div class="col-sm-4">
                        Year Visitor : 
                        <span class="label label-info">
                            ${rs.year_visit}
                        </span>
                    </div>
                </div>
            `;
            pl.html(tmp);
        }
    });
    
}

count_visit();

function scroll (go,place) {
   
    var el = document.getElementById(place);
  //if (el) el.scrollIntoView({behavior: 'smooth', block: 'start'})
    var url = "<?php echo site_url("/index.php/#");?>"+go;
    el.scrollIntoView(url);

}

</script>




    

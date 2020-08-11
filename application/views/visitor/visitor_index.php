<section id="visitor">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">Visitor</h1>
      </div>
      <div class="col-lg-12">
        <div class="row">
          <div class="col-md-3">
            <div class="alert alert-info">
              <h1 style="text-align:right" class="numToday">0</h1>
            </div>
            <p>Visitor today</p>
          </div>
          <div class="col-md-3">
            <div class="alert alert-info">
              <h1 style="text-align:right;color:blue;" class="numMonth">0</h1>
            </div>
            <p>Visitor this month</p>
          </div>
          <div class="col-md-3">
            <div class="alert alert-info">
              <h1 style="text-align:right;color:blue;" class="numAll">0</h1>
            </div>
            <p>All Visitor</p>
          </div>
          <div class="col-md-3">
            <p class="cur_ip">
              IP : <?php echo $ip;?>
            </p>
            <p class="cur_os">
              OS  : <?php echo $os;?>
            </p>
            <p class="cur_browser">
              Browser : <?php echo"{$browser_name} version {$browser_version}";?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
$(function(){
    /*
        * 14-Dec-2019
        * Start using vs style
        *
     */
    const $PL = $("#visitor");
    const $os = "<?php echo $os; ?>";
    const $ip = "<?php echo $ip; ?>";
    const $browser = "<?php echo $browser_name; ?>";
    const $b_version = "<?php echo $browser_version; ?>";

    const $vis = (function(){

        let $label_all = getEl(".numAll");
        let $label_month = getEl(".numMonth");
        let $label_today = getEl(".numToday");


        function todayVisit(){
            $label_today.html("Loading...");
            let url = "<?php echo site_url("visitor/getTodayVisit"); ?>";
            $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $label_today.html(rs.num_today);

                    $label_month.html(rs.num_month);
                    $label_all.html(rs.num_all);

            }
            });


        }
        function monthVisit(){
            $label_month.html(55);
        }
        function allVisitor(){
            $label_all.html(115);
        }
        function getSummary(){
           // allVisitor();
           // monthVisit();
            todayVisit();
            setTimeout(()=>{
                todayVisit();

            },2000);
        }
        function getEl(el){
            return $PL.find(el);
        }
        function getEvent(){
            getSummary();
        }
        return{getEvent:getEvent}
    })();
    $vis.getEvent();
});
</script>

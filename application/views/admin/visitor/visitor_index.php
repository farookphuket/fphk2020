<section id="visitor">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">
          <?php
          $show = "{$sysName} version {$sysVersion} on {$sysDate}";
          echo $show;

          ?>
        </h1>
      </div>
      <div class="col-lg-12">
        <h1 class="text-center">
          All Visitor
          <span class="badge badge-success numAll">0</span>
        </h1>
        <hr class="my-4">
        <p class="pt-4">&nbsp;</p>
        <div class="table-responsive">
          <table class="table table-bordered" id="visitor_list">
            <tr>
              <th>Date</th>
              <th>IP</th>
              <th>Browser</th>
              <th>OS</th>
            </tr>
            <tbody class="body_list">

            </tbody>
          </table>
          <div class="body_pagin">

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>

    $(function(){
        const $P = $("#visitor");
        const $page_status = $(".status");
        const $vt = (function(){

            let $numAll = getEl(".numAll");
            let $v_list = getEl(".body_list");
            let $v_pagin = getEl(".body_pagin");


            function visitorList(page=1){
                $v_list.html("");
                let url = "<?php echo site_url("visitor/adminList/") ?>"+page;
                $.ajax({
                url : url,
                    success : (e)=>{
                    let rs = $.parseJSON(e);
                    //console.log(rs);
                    $.each(rs.get_v,(i,v)=>{
                        
                    let tmp = `<tr>
                        <td>${v.v_cur_visit_time}</td>
                        <td>${v.v_ip}</td>
                        <td>${v.v_browser}</td>
                        <td>${v.v_os}</td>
    
</tr>`;
                        $v_list.append(tmp);
                    });
                    if(rs.pagination){
                        $v_pagin.html(rs.pagination);
                    }
                }
                });
            }
            //------------------
            //--- getSummary
            function getSummary(){
                visitorList();
            }
            function getEl(el){
                return $P.find(el);
            }
            function getEvent(){
                getSummary();

                $v_pagin.delegate(".pagination a","click",function(e){
                e.preventDefault();
                let page = $(this).attr("data-ci-pagination-page");
                   visitorList(page); 
                });
            }
            return{getEvent:getEvent}
        })();
        $vt.getEvent();

    });
</script>

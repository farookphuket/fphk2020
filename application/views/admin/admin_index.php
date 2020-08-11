<!--last edit on 9/Jan/2020-->
<script charset="utf-8">
    const $page_status = $(".status");
</script>
<section id="booking">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class='text-center'>Booking</h1>
          <p class="text-center">Notification</p>
          <hr class="my-4">
          <p>&nbsp;</p>
        </div>
        <div class="col-lg-4">
          <div class="alert alert-info">
            <h1 class="numAllBooking" style="text-align:center">0</h1>

          </div>
          <p class="text-center">All Booking</p>
        </div>
        <div class="col-lg-4">
          <div class="alert alert-success">
            <h1 class="numConfirm" style="text-align:center">0</h1>
          </div>
          <p class="text-center">Has Confirmed</p>
        </div>
        <div class="col-lg-4">
          <div class="alert alert-danger">
            <h1 class="numNoneConfirm" style="text-align:center">0</h1>
          </div>
          <p class="text-center">Not Confirm</p>
        </div>
      </div>
    </div>
</section>
<script charset="utf-8">

</script>



<!--end of booking-->
<!--tour program start 6-7-2019 -->
<section id="tour_program">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="text-center">Tour Program</h1>
          <p>&nbsp;</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-info">
            <h1 class="numAllTour" style="text-align:right;">0</h1>

          </div>
          <p>All tour program.</p>
        </div>

        <div class="col-lg-3">
          <div class="alert alert-warning">
            <h1 class="numNotOnSale" style="text-align:right;">0</h1>

          </div>
          <p>Save as Draft.</p>
        </div>

        <div class="col-lg-3">
          <div class="alert alert-success">
            <h1 class="numOnSale" style="text-align:right;">0</h1>

          </div>
          <p>On Sale.</p>
        </div>


      </div>
    </div>
</section>
<!--end of tour program-->
<!--Post start 6/7/2019 -->
<section id="post">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">Post</h1>
        <hr class="my-4">
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-2">
        <div class="alert alert-info">
          <h1 class="numAllPost" style="text-align:right">0</h1>
        </div>
        <p>All post</p>
      </div>
      <div class="col-lg-2">
        <div class="alert alert-success">
          <h1 class="numPubPost" style="text-align:right">0</h1>
        </div>
        <p>Public post</p>
      </div>
      <div class="col-lg-2">
        <div class="alert alert-info">
          <h1 class="numIndexPost" style="text-align:right">0</h1>
        </div>
        <p>Public Index post</p>
      </div>

      <div class="col-lg-3">
        <div class="alert alert-warning">
          <h1 class="numPriPost" style="text-align:right">0</h1>
        </div>
        <p>Private post</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-danger">
          <h1 class="numNonApprovePost" style="text-align:right">0</h1>
        </div>
        <p>Not Approve post</p>
      </div>
    </div>
  </div>


</section>
<script charset="utf-8">
$(function(){
    const $P = $("#post");
    
    const $post = (function(){

        let $numAllPost = getEl(".numAllPost");
        let $numPubPost = getEl(".numPubPost");
        let $numIndexPost = getEl(".numIndexPost");
        let $numPriPost = getEl(".numPriPost");
        let $numNonApprovePost = getEl(".numNonApprovePost");


        function getLabelNumber(){
            let url = "<?php echo site_url("admin/getCountPost"); ?>";
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                $numAllPost.html(rs.get.length);
                let pubPost = 0;
                let indexPost = 0;
                let notApprovePost = 0;

                $.each(rs.get,(i,v)=>{
                if(parseInt(v.ar_is_approve) !== 0){
                    pubPost++;
                }else{
                    notApprovePost++;
                }
                if(parseInt(v.ar_show_index) !== 0){
                    indexPost++;
                }
                    $numNonApprovePost.html(notApprovePost);
                    $numPriPost.html(notApprovePost);
                    $numPubPost.html(pubPost);
                    $numIndexPost.html(indexPost);

                });

                console.log(rs);
            }
            });
        }
        //----------------
        function getSummary(){
            getLabelNumber();
        }
        //---------------
        function getEl(el){
            return $P.find(el);
        }
        function getEvent(){
            getSummary(); 
        }
        return{getEvent:getEvent}
    })();
    $post.getEvent();
});
</script>

<!--End of post -->
<!-- // This is block  -->
<!--User Start -->
<section id="user">

    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h1 class="text-center">User</h1>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-info">
            <h1 class="numAllUser" style="text-align:right;">0</h1>
          </div>
          <p>All users (included YOU)</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-success">
            <h1 class="numActiveUser" style="text-align:right;">0</h1>
          </div>
          <p>Activated User</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-danger">
            <h1 class="numBanUser" style="text-align:right;">0</h1>
          </div>
          <p>Ban user</p>
        </div>
        <div class="col-lg-3">
          <div class="alert alert-warning">
            <h1 class="numModUser" style="text-align:right;">0</h1>
          </div>
          <p>Moderator User</p>
        </div>

      </div>
    </div>

</section>
<script>
$(function(){
    /*
        *   last edit this file on 22-dec-2019
        *   as it still use the old style JS
     */
    const $UR = $("#user");
    const $usr = (function(){

        const $numAllUser = getEl(".numAllUser"); 
        const $numActiveUser = getEl(".numActiveUser"); 
        const $numBanUser = getEl(".numBanUser"); 
        const $numModUser = getEl(".numModUser"); 


        let numAll = 0;
        let numActive = 0;
        let numBan = 0;
        let numMod = 0;

        //--- getUserCount
        function getUserCount(){
            let url = "<?php echo site_url("users/all"); ?>";
            $.ajax({
            url : url,
                success : (e)=>{
                let rs = $.parseJSON(e);
                numAll = rs.get.length;
                $numAllUser.html(numAll);
                $.each(rs.get,(i,v)=>{
                if(parseInt(v.is_activated) !== 0){
                    numActive++;
                }
                if(parseInt(v.is_ban) !== 0){
                    numBan++;
                }
                if(parseInt(v.moderate) !== 0){
                    numMod++;
                }
                    $numActiveUser.html(numActive);
                    $numBanUser.html(numBan);
                    $numModUser.html(numMod);
                });
            }
            });
        }

        //--- getSummary 
        function getSummary(){
            getUserCount();
        }

        //----------------
        function getEl(el){
            return $UR.find(el);
        }
        function getEvent(){
            getSummary();
        }
        return{getEvent:getEvent}
    })();
    $usr.getEvent();
}); 
</script>


<section class="bg-primary" id="about">
    <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-center">
              <h2 class="section-heading text-white">

                  <?php echo"Welcome {$user_name} ";?>
              </h2>
              <hr class="light my-4">
              <p class="text-faded mb-4">
                  Make Booking, Check My Booking,Write my post.
                </p>
            </div>
        </div>
      </div>
</section>
<!--this is the index page for the user after they login will show the summary-->


<section id="my_booking">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-center">My Booking</h1>
                <hr>
                <div style="text-align:center">
                    <?php
                      $booking_url = site_url("booking/u/");
                    ?>
                    <a href="<?php echo $booking_url;?>" class="btn btn-primary">See My Booking</a>
                    <p>&nbsp;</p>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="alert alert-info">
                            <h2 class="book_all" style="color:#ff0000;text-align:center;">0</h2>
                            <p class="text-center">
                                All Booking
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-warning">
                            <h2 class="not_conf" style="color:#ff0000;text-align:center;">0</h2>
                            <p class="text-center">
                                Not Confirm
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="alert alert-success">
                            <h2 class="has_conf" style="color:#ff0000;text-align:center;">0</h2>
                            <p class="text-center">
                                Has Confirmed
                            </p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>

</section>
<script>
    $(function(){
        var $bk = $("#my_booking");

        var $allBookNum = $bk.find(".book_all");
        var $noConfNum = $bk.find(".not_conf");
        var $confNum = $bk.find(".has_conf");

        var all_b = 0;
        var not_conf = 0;
        var conf_b = 0;

        function getNumAll(){
            var url = "<?php echo site_url("booking/getMyTicketList/");?>";
            $.ajax({
              url : url,
              success : function(e){
                var rs = $.parseJSON(e);
                all_b = rs.get_ticket.length;
                if(all_b !== 0){
                  $allBookNum.css("background-color","blue").html(all_b);
                  //console.log(rs);
                  $.each(rs.get_ticket,function(i,v){
                    //console.log(v);
                    if(parseInt(v.bk_confirm) !== 0){
                      conf_b++;
                    }else{
                      not_conf++;
                    }
                    $noConfNum.html(not_conf);

                  });
                }

              }
            });
        }
        function getSummary(){
            getNumAll();
        }
        function getEvent(){
            getSummary();
        }
        var booking = (function(){
            return{getEvent:getEvent}
        })();
        booking.getEvent();
    });
</script>
<section id="my_post">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">My Post
          &nbsp;<span class="badge badge-success num_allPost">0</span>
        </h1>
        <hr class="my-4" />

        <?php $lnMyPost = site_url("article/u");?>
        <div style="text-align:center">
            <a href="<?php echo $lnMyPost;?>" class="btn btn-primary">See All of my post</a>
        </div>
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 class="num_allPost" style="text-align:center;color:gray;">0</h1>
          <p class="text-center">All my post</p>
        </div>
      </div>
      <!--show public post start-->
      <div class="col-lg-3">
        <div class="alert alert-info">
          <h1 class="num_pubPost" style="text-align:center;color:green;">0</h1>
          <p class="text-center">my public post</p>
        </div>
      </div>
      <!-- END OF show public post-->
      <!--show unpublic post start-->
      <div class="col-lg-3">
        <div class="alert alert-warning">
          <h1 class="num_priPost" style="text-align:center;color:red;">0</h1>
          <p class="text-center">my private post</p>
        </div>
      </div>
      <!-- END OF show unpublic post-->
      <!--show NOT Approve post start-->
      <div class="col-lg-3">
        <div class="alert alert-warning">
          <h1 class="num_notApprove" style="text-align:center;color:red;">0</h1>
          <p class="text-center">NOT Approve post</p>
        </div>
      </div>
      <!-- END OF show NOT Approve post-->
    </div>
  </div>
</section>
<script>
  /*
  Last update this script on 7-Aug-2019
  */
  $(function(){
    var $a = $("#my_post");
    var my_post = (function(){

      var $numAll = getEl(".num_allPost");
      var $numPub = getEl(".num_pubPost");
      var $numPri = getEl(".num_priPost");
      var $numNot = getEl(".num_notApprove");
      //---------------------
      //------- showLabelPubPost
      function showLabelMyPost(){
        var all = 0;
        var pub = 0;
        var pri = 0;
        var not = 0;

        var url = "<?php echo site_url("article/uList");?>";
        $.ajax({
          url : url,
          success : function(e){
            var rs = $.parseJSON(e);
            //console.log(rs.get_all);
            all = rs.get_all.length;
            $.each(rs.get_all,function(i,v){
              if(parseInt(v.ar_is_approve) === 0){
                //---not approve
                not++;
              }

              if(parseInt(v.ar_show_public) === 0){
                pri++;
              }else{
                pub++;
              }

            });

            console.log(`All num is ${all}`);
            $numAll.html(all);
            $numPub.html(pub);
            $numPri.html(pri);
            $numNot.html(not);
          }
        });

      }
      //---------------------
      function getSummary(){
        showLabelMyPost();
      }
      //-------------------
      //------- getEl
      function getEl(el){
        return $a.find(el);
      }
      //-------getEvent
      function getEvent(){
        getSummary();
      }
      return {getEvent:getEvent}
    })();

    //--call script
    my_post.getEvent();
  });
  /*
    End of user home page post script
  */
</script>

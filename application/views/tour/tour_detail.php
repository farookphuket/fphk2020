<?php

$tour_owner_email = "";
$tour_title = "";
$tour_sum = "";
$tour_body = "";

foreach($get as $row):
    
    $tour_owner_email = $row->email;
  $tour_title = $row->t_name;
  $tour_sum = $row->t_summary;
  $tour_body = $row->t_program;

endforeach;
?>
<section id="tour">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">

        <h1 class="text-center">
          <?php echo $tour_title;?>
        </h1>
        <p>By : <?php echo $tour_owner_email;?></p>
        <p>&nbsp;</p>
        
      </div>
      <div class="col-lg-12">
        <?php echo $tour_sum;?>
      </div>
      <div class="col-lg-12">
        <?php echo $tour_body;?>
      </div>
      <div class="col-lg-12">
        <div class="container">
          <?php
            $this->load->view("booking/book_index.php");
          ?>
        </div>

      </div>
      <div class="col-lg-12">
        <?php
          $this->load->view("payment_method/pay_index.php");
        ?>
      </div>
      <div class="col-lg-12">
          <?php
            $this->load->view("comment/comment_index.php");
          ?>
      </div>
    </div>
  </div>
</section>
<script>
  $(function(){
    var ck_page_owner_email = "<?php echo $tour_owner_email;?>";
    Cookies.set("ck_page_owner_email",ck_page_owner_email);
  });
</script>

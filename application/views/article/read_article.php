<?php

  $ar_title = "";
  $ar_sum = "";
  $ar_body = "";
  $own_name = "";
  $own_email = "";
  $date_create = "";
  //$own_name = "";
  foreach($get_ar as $row):
    $ar_title = $row->ar_title;
    $ar_sum = $row->ar_summary;
    $ar_body = $row->ar_body;
    $own_name = $row->name;
    $own_email = $row->email;
    $date_create = $row->date_add;
  endforeach;
?>
<section id="article">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="text-center">
          <?php echo $ar_title;?>
        </h1>
        <p>
        Post By : <strong><?php echo $own_name;?></strong> |  date create  <?php echo $date_create; ?>
          <input type="hidden" class="page_owner_email" name="page_owner_email" value="<?php echo $own_email;?>"/>
          <input type="hidden" class="page_owner_name" name="page_owner_name" value="<?php echo $own_name;?>" />
        </p>
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-12">
        <?php echo $ar_sum;?>
        <p>&nbsp;</p>
      </div>
      <div class="col-lg-12">
        <?php echo $ar_body;?>
        <p>&nbsp;</p>
      </div>
    </div>
  </div>
</section>
<script charset="utf-8">
    $(function(){
        /*
            * Just a simple use cookie
            *
         */
        const owner_email = "<?php echo $own_email; ?>";
        const $ck_owner_email = Cookies.set("owner_email",owner_email);
    });
</script>

    
<?php
    $comment = "comment/comment_index";
    $this->load->view($comment);
?>

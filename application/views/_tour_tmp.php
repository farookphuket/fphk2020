<!DOCTYPE html>
<html lang="en">
<head>
  <?php 
    $tag_head = "component/_tag_in_head.php";
    $this->load->view($tag_head);
  ?>
</head>
<body>
  <?php 
    $closeTag = "component/_close_msg_tmp.php";
    $this->load->view($closeTag);
  ?>
  <section id="tour">
    <?php 
        $this->load->view($subview);
    ?>
  </section>


  <?php 
      $tail = "component/_tag_in_tail.php";
      $this->load->view($tail);
  ?>
</body>
</html>
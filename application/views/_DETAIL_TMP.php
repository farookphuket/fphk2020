<!DOCTYPE html>
<html>
<head>

    <?php
        $tag_head = "component/_tag_in_head.php";
        $this->load->view($tag_head);
    ?>
    <title>
    <?php //echo $meta_title; ?>
    </title>

</head>
<body id="page-top">
  <div class="status">

  </div>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="float-right">
          <button type="button" class="btn btn-danger lnClose">Close</button>
        </div>

      </div>
    </div>
  </div>



    <?php $this->load->view($subview); ?>

    <p>&nbsp;</p>
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="float-right">
            <button type="button" class="btn btn-danger lnClose">Close</button>
          </div>
          <p>This window can be close by the "Close" button.</p>
          <p>&nbsp;</p>
        </div>
      </div>
    </div>
    <script>
      $(function(){
        var page_owner_email = Cookies.get("ck_page_owner_email");

        $(".lnClose").on("click",function(){
          //alert(`The cookies is ${page_owner_email}`);

          if(page_owner_email !== null){
            Cookies.remove("ck_page_owner_email");
          }

          window.close();
        });
      });
    </script>

    <!---Load the comment plugin-->
      <?php
        $comment = "comment/comment_index.php";
        $this->load->view($comment);
      ?>
    <!--END Load comment plugin-->
    <?php
        $tag_tail = "component/_tag_in_tail.php";
        $this->load->view($tag_tail);
    ?>
</body>
</html>

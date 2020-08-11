<!DOCTYPE html>
<html lang="en">
<head>
    <?php

        $tag_head = "component/_tag_in_head.php";
        $this->load->view($tag_head);
        $admin_nav = site_url("public/css/admin_nav.css");
    ?>
    <link rel="stylesheet" href="<?php echo $admin_nav;?>" />
</head>
<body class="page-top">
    <?php

        $menu_mod = "component/menu_mod.php";
        $this->load->view($menu_mod);
    ?>
    <div class="status">

    </div>
    <div class="container">
      <?php
        $this->load->view($subview);
      ?>
    </div>


    <?php

    $tag_tail = "component/_tag_in_tail.php";
    $this->load->view($tag_tail);
    ?>

</body>
</html>

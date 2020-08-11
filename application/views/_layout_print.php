<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Print Only Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo site_url("public/css/bootstrap.css");?>" />
    <script src="<?php echo site_url("public/js/bootstrap.js");?>"></script>

    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <div class="container">
        <?php 
            $this->load->view($subview);
        ?>
    </div>

</body>
</html>


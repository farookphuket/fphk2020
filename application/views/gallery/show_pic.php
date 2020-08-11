<div class="jumbotron">
<h1>Show pic</h1>
</div>
<div class="container">

<?php
    foreach($get_pic as $row):
    $pic = site_url("public/image/".$row->pic_name);
        ?>
        <img src="<?php echo $pic; ?>" />
    <?php
    endforeach;
?>
</div><!--end of page content-->

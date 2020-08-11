<?php

$fox = "Firefox";
$chrome = "Chrome";
$opera = "Opera";
$safari = "Safari";
$ie = "Internet Explorer";

$home_url = site_url();
$cur_url = current_url();

$err_msg = "<div class='alert alert-danger'>
<h4 class='text-center'>Your browser is not support!</h4>
<p>
dear friend your browser (<b>{$browser_name}</b>) is not support this website.

Please use {$chrome} , {$opera} , 'Microsoft Edge' instead to visit this website.
</p>
</div>";

$show = "";

if($browser_name == $fox || $browser_name == $safari || $browser_name == $ie):
  $show = $err_msg;
endif;


if($cur_url != $home_url):
    echo"<p class='pt-2'>&nbsp;</p>";
endif;
?>
<section id="support_browser">
<div class="container">
  <?php echo $show;?>
</div>
</section>

<?php
  $home_url = site_url();
  $ln_service = $home_url."#services";
?>

<section class="bg-primary" id="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 mx-auto text-center">
        <h2 class="section-heading text-white">Dear Friend! I am so <u>appreciate</u> that you have come visit my site!</h2>
        <hr class="light my-4">
        <p>
            And I am so apologize that this website that I have create is still on the <strong>test mode</strong> and doesn't have much content in it, so something that I have wrote in here there may or may-not givin' you much of what you've been expecting in. if it so you know that I will say sorry for that<br />
        Thank you so much again for visiting!
        </p>
        <p style="text-align:right;">
            Best regards
        </p>
        <p style="text-align:right;">
            Your friend <strong>Farook</strong>  <i><?php echo $admin_email;?></i>
        </p>
        <a class="btn btn-light btn-xl js-scroll-trigger" href="<?php echo $ln_service;?>">service</a>
      </div>
    </div>
  </div>
</section>

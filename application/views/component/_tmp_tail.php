
    <section id="services">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-center">
            <h2 class="section-heading">At Your Service</h2>
            <hr class="my-4">
          </div>
        </div>
      </div>


      <div class="container">
        <div class="row">
          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-gem text-primary mb-3 sr-icon-1"></i>
              <h3 class="mb-3">Set your belove destination</h3>
              
              <p class="text-muted mb-0">Take a one day tour bird watching in phuket ,pahng-nga ,krabi etc.</p>
              
            </div>
          </div>


          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-paper-plane text-primary mb-3 sr-icon-2"></i>
              <h3 class="mb-3">Include or Exclude transfer</h3>
              <p class="text-muted mb-0">
                Want to drive yourself? no problem!you can make your self to suit you need.
              </p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-code text-primary mb-3 sr-icon-3"></i>
              <h3 class="mb-3">Check your booking online</h3>
              
              <p class="text-muted mb-0">
                We do update your booking online you can do check anywahere.
              </p>
            </div>
          </div>

<!--
          <div class="col-lg-3 col-md-6 text-center">
            <div class="service-box mt-5 mx-auto">
              <i class="fas fa-4x fa-heart text-primary mb-3 sr-icon-4"></i>
              <h3 class="mb-3">Made with Love</h3>
              <p class="text-muted mb-0">
                  your destination is our service!
              </p>
              
            </div>
          </div>
-->

        </div>
      </div>
    </section>




    <section class="p-0" id="portfolio">
      <div class="container-fluid p-0">
        <div class="row no-gutters popup-gallery">
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/1.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/1.jpg");?>" alt="">

              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Bird Watching
                  </div>
                </div>
              </div>
            </a>
          </div>


          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/2.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/2.jpg");?>" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/3.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/3.jpg");?>" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/4.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/4.jpg");?>" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/5.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/5.jpg");?>" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
          <div class="col-lg-4 col-sm-6">
            <a class="portfolio-box" href="<?php echo site_url("public/img/portfolio/fullsize/6.jpg");?>">
              <img class="img-fluid" src="<?php echo site_url("public/img/portfolio/thumbnails/6.jpg");?>" alt="">
              <div class="portfolio-box-caption">
                <div class="portfolio-box-caption-content">
                  <div class="project-category text-faded">
                    Category
                  </div>
                  <div class="project-name">
                    Project Name
                  </div>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="bg-dark text-white">
      <div class="container text-center">
        <h2 class="mb-4">This Theme</h2>
        
        <a class="btn btn-primary btn-xl" href="http://startbootstrap.com/template-overviews/creative/" style="color:white;font-weigth:bold;">Have a look</a>


      </div>
    </section>

    <!---contact start-->
    <?php
        $contact_main = "component/contact_main.php";
        $this->load->view($contact_main);
    ?>
    <!---contact end-->

    <!-- Bootstrap core JavaScript -->
    <!--
    <script src="<?php //echo site_url("public/vendor/jquery/jquery.min.js");?>"></script>
    -->
    <script src="<?php echo site_url("public/vendor/bootstrap/js/bootstrap.bundle.min.js");?>"></script>

    <!-- Plugin JavaScript -->
    <script src="<?php echo site_url("public/vendor/jquery-easing/jquery.easing.min.js");?>"></script>
    <script src="<?php echo site_url("public/vendor/scrollreveal/scrollreveal.min.js");?>"></script>
    <script src="<?php echo site_url("public/vendor/magnific-popup/jquery.magnific-popup.min.js");?>"></script>

    <!-- Custom scripts for this template -->
    <script src="<?php echo site_url("public/js/creative.min.js");?>"></script>
   

  </body>

</html>

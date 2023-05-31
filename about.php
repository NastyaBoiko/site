<?php 
$fileName = basename(__FILE__, '.php');
require_once "lib/$fileName" . "init.php";

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?= $header->create('О нас')?>
</head>

<body>
  <div id="colorlib-page">
    <?php 
      echo $menu->nav(basename(__FILE__));
    ?>

    <div id="colorlib-main">
      <section class="ftco-about img ftco-section ftco-no-pt ftco-no-pb" id="about-section">
        <div class="container-fluid px-0">
          <div class="row d-flex mt-5">
            <div class="col-md-6 d-flex align-items-center">
              <div class="text px-4 pt-5 pt-md-0 px-md-4 pr-md-5 ftco-animate">
                <h2 class="mb-4">I'm <span>Andrea Moore</span> a Scotish Blogger &amp; Explorer</h2>
                <p>A small river named Duden flows by their place and supplies it with the necessary regelialia. It is a
                  paradisematic country, in which roasted parts of sentences fly into your mouth. It is a paradisematic
                  country, in which roasted parts of sentences fly into your mouth.</p>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div><!-- END COLORLIB-MAIN -->
  </div><!-- END COLORLIB-PAGE -->

  <?= file_get_contents('lib/preloader.html');?>
  <!-- loader
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10"
        stroke="#F96D00" />
    </svg>
  </div> -->

  <?= file_get_contents('lib/script.html');?>


</body>

</html>
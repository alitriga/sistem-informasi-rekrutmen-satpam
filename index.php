<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PT. Nutrido Nusa Kampita</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <!-- Favicons -->
  <link href="assets/img/13.png" rel="icon">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <h1 class="logo"><a href="index.php">PT. Nutrido Nusa Kampita</a></h1>
      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#about">Pendaftaran</a></li>
          <li><a class="nav-link scrollto" href="#contact">About</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <div id="hero" class="hero route bg-image" style="background-image: url(assets/img/11.png)">
    <div class="overlay-itro"></div>
    <div class="hero-content display-table">
      <div class="table-cell">
        <div class="container">
          <p class="display-6 color-d">
            <img src="assets/img/13.png" alt="" class="img-fluid" width="150">
          </p>
          <h1 class="hero-title mb-4">PT. Nutrido Nusa Kampita</h1>
          <p class="hero-subtitle">
            <span class="typed" data-typed-items="Jalan Bandar Purus No.19, Kelurahan Padang Pasir, Kecamatan Padang Barat, Kota Padang, Provinsi Sumatera Barat"></span>
          </p>
          <p class="pt-3">
            <a class="btn btn-primary btn js-scroll px-4" href="#about" role="button">More</a>
          </p>
        </div>
      </div>
    </div>
  </div><!-- End Hero Section -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about-mf sect-pt4 route">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="about-me pt-4 pt-md-0">
                    <div class="title-box-2">
                      <h5 class="title-left">LOGIN</h5>
                    </div>
                    <p class="lead">
                      Silahkan masukkan Username dan password Anda.
                    </p>
                      <!-- Display error message -->
                    <?php
                    if (isset($_SESSION['login_error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                        unset($_SESSION['login_error']);
                    }
                    ?>
                    <form action="login.php" method="post">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="username" placeholder="1234567890">
                        <label for="floatingInput">Username</label>
                      </div>
                      <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                        <label for="floatingPassword">Password</label>
                      </div>
                      <br>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="about-me pt-4 pt-md-0">
                    <div class="title-box-2">
                      <h5 class="title-left">Penerimaan Satuan Pengamanan (Satpam)</h5>
                    </div>
                    <div class="row">
                      <div class="col">
                        <div class="work-box">
                          <a href="assets/img/15.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox">
                            <div class="work-img">
                              <img src="assets/img/15.jpg" alt="" class="img-fluid">
                            </div>
                          </a>
                          <div class="work-content">
                            <div class="row">
                              <div class="col">
                                <h2 class="w-title">
                                  <a href="pendaftaran.php">Formulir Pendaftaran Diklat Satpam</a>
                                </h2>
                                <div class="w-more">
                                  <span class="w-ctegory">Diklat Satpam</span> / <span class="w-date">07 Jul. 2024</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="work-box">
                          <a href="assets/img/work-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox">
                            <div class="work-img">
                              <img src="assets/img/work-1.jpg" alt="" class="img-fluid">
                            </div>
                          </a>
                          <div class="work-content">
                            <div class="row">
                              <div class="col">
                                <h2 class="w-title"><a href="">Lorem impsum dolor</a></h2>
                                <div class="w-more">
                                  <span class="w-ctegory">Lorem</span> / <span class="w-date">07 Jul. 2024</span>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End About Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route" style="background-image: url(assets/img/16.jpg)">
      <div class="overlay-mf"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <div class="contact-mf">
              <div id="contact" class="box-shadow-full">
                <div class="row">
                  <div class="col-md-6">
                    <div class="title-box-2">
                      <h5 class="title-left">Lokasi</h5>
                    </div>
                    <div>
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.280141449344!2d100.353759273645!3d-0.941085935343508!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd4b94d52c7cd87%3A0xd6c4c8d57fe480eb!2sPt.%20Nutrido%20nusa%20kampita!5e0!3m2!1sen!2sid!4v1720767346698!5m2!1sen!2sid" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="title-box-2 pt-4 pt-md-0">
                      <h5 class="title-left">About</h5>
                    </div>
                    <div class="more-info">
                      <p class="lead">
                        PT. Nutrido Nusa Kampita merupakan salah satu Badan Usaha Jasa Pengamanan (BUJP) yang menyediakan Pendidikan dan Latihan (Diklat) bagi calon anggota Satuan Pengamanan (Satpam). PT. Nutrido Nusa Kampita berdiri pada bulan April tahun 2014.
                      </p>
                      <ul class="list-ico">
                        <li><span class="bi bi-geo-alt"></span>Bandar Purus No.19, Padang Pasir, Padang Barat, Padang, Sumatera Barat</li>
                        <li><span class="bi bi-phone"></span> (0751) 4670 014</li>
                        <li><span class="bi bi-envelope"></span> pt.nutridonusakampita@gmail.com</li>
                      </ul>
                    </div>
                    <div class="socials">
                      <ul>
                        <li><a href="https://api.whatsapp.com/send/?phone=6297895990005&text&type=phone_number&app_absent=0"><span class="ico-circle"><i class="bi bi-whatsapp"></i></span></a></li>
                        <li><a href="https://www.instagram.com/nutridonusakampita?igsh=MXRrNDhkaHRjMnplaw=="><span class="ico-circle"><i class="bi bi-instagram"></i></span></a></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- End Contact Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="copyright-box">
            <p class="copyright">&copy; Copyright <strong>PT. Nutrido Nusa Kampita</strong>.</p>
            <div class="credits">
              Designed by <a href="https://api.whatsapp.com/send/?phone=6282288457224&text&type=phone_number&app_absent=0">Alitriga.Comp</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/typed.js/typed.umd.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <!-- bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>

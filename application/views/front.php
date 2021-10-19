<!doctype html>
<html lang="zxx">



<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="<?= cetak($deskripsi) ?>">
    <meta name="keywords" content="<?= cetak($keyword) ?>">
    <meta name="author" content="CV. Indosistem">
    <title><?= $identitas['nama'] . ' | ' . $title ?></title>
    <link rel="shortcut icon" href="<?= base_url('assets/img/') ?>logotwh.png" type="image/x-icon">
    <link rel="icon" href="<?= base_url('assets/img/') ?>logotwh.png" type="image/x-icon">
    <link href="<?= base_url() ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />



    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/front/') ?>DataTables/datatables.min.css" />
    <script src="<?= base_url('assets/front/') ?>assets/js/jquery.min.js"></script>

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/bootstrap.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/owl.theme.default.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/owl.carousel.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/magnific-popup.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/animate.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/boxicons.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/flaticon.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/meanmenu.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/nice-select.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/progressbar.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/odometer.min.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/style.css">

    <link rel="stylesheet" href="<?= base_url('assets/front/') ?>assets/css/responsive.css">



    <link href="<?= base_url() ?>assets/plugins/lightbox/ekko-lightbox.css" rel="stylesheet" />

    <?php
    if ($this->uri->segment('2') == 'detail') {
        echo '<meta property="og:image" content="' . gambarAws($gambar) . '" />';
        if ($hal == 'berita') {
            foreach ($tags as $tag) {
                echo '<meta property="article:tag" content="' . $tag . '" />';
            }
        }

        if ($this->uri->segment('1') == 'infodinas') {
            echo '<meta property="article:published_time" content="' . $rows->input_at . '" />
        <meta property="article:modified_time" content="' . $rows->input_at . '" />';
        } else {
            echo '<meta property="article:published_time" content="' . $rows['input_at'] . '" />
        <meta property="article:modified_time" content="' . $rows['input_at'] . '" />';
        }
    } else {
        echo '<meta property="og:image" content="' . base_url('assets/img/' . $identitas['logo']) . '" />';
    }
    ?>

</head>

<body>

    <div class="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>


    <header class="header-area header-area-two">
      

        <div class="contolib-nav-style contolib-nav-style-two">
            <div class="navbar-area">

                <div class="mobile-nav">
                    <a href="<?= base_url() ?>" class="logo">
                        <img src="<?= base_url('assets/img/') . $identitas['logo'] ?>" alt="Logo">
                    </a>
                </div>

                <div class="main-nav">
                    <nav class="navbar navbar-expand-md navbar-light">
                        <div class="container">
                            <a class="navbar-brand" href="index.html">
                                <img src="<?= base_url('assets/img/') . $identitas['logo'] ?>" alt="Logo">
                            </a>
                            <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                                <ul class="navbar-nav m-auto">

                                    <?php
                                    $menus = '';
                                    foreach ($tabs as $key => $value) {
                                        $act = ($value['ctrl'] == $ctrl) ? 'active' : '';
                                        if (count($value['child']) == 0) {
                                            $menus .= '<li class="nav-item' . '"><a class="nav-link" href="' . $value['url'] . '">' . $value['title-menu'] . '</a></li>';
                                        } else {
                                            $menus .= '<li class="nav-item'  . '" ><a class="nav-link dropdown-toggle" . $act .    href= "'  . $value['url'] . '">' . $value['title-menu'] . '      <i class="bx bx-plus"></i>' . '</a>';
                                            $menus .= '<ul class="dropdown-menu">'; // pembuka submenu
                                            foreach ($value['child'] as $key => $value) {
                                                $menus .= '<li class="nav-item"><a class="nav-link" href="' . $value['url'] . '">' . $value['title-menu'] . '</a></li>';
                                            }
                                            $menus .= '</ul>'; // penutup submenu
                                            $menus .= '</li>';
                                        }
                                    }
                                    echo $menus;
                                    ?>


                                    <!-- <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle active">
                                            Home
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="index.html" class="nav-link">Home One</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="index-2.html" class="nav-link active">Home Two</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="index-3.html" class="nav-link">Home Three</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle">
                                            Pages
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="about.html" class="nav-link">About</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="pricing.html" class="nav-link">Pricing</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="testimonials.html" class="nav-link">Testimonials</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="team.html" class="nav-link">Team</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="faq.html" class="nav-link">FAQ</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="terms-conditions.html" class="nav-link">Terms Conditions</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="privacy-policy.html" class="nav-link">Privacy Policy</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#" class="nav-link dropdown-toggle">
                                                    User
                                                    <i class="bx bx-plus"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li class="nav-item">
                                                        <a href="log-in.html" class="nav-link">Log In</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="sign-up.html" class="nav-link">Sign Up</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a href="recover-password.html" class="nav-link">Recover Password</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="nav-item">
                                                <a href="coming-soon.html" class="nav-link">Coming Soon</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="404.html" class="nav-link">404 Error</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle">
                                            Services
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="services.html" class="nav-link">Services</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="services-details.html" class="nav-link">Services Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle">
                                            Portfolio
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="portfolio.html" class="nav-link">Portfolio</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="portfolio-details.html" class="nav-link">Portfolio Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle">
                                            Shop
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="shop-grid-view.html" class="nav-link">Shop Grid view</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="cart.html" class="nav-link">Cart</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="checkout.html" class="nav-link">Checkout</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="shop-details.html" class="nav-link">Shop Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link dropdown-toggle">
                                            News
                                            <i class="bx bx-plus"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li class="nav-item">
                                                <a href="news-grid.html" class="nav-link">News Grid</a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="news-details.html" class="nav-link">News Details</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="contact.html" class="nav-link">Contact</a>
                                    </li> -->

                                    <li class="nav-item">
                                        <a href="<?= base_url('login') ?>" class="nav-link">Login</a>
                                    </li>

                                </ul>

                                <div class="others-option">
                                    <div class="menu-menu">
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#myModal2">
                                            <i class="flaticon-menu"></i>
                                        </a>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </div>

    </header>

    <div class="sidebar-modal">
        <div class="modal right fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">
                                <i class="bx bx-x"></i>
                            </span>
                        </button>
                        <h2 class="modal-title" id="myModalLabel2">
                            <a href="<?= base_url() ?>">
                                <img src="<?= base_url('assets/img/') . $identitas['logo'] ?>" alt="Logo">
                            </a>
                        </h2>
                    </div>
                    <div class="modal-body">


                        <div class="sidebar-modal-widget">
                            <h3 class="title">Informasi Kontak</h3>
                            <ul class="contact-info">
                                <li>
                                    <i class="bx bx-location-plus"></i>
                                    Alamat
                                    <span><?= $identitas['alamat'] ?></span>
                                </li>
                                <li>
                                    <i class="bx bx-envelope"></i>
                                    Email
                                    <a href="<?= $identitas['email'] ?>"><span class="__cf_email__" data-cfemail="49212c252526092a26273d2625202b672a2624"><?= $identitas['email'] ?></span></a>
                                </li>
                                <li>
                                    <i class="bx bxs-phone-call"></i>
                                    Telepon
                                    <a href="tel:+0-(321)-984-754"><?= $identitas['telp'] ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="sidebar-modal-widget">
                            <h3 class="title">Sosial Media </h3>
                            <ul class="social-list">
                                <li>
                                    <a href="<?= $identitas['tw'] ?>">
                                        <i class='bx bxl-twitter'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $identitas['fb'] ?>">
                                        <i class='bx bxl-facebook'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?= $identitas['email'] ?>">
                                        <i class='bx bxl-youtube'></i>
                                    </a>
                                </li>

                                <li>
                                    <a href="<?= $identitas['yt'] ?>">
                                        <i class='bx bxl-youtube'></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    echo $contents;
    ?>




    <footer class="footer-bottom-area footer-bottom-electronics-area">
        <div class="container">
            <div class="copy-right">
                <p>
                    <?= $identitas['footer'] ?>

                </p>
            </div>
        </div>
    </footer>


    <div class="go-top">
        <i class='bx bx-chevrons-up'></i>
        <i class='bx bx-chevrons-up'></i>
    </div>


    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>

    <?php
    if ($this->uri->segment('1') == 'gallery' or $this->uri->segment('1') == 'tentangkami') {
    } else {
    ?>
        <script src="<?= base_url('assets/front/') ?>assets/js/bootstrap.bundle.min.js"></script>
    <?php } ?>
    <script src="<?= base_url('assets/front/') ?>assets/js/meanmenu.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/wow.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/owl.carousel.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/carousel-thumbs.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/magnific-popup.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/nice-select.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/jarallax.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/mixitup.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/appear.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/odometer.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/progressbar.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/ajaxchimp.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/form-validator.min.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/contact-form-script.js"></script>

    <script src="<?= base_url('assets/front/') ?>assets/js/custom.js"></script>

    <script src="<?= base_url() ?>assets/plugins/lightbox/ekko-lightbox.js"></script>
    <script>
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true,
            });
        });
    </script>
    <script type="text/javascript" src="<?= base_url('assets/front/') ?>DataTables/datatables.min.js"></script>

</body>



</html>
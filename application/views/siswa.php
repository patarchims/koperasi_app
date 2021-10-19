<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?= $identitas['nama'] ?> | <?= $title ?></title>
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
  <meta content="" name="description" />
  <meta content="indosistem.com" name="author" />

  <!-- ================== BEGIN BASE CSS STYLE ================== -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/lightbox/ekko-lightbox.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/default/style.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
  <!-- ================== END BASE CSS STYLE ================== -->
  <link href="<?= base_url() ?>assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
  <link href="<?= base_url() ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
  <!-- ================== BEGIN BASE JS ================== -->
  <script src="<?= base_url() ?>assets/plugins/js-webshim/minified/polyfiller.js"></script>
  <script src="<?= base_url() ?>assets/plugins/pace/pace.min.js"></script>
  <!-- ================== END BASE JS ================== -->
  <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <!-- begin #page-loader -->
  <div id="page-loader" class="fade show"><span class="spinner"></span></div>
  <!-- end #page-loader -->

  <!-- begin #page-container -->
  <div id="page-container" class="fade page-sidebar-fixed page-header-fixed ">
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
      <!-- begin navbar-header -->
      <div class="navbar-header">
        <a href="" class="navbar-brand"><span class="navbar-logo"></span> <b><?= $identitas['nama'] ?></b></a>
        <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <!-- end navbar-header -->

      <!-- begin header-nav -->
      <ul class="navbar-nav navbar-right">


        <li class="dropdown navbar-user">
          <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= gambarAws($this->session->foto_user) ?>" alt="" />
            <span class="d-none d-md-inline"><?= $this->session->nama_user ?></span> <b class="caret"></b>
          </a>
          <div class="dropdown-menu dropdown-menu-right">

            <a href="<?= base_url('siswa/profil') ?>" class="dropdown-item">Profile</a>
            <a href="<?= base_url('siswa/gantipassword') ?>" class="dropdown-item">Ubah Password</a>

            <div class="dropdown-divider"></div>
            <a href="<?= base_url('login/logout') ?>" class="dropdown-item">Log Out</a>
          </div>
        </li>
      </ul>


    </div>
    <!-- end #header -->

    <!-- begin #sidebar -->
    <div id="sidebar" class="sidebar">
      <!-- begin sidebar scrollbar -->
      <div data-scrollbar="true" data-height="100%">
        <!-- begin sidebar user -->
        <ul class="nav">
          <li class="nav-profile">
            <a href="javascript:;" data-toggle="nav-profile">
              <div class="cover with-shadow"></div>
              <div class="image">
                <img src="<?= gambarAws($this->session->foto_user) ?>" alt="" />
              </div>
              <div class="info">
                <b class="caret pull-right"></b>
                <?= $this->session->nama_user ?>
                <small><?= $this->session->level ?></small>
              </div>
            </a>
          </li>
          <li>
            <ul class="nav nav-profile">
              <li><a href="<?= base_url('siswa/profil') ?>"><i class="fa fa-user"></i> Profil</a></li>
              <li><a href="<?= base_url('siswa/gantipassword') ?>"><i class="fa fa-key"></i> Ubah Password</a></li>


              <li><a href="<?= base_url('logout') ?>"><i class="fa fa-sign-out-alt"></i> Log Out</a></li>

            </ul>
          </li>
        </ul>
        <!-- end sidebar user -->
        <!-- begin sidebar nav -->
        <ul class="nav">
          <li class="nav-header">Menu</li>
          <?php
          $menus = '';
          foreach ($tabs as $key => $value) {
            $act = ($value['ctrl'] == $ctrl) ? 'active' : '';
            if (count($value['child']) == 0) {
              $menus .= '<li class="' . $act . '"><a href="' . base_url($value['url']) . '">
                              <i class="fa fa-' . $value['icon'] . '"></i>
                              <span>' . $value['title-menu'] . '</span>
                            </a></li>';
            } else {
              $menus .= '<li class="has-sub ' . $act . '">
                               <a href="javascript:;">
                                  <b class="caret pull-right"></b>
                                      <i class="fa fa-' . $value['icon'] . '"></i> 
                                          <span>' . $value['title-menu'] . '</span>
                              </a>';
              $menus .= '<ul class="sub-menu">'; // pembuka submenu
              foreach ($value['child'] as $key => $value) {
                $act = ($value['url'] == $link) ? 'active' : '';
                $menus .= '<li class="' . $aktif . '" ><a  href="' . base_url($value['url']) . '">' . $rows['title-menu'] . '</a></li>';
              }
              $menus .= '</ul>'; // penutup submenu
              $menus .= '</li>';
            }
          }
          echo $menus;

          echo '<li class="">
                      <a href="' . base_url('login/logout') . '">
                          <i class="fas fa-sign-out-alt text-danger"></i>
                          <span>Logout</span>
                      </a>
                   </li>';

          ?>
          <!-- begin sidebar minify button -->
          <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-double-left"></i></a></li>
          <!-- end sidebar minify button -->
        </ul>
        <!-- end sidebar nav -->
      </div>
      <!-- end sidebar scrollbar -->
    </div>
    <div class="sidebar-bg"></div>
    <!-- end #sidebar -->

    <!-- begin #content -->
    <div id="content" class="content ">
      <!-- begin page-header -->
      <h1 class="page-header"><?= $header ?><small></small></h1>
      <!-- end page-header -->
      <!-- begin section-container -->
      <div class="section-container section-with-top-border p-b-5">
        <?php

        if ($this->session->flashdata('sukses') != '') {
          echo '  <script>
                $(document).ready(function() {
            
                swal("Selamat!", "' . $this->session->flashdata('sukses') . '", "success");
              
                });
              </script>';
        } else if ($this->session->flashdata('gagal') != '') {

          echo '  <script>
                $(document).ready(function() {
            
                swal("Maaf!", "' . $this->session->flashdata('gagal') . '", "error");
              
                });
              </script>';
        }


        echo $contents;
        ?>
      </div>
      <!-- end section-container -->
    </div>
    <!-- end #content -->



    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
  </div>
  <!-- end page container -->

  <!-- ================== BEGIN BASE JS ================== -->

  <script src="<?= base_url() ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/js-cookie/js.cookie.js"></script>
  <script src="<?= base_url() ?>assets/js/theme/default.min.js"></script>
  <script src="<?= base_url() ?>assets/js/apps.min.js"></script>
  <!-- ================== END BASE JS ================== -->
  <script src="<?= base_url() ?>assets/plugins/select2/dist/js/select2.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
  <script src="<?= base_url() ?>assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
  <script src="<?= base_url() ?>assets/plugins/lightbox/ekko-lightbox.js"></script>
  <script src="<?= base_url() ?>assets/plugins/chart-js/Chart.min.js"></script>
  <script src="<?= base_url() ?>assets/ckeditor/ckeditor.js"></script>
  <script src="<?= base_url() ?>assets/ckfinder/ckfinder.js"></script>
  <script type="text/javascript" src="<?= base_url() ?>assets/ckeditor/adapters/jquery.js"></script>

  <script>
    $(document).ready(function() {
      App.init();
      $("#data-table").DataTable();

      webshims.setOptions('forms-ext', {
        replaceUI: 'auto',
        types: 'number',
        widgets: {
          startView: 2,
          openOnMouseFocus: true,
          stepfactor: 1
        }
      });
      webshims.polyfill('forms forms-ext');
      CKFinder.setupCKEditor();

      $('textarea.mytextarea').ckeditor();
      $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox({
          alwaysShowClose: true,
        });
      });


    });

    function ShowLoading(e) {
      $('#btnSimpan').hide();
      var div = document.createElement('div');
      var img = document.createElement('img');
      img.src = '<?= base_url('assets/img/loading.gif') ?>';
      div.innerHTML = "<br />";
      div.style.cssText = 'position: fixed; top: 20%; left: 40%; z-index: 5000; width: 200px; text-align: center; ';
      div.appendChild(img);
      document.body.appendChild(div);
      return true;
      // These 2 lines cancel form submission, so only use if needed.
      //window.event.cancelBubble = true;
      //e.stopPropagation();
    }
  </script>

</body>

</html>
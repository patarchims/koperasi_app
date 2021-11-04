<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $identitas['nama'] ?></title>

    <!-- Google Font: Source Sans Pro -->
    <link href="<?= base_url() ?>assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/admin/') ?>dist/css/adminlte.min.css">

    <!-- ================== END BASE JS ================== -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>

</head>

<body class="hold-transition  sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__wobble" src="<?= base_url('assets/admin/') ?>dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark">


            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->
                <li class="nav-item">
                    <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                        <i class="fas fa-search"></i>
                    </a>
                    <div class="navbar-search-block">
                        <form class="form-inline">
                            <div class="input-group input-group-sm">
                                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-navbar" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

                <!-- Messages Dropdown Menu -->

                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">

                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="<?= base_url('dashboard') ?>" class="brand-link">
                <img src="<?= base_url('assets/admin/') ?>dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?= $identitas['nama'] ?></span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url() ?>assets/img/user/<?= $this->session->foto_user ?>" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= $this->session->nama_user ?></span> </a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


                        <?php
                        $this->load->view('admin/menu');
                        ?>


                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Here -->
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
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> -->
            <!-- All rights reserved. -->
            <div class="float-right d-none d-sm-inline-block">
                <!-- <b>Version</b> 3.2.0-rc -->
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/admin/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.min.js"></script>


    <script src="<?= base_url('assets/admin/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap-sweetalert/sweetalert.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/select2/dist/js/select2.min.js"></script>



    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets/admin/') ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/admin/') ?>dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="<?= base_url('assets/admin/') ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/admin/') ?>plugins/chart.js/Chart.min.js"></script>

    <!-- <script src="<?= base_url('assets/admin/') ?>dist/js/demo.js"></script>
    <script src="<?= base_url('assets/admin/') ?>dist/js/pages/dashboard2.js"></script> -->



    <script>
        $(document).ready(function() {
            // App.init();
            // $("#data-table").DataTable();

            // webshims.setOptions('forms-ext', {
            //     replaceUI: 'auto',
            //     types: 'number',
            //     widgets: {
            //         startView: 2,
            //         openOnMouseFocus: true,
            //         stepfactor: 1
            //     }
            // });
            // webshims.polyfill('forms forms-ext');
            // CKFinder.setupCKEditor();

            // $('textarea.mytextarea').ckeditor();
            // $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            //     event.preventDefault();
            //     $(this).ekkoLightbox({
            //         alwaysShowClose: true,
            //     });
            // });


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
        }
    </script>
</body>

</html>
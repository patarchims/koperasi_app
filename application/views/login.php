<!DOCTYPE html>

<html lang="en">


<head>
    <meta charset="utf-8" />
    <title><?= $identitas['nama'] ?> | <?= $title ?></title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />

    <meta content="indosistem.com" name="author" />

    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/font-awesome/5.0/css/fontawesome-all.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/plugins/animate/animate.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/default/style.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/default/style-responsive.min.css" rel="stylesheet" />
    <link href="<?= base_url() ?>assets/css/default/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?= base_url() ?>assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
</head>

<body class="pace-top">
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade show"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade">
        <!-- begin login -->
        <div class="login bg-black animated fadeInDown">
            <!-- begin brand -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> <b>Login</b> Siswa dan Guru
                    <small><?= $identitas['nama'] ?></small>
                </div>
                <div class="icon">
                    <i class="fa fa-lock"></i>
                </div>
            </div>
            <!-- end brand -->
            <!-- begin login-content -->
            <div class="login-content">
                <form action="<?= base_url($link) ?>" method="POST" class="margin-bottom-0">
                    <input type="hidden" name="token" value="<?= $token ?>">
                    <div class="form-group m-b-20">
                        <input type="text" name="username" class="form-control form-control-lg " placeholder="NISN utk Siswa / email utk Guru dan Pegawai" required />
                    </div>
                    <div class="form-group m-b-20">
                        <input type="password" name="password" class="form-control form-control-lg " placeholder="Password" required />
                    </div>
                    <div class="form-group m-b-20">
                        <select name="sebagai" class="form-control form-control-lg" required>
                            <option value="">..::Login Sebagai::..</option>
                            <option value="Siswa">SISWA</option>
                            <option value="Guru">Guru atau Pegawai</option>
                        </select>
                    </div>

                    <div class="row row-space-10">
                        <div class="col-md-6 m-b-20">
                            <input type="text" class="form-control form-control-lg" value="<?= $captcha ?>" placeholder="" readonly />
                        </div>
                        <div class="col-md-6 m-b-20">
                            <input type="text" name="captcha" class="form-control form-control-lg" placeholder="Hasil" required />
                        </div>
                    </div>

                    <div class="login-buttons">
                        <button type="submit" name="login" class="btn btn-success btn-block btn-lg">Login</button>
                    </div>
                </form>
            </div>
            <!-- end login-content -->
        </div>
        <!-- end login -->


    </div>
    <!-- end page container -->

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="<?= base_url() ?>assets/plugins/jquery/jquery-3.2.1.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/bootstrap/4.1.0/js/bootstrap.bundle.min.js"></script>

    <script src="<?= base_url() ?>assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/js-cookie/js.cookie.js"></script>
    <script src="<?= base_url() ?>assets/js/theme/default.min.js"></script>
    <script src="<?= base_url() ?>assets/js/apps.min.js"></script>
    <!-- ================== END BASE JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
        });
    </script>

</body>


</html>
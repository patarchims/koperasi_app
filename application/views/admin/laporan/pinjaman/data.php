<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Laporan Data Simpanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Icons</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>


<section class="content">
    <div class="container-fluid">
        <form class="form-horizontal" action="<?= base_url($link) ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="card card-primary card-outline">
                <div class="card-header">

                    <h3 class="card-title">
                        <a target="_blank" href="<?= base_url('laporan/cetakpinjamanall') ?>" name="cetak" class="btn btn-primary btn-block"><i class="fa fa-paper"></i> Print All</a>
                    </h3>

                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="mr-5 pd-5">
                                <strong>Atau</strong> Masukan ID Anggota
                            </div>

                            <input type="text" name="id_anggota" class="form-control" placeholder="Search Mail">
                            <div class="input-group-append">
                                <button class="btn btn-primary" name="cari" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-tools -->
                </div>

            </div>
        </form>

    </div>
</section>
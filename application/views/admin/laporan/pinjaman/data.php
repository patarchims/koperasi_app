<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= 'Laporan ' . $title ?></h1>
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
                                <strong>Atau</strong> Masukan Nomor Anggota
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



<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="mytable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Pinjaman</th>
                                    <th>Nomor Anggota</th>
                                    <th>Jumlah Pinjaman</th>
                                    <th>Nama Anggota</th>
                                    <th>Angsuran</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>



<script>
    $('#mytable').on('click', '.tombol-hapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        swal({
                title: "Apakah Kamu Yakin?",
                text: "Jika Dihapus Data tidak Bisa dikembalikan Lagi",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: href,
                        type: "POST",
                        dataType: "JSON",
                        success: function(response) {
                            if (response['hasil'] == 'sukses') {
                                swal(response['pesan'], {
                                    icon: "success",
                                });
                            } else {
                                swal(response['pesan'], {
                                    icon: "error",
                                });
                            }
                            table.ajax.reload(null, false);
                        }
                    });
                }
            });

    });
    $(document).ready(function() {

        table = $('#mytable').DataTable({

            "processing": true,
            "serverSide": true,
            "order": [],

            "ajax": {
                "url": "<?php echo base_url('laporan/get_pinjaman') ?>",
                "type": "POST"
            },


            "columnDefs": [{
                    "targets": [0, 1, 7],
                    "orderable": false,
                },
                {
                    "targets": [7],
                    "className": 'text-nowrap',
                }
            ],

        });


    });
</script>




<script>
    $('#mytable').on('click', '.tombol-hapus', function(e) {
        e.preventDefault();
        const href = $(this).attr('href');
        swal({
                title: "Apakah Kamu Yakin?",
                text: "Jika Dihapus Data tidak Bisa dikembalikan Lagi",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: href,
                        type: "POST",
                        dataType: "JSON",
                        success: function(response) {
                            if (response['hasil'] == 'sukses') {
                                swal(response['pesan'], {
                                    icon: "success",
                                });
                            } else {
                                swal(response['pesan'], {
                                    icon: "error",
                                });
                            }
                            table.ajax.reload(null, false);
                        }
                    });
                }
            });

    });
</script>
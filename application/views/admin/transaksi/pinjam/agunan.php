    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h3 class="card-title"><?= $title ?></h3> -->
                            <?php
                            if (bisaTulis($link, $id_level)) {
                                echo aksiModalTambah('#modalTambah', 'Tambah');
                            }
                            ?>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="mytable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Agunan </th>
                                        <th>File Agunan</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>


    <div class="modal fade" id="modalTambah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Tambah Agunan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="<?= base_url($post) ?>" enctype="multipart/form-data" method="POST">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="modal-body">

                            <div class="form-group row">
                                <label class="control-label col-sm-3">Nama Agunan</label>
                                <div class="col-sm-9">
                                    <?= formInputText('nama_agunan', '', 'Nama Agunan', 'required') ?>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="control-label col-sm-3">Agunan</label>
                                <div class="col-sm-9">
                                    <?= formInputGambar('gambar', 'required') ?>
                                </div>
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
                            <input type="submit" name="tambah" id="simpan" value="Simpan" class="btn btn-success">
                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="modalEdit">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form Edit Agunan</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                </div>
                <form class="form-horizontal" action="<?= $post ?>" enctype="multipart/form-data" method="POST">
                    <div class="modal-body">
                        <div class="fetched-data"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
                        <button type="submit" name="edit" class="btn btn-success">Simpan</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


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
                    "url": "<?php echo base_url('transaksi/get_agunan/' . $id) ?>",
                    "type": "POST"
                },


                "columnDefs": [{
                        "targets": [0, 2, 3],
                        "orderable": false,
                    },
                    {
                        "targets": [3],
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
<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?php
            if (bisaTulis($link, $id_level)) {
                echo aksiTambah($link . 'tambah', 'Tambah');
            }
            ?>
        </div>
        <h3 class="panel-title"><?= $title ?></h3>
    </div>
    <div class="panel-body">
        <form action="<?= current_url() ?>" class="form-inline m-b-10" method="post">
            <div class="form-group">
                <label for="" class="control-label m-r-20">Tahun</label>
                <select name="tahun" id="" class="form-control" onchange="submit()">
                    <?= opTahun($tahun) ?>
                </select>
            </div>
        </form>
        <div class="table-responsive">
            <table id="mytable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Penandatangan</th>
                        <th>Hal</th>
                        <th width="1%">File</th>
                        <th width="1%">Aksi</th>
                    </tr>
                </thead>
                <tbody>


                </tbody>
            </table>
        </div>
    </div>
    <!-- /.panel-body -->
</div>


<div class="modal fade" id="modalUpload">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header ">
                <h4 class="modal-title">Upload File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form class="form-horizontal" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="id_layanan" name="id">
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="" class="control-label col-md-3">Berkas</label>
                        <div class="col-md-9">
                            <?= formInputFile('gambar', 'required') ?>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
                    <button type="submit" name="upload" class="btn width-100 btn-info">Upload</button>
                </div>
            </form>

        </div>
    </div>
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
                "url": "<?php echo base_url($link . 'get') ?>",
                "type": "POST"
            },


            "columnDefs": [{
                "targets": [0, 5, 6],
                "orderable": false,
                "className": 'text-nowrap'
            }],

        });

        $('#modalUpload').on('show.bs.modal', function(e) {
            var rowid = $(e.relatedTarget).data('id');
            $('#id_layanan').val(rowid);

        });
    });
</script>
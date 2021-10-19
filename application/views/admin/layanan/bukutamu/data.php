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
            <table id="mytable" class="table table-striped table-bordered width-full">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Tanggal</th>

                        <th>Nama/ NIK</th>

                        <th>Instansi</th>
                        <th>Pekerjaan</th>

                        <th>Tujuan</th>
                        <th>Keperluan</th>
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
                "targets": [0, 7],
                "orderable": false,
                "className": 'text-nowrap'
            }],

        });
    });
</script>
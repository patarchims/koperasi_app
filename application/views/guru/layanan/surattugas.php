<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">

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
            <table id="data-table" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th width="1%">No</th>
                        <th>Nomor Surat</th>
                        <th>Tanggal</th>
                        <th>Penandatangan</th>
                        <th width="1%">File</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($record as $row) {
                        $berkas = 'Belum Upload';
                        if ($row['gambar'] != '') {
                            $berkas = aksiUrl($row['gambar'], 'Lihat');
                        }
                        $no++;
                        echo '<tr>
                        <td>' . $no . '</td>
                        <td>' . $row['nomor'] . '</td>
                        <td>' . tgl_indo($row['tanggal']) . '</td>
                        <td>' . stripslashes($row['nama']) . '</td>
                        <td nowrap>' . $berkas . '</td>
                        </tr>';
                    }
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
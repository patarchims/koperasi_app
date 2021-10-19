<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?= aksiTambah($link . 'tambah') ?>
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
                        <th>Tanggal</th>
                        <th>Hal</th>
                        <th>Status</th>
                        <th>Informasi</th>
                        <th width="1%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($record as $row) {
                        $no++;
                        echo '<tr>
                        <td>' . $no . '</td>
                        <td>' . tgl_indo($row['tanggal']) . '</td>
                        <td>' . stripslashes($row['hal']) . '</td>
                        <td>' . statusTiket($row['status']) . '</td>
                        <td>' . stripslashes($row['informasi']) . '</td>
                        <td nowrap>';
                        echo aksiDetail($link . 'detail', enkrip($row['id']));
                        if ($row['status'] == 0) {
                            echo '&nbsp;';
                            echo aksiEdit($link . 'edit', enkrip($row['id']));
                            echo '&nbsp;';
                            echo aksiHapus($link . 'hapus', enkrip($row['id']));
                        }
                        echo '</td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.panel-body -->
</div>
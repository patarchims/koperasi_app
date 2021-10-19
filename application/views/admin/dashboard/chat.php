<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?= aksiKembali($link) ?>
        </div>
        <h3 class="panel-title"><?= $title ?></h3>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-condensed">
                <thead>
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="1%">:</th>
                        <th><?= tgl_indo($rows['tanggal']) ?></th>
                    </tr>
                    <tr>
                        <th width="15%">Hal</th>
                        <th width="1%">:</th>
                        <th><?= stripslashes($rows['hal']) ?></th>
                    </tr>
                    <tr>
                        <th width="15%">Uraian</th>
                        <th width="1%">:</th>
                        <th><?= gantiEnter($rows['isi']) ?></th>
                    </tr>
                    <tr>
                        <th width="15%">Lampiran</th>
                        <th width="1%">:</th>
                        <th>
                            <?php if ($rows['gambar'] == '') {
                                echo 'Tidak Ada Lampiran';
                            } else {
                                echo aksiUrl($rows['gambar'], 'Lihat');
                            } ?>
                        </th>
                    </tr>
                    <tr>
                        <th width="15%">Status</th>
                        <th width="1%">:</th>
                        <th><?= statusTiket($rows['status']) ?></th>
                    </tr>
                    <tr>
                        <th width="15%">Informasi</th>
                        <th width="1%">:</th>
                        <th><?= stripslashes($rows['informasi']) ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- /.panel-body -->
</div>

<div class="row">
    <!-- begin col-4 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse" data-sortable-id="index-2">
            <div class="panel-heading">
                <h4 class="panel-title">Histori Percakapan <span class="label bg-gradient-teal pull-right"><?= count($chat) ?> Pesan</span></h4>
            </div>
            <div class="panel-body bg-silver">
                <div class="chats">
                    <?php

                    foreach ($chat as $row) {
                        $lampiran = '';
                        if ($row['gambar'] != '') {
                            $lampiran = aksiUrl($row['gambar'], 'Lihat Lampiran');
                        }
                        if ($row['pengirim'] == 'Siswa') {
                            echo '<div class="left">
                                    <span class="date-time">' . tgl_waktu_full($row['create_at']) . '</span>
                                    <a href="javascript:;" class="name">' . stripslashes(viewSiswa($row['id_pengirim'], 'nama')) . '</a>
                                    <a href="javascript:;" class="image"><img alt="" src="' . gambarAws(viewSiswa($row['id_pengirim'], 'gambar')) . '" width="75"/></a>
                                    <div class="message">
                                        ' . stripslashes($row['pesan']) . '
                                        </p>' . $lampiran . '</p>
                                    </div>
                                </div>';
                        } else {
                            echo '<div class="right">
                                    <span class="date-time">' . tgl_waktu_full($row['create_at']) . '</span>
                                    <a href="javascript:;" class="name"><span class="label label-primary">' . stripslashes(viewUser($row['id_pengirim'])) . '</span></a>
                                    <a href="javascript:;" class="image"><img alt="" src="' . gambarUser(viewUser($row['id_pengirim'], 'gambar')) . '" /></a>
                                    <div class="message">
                                        ' . stripslashes($row['pesan']) . '
                                        </p>' . $lampiran . '</p>
                                    </div>
                                </div>';
                        }
                    }
                    ?>

                </div>
            </div>
            <?php if ($rows['status'] < 2) { ?>
                <div class="panel-footer">
                    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" enctype="multipart/form-data" method="post">
                        <input type="hidden" name="id_tiket" value="<?= $rows['id'] ?>">
                        <div class="form-group row m-b-5">
                            <label for="" class="col-md-2 control-label">Pesan</label>
                            <div class="col-md-10">
                                <textarea name="pesan" id="" class="form-control" rows="5" required></textarea>
                            </div>

                        </div>
                        <div class="form-group row m-b-5">
                            <label for="" class="col-md-2 control-label">Lampiran</label>
                            <div class="col-md-10">
                                <?= formInputFile('gambar') ?>
                                <small>Kosongkan jika tidak upload lampiran</small>
                            </div>

                        </div>
                        <div class="form-group row m-b-5">
                            <div class="col-md-12 text-right">
                                <button type="submit" name="simpan" id='btn-simpan' class="btn btn-info">Balas Pesan</button>
                            </div>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>
        <!-- end panel -->
    </div>

</div>
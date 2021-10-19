<div class="row">
    <!-- end col-6 -->

    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <?= aksiKembali($link) ?>
                </div>
                <h4 class="panel-title">Detail <?= $title ?></h4>
            </div>
            <div class="panel-body text-center">


                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive text-left f-w-700">
                            <table class="table table-hover table-condensed ">
                                <tbody>
                                    <tr>
                                        <td width="15%">Tanggal</td>
                                        <td>:</td>
                                        <td><?= tgl_indo($rows['tanggal']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%" nowrap>Pukul</td>
                                        <td width="1%">:</td>
                                        <td><?= $rows['waktu'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Nama</td>
                                        <td width="1%">:</td>
                                        <td><?= stripslashes($rows['nama']) ?></td>
                                    </tr>
                                    <tr>
                                        <td>NIK</td>
                                        <td width="1%">:</td>
                                        <td><?= $rows['nik'] ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Alamat</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['alamat']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Instansi</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['instansi']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Pekerjaan</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['pekerjaan']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Jabatan</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['jabatan']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Tujuan</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['tujuan']) ?></td>
                                    </tr>
                                    <tr>
                                        <td width="15%">Keperluan</td>
                                        <td width="1%">:</td>
                                        <td><?= stripcslashes($rows['keperluan']) ?></td>
                                    </tr>



                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- end panel -->
    </div>
</div>
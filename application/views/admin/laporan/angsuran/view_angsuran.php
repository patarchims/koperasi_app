<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?= $title ?></h1>
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


        <div class="col md-12">


            <!-- /.card-header -->
            <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th>Nomor Angsuran</th>
                            <th>Nomor Pinjam</th>
                            <th>Nomor Anggota</th>
                            <th>Angsuran Ke</th>
                            <th>Jumlah</th>
                            <th>Tanggal Transaksi</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        foreach ($result as $key) {
                            $no++;

                        ?>
                            <tr>
                                <td><?= $no; ?></td>
                                <td><?= $key['no_angsuran'] ?></td>
                                <td><?= $key['no_pinjaman'] ?></td>
                                <td><?= $key['no_anggota'] ?></td>
                                <td><?= $key['angsuran_ke'] ?></td>
                                <td><?= $key['jlh_bayar'] ?></td>
                                <td><?= $key['tanggal'] ?></td>
                                <td>
                                    <a target="_blank" href="<?= base_url('transaksi/cetak_angsuran/') . $key['id_angsuran'] ?>" class="btn btn-block btn-info">Cetak</a>
                                </td>

                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</section>
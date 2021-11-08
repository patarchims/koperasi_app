<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Data Pinjaman</h1>
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
                            <th>Nomor Pinjaman</th>
                            <th>Nomor Anggota</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tenor</th>
                            <th>Angsuran</th>
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
                                <td><?= $key['no_pinjaman'] ?></td>
                                <td><?= $key['no_anggota'] ?></td>
                                <td><?= 'IDR ' . rupiah($key['jlh_pinjam']) ?></td>
                                <td><?= $key['tenor'] . ' Bulan' ?></td>
                                <td><?= 'IDR ' . rupiah($key['angsuran']) ?></td>
                                <td><?= tgl_indo($key['tgl_pinjam']) ?></td>
                                <td>
                                    <a target="_blank" href="<?= base_url('transaksi/cetak_pinjaman/') . $key['no_pinjaman'] ?>" class="btn btn-block btn-info">Cetak</a>
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
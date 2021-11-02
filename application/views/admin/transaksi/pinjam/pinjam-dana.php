    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= ' Transaksi Pinjaman' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= ' Transaksi Pinjaman' ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">


            <h5 class="mt-4 mb-2"></h5>

            <div class="row">
              <div class="col-md-12">

                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h5><i class="icon fas fa-info"></i> Note!</h5>
                  Catat dan simpan Nomor transaksi. Periksa kembali detail pinjaman di bawah ini sebelum di cetak.
                </div>




                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">

                          <div class="col-md-6">
                            <h3 class="card-title">
                              <i class="fas fa-text-width"></i>
                              <?= $identitas['nama'] ?>
                            </h3>
                          </div>
                          <div class="col-md-6">
                            <h5>Nomor Transaksi : <?= $result['no_pinjaman'] ?></h3>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body">
                        <dl>
                          <dt>Description lists</dt>
                        </dl>
                      </div>

                      <br>



                      <!-- TABLE DETAIL -->
                      <div class="card-body">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Jumlah Pinjaman</th>
                              <th>Tenor</th>
                              <th>Bunga Per Tahun</th>
                              <th>Total</th>
                              <th>Angsuran</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td></td>
                              <td><?= rupiah($result['jlh_pinjam'])  ?></td>
                              <td><?= $result['tenor'] . ' Bulan' ?></td>
                              <td><?= $result['bunga'] . ' %' ?></td>
                              <td><?= rupiah($result['total'])  ?></td>
                              <td><?= rupiah($result['angsuran'])  ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>Jumlah Pinjam</td>
                              <td>IDR <?= rupiah($result['jlh_pinjam']) ?></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td>Administrasi</td>
                              <td>IDR <?= rupiah($result['administrasi'])  ?></td>
                            </tr>

                          </tbody>
                        </table>

                        <h5>Keterangan : </h5>
                        <br>
                        <td><?= $result['keterangan'] ?> </td>
                        <br>

                        <a class="btn btn-primary" href="<?= base_url($link) ?>" type="button">Kembali</a>
                        <a class="btn btn-info" href="<?= base_url('transaksi/cetak_pinjaman/') .  ?>" type="button">Cetak</a>


                      </div>


                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- ./col -->

                </div>





                <!-- /.card -->
              </div>
              <!-- /.col -->

            </div>

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
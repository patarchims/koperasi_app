<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">


        <h5 class="mt-4 mb-2"></h5>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-exclamation-triangle"></i>
                  Informasi
                </h3>
              </div>
              <!-- /.card-header -->

              <div class="card-body">

                <div class="callout callout-info">
                  <h5></h5>

                  <p>Pembayaran angsuran ke- <strong> <?= $result['angsuran_ke'] ?> </strong> untuk No. Pinjam <?= $result['no_pinjaman'] ?> berhasil</p>

                </div>

              </div>




              <div class="card-body">

                <div class="row">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Nomor Pinjaman</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <?= $result['no_pinjaman'] ?>
                        </td>
                        <td>
                          <?= viewAnggota($result['id_anggota'], 'no_identitas') ?>
                        </td>
                        <td>
                          <?= viewAnggota($result['id_anggota'], 'nama_anggota') ?>
                        </td>
                        <td>
                          <?= $result['tanggal'] ?>
                        </td>
                      </tr>
                    </tbody>
                  </table>


                  <div class="col-md-7"></div>
                  <div class="col-md-5">
                    <table>
                      <tr>
                        <td>
                          <h6 style="font-weight: bold;"> Nomor Angsuran </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"> : </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"><?= $result['no_angsuran'] ?></h6>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h6 style="font-weight: bold;"> Angsuran Ke </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"> : </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"><?= $result['angsuran_ke'] ?></h6>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <h6 style="font-weight: bold;"> Jumlah Bayar </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"> : </h6>
                        </td>
                        <td>
                          <h6 style="font-weight: bold;"> <?= 'IDR ' .  rupiah($result['jlh_bayar'])  ?> </h6>
                        </td>
                      </tr>

                    </table>
                  </div>





                  <br>
                  <br>


                  <br>

                  <div class="col-md-7 mt-3">
                    <tr>
                      <h6 style="font-weight: bold;"> Keterangan : </h6>
                      <p><?= $result['keterangan'] ?></p>
                    </tr>
                  </div>
                  <div class="col-md-5" style="text-align: right;">

                    <a class="btn btn-primary " href="<?= base_url($link) ?>" type="button">Batal</a>
                    <a class="btn btn-warning " href="<?= base_url('transaksi/cetak_angsuran/') . $result['id_angsuran']    ?>" style="margin-left: 10px">Cetak</a>
                  </div>


                </div>
              </div>


              <!-- /.card-body -->
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
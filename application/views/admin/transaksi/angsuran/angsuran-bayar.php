<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?= ' Transaksi Angsuran' ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active"><?= ' Transaksi Angsuran' ?></li>
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
            <div class="card card-default">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-7">
                    <h3 class="card-title">
                      Bayar Angsuran
                    </h3>
                  </div>
                  <div class="col-md-5">
                    Waktu Transaksi : <?= date('Y-m-d H:i:s') ?>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->

              <div class="card-body">
                <!-- Content Body Here -->

                <div class="card-body">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>No. Pinjam</th>
                        <th>NIK</th>
                        <th>Nama</th>
                        <th>Angsuran</th>
                        <th>Sisa Tenor</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?= $result['no_pinjaman'] ?></td>
                        <td><?= viewAnggota($result['id_anggota'], 'no_identitas') ?></td>
                        <td><?= viewAnggota($result['id_anggota'], 'nama_anggota') ?></td>
                        <td><?= 'IDR ' .  rupiah($result['angsuran'])  ?></td>
                        <td><?= $result['sisa_tenor'] . ' Bulan' ?></td>
                        <td><?= $result['status'] ?></td>
                      </tr>
                    </tbody>
                  </table>

                  <br>

                  <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6">
                      <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= base_url($link) ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                        <input type="hidden" name="no_pinjaman" value="<?= $result['no_pinjaman'] ?>">
                        <input type="hidden" name="no_angsuran" value="<?= hitungAngsuran($result['no_pinjaman']) ?>">
                        <input type="hidden" name="denda" value="1">
                        <input type="hidden" name="id_anggota" value="<?= $result['id_anggota'] ?>">
                        <input type="hidden" name="tgl_pinjam" value="<?= $result['tgl_pinjam'] ?>">
                        <input type="hidden" name="angsuran" value="<?= $result['angsuran'] ?>">
                        <input type="hidden" name="tenor" value="<?= $result['tenor'] ?>">
                        <input type="hidden" name="angsuran_ke" value="<?= $angsuran_ke ?>">
                        <input type="hidden" name="jlh_bayar" value="<?= $total_bayar ?>">
                        <input type="hidden" name="denda" value="<?= $denda ?>">
                        <input type="hidden" name="jth_tempo" value="<?= $tgl_jatuh_tempo ?>">
                        <input type="hidden" name="hari_telat" value="<?= $tgl_telat ?>">
                        <table>
                          <tr>
                            <td>
                              <h6 style="font-weight: bold;"> Angsuran Ke </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"> : </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"><?= $angsuran_ke ?></h6>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h6 style="font-weight: bold;"> Tanggal Jatuh Tempo </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"> : </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"><?= tgl_indo($tgl_jatuh_tempo) ?></h6>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h6 style="font-weight: bold;"> Jumlah Hari Telat </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"> : </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"><?= $tgl_telat . ' Hari' ?></h6>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h6 style="font-weight: bold;"> Denda </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"> : </h6>
                            </td>
                            <td>
                              <h6 style="font-weight: bold;"><?= ' IDR ' . rupiah($denda) ?></h6>
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
                              <h6 style="font-weight: bold;"> <?= 'IDR ' .  rupiah($total_bayar)  ?> </h6>
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <h6 style="font-weight: bold;"> Keterangan : </h6>
                            </td>
                            <td></td>
                            <td>
                              <textarea class="form-control" name="keterangan" rows="3" placeholder="Keterangan"></textarea>
                            </td>
                          </tr>
                        </table>
                        <br>


                        <a class="btn btn-primary" href="<?= base_url($link) ?>" type="button">Batal</a>
                        <button class="btn btn-warning" type="submit" name="bayar">Bayar</button>
                        <!-- <a class="btn btn-warning" href="<?= base_url($link) ?>" type="button">Bayar</a> -->

                      </form>
                      <br>

                    </div>


                  </div>


                  <br>



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
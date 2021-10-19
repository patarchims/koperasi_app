<div class="row">
  <!-- end col-6 -->

  <div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <?= aksiKembali($link) ?>
        </div>
        <h4 class="panel-title">Detail Pendaftar</h4>
      </div>
      <div class="panel-body text-center">
        <div class="row">

          <div class="col-md-12">
            <div class="table-responsive text-left f-w-700">
              <table class="table table-hover table-condensed ">
                <tbody>
                  <tr>
                    <td width="15%">Tahun PPDB</td>
                    <td>:</td>
                    <td><?= stripcslashes($rows['tahun']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Cara Daftar</td>
                    <td>:</td>
                    <td><?= stripcslashes($rows['cara_daftar']) ?></td>
                  </tr>

                  <tr>
                    <td width="15%">Nama</td>
                    <td>:</td>
                    <td><?= stripcslashes($rows['nama']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>Tanggal lahir</td>
                    <td width="1%">:</td>
                    <td><?= tgl_indo($rows['tgl_lahir']) ?></td>
                  </tr>

                  <tr>
                    <td width="15%">Jenis Kelamin</td>
                    <td width="1%">:</td>
                    <td><?= $rows['jk'] ?></td>
                  </tr>

                  <tr>
                    <td width="15%">No. HP</td>
                    <td width="1%">:</td>
                    <td><?= $rows['hp'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Email</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['email']) ?></td>
                  </tr>

                  <tr>
                    <td width="15%">Alamat</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['alamat']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">NIK</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['nik']) ?></td>
                  </tr>
                  <?php
                  if ($rows['id_jurusan'] > 0) {
                  ?>
                    <tr>
                      <td width="15%">Jurusan</td>
                      <td width="1%">:</td>
                      <td><?= viewJurusan($rows['id_jurusan']) ?></td>
                    </tr>
                  <?php
                  }

                  if ($rows['cara_daftar'] == 'Manual') {
                  ?>
                    <tr>
                      <td width="15%" nowrap>User yang mendaftarkan</td>
                      <td width="1%">:</td>
                      <td><?= viewUser($rows['create_user']) ?></td>
                    </tr>
                  <?php
                  }
                  ?>

                  <tr>
                    <td width="15%">Tanggal Daftar</td>
                    <td width="1%">:</td>
                    <td><?= tgl_waktu_full($rows['create_at']) ?></td>
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
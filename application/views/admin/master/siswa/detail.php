<div class="row">
  <!-- end col-6 -->

  <div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <?= aksiKembali($link) ?>
        </div>
        <h4 class="panel-title">Detail Siswa</h4>
      </div>
      <div class="panel-body text-center">
        <img class="p-b-20" src="<?= gambarAws($rows['gambar']) ?>" width="200" alt="">

        <div class="row">
          <div class="col-md-2">
          </div>
          <div class="col-md-8">
            <div class="table-responsive text-left f-w-700">
              <table class="table table-hover table-condensed ">
                <tbody>
                  <tr>
                    <td width="15%">Nama</td>
                    <td>:</td>
                    <td><?= stripcslashes($rows['nama']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>NIS</td>
                    <td width="1%">:</td>
                    <td><?= $rows['nis'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>NISN</td>
                    <td width="1%">:</td>
                    <td><?= $rows['nisn'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>Tanggal Masuk</td>
                    <td width="1%">:</td>
                    <td><?= tgl_indo($rows['tgl_masuk']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>Kelas</td>
                    <td width="1%">:</td>
                    <td><?= viewKelas($rows['id_siswa']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>Status</td>
                    <td width="1%">:</td>
                    <td><?= $rows['status'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%" nowrap>Tempat Tanggal Lahir</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['tempat_lahir']) . ', ' . tgl_indo($rows['tgl_lahir']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Jenis Kelamin</td>
                    <td width="1%">:</td>
                    <td><?= $rows['jk'] ?></td>
                  </tr>
                  <tr>
                    <td>Agama</td>
                    <td width="1%">:</td>
                    <td><?= $rows['agama'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Alamat</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['alamat']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Nama Ayah</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['nama_ayah']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Pekerjaan Ayah</td>
                    <td width="1%">:</td>
                    <td><?= $rows['pekerjaan_ayah'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">No. HP Ayah</td>
                    <td width="1%">:</td>
                    <td><?= $rows['hp_ayah'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Nama Ibu</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['nama_ibu']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Pekerjaan Ibu</td>
                    <td width="1%">:</td>
                    <td><?= $rows['pekerjaan_ibu'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">No. HP Ibu</td>
                    <td width="1%">:</td>
                    <td><?= $rows['hp_ibu'] ?></td>
                  </tr>
                  <tr>
                    <td width="15%">Nama Wali</td>
                    <td width="1%">:</td>
                    <td><?= stripcslashes($rows['nama_wali']) ?></td>
                  </tr>
                  <tr>
                    <td width="15%">No. HP Wali</td>
                    <td width="1%">:</td>
                    <td><?= $rows['hp_wali'] ?></td>
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
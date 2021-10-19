<div class="panel panel-inverse">
  <div class="panel-heading">
    <h3 class="panel-title"><?= $title ?></h3>

    <div class="panel-heading-btn">

    </div>
  </div>
  <div class="panel-body">
    <form class="form-horizontal " enctype="multipart/form-data" action="<?= base_url($link) ?>" method="POST">
      <?php
      echo '<input class="form-control form-control-sm" type="hidden" name="id" value="' . $rows['id'] . '">';
      echo '<div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">NPSN</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="kode" value="' . $rows['kode'] . '" placeholder="Kode" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Tingkat Pendidikan</label>
                        <div class="col-sm-10 ">
                          <select name="tingkat" class="form-control" required>
                            ' . opEnum('identitas', 'tingkat', $rows['tingkat']) . '
                          </select>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Instansi</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="instansi" value="' . $rows['instansi'] . '" placeholder="Instansi" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Nama</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="nama" value="' . $rows['nama'] . '" placeholder="Nama" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Alamat</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="alamat" value="' . $rows['alamat'] . '" placeholder="Alamat" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Kota</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="kota" value="' . $rows['kota'] . '" placeholder="Kota" required>
                          </div>
                      </div> 
                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Telepon</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="telp" value="' . $rows['telp'] . '" placeholder="No. Telepon">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Website</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="web" value="' . $rows['web'] . '" placeholder="Website">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="email" name="email" value="' . $rows['email'] . '" placeholder="Email">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Default Kode Nomor Surat</label>
                        <div class="col-sm-10 ">
                          <input class="form-control form-control-sm" type="text" name="nomor_surat" value="' . $rows['nomor_surat'] . '" placeholder="Kode Nomor Surat">
                          </div>
                      </div>

                      

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Facebook</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="fb" class="form-control form-control-sm" value="' . $rows['fb'] . '" placeholder="Facebook">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Twitter</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="tw" class="form-control form-control-sm" value="' . $rows['tw'] . '" placeholder="Twitter">
                          </div>
                      </div>

                      

                       
                       <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Youtube</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="yt" class="form-control form-control-sm" value="' . $rows['yt'] . '" placeholder="Youtube">
                          </div>
                      </div>


                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Footer</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="footer" class="form-control form-control-sm" value="' . $rows['footer'] . '" placeholder="Footer">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Keyword</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="keyword" class="form-control form-control-sm" value="' . $rows['keyword'] . '" placeholder="Keyword (pisahkan dengan koma)">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Deskripsi</label>
                        <div class="col-sm-9 controls">
                          <input type="text" name="deskripsi" class="form-control form-control-sm" value="' . $rows['deskripsi'] . '" placeholder="Deskripsi">
                          </div>
                      </div>

                      

                      <div class="form-group row m-b-15">
                        <label class="col-sm-2 control-label">Logo</label>
                        <div class="col-sm-3 ">
                          <input class="form-control" type="file" name="gambar">
                          </div>
                          <label class="col-sm-7 control-label">Kosong Jika Tidak Mengganti Logo</label>
                      </div>

                      <div class="form-group row m-b-15">
                        <label class="col-sm-2 control-label">Logo Sebelumnya</label>
                        <div class="col-sm-2 ">';
      if ($rows['logo'] == '') {
        echo '<p>Belum Ada Logo</p>';
      } else {
        echo '<img src="' . base_url() . 'assets/img/' . $rows['logo'] . '" width="100%">';
      }
      echo '</div>
                         
                      </div>';



      if (bisaUbah($link, $id_level)) {

        echo '<div class="form-group row m-b-5 ">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-10">
                          <button class="btn btn-success" name="submit" type="submit"> Edit</button>
                          
                        </div>
                      </div>';
      }

      ?>
    </form>
  </div>
  <!-- /.panel-body -->
</div>
<!-- begin page-header -->
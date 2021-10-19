<style>
  * {
    padding: 0;
    margin: 0;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }

  body {
    line-height: 1.5;
  }

  img {
    max-width: 100%;
    height: auto;
  }

  ul,
  ol {
    list-style-type: none;
  }

  p,
  label {
    font-family: sans-serif;
  }

  .container-wrapper {
    margin: 7% auto;
    position: relative;
    width: 500px;
    overflow: hidden;
  }

  /* CSS Tab styling is start here */

  /* Tab menu styling*/
  input.tab-menu-radio {
    display: none;
  }

  label.tab-menu {
    display: inline-block;
    float: left;
    padding: 10px 30px;
    cursor: pointer;
    z-index: 99;
  }

  /* End Tab menu styling*/

  /* Tab content styling*/

  .tab-content {
    top: -3px;
    clear: both;
    width: 100%;
    position: relative;
    padding: 20px;
    background-color: #f7f7f7;
    border-top: 7px solid #333;
  }

  /* End Tab content styling*/

  /* CSS tab core */
  .tab-menu-radio:checked+label {
    -webkit-transition: all 1s;
    /* Optional */
    -moz-transition: all 1s;
    /* Optional */
    transition: all 1s;
    /* Optional */
    background-color: #333;
    color: #fff;
  }

  .tab-content .tab {
    height: 0;
    opacity: 0;
  }

  #tab-menu1:checked~.tab-content .tab-1,
  #tab-menu2:checked~.tab-content .tab-2,
  #tab-menu3:checked~.tab-content .tab-3 {
    -webkit-transition: opacity 1s;
    /* Optional */
    -moz-transition: opacity 1s;
    /* Optional */
    transition: opacity 1s;
    /* Optional */
    height: auto;
    opacity: 1;
  }


  /* Pesan Kesalahan */
  .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
  }

  .success {
    padding: 20px;
    background-color: #3CB371;
    color: white;
  }


  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }

  /* End CSS tab core */

  /* CSS Tab Styling is end here */
</style>



<div class="page-title-area bg-13">
  <div class="container">
    <div class="page-title-content">
      <h2><?= $title ?></h2>
      <ul>
        <li>
          <a href="<?= base_url('home') ?>">
            Home
          </a>
        </li>

        <li><?= $title ?></li>
      </ul>
    </div>
  </div>
</div>


<section class="news-details-area ptb-100">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12">


      <div class="container">

<?php
if ($this->session->flashdata('sukses') != '') {
  echo '
<div class="success">
<span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
<strong></strong> ' . $this->session->flashdata('sukses') . ' 
</div>';
} else if ($this->session->flashdata('gagal') != '') {
  echo '
<div class="alert">
<span class="closebtn" onclick="this.parentElement.style.display="none";">&times;</span> 
<strong></strong> ' .  $this->session->flashdata('gagal') .  ' 
</div>';
}
?>
<div class="tab-container">


  <?php
  if (count($rows) > 0) {
    $tanggal = date('Y-m-d');
    if ($rows['tgl_awal_daftar'] <= $tanggal and $rows['tgl_akhir_daftar']) {
  ?>


      <input type="radio" name="tab-menu" class="tab-menu-radio" id="tab-menu1" checked />
      <label for="tab-menu1" class="tab-menu">Pendaftaran</label>

      <input type="radio" name="tab-menu" class="tab-menu-radio" id="tab-menu2" />
      <label for="tab-menu2" class="tab-menu">Upload Bukti Bayar</label>



      <div class="tab-content">

        <div class="tab tab-1">
          <form class="form-horizontal" action="<?= current_url() ?>" method="post">
            <div class="form-group row">
              <label class="control-label col-md-3">Tahun</label>
              <div class="col-md-9">
                <?= formInputText('tahun', date('Y'), 'Tahun', 'readonly') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Nama Lengkap</label>
              <div class="col-md-9">
                <?= formInputText('nama', '', 'Nama Lengkap', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Tanggal Lahir</label>
              <div class="col-md-9">
                <?= formInputDate('tgl_lahir', '', 'Tanggal Lahir', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Jenis Kelamin</label>
              <div class="col-md-9">
                <?= opEnumRadio('ppdb_pendaftar', 'jk', '') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Nama Orangtua</label>
              <div class="col-md-9">
                <?= formInputText('nama_ortu', '', 'Nama Orang Tua', 'required') ?>
              </div>
            </div>


            <div class="form-group row">
              <label class="control-label col-md-3">NO. HP</label>
              <div class="col-md-9">
                <?= formInputText('hp', '', 'No. Handphone', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
                <?= formInputEmail('email', '', 'Alamat Email', 'required') ?>
              </div>
            </div>


            <div class="form-group row">
              <label class="control-label col-md-3">Alamat</label>
              <div class="col-md-9">
                <?= formInputText('alamat', '', 'Alamat Rumah', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">NIK</label>
              <div class="col-md-9">
                <?= formInputText('nik', '', 'Nomor Induk Kependudukan', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Password</label>
              <div class="col-md-9">
                <?= formInputPassword('password', '', 'Password', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Ulangi Password</label>
              <div class="col-md-9">
                <?= formInputPassword('password1', '', 'Password', 'required') ?>
              </div>
            </div>

            <?php
            if (jurusanAktif() > 0) {
              echo '
<div class="form-group row">
<label class="control-label col-md-3">Jurusan</label>
<div class="col-md-9">
<select name="id_jurusan" class="form-control" required>
' . opJurusan('') . '
</select>
</div>
</div>
';
            } else {
              echo '<input type="hidden" name="id_jurusan" value="0">';
            }
            ?>


            <div class="form-group row">
              <label class="control-label col-md-3"></label>
              <div class="col-md-9">
                <button class="btn btn-success" id="btnSimpan" name="daftar" type="submit"> Daftar</button>

              </div>
            </div>
          </form>

        </div>

        <div class="tab tab-2">
          <form class="form-horizontal" action="<?= current_url() ?>" enctype="multipart/form-data" method="post">


            <div class="form-group row">
              <label class="control-label col-md-3">Email</label>
              <div class="col-md-9">
                <?= formInputEmail('email', '', 'Alamat Email', 'required') ?>
              </div>
            </div>


            <div class="form-group row">
              <label class="control-label col-md-3">Password</label>
              <div class="col-md-9">
                <?= formInputText('password', '', 'Password', 'required') ?>
              </div>
            </div>

            <div class="form-group row">
              <label class="control-label col-md-3">Bukti Bayar</label>
              <div class="col-md-9">
                <?= formInputFile('gambar', 'required') ?>
              </div>
            </div>



            <div class="form-group row">
              <label class="control-label col-md-3"></label>
              <div class="col-md-9">
                <button class="btn btn-success" id="btnUpload" name="upload" type="submit"> Upload Bukti Bayar</button>

              </div>
            </div>
          </form>
        </div>



      </div>

  <?php
    } else if ($rows['tgl_awal_daftar'] > $tanggafl) {
      echo '<p>Pendaftaran Penerimaan Peserta Didik Baru Belum Di Buka</p>';
    } else {
      echo '<p>Pendaftaran Penerimaan Peserta Didik Baru Sudah Ditutup</p>';
    }
  } else {
    echo '<p>Pendaftaran Penerimaan Peserta Didik Baru Belum Di Buka</p>';
  } ?>

</div>
</div>





      </div>
      <div class="col-lg-4 col-md-12">


        <?php $this->load->view('front/sidebar'); ?>

      </div>
    </div>
  </div>
</section>













<script type="text/javascript">
  $('#btnSimpan').click(function() {
    var password = $('#password').val();
    var password1 = $('#password1').val();
    if (password !== password1) {
      alert('Password Tidak Sama');
      return false;
    }
  });
</script>
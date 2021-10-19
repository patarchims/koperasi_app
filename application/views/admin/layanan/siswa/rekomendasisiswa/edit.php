<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">

    </div>
    <h3 class="panel-title"><?= $title ?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group row">
        <label class="control-label col-md-2">Judul Surat</label>
        <div class="col-md-10">
          <?= formInputText('judul_surat', stripslashes($rows['judul_surat']), 'Judul Surat', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Surat</label>
        <div class="col-md-10">
          <?= formInputDate('tanggal', $rows['tanggal'], 'Tanggal Surat', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nomor Surat</label>
        <div class="col-md-10">
          <?= formInputText('nomor', $rows['nomor'], 'Nomor Surat', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Penandatangan</label>
        <div class="col-md-10">
          <select name="penandatangan" class="form-control">
            <option value="">..::Pilih Penandatangan::..</option>
            <?= opPenandatangan($rows['penandatangan']) ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Pengantar</label>
        <div class="col-md-10">
          <?= formInputText('pengantar', stripslashes($rows['pengantar']), 'Pengantar', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nama</label>
        <div class="col-md-10">
          <?= formInputText('nama', stripslashes($rows['nama']), 'Nama', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NISN</label>
        <div class="col-md-10">
          <?= formInputText('nisn', $rows['nisn'], 'NISN', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Tempat Lahir</label>
        <div class="col-md-10">
          <?= formInputText('tempat_lahir', stripslashes($rows['tempat_lahir']), 'Tempat Lahir', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Lahir</label>
        <div class="col-md-10">
          <?= formInputDate('tgl_lahir', $rows['tgl_lahir'], 'Tanggal Lahir', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis Kelamin</label>
        <div class="col-md-10">
          <?= opEnumRadio('layanan_05', 'jk', $rows['jk']) ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Sekolah Asal</label>
        <div class="col-md-10">
          <?= formInputText('sekolah_asal', stripslashes($rows['sekolah_asal']), 'Sekolah Asal', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Alamat</label>
        <div class="col-md-10">
          <?= formInputText('alamat', stripslashes($rows['alamat']), 'Alamat', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Kelas</label>
        <div class="col-md-10">
          <?= formInputText('kelas', $rows['kelas'], 'Kelas', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jurusan</label>
        <div class="col-md-10">
          <?= formInputText('jurusan', $rows['jurusan'], 'Jurusan', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nama Orangtua</label>
        <div class="col-md-10">
          <?= formInputText('nama_ortu', stripslashes($rows['nama_ortu']), 'Nama Orang Tua', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Keterangan</label>
        <div class="col-md-10">
          <?= formInputTextarea('keterangan', gantiEdit($rows['keterangan']), 'form-control', 'Keterangan Rekomendasi') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2"></label>
        <div class="col-md-10">
          <button class="btn btn-success" id="btnSimpan" name="simpan" type="submit"> Simpan</button>
          <a class="btn btn-danger" href="<?= base_url($link) ?>" type="button">Cancel</a>
        </div>
      </div>

    </form>
  </div>
  <!-- /.panel-body -->
</div>
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
          <?= formInputText('judul_surat', 'SURAT KETERANGAN', 'Judul Surat', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Surat</label>
        <div class="col-md-10">
          <?= formInputDate('tanggal', date('Y-m-d'), 'Tanggal Surat', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nomor Surat</label>
        <div class="col-md-10">
          <?= formInputText('nomor', $identitas['nomor_surat'] . date('Y'), 'Nomor Surat', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Penandatangan</label>
        <div class="col-md-10">
          <select name="penandatangan" class="form-control">
            <option value="">..::Pilih Penandatangan::..</option>
            <?= opPenandatangan('') ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Pengantar</label>
        <div class="col-md-10">
          <?= formInputText('pengantar', 'Yang bertanda tangan dibawah ini Kepala ' . $identitas['nama'] . ', menerangkan bahwa :', 'Pengantar', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nama</label>
        <div class="col-md-10">
          <?= formInputText('nama', '', 'Nama', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NPM</label>
        <div class="col-md-10">
          <?= formInputText('npm', '', 'NPM', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Program Studi</label>
        <div class="col-md-10">
          <?= formInputText('prodi', '', 'Program Studi', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenjang Program</label>
        <div class="col-md-10">
          <?= formInputText('jenjang', '', 'Jenjang Program', '') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Keterangan</label>
        <div class="col-md-10">
          <?= formInputText('keterangan', 'Adalah benar telah menyerahkan sebuah Skripsi dengan Judul', 'Keterangan', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Judul Skripsi</label>
        <div class="col-md-10">
          <?= formInputText('judul_skripsi', '', 'Judul Skripsi', 'required') ?>
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
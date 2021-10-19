<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">

    </div>
    <h3 class="panel-title">Form Edit <?= $title ?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal</label>
        <div class="col-md-10">
          <?= formInputDate('tanggal', $rows['tanggal'], 'Tanggal', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Pukul</label>
        <div class="col-md-10">
          <?= formInputTime('waktu', $rows['waktu'], 'Pukul', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Nama Tamu</label>
        <div class="col-md-10">
          <?= formInputText('nama', stripslashes($rows['nama']), 'Nama Tamu', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">NIK</label>
        <div class="col-md-10">
          <?= formInputText('nik', stripslashes($rows['nik']), 'NIK', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Alamat</label>
        <div class="col-md-10">
          <?= formInputText('alamat', stripslashes($rows['alamat']), 'Alamat', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Instansi</label>
        <div class="col-md-10">
          <?= formInputText('instansi', stripslashes($rows['instansi']), 'Instansi', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Pekerjaan</label>
        <div class="col-md-10">
          <?= formInputText('pekerjaan', stripslashes($rows['pekerjaan']), 'Pekerjaan', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Jabatan</label>
        <div class="col-md-10">
          <?= formInputText('jabatan', stripslashes($rows['jabatan']), 'Jabatan', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Tujuan</label>
        <div class="col-md-10">
          <?= formInputText('tujuan', stripslashes($rows['tujuan']), 'Tujuan', 'required') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Keperluan</label>
        <div class="col-md-10">
          <?= formInputText('keperluan', stripslashes($rows['keperluan']), 'Keperluan', 'required') ?>
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
<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">

    </div>
    <h3 class="panel-title"><?= $title ?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
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
        <label class="control-label col-md-2">Lampiran</label>
        <div class="col-md-10">
          <?= formInputText('lampiran', '-', 'Lampiran', '') ?>
        </div>
      </div>
      <div class="form-group row">
        <label class="control-label col-md-2">Hal</label>
        <div class="col-md-10">
          <?= formInputText('hal', '', 'Hal', 'required') ?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Keterangan</label>
        <div class="col-md-10">
          <?= formInputText('keterangan', '', 'Keterangan', 'required') ?>
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

      <div class="form-group row after-add-more">
        <label class="control-label col-md-2">Guru/Pegawai</label>
        <div class="col-md-8">
          <select name="pelaksana[]" class="form-control guru" required>
            <option value="">..::Pilih Guru/ Pegawai::..</option>
            <?= opGuru('') ?>
          </select>
        </div>

        <div class="col-md-2">
          <button class="btn btn-success add-more" type="button">
            <i class="glyphicon glyphicon-plus"></i> Tambah
          </button>
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

<div class="copy hide">
  <div class="form-group row">
    <label class="control-label col-md-2">Guru/Pegawai</label>
    <div class="col-md-8">
      <select name="pelaksana[]" class="form-control guru1">
        <option value="">..::Pilih Guru/Pegawai::..</option>
        <?= opGuru('') ?>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-danger remove" type="button"><i class="glyphicon glyphicon-remove"></i> Remove</button>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    // $(".guru").select2({
    //   placeholder: "Pilih Pelaksana"
    // });
    $(".add-more").click(function() {
      var html = $(".copy").html();
      $(".after-add-more").after(html);
      // $(".guru1").select2({
      //   placeholder: "Pilih Pelaksana"
      // });

    });

    // saat tombol remove dklik control group akan dihapus 
    $("body").on("click", ".remove", function() {
      $(this).parents(".form-group").remove();
    });


  });
</script>
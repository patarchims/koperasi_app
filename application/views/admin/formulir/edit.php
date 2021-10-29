<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><?= $subTitle ?></h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active"><?= $subTitle ?></li>
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title"><?= $title ?></h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= base_url($link . 'edit') ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
            <div class="card-body">

              <input type="hidden" name="id" value="<?= $rows['id_fpp'] ?>">

              <div class="form-group">
                <label class="control-label">Nomor FPP</label>
                <?= formInputNumber('no_fpp', $rows['no_fpp'], 'Nomor FPP', 'required') ?>
              </div>

              <div class="form-group">
                <label class="control-label ">Tanggal Permohonan</label>
                <?= formInputDate('tgl_permohonan', $rows['tgl_permohonan'], 'Tanggal Permohonan', '') ?>
              </div>

              <div class="form-group">
                <label class="control-label">Jumlah Permohonan</label>
                <?= formInputNumber('jlh_permohonan', $rows['jlh_permohonan'], 'Jumlah Permohonan', 'required') ?>
              </div>

              <div class="form-group">
                <label class="control-label  ">Anggota</label>
                <select name="id_anggota" class="form-control anggota" required>
                  <option value=""></option>
                  <?= opAnggota($rows['id_anggota']) ?>
                </select>
              </div>

              <div class="card-footer">
                <button type="submit" id="btnSimpan" name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                <a class="btn btn-danger" href="<?= base_url($link) ?>" type="button">Cancel</a>
              </div>
          </form>
        </div>
        <!-- /.card -->



      </div>
    </div>
  </div>
</section>


<script type="text/javascript">
  $(document).ready(function() {
    $(".anggota").select2({
      placeholder: "Pilih Anggota",
      minimumInputLength: 3
    });
  });
</script>
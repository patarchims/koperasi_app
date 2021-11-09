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




<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <h2 class="text-center display-4">Cari Nomor Pinjaman</h2>
  </div>
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 offset-md-2">


        <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= base_url($link) ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
          <div class="input-group ">
            <select name="no_angsuran" class="form-control form-control-lg anggota" required>
              <option value=""></option>
              <?= opPinjaman('') ?>
            </select>
            <div class="input-group-append">
              <button type="submit" name="cari" class="btn  btn-default">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</section>



<script type="text/javascript">
  $(document).ready(function() {
    $(".anggota").select2({
      placeholder: "Pilih Anggota / No Pinjaman",
      minimumInputLength: 3
    });
  });
</script>
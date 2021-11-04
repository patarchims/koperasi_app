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
          <div class="input-group input-group-lg">
            <input type="search" name="no_angsuran" class="form-control form-control-lg" placeholder="Cari Nomor Angsuran">
            <div class="input-group-append">
              <button type="submit" name="cari" class="btn btn-lg btn-default">
                <i class="fa fa-search"></i>
              </button>
            </div>
          </div>
        </form>


      </div>
    </div>

    <!-- <div class="row mt-3">
      <div class="col-md-10 offset-md-1">
        <div class="list-group">

          <div class="list-group-item">
            <div class="row">
              <div class="col-auto">
                <iframe width="240" height="160" src="https://www.youtube.com/embed/WEkSYw3o5is?controls=0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" class="border-0" allowfullscreen></iframe>
              </div>
              <div class="col px-4">
                <div>
                  <div class="float-right">2021-04-20 11:54pm</div>
                  <h3>Lorem ipsum dolor sit amet</h3>
                  <p class="mb-0">consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div> -->
  </div>
</section>
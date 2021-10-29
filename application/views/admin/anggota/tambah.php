    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= 'Data Anggota' ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= 'Anggota' ?></li>
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
              <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= base_url($link . 'tambah') ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                <div class="card-body">

                  <div class="form-group">
                    <label class="control-label">Nomor Anggota</label>
                    <?= formInputNumber('no_anggota', '', 'Nomor Anggota', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Nama Anggota</label>
                    <?= formInputText('nama_anggota', '', 'Nama Anggota', 'required') ?>
                  </div>



                  <div class="form-group ">
                    <label class="control-label ">Jenis Kelamin</label> <br>
                    <?= opEnumRadio('tb_anggota', 'jenis_kelamin', '') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Tempat Lahir</label>
                    <?= formInputText('tempat_lahir', '', 'Tempat Lahir', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label ">Tanggal Lahir</label>
                    <?= formInputDate('tgl_lahir', '', 'Tanggal Lahir', '') ?>
                  </div>



                  <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <?= formInputText('alamat', '', 'Alamat', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Pekerjaan</label>
                    <?= formInputText('pekerjaan', '', 'Pekerjaan', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Agama</label>
                    <select name="agama" class="form-control" required>
                      <?= opKodeApp('AGAMA', '') ?>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <?= formInputText('email', '', 'Email', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Telp</label>
                    <?= formInputNumber('telp', '', 'Telp', 'required') ?>
                  </div>

                  <div class="form-group">
                    <label class="control-label">No Identitas</label>
                    <?= formInputNumber('no_identitas', '', 'No Identitas', 'required') ?>
                  </div>


                  <div class="form-group">
                    <label class="control-label ">Tanggal Daftar</label>
                    <?= formInputDate('tgl_daftar', '', 'Tanggal Daftar', '') ?>
                  </div>


                  <div class="card-footer">
                    <button type="submit" id="btnSimpan" name="simpan" type="submit" class="btn btn-primary">Simpan</button>
                    <a class="btn btn-danger" href="<?= base_url($link) ?>" type="button">Cancel</a>
                  </div>
              </form>
            </div>
            <!-- /.card -->



          </div>
          <!--/.col (left) -->
          <!-- right column -->

          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
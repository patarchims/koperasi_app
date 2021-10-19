<div class="row">
  <div class="col-md-12">
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">

        </div>
        <h3 class="panel-title">Form Edit <?= $title ?></h3>
      </div>
      <div class="panel-body">
        <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
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
            <label class="control-label col-md-2">Lampiran</label>
            <div class="col-md-10">
              <?= formInputText('lampiran', $rows['lampiran'], 'Lampiran', '') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-md-2">Hal</label>
            <div class="col-md-10">
              <?= formInputText('hal', stripslashes($rows['hal']), 'Hal', 'required') ?>
            </div>
          </div>

          <div class="form-group row">
            <label class="control-label col-md-2">Keterangan</label>
            <div class="col-md-10">
              <?= formInputText('keterangan', stripslashes($rows['keterangan']), 'Keterangan', 'required') ?>
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
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">

          <?= aksiModalTambahId('#modalTambah', $rows['id'], 'Tambah') ?>

        </div>
        <h3 class="panel-title">Daftar Guru/ Pegawai Yang di Ajukan</h3>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="mytable" class="table table-bordered">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th width="1%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach ($record as $row) {
                $no++;
                echo '<tr>
                        <td>' . $no . '</td>
                        <td>' . stripslashes($row['nip']) . '</td>
                        <td>' . stripslashes($row['nama']) . '</td>
                        <td>' . aksiHapusSwal($link . 'pesertahapus', enkrip($row['id'])) . '</td>
              </tr>';
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
      <!-- /.panel-body -->
    </div>
  </div>
</div>


<div class="modal fade" id="modalTambah">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header ">
        <h4 class="modal-title">Form Tambah Guru/ Pegawai Kenaikan Gaji Berkala</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>

      <form class="form-horizontal" action="<?= current_url() ?>" method="POST">
        <input type="hidden" name="id_layanan" value="<?= $rows['id'] ?>">
        <div class="modal-body">
          <div class="form-group row">
            <label for="" class="control-label col-md-3">Pelaksana</label>
            <div class="col-md-9">
              <select name="id_ptk" id="" class="form-control" required>
                <option value="">..::Pilih Guru/ Pegawai::..</option>
                <?= opGajiBerkala($rows['id']) ?>
              </select>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
          <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  $('#mytable').on('click', '.tombol-hapus', function(e) {
    e.preventDefault();
    const href = $(this).attr('href');
    swal({
        title: "Apakah Kamu Yakin?",
        text: "Jika Dihapus Data tidak Bisa dikembalikan Lagi",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: href,
            type: "POST",
            dataType: "JSON",
            success: function(response) {
              if (response['hasil'] == 'sukses') {
                swal(response['pesan'], {
                  icon: "success",
                });
              } else {
                swal(response['pesan'], {
                  icon: "error",
                });
              }
              location.reload();
            }
          });
        }
      });

  });
</script>
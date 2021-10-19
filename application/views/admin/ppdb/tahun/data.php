<div class="row">
  <!-- begin col-8 -->
  <div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <div class="panel-heading-btn">
          <?php
          if (bisaTulis($link, $id_level)) {
            echo aksiModalTambah('#modalTambah', 'Tambah');
          }
          ?>
        </div>
        <h4 class="panel-title"><?= $title ?></h4>
      </div>
      <div class="panel-body">
        <div class="table-responsive">
          <table id="data-table" class="table table-striped table-bordered width-full table-th-valign-middle">
            <thead class="text-center">
              <tr>
                <th width="1%" rowspan="2">Tahun</th>
                <th rowspan="2">Nama Tahun</th>
                <th colspan="2">Tanggal Pendaftaran</th>
                <th rowspan="2">Tanggal Pengumuman</th>
                <th colspan="2">Tanggal Registrasi</th>
                <th rowspan="2">Biaya Daftar</th>
                <th rowspan="2">Keterangan</th>
                <th rowspan="2" width="1%">Aksi</th>
              </tr>
              <tr>
                <th>Awal</th>
                <th>Akhir</th>
                <th>Awal</th>
                <th>Akhir</th>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach ($record as $row) {
                echo '<tr>
                            <td>' . $row['tahun'] . '</td>
                            <td>' . stripslashes($row['nama_tahun']) . '</td>
                            <td>' . tgl_view($row['tgl_awal_daftar']) . '</td>
                            <td>' . tgl_view($row['tgl_akhir_daftar']) . '</td>
                            <td>' . tgl_view($row['tgl_pengumuman']) . '</td>
                            <td>' . tgl_view($row['tgl_awal_registrasi']) . '</td>
                            <td>' . tgl_view($row['tgl_akhir_registrasi']) . '</td>
                            <td>' . rupiah($row['biaya_daftar']) . '</td>
                            <td>' . aksiModalLihat('#modalLihat', $row['id'], 'Lihat') . '</td>
                            <td class="with-btn" nowrap>';
                if (bisaUbah($link, $id_level)) {
                  echo aksiModalEdit('#modalEdit', $row['id']);
                }
                echo '&nbsp;';
                if (bisaHapus($link, $id_level)) {
                  echo aksiHapusSwal($link . 'hapus', enkrip($row['id']), '');
                }
                echo '</td>
                         
                      </tr>';
              }
              ?>

            </tbody>

          </table>
        </div>
      </div>
    </div>
    <!-- end panel -->
  </div>
  <!-- end col-8 -->
</div>
<!-- end row -->

<div class="modal fade" id="modalTambah">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Form Tambah Tahun Penerimaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" enctype="multipart/form-data" method="POST">

        <div class="modal-body">

          <div class="form-group row">
            <label class="control-label col-sm-3">Tahun</label>
            <div class="col-sm-9">
              <input type="year" class="form-control" name="tahun" value="<?= date('Y') ?>" placeholder="Tahun Penerimaan" required>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Nama Tahun</label>
            <div class="col-sm-9">
              <?= formInputText('nama_tahun', '', 'Nama Tahun Penerimaan', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Tanggal Awal Pendaftaran</label>
            <div class="col-sm-9">
              <?= formInputDate('tgl_awal_daftar', '', 'Tanggal Awal Pendaftaran', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Tanggal Akhir Pendaftaran</label>
            <div class="col-sm-9">
              <?= formInputDate('tgl_akhir_daftar', '', 'Tanggal Akhir Pendaftaran', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Tanggal Pengumuman Kelulusan</label>
            <div class="col-sm-4">
              <?= formInputDate('tgl_pengumuman', '', 'Tanggal Pengumuman', 'required') ?>
            </div>
            <label class="control-label col-sm-2">Waktu</label>
            <div class="col-sm-3">
              <?= formInputTime('waktu_pengumuman', '', 'Jam Pengumuman', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Tanggal Awal Registrasi Ulang</label>
            <div class="col-sm-9">
              <?= formInputDate('tgl_awal_registrasi', '', 'Tanggal Awal Registrasi Ulang', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Tanggal Akhir Registrasi Ulang</label>
            <div class="col-sm-9">
              <?= formInputDate('tgl_akhir_registrasi', '', 'Tanggal Akhir Registrasi Ulang', 'required') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Biaya Pendaftaran</label>
            <div class="col-sm-9">
              <?= formInputNumber('biaya_daftar', '', 'Biaya Pendaftaran', '') ?>
            </div>
          </div>
          <div class="form-group row">
            <label class="control-label col-sm-3">Keterangan</label>
            <div class="col-sm-9">
              <?= formInputTextarea('keterangan', '', 'form-control', 'Keterangan', '3') ?>
            </div>
          </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" name="tambah" id="btnSimpan" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modalEdit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Form Edit Tahun Penerimaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" enctype="multipart/form-data" method="POST">

        <div class="modal-body">
          <div class="fetched-data"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" name="edit" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="modalLihat">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Keterangan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="fetch-data"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
      </div>

    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>



<script type="text/javascript">
  $('#data-table').on('click', '.tombol-hapus', function(e) {
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
  $(document).ready(function() {
    $('#modalEdit').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url($link . 'edit') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetched-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });
    $('#modalLihat').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url($link . 'keterangan') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetch-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });
  });
</script>
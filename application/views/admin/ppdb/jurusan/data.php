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
          <table id="data-table" class="table table-striped table-bordered width-full">
            <thead>
              <tr>
                <th width="1%">No</th>
                <th>Jurusan</th>
                <th>Aktif</th>
                <th width="1%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($record as $row) {
                echo '<tr>
                            <td>' . $no . '</td>
                            <td>' . $row['jurusan'] . '</td>
                            <td>' . aksiAktif($link . 'aktif', enkrip($row['id_jurusan']), $row['status']) . '</td>
                            <td class="with-btn" nowrap>';
                if (bisaUbah($link, $id_level)) {
                  echo aksiModalEdit('#modalEdit', $row['id_jurusan']);
                }
                echo '&nbsp;';
                if (bisaHapus($link, $id_level)) {
                  echo aksiHapusSwal($link . 'hapus', enkrip($row['id_jurusan']), '');
                }
                echo '</td>
                         
                      </tr>';
                $no++;
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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Form Tambah Jurusan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form class="form-horizontal" action="<?= current_url() ?>" enctype="multipart/form-data" method="POST">

        <div class="modal-body">

          <div class="form-group row">
            <label class="control-label col-sm-3">Nama Jurusan</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" name="jurusan" value="" placeholder="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
          <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="modalEdit">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Form Edit Jurusan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <form class="form-horizontal" action="<?= current_url() ?>" enctype="multipart/form-data" method="POST">

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
  });
</script>
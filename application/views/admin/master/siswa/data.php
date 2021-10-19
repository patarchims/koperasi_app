<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      <?php
      if (bisaTulis($link, $id_level)) {
        echo aksiSync($link . 'sync', '', 'Sinkronisasi');
      }
      ?>
    </div>
    <h3 class="panel-title"><?= $title ?></h3>
  </div>
  <div class="panel-body">
    <form class="form-inline m-b-20" action="<?= base_url($link) ?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label class="control-label m-r-20">Tahun Masuk</label>
        <select name="tahun_masuk" class="form-control" onchange="submit()">
          <option value="">..::Semua Tahun Masuk</option>
          <?= opTahunMasuk($tahun_masuk) ?>
        </select>
      </div>
    </form>
    <div class="table-responsive">
      <table id="mytable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>Jenis Kelamin</th>
            <th>Nama Ayah</th>
            <th>HP Ayah</th>
            <th>Alamat</th>
            <th>Aksi</th>
            <th>Paswd</th>
          </tr>
        </thead>
        <tbody>


        </tbody>
      </table>
    </div>
  </div>
  <!-- /.panel-body -->
</div>

<div class="modal fade" id="modalPassword">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header ">
        <h4 class="modal-title">Form Edit Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

      </div>

      <div class="modal-body">
        <form class="form-horizontal" id="update_form" method="POST">
          <div class="fetch-data"></div>
        </form>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>

      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="modalEdit">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header ">
        <h4 class="modal-title">Form Edit Siswa</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

      </div>


      <div class="modal-body">
        <form class="form-horizontal" id="siswa_form" method="POST">
          <div class="fetched-data"></div>
        </form>
      </div>
      <div class="modal-footer">
        <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>

      </div>

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
              table.ajax.reload(null, false);
            }
          });
        }
      });

  });
  $(document).ready(function() {

    table = $('#mytable').DataTable({

      "processing": true,
      "serverSide": true,
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('master/get_siswa') ?>",
        "type": "POST"
      },


      "columnDefs": [{
          "targets": [0, 7, 8],
          "orderable": false,
        },
        {
          "targets": [0, 7],
          "className": "text-nowrap",
        },
      ],

    });

    $('#modalPassword').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url('master/siswapassword') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetch-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });

    $('#modalEdit').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url('master/siswaedit') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetched-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });

    $('#update_form').on("submit", function(event) {
      event.preventDefault();

      $.ajax({
        url: "<?= base_url('master/siswasimpan') ?>",
        type: "POST",
        data: $('#update_form').serialize(),

        beforeSend: function() {
          $('#insert').val("Updating....");
        },
        success: function(data) {
          $('#modalPassword').modal('hide');
          table.ajax.reload(null, false);
          swal(data['pesan'], {
            icon: data['hasil'],
          });
        }
      });

    });

    $('#siswa_form').on("submit", function(event) {
      event.preventDefault();

      $.ajax({
        url: "<?= base_url('master/siswaeditsimpan') ?>",
        type: "POST",
        data: $('#siswa_form').serialize(),
        dataType: "JSON",
        beforeSend: function() {
          $('#insert').val("Updating....");
        },
        success: function(data) {
          $('#modalEdit').modal('hide');
          swal(data['pesan'], {
            icon: data['hasil'],
          });
          table.ajax.reload(null, false);
        }
      });

    });

  });
</script>
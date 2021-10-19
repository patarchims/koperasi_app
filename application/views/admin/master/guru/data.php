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
        <label class="control-label m-r-20">Jenis PTK</label>
        <select name="jenis" class="form-control" onchange="submit()">
          <option value="">..::Semua::..</option>
          <?= opJenisPtk($jenis) ?>
        </select>
      </div>
    </form>
    <div class="table-responsive">
      <table id="mytable" class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIP</th>
            <th>Jenis Kelamin</th>
            <th>HP</th>
            <th>Email</th>
            <th>Status</th>
            <th>Jabatan</th>
            <th>Jenis</th>
            <th>Aksi</th>
            <th>Psswd</th>
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
        <h4 class="modal-title">Form Edit Jabatan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

      </div>


      <div class="modal-body">
        <form class="form-horizontal" id="jabatan_form" method="POST">
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
        "url": "<?php echo base_url('master/get_guru') ?>",
        "type": "POST"
      },


      "columnDefs": [{
          "targets": [0, 9, 10],
          "orderable": false,
        },
        {
          "targets": [9],
          "className": 'text-nowrap',
        }
      ],

    });

    $('#modalPassword').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url('master/gurupassword') ?>',
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
        url: '<?= base_url('master/guruedit') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetched-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });

    $('#update_form').on("submit", function(event) {
      event.preventDefault();

      $.ajax({
        url: "<?= base_url('master/gurusimpan') ?>",
        type: "POST",
        data: $('#update_form').serialize(),
        dataType: "JSON",
        beforeSend: function() {
          $('#insert').val("Updating....");
        },
        success: function(data) {
          $('#modalPassword').modal('hide');
          swal(data['pesan'], {
            icon: data['hasil'],
          });
          table.ajax.reload(null, false);
        }
      });

    });

    $('#jabatan_form').on("submit", function(event) {
      event.preventDefault();

      $.ajax({
        url: "<?= base_url('master/gurujabatan') ?>",
        type: "POST",
        data: $('#jabatan_form').serialize(),
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
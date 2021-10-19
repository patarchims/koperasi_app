<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      <?php
      echo aksiExport('export/pendaftar', $tahun, 'Export Excel');
      echo aksiCetak($link . 'cetak', $tahun, 'Cetak');
      if (bisaTulis($link, $id_level)) {
        echo aksiTambah($link . 'tambah', 'Tambah Peserta');
      }

      ?>
    </div>
    <h3 class="panel-title"><?= $title ?></h3>
  </div>
  <div class="panel-body">
    <form class="form-inline m-b-20" action="<?= current_url() ?>" method="post" accept-charset="utf-8">
      <div class="form-group">
        <label class="control-label m-r-20">Tahun Penerimaan</label>
        <select name="tahun" class="form-control" onchange="submit()">
          <?= opTahun($tahun) ?>
        </select>
      </div>
    </form>
    <div class="table-responsive">
      <table id="mytable" class="table table-striped table-bordered width-full">
        <thead>
          <tr>
            <th width="1%">No</th>
            <th>Cara Daftar</th>
            <th>Nama</th>
            <th>Tgl. Lahir</th>
            <th>J. Kelamin</th>
            <th>HP</th>
            <th>Email</th>
            <th>Bukti Bayar</th>
            <th>Status Bayar</th>
            <th width="1%">Aksi</th>
            <th width="1%">Pswd</th>
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



<script>
  $('#mytable').on('click', '.tombol-valid', function(e) {
    e.preventDefault();
    const href = $(this).attr('href');
    swal({
        title: "Apakah Kamu Yakin?",
        text: "Akan Memvalidasi data ini?",
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
              swal(response['pesan'], {
                icon: response['hasil'],
              });

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
        "url": "<?php echo base_url($link . 'get') ?>",
        "type": "POST"
      },


      "columnDefs": [{
        "targets": [0, 8, 9],
        "orderable": false,
        "className": "text-nowrap"
      }],

    });

    $('#modalPassword').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      //menggunakan fungsi ajax untuk pengambilan data
      $.ajax({
        type: 'POST',
        url: '<?= base_url($link . 'password') ?>',
        data: 'rowid=' + rowid,
        success: function(data) {
          $('.fetch-data').html(data); //menampilkan data ke dalam modal
        }
      });
    });



    $('#update_form').on("submit", function(event) {
      event.preventDefault();

      $.ajax({
        url: "<?= base_url($link . 'simpan') ?>",
        type: "POST",
        data: $('#update_form').serialize(),
        dataType: "JSON",
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


  });
</script>
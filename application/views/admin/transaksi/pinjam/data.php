    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <!-- <h3 class="card-title"><?= $title ?></h3> -->
                <?php
                if (bisaTulis($link, $id_level)) {
                  echo aksiTambah($link . 'tambah', 'Tambah');
                }
                ?>
              </div>

              <!-- /.card-header -->
              <div class="card-body">
                <table id="mytable" class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nomor Pinjaman</th>
                      <th>Nomor Anggota</th>
                      <th>Jumlah Pinjaman</th>
                      <th>Nama Anggota</th>
                      <th>Angsuran</th>
                      <th>Agunan</th>
                      <th>Status</th>
                      <!-- <th>Aksi</th> -->
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>



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
            "url": "<?php echo base_url('transaksi/get_pinjaman') ?>",
            "type": "POST"
          },


          "columnDefs": [{
              "targets": [0, 1, 6],
              "orderable": false,
            },
            {
              "targets": [6],
              "className": 'text-nowrap',
            }
          ],

        });


      });
    </script>




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
    </script>
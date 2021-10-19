<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      <?php
      if(bisaTulis($link,$id_level))
      {
        echo aksiTambah($link.'tambah','Tambah');
      }
      ?>
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
   <div class="table-responsive">
      <table id="mytable" class="table table-striped table-bordered">
       <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Jenis Kerjasama</th>
          <th>Bidang Kerjasama</th>
          <th>Rekanan</th>
          <th>Tanggal Kerjasama</th>
          <th>Isi</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
     
        
      </tbody>
    </table>
  </div>
  </div>
  <!-- /.panel-body -->
</div>

<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <div class="modal-content ">
            <div class="modal-header ">
              <h4 class="modal-title">Anda Yakin?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                
            </div>
            
            
            <div class="modal-body">
                <form class="form-horizontal" id="update_form" method="POST">
                <div class="fetched-data"></div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
                
            </div>
          
        </div>
    </div>
</div>

<div class="modal fade" id="modalLihat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header ">
              <h4 class="modal-title">Detail Isi Kerjasama</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="fetched-data"></div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
                
            </div>
          
        </div>
    </div>
</div>

<script>

  $('#mytable').on('click', '.tombol-aktif', function(e)
    {
            e.preventDefault();
            const href = $(this).attr('href');
            swal({
            title: "Apakah Kamu Yakin?",
            text: "",
            icon: "warning",
            buttons: true,
            dangerMode: false,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({  
                     url: href,  
                     type:"POST",    
                     success:function(data){  
                          swal("Berhasil", {
                            icon: "success",
                          });  
                          table.ajax.reload( null, false );
                     }  
                });  
            } 
          });
           
    });

  $('#mytable').on('click', '.tombol-hapus', function(e)
    {
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
                     type:"POST",   
                     dataType:"JSON", 
                     success:function(response){ 
                     if(response['hasil']=='sukses')
                      { 
                        swal(response['pesan'], {
                          icon: "success",
                        });  
                      }
                      else
                      {
                        swal(response['pesan'], {
                          icon: "error",
                        });
                      }
                      table.ajax.reload( null, false );
                     }  
                });  
            } 
          });
           
    });
  $(document).ready(function(){
       
    table = $('#mytable').DataTable({ 
 
            "processing": true, 
            "serverSide": true, 
            "order": [], 
             
            "ajax": {
                "url": "<?php echo base_url('website/get_kerjasama')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
              { 
                  "targets": [ 0,7 ], 
                  "orderable": false, 
              },
              {
                  "targets": [ 7 ],
                  "className": 'text-nowrap',
              }
            ],
 
        });

      $('#modalLihat').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'POST',
                url : '<?=base_url('website/kerjasamadetail')?>',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });


  });


  

</script>
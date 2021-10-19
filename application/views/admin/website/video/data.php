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
          <th>Cover</th>
          <th>Jumlah Video</th>
          <th>Status</th>
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
                "url": "<?php echo base_url('website/get_albumvideo')?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
              { 
                  "targets": [ 0,1,5 ], 
                  "orderable": false, 
              },
              {
                  "targets": [ 5 ],
                  "className": 'text-nowrap',
              }
            ],
 
        });


  });


  

</script>
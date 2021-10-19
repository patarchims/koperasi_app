<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      <?php
      echo aksiKembali($link);
      if(bisaTulis($link,$id_level))
      {
        echo aksiModalTambah('#modalTambah','Tambah');
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
          <th>Gambar</th>
          <th>Video</th>
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

<div class="modal fade" id="modalTambah">
  <div class="modal-dialog modal-md">
      <div class="modal-content">
          <div class="modal-header">
              
              <h4 class="modal-title">Form Tambah Video</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
          </div>
          <form class="form-horizontal" action="<?=base_url($post)?>" enctype="multipart/form-data" method="POST">
          <input type="hidden" name="id_album" value="<?=$id_album?>">
          <div class="modal-body">
           
            <div class="form-group row">
                <label class="control-label col-sm-3">Judul Video</label>
                <div class="col-sm-9">
                <?=formInputText('judul','','Judul Video','required')?>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-sm-3">Link Video (Youtube)</label>
                <div class="col-sm-9">
                <?=formInputUrl('link','','Link Youtube','required')?>
                </div>
              </div>
              <div class="form-group row">
                <label class="control-label col-sm-3">Foto</label>
                <div class="col-sm-9">
                <?=formInputGambar('gambar','required')?>
                </div>
              </div>
              
              
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
              <input type="submit" name="tambah" id="simpan" value="Simpan" class="btn btn-success">
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
              
              <h4 class="modal-title">Form Edit Video</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
          </div>
          <form class="form-horizontal" action="<?=base_url($post)?>" enctype="multipart/form-data" method="POST">
          <div class="modal-body">
            <div class="fetched-data">
                
              </div>  
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
              <input type="submit" name="edit" id="simpan" value="Simpan" class="btn btn-success">
          </div>
        </form>
      </div>
      <!-- /.modal-content -->
  </div>
<!-- /.modal-dialog -->
</div>


<script>



  

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
                "url": "<?php echo base_url('website/get_video/'.$id_album)?>",
                "type": "POST"
            },
 
             
            "columnDefs": [
              { 
                  "targets": [ 0,2,3 ], 
                  "orderable": false, 
              },
              {
                  "targets": [ 3 ],
                  "className": 'text-nowrap',
              }
            ],
 
        });

    $('#modalEdit').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'POST',
                url : '<?=base_url('website/videoedit')?>',
                data :  'rowid='+ rowid,
                success : function(data){
                $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
         });

  });


  

</script>
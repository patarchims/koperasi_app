<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    
   <div class="table-responsive">
      <table id="data-table" class="table table-striped table-bordered">
       <thead>
        <tr>
          <th>No</th>
          <th>Judul</th>
          <th>Tanggal Mulai</th>
          <th>Tanggal Akhir</th>
          <th>Keterangan</th>
          <th>Jumlah File</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
          $no=0;
          $now=date('Y-m-d');
          foreach ($hasil as $row) {
            $no++;
            $aksi='';
            
            if($row->tgl_mulai<=$now AND $row->tgl_selesai >= $now)
            {
              $aksi=aksiTambah($link.'tambah/'.enkrip($row->id),'Isi Data');
            }

            $berkas=api('api/permintaanjlhfile',array("npsn"=>$identitas['kode'],"uid"=>$identitas['uid'],"id_permintaan"=>$row->id));
            $jlh=$berkas->hasil;
            if($jlh>0)
            {
              $lihat=aksiDetail($link.'detail',enkrip($row->id),$jlh);
            }
            else
            {
              $lihat=$jlh;
            }
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.stripcslashes($row->judul).'</td>
                    <td>'.tgl_view($row->tgl_mulai).'</td>
                    <td>'.tgl_view($row->tgl_selesai).'</td>
                    <td>'.aksiModalLihat('#modalLihat',$row->keterangan,'Lihat').'</td>
                    <td nowrap>'.$lihat.'</td>
                    <td>'.$aksi.'</td>
                  </tr>';
          }
      ?>
        
      </tbody>
    </table>
  </div>
  </div>
  <!-- /.panel-body -->
</div>

<div class="modal fade" id="modalLihat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header ">
              <h4 class="modal-title">Keterangan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                
            </div>
            
            
            <div class="modal-body">
                
                <div class="fetch-data"></div>
             
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
                
            </div>
          
        </div>
    </div>
</div>


<script>
  
  $(document).ready(function(){

      $('#modalLihat').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $('.fetch-data').html(rowid);
            //menggunakan fungsi ajax untuk pengambilan data
            
         });

  });

 
  

</script>
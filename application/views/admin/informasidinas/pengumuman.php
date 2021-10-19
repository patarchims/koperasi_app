<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body bg-grey-transparent-1">
    <form action="<?=base_url($link)?>" method="post" accept-charset="utf-8">
        <div class="input-group input-group-lg m-b-20">
            <input type="text" name="cari" class="form-control input-lg input-white" value="<?=$cari?>" placeholder="Cari Pengumuman" />
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-search fa-fw"></i> Search</button>
                
            </div>
        </div>
    </form>
   <div class="table-responsive bg-white">
      <table class="table table-striped table-bordered">
       <thead class="bg-info">
          <tr>
            <th width="1%">No</th>
            <th>Tanggal</th>
            <th>Judul</th>
            <th>Keterangan</th>
            <th width="1%">Lampiran</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no=0;
          foreach ($record as $row) {
            $no++;
            if($row->gambar!='')
            {
              $lampiran=aksiDownloadFile($row->gambar,'Download');
            }
            else
            {
              $lampiran='Tidak Ada';
            }
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.tgl_indo($row->tanggal).'</td>
                    <td>'.stripcslashes($row->judul).'</td>
                    <td>'.aksiModalLihat('#modalLihat',$row->isi,'Lihat').'</td>
                    <td nowrap>'.$lampiran.'</td>
            </tr>';
          }
          ?>
        </tbody>
    </table>
    </div>
    <div class="clearfix m-t-20">
        <ul class="pagination pull-right">
          <?php echo $this->pagination->create_links(); ?>
        </ul>
    </div>
  </div>
  <!-- /.panel-body -->
</div>

<div class="modal fade" id="modalLihat">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">
            <div class="modal-header ">
              <h4 class="modal-title">Keterangan Pengumuman</h4>
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
  $(document).ready(function(){
    $('#modalLihat').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $('.fetched-data').html(rowid);
         });

    


  });


  

</script>
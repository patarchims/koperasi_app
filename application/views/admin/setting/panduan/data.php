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
          <th width="1%">No</th>
          <th>Judul</th>
          <th>Menu</th>
          <th width="1%">Video</th>
          <th width="1%">Manual Book</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no=0;
        foreach ($record as $row) {
           $no++;
           $video='Tidak Ada Video';
            if($row->video!='')
            {
              $video=lihatVideo($row->video,'Putar');
            }

            $berkas='Tidak Ada File';
            if($row->gambar!='')
            {
              $berkas=aksiDownloadFile($row->gambar,'Lihat');
            }
           echo'<tr>
                  <td nowrap>'.$no.'</td>
                  <td>'.stripslashes($row->judul).'</td>
                  <td>'.stripslashes($row->menu).'</td>
                  <td nowrap>'.$video.'</td>
                  <td nowrap>'.$berkas.'</td>
                </tr>';
         } 
         ?>
        
      </tbody>
    </table>
  </div>
  </div>
  <!-- /.panel-body -->
</div>


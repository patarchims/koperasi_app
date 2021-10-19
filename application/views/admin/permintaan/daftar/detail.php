<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      <?php
      $now=date('Y-m-d');
      echo aksiKembali($link);
      if($rows->tgl_mulai<=$now AND $rows->tgl_selesai>=$now)
        {
          echo aksiTambah($link.'tambah/'.enkrip($rows->id));
        }
      ?>
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
   <div class="table-responsive">
      <h4><?=stripcslashes($rows->judul)?></h4>
      <table id="data-table" class="table table-striped table-bordered">
       <thead>
        <tr>
          <th width="1%">No</th>
          <th>Judul</th>
          <th>Keterangan</th>
          <th width="1%">File</th>
          <th width="1%">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $no=0;
      
      foreach ($record as $row) {
        $no++;
        if($rows->tgl_mulai<=$now AND $rows->tgl_selesai>=$now)
        {
          $aksi=aksiHapus($link.'hapus',enkrip($row->id_permintaan).'/'.enkrip($row->id));
        }
        else
        {
          $aksi='';
        }
        echo '<tr>
              <td>'.$no.'</td>
              <td>'.stripcslashes($row->judul).'</td>
              <td>'.$row->keterangan.'</td>
              <td nowrap>'.aksiDownloadFile($row->gambar,'Download').'</td>
              <td nowrap>'.$aksi.'</td>
            </tr>';
      }
      ?>
        
      </tbody>
    </table>
  </div>
  </div>
  <!-- /.panel-body -->
</div>


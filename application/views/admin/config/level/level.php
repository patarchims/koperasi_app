<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
     
        <?=aksiTambah($link.'tambah','tambah')?>
     
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <div class="table-responsive">
        <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
         
         <thead>
          <tr>
            <th>No</th>
            <th>Level</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no=0;
            foreach ($record as $row) {
            $no++;
            echo'<tr>
                  <td>'.$no.'</td>
                  <td>'.$row['nama_level'].'</td>
                  <td>'.aksiEdit($link.'edit',enkrip($row['id_level'])).' &nbsp; '.aksiHapus($link.'hapus',enkrip($row['id_level'])).'</td>
                </tr>';


            }
          ?>
        </tbody>
             
      </table>
    </div>
  </div>
  <!-- /.panel-body -->
</div>
<!-- begin breadcrumb -->
      

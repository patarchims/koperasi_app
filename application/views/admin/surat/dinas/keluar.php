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
  <div class="panel-body bg-grey-transparent-1">
    <form action="<?=base_url($link)?>" method="post" accept-charset="utf-8">
        <div class="input-group input-group-lg m-b-20">
            <input type="text" name="cari" class="form-control input-lg input-white" value="<?=$cari?>" placeholder="Cari Surat Keluar (Berdasarkan Perihal atau Nomor Surat)" />
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
            <th>Jenis Surat</th>
            <th>Nomor Surat</th>
            <th>Tanggal Surat</th>
            <th>Perihal</th>
            <th width="1%">Dibaca</th>
            <th width="1%">Terakhir Baca</th>
            <th width="1%">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no=0;
          foreach ($record as $row) {
            $no++;
            echo '<tr>
                    <td>'.$no.'</td>
                    <td>'.stripcslashes($row->nama_jenis).'</td>
                    <td>'.stripcslashes($row->no_surat).'</td>
                    <td>'.tgl_indo($row->tgl_surat).'</td>
                    <td>'.stripcslashes($row->isi_ringkas).'</td>
                    <td>'.$row->dibaca.'</td>
                    <td>'.$row->user_baca.'</td>
                    <td nowrap>';
                    echo aksiDownloadFile($row->gambar,'');
                    if(bisaHapus($link,$id_level))
                      {
                        echo '&nbsp;';
                        echo aksiHapus($link.'hapus',enkrip($row->id_surat));
                      }
                    echo'</td>
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




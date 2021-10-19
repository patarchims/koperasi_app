<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body bg-grey-transparent-1">
    <form action="<?=base_url($link)?>" method="post" accept-charset="utf-8">
        <div class="input-group input-group-lg m-b-20">
            <input type="text" name="cari" class="form-control input-lg input-white" value="<?=$cari?>" placeholder="Cari Download" />
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
            <th>Judul</th>
            <th width="1%">Didownload</th>
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
                    <td>'.stripcslashes($row->judul).'</td>
                    <td>'.$row->dibaca.'</td>
                    <td nowrap>'.aksiDownload('informasidinas/downloadfile',enkrip($row->id_download),'Download').'</td>
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




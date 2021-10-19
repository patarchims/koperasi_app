
<!-- begin row -->
<div class="row">
    <!-- begin col-8 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <?=aksiTambah($link.'tambah','tambah')?>
                </div>
                <h4 class="panel-title"><?=$title?></h4>
            </div>
            <div class="panel-body">
              <form class="form-inline mb-2" action="<?=base_url($link)?>" method="post" accept-charset="utf-8">
                <input type="hidden" name="cari" value="">
                <div class="form-group">
                  <label class="control-label mr-2">Modul</label>
                  <select name="modul" class="form-control" onchange="submit()">
                    <?=opModul($modul)?>
                  </select>
                  
                </div>
              </form>  
                                      
              <div class="table-responsive">
                  <table id="data-table" class="table table-striped table-bordered nowrap" width="100%">
                   
                   <thead>
                    <tr>
                      <th>No</th>
                      <th>Modul</th>
                      <th>Nama Menu</th>
                      <th>Link</th>
                      <th>Urutan</th>
                      
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
                          <td>'.viewModul($row['id_modul']).'</td>
                          <td>'.$row['nama_menu'].'</td>
                          <td>'.$row['link'].'</td>
                          <td>'.$row['urutan'].'</td>
                          <td class="with-btn">'.aksiEdit('config/menuedit',enkrip($row['id_menu'])).'&nbsp;'.aksiHapus('config/menuhapus',enkrip($row['id_menu'])).'</td>
                        </tr>';

                    
                        }
                      ?>
                    </tbody>
                                 
                  </table>
              </div>
            </div>
        </div>
        <!-- end panel -->
    </div>
    <!-- end col-8 -->
</div>
<!-- end row -->



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
            
              <div class="table-responsive">
                  <table id="data-table" class="table table-striped table-bordered width-full">
                      <thead>
                        <tr>
                          <th width="1%">No</th>
                          <th>Nama Modul</th>
                          <th>Controller</th>
                          <th>Urutan</th>
                          
                          <th width="1%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                          $no=0;
                          foreach ($record as $row) {
                          $no++;
                          echo'<tr>
                            <td>'.$no.'</td>
                            <td>'.$row['nama_modul'].'</td>
                            <td>'.$row['controller'].'</td>
                            <td>'.$row['urutan'].'</td>
                            <td class="with-btn" nowrap>'.aksiEdit('config/moduledit',enkrip($row['id_modul'])).'&nbsp;'.aksiHapus('config/modulhapus',enkrip($row['id_modul'])).'</td>
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


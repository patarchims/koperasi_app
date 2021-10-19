
<div class="row">

<!-- begin col-8 -->
<div class="col-md-12">
    <!-- begin panel -->
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="panel-heading-btn">
                <?php
                  if(bisaTulis($link,$id_level))
                  {
                  echo'<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus"></i> Tambah</button>';
                  } 
                  ?>
            </div>
            <h4 class="panel-title"><?=$title?></h4>
        </div>
        <div class="panel-body">
          
       
        <div class="table-responsive">
            <table id="data-table" class="table table-striped table-bordered width-full">
             <thead>
              <tr>
                
                 
                  <th>No</th>
                  <th>Kode Aplikasi</th>
                  <th>Keterangan</th>
                  <th width="1%">Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $no = 1;
                foreach ($record->result_array() as $row){
                

                echo '<tr><td>'.$no.'</td>
                          <td>'.$row['idxref'].'</td>
                          <td>'.$row['referensi'].'</td>
                          <td>'.aksiDetail('referensi/kodedetail',$row['idxref']).'</td>
                         
                      </tr>';
                  $no++;

                 


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

<div class="modal fade" id="modalTambah">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
               <h4 class="modal-title">Form Tambah Kode Aplikasi </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
               
            </div>
            <form class="form-horizontal" action="<?=base_url($link)?>" enctype="multipart/form-data" method="POST">
            
            <div class="modal-body">
              
              <div class="form-group row">
                  <label class="control-label col-sm-3">Kode Aplikasi</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="kd" value="" placeholder="" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="control-label col-sm-3">Keterangan</label>
                  <div class="col-sm-9">
                  <input type="text" class="form-control" name="ket" value="" placeholder="" required>
                  </div>
                </div>
                
              
              
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
                <button type="submit" name="submit" class="btn btn-success">Simpan</button>
            </div>
          </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>  <!-- /.modal-dialog -->

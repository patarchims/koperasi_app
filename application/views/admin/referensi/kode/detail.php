 <div class="row">
                    
                    <!-- begin col-8 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                <div class="panel-heading-btn">
                                    <?php
                                    echo aksiKembali('referensi/kode');
                                    if(bisaTulis($link,$id_level)==1)
                                    {
                                    echo'<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#modalTambah"><i class="fa fa-plus"></i> Tambah</button>';
                                    } 
                                    ?>
                                </div>
                                <h4 class="panel-title">Detail <?=$title?> <?=viewAplikasi($aplikasi)?></h4>
                            </div>
                            <div class="panel-body">
                              
                           
                            <div class="table-responsive">
                                <table id="data-table" class="table table-striped table-bordered width-full">
                                 <thead>
                                  <tr>
                                    
                                     
                                      <th width="1%">No</th>
                                      <th>Kode</th>
                                      <th>Nama Ref 1</th>
                                      <th>Nama Ref 2</th>
                                      <th>Nama Ref 3</th>
                                      <th>Kode Dikti</th>
                                      <th>Status</th>
                                      <th width="1%">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php 
                                    $no = 1;
                    foreach ($record as $row){
                    if($row['stsrek']=='Tidak')
                        {
                          $stsrek='<label class="switcher-control switcher-control-success"><input type="checkbox" id="stsrek_'.$row['id'].'_Aktif"  name="onoffswitch"  class="stsrek  switcher-input">
                          <span class="switcher-indicator"></span>
                          </label>';
                        }
                        else
                        {
                          $stsrek='<label class="switcher-control switcher-control-success"><input type="checkbox" id="stsrek_'.$row['id'].'_Tidak" name="onoffswitch"  class="stsrek  switcher-input" checked>
                          <span class="switcher-indicator"></span></label>';
                        }

                    echo '<tr><td>'.$no.'</td>
                              <td>'.$row['kderef'].'</td>
                              <td>'.$row['nmaref1'].'</td>
                              <td>'.$row['nmaref2'].'</td>
                              <td>'.$row['nmaref3'].'</td>
                              <td>'.$row['kdedikti'].'</td>
                              <td>'.$stsrek.'</td>
                              <td class="with-btn" nowrap>';
                              if(bisaUbah($link,$id_level)==1)
                              {
                                echo'<button type="button" class="btn btn-success btn-xs" title="Edit Data" data-toggle="modal" data-target="#modalEdit'.$row['id'].'"><i class="fa fa-edit"></i></button>';
                              }
                              echo '&nbsp;';
                              if(bisaHapus($link,$id_level)==1)
                              {
                                echo aksiHapus('referensi/kodehapus/'.$row['idxref'],enkrip($row['id']));
                              }
                              echo '</td>
                             
                          </tr>';
                      $no++;
                     

                       echo'<div class="modal fade" id="modalEdit'.$row['id'].'">
                        <div class="modal-dialog modal-md">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Form Edit Kode Aplikasi </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                </div>
                                <form class="form-horizontal" action="'.base_url().'referensi/kodedetail" enctype="multipart/form-data" method="POST">
                                <input type="hidden" name="id" value="'.$row['id'].'">
                                <div class="modal-body">
                                  
                                  <input type="hidden" name="kd" value="'.$row['idxref'].'">
                                  <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode Aplikasi</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control"  value="'.$row['idxref'].'" placeholder="" disabled>
                                      </div>
                                    </div>

                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Keterangan</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control" name="ket" value="'.viewAplikasi($aplikasi).'" placeholder="" disabled>
                                      </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control" name="kode" value="'.$row['kderef'].'" placeholder="" >
                                      </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 1</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref1" value="'.$row['nmaref1'].'" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 2</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref2" value="'.$row['nmaref2'].'" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 3</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref3" value="'.$row['nmaref3'].'" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode Dikti</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="kdedikti" value="'.$row['kdedikti'].'" placeholder="" >
                                      </div>
                                    </div>
                                 
                                  
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Tutup</button>
                                    <button type="submit" name="edit" class="btn btn-success">Edit</button>
                                </div>
                              </form>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>';

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
                                <form class="form-horizontal" action="<?=base_url('referensi/kodedetail')?>" enctype="multipart/form-data" method="POST">
                                
                                <div class="modal-body">
                                 
                                  <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode Aplikasi</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control" name="kd" value="<?=$aplikasi?>" placeholder="" readonly>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Keterangan</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control" name="ket" value="<?=viewAplikasi($aplikasi)?>" placeholder="" readonly>
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode</label>
                                      <div class="col-sm-9">
                                      <input type="text" class="form-control" name="kode" value="" placeholder="" >
                                      </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 1</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref1" value="" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 2</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref2" value="" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Nama Ref 3</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="nmaref3" value="" placeholder="" >
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                      <label class="control-label col-sm-3">Kode Dikti</label>
                                      <div class="col-sm-9">
                                      <input type="text"  class="form-control" name="kdedikti" value="" placeholder="" >
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
                    </div>



<script  type="text/javascript">
  $(document).ready(function(){

    $('.stsrek').change(function(){
      var id = this.id;
      var split_id = id.split("_");
      var field_name = split_id[0];
      var edit_id = split_id[1];
      var value = split_id[2];

      // AJAX request
      $.ajax({
        url:'<?=base_url()?>referensi/status',
        method: 'post',
        data: {id: edit_id, value: value, table: 'tbrefb', id_table:'id', status : field_name},
        dataType: 'json',
        success: function(){

       console.log('Save successfully'); 
         
        }
     });
   });

  
 
});
</script>
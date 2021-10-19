<!-- begin row -->
<div class="row">
    
    <!-- begin col-8 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                
                <h4 class="panel-title"><?=$title?></h4>
            </div>
            <div class="panel-body">
               <form class="form-horizontal"  action="<?=base_url('setting/useredit')?>" enctype="multipart/form-data" method="POST">
                <?php
              echo '<input class="form-control" type="hidden" name="id" value="'.$rows['id_user'].'">';
                     echo '<div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Nama Lengkap</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="nama" value="'.$rows['nama'].'" placeholder="Nama User" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="email" name="email" value="'.$rows['email'].'" placeholder="Email User" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">HP</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="hp" value="'.$rows['hp'].'" placeholder="No. HP" >
                          </div>
                      </div>
                      
                     

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="password" placeholder="Biarkan Kosong Jika Tidak Mengganti Password">
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Level</label>
                        <div class="col-sm-10 ">
                            <select class="form-control" id="level" name="level"  required>'.opLevel($rows['level']).'</select>
                          </div>
                      </div>

                      

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Status Aktif</label>
                        <div class="col-sm-10 ">
                          <select class="form-control" name="status"  required>'.opEnum('user','status',$rows['status']).'</select>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-3 ">
                          <input class="form-control" type="file" name="gambar">
                          </div>
                          <label class="col-sm-7 control-label">Kosong Jika Tidak Mengganti Foto</label>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Foto Sebelumnya</label>
                        <div class="col-sm-2 ">';
                        if($rows['gambar']=='')
                         {
                          echo'<p>Belum Ada Foto</p>';
                         }
                         else
                         {
                          echo '<img src="'.base_url().'assets/img/user/'.$rows['gambar'].'" width="100%">';
                         }
                          echo'</div>
                         
                      </div>
                      
                     
                      <div class="form-group row m-b-5">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-10">
                          <button class="btn btn-success" name="submit" type="submit">Simpan</button>
                          <a class="btn btn-danger" href="'.base_url($link).'">Cancel</a>
                        </div>
                      </div>
                    ';
                    ?>
                    </form>
                  </div>
                </div>
                <!-- Panel Widget --> 
              </div>
              <!-- col-md-12 --> 
            </div>
            <!-- row -->


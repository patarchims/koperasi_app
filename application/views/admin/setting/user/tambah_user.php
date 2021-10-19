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
               <form class="form-horizontal"  action="<?=base_url('setting/usertambah')?>" enctype="multipart/form-data" method="POST">
                
              
               <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Nama Lengkap</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="nama" placeholder="Nama User" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="email" name="email" placeholder="Email User" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">HP</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="hp" placeholder="No. HP"  >
                          </div>
                      </div>
                      
                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="username" placeholder="Username" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="text" name="password" placeholder="Password" required>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Level</label>
                        <div class="col-sm-10 ">
                            <select class="form-control" id="level" name="level"  required><?=opLevel($p)?></select>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Status Aktif</label>
                        <div class="col-sm-10 ">
                          <select class="form-control" name="status"  required><?=opEnum('user','status')?></select>
                          </div>
                      </div>

                      <div class="form-group row m-b-5">
                        <label class="col-sm-2 control-label">Foto</label>
                        <div class="col-sm-10 ">
                          <input class="form-control" type="file" name="gambar">
                          </div>
                      </div>
                      
                     
                      <div class="form-group row m-b-5">
                        <div class="col-sm-2"> </div>
                        <div class="col-sm-10">
                          <button class="btn btn-success" name="submit" type="submit"> Simpan</button>
                          <a class="btn btn-danger" href="<?=base_url($link)?>" >Cancel</a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- Panel Widget --> 
              </div>
              <!-- col-md-12 --> 
            </div>
            <!-- row -->
   

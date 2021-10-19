

<!-- begin section-container -->
      <div class="section-container section-with-top-border p-b-5">
          <!-- begin row -->
                <div class="row">
                    
                    <!-- begin col-8 -->
                    <div class="col-md-12">
                        <!-- begin panel -->
                        <div class="panel panel-inverse">
                            <div class="panel-heading">
                                
                                <h4 class="panel-title">Form Ubah Password</h4>
                            </div>
                            <div class="panel-body">
                            <form class="form-horizontal form-group row-sm"  action="<?=base_url()?>dashboard/gantipassword" method="POST">
                             
                          <div class="form-group row">
                  <label class="col-sm-2 control-label ">Password Lama </label>
                  <div class="col-sm-10">
                    <input type="password" name="pass" value="" class="form-control" placeholder="Password Lama" required>
                  </div>
                </div><!-- row -->
                <div class="form-group row">
                  <label class="col-sm-2 control-label ">Password Baru</label>
                  <div class="col-sm-10">
                    <input type="password" name="pass1" value="" placeholder="Password Baru"  class="form-control" required>
                  </div>
                  
                </div><!-- row -->
                 <div class="form-group row">
                  <label class="col-sm-2 control-label ">Konfirmasi Password</label>
                  <div class="col-sm-10">
                    <input type="password" name="pass2" value="" placeholder="Konfirmasi Password Baru"  class="form-control" required>
                  </div>
                  
                </div><!-- row -->
              
                                

                                  <div class="form-group row">
                                    <label class="col-sm-2 control-label ">&nbsp;</label>
                                    <div class="col-sm-10">
                                      
                                      <button type="submit" name="edit" class="btn btn-success">Simpan</button>
                                      <a href="<?=base_url()?>dashboard/profil" class="btn btn-danger">Cancel</a>
                                    </div>
                                  </div><!-- row -->
                      
                            </form>
                          </div>
                            
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end col-8 -->
                </div>    
                <!-- end row -->
      </div>
      <!-- end section-container -->

   

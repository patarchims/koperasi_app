<div class="row">  
    <!-- begin col-8 -->
    <div class="col-md-12">
        <!-- begin panel -->
        <div class="panel panel-inverse">
            <div class="panel-heading">
                
                <h4 class="panel-title">Form Edit Profil</h4>
            </div>
            <div class="panel-body">
            <form class="form-horizontal form-group row-sm"  action="<?=base_url()?>dashboard/editprofil" method="POST">
             
          <div class="form-group row">
            <label class="col-sm-2 control-label ">Nama </label>
            <div class="col-sm-10">
              <input type="text" name="nama" value="<?=$rows['nama']?>" class="form-control" placeholder="Nama" required>
            </div>
          </div><!-- row -->
          <div class="form-group row">
            <label class="col-sm-2 control-label ">Email</label>
            <div class="col-sm-10">
              <input type="email" name="email" value="<?=$rows['email']?>" placeholder="Email"  class="form-control" required>
            </div>
            
          </div><!-- row -->
          <div class="form-group row">
            <label class="col-sm-2 control-label ">HP</label>
            <div class="col-sm-10">
              <input type="tel" name="hp" value="<?=$rows['hp']?>" placeholder="HP"  class="form-control" required>
            </div>
            
          </div><!-- row -->
           <div class="form-group row">
            <label class="col-sm-2 control-label ">Foto (1:1)</label>
            <div class="col-sm-10">
              <input type="file" name="gambar" class="form-control" >
            </div>
          </div><!-- row -->

          <div class="form-group row">
            <label class="col-sm-2 control-label ">Foto Sebelumnya</label>
            <div class="col-sm-10">
              <?php
              if($rows['gambar'] !='')
              {
                  echo'<img src="'.base_url().'assets/img/user/'.$rows['gambar'].'" width="100">';
              }
              else
              {
                echo 'Belum ada Foto';
              }
              ?>
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


   


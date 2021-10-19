<div class="panel panel-inverse">
  <div class="panel-heading">
    <h3 class="panel-title"><?=$title?></h3>

    <div class="panel-heading-btn">
     
    </div>
  </div>
  <div class="panel-body">
    <form class="form-horizontal "  action="<?=base_url($link.'edit')?>" method="POST">
          <input type="hidden" name="id" value="<?=$row['id_level']?>">
            
          <div class="form-group row">
            <label class="col-sm-2 control-label ">Nama Level</label>
            <div class="col-sm-10">
              <input type="text" name="level" class="form-control" value="<?=$row['nama_level']?>" placeholder="Nama Level" required>
            </div>
          </div><!-- row -->

          
          <div class="form-group row">
            <label class="col-sm-2 control-label ">Level Wilayah?</label>
            <div class="col-sm-10">
              <select name="wilayah" id="wilayah" class="form-control" required>
                <?=opEnum('level','wilayah',$row['wilayah'])?>
              </select>
            </div>
          </div><!-- row -->
          
            <div class="form-group row">
              <label class="col-sm-2 control-label ">&nbsp;</label>
              <div class="col-sm-10">
                
                <button type="submit" name="edit" class="btn btn-success">Simpan</button>
                <a href="<?=base_url('config/level')?>" class="btn btn-danger">Cancel</a>
              </div>
            </div><!-- row -->


      </form>
  </div>
  <!-- /.panel-body -->
</div>
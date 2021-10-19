<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      

      <div class="form-group row">
        <label class="control-label col-md-2">Nama Lengkap</label>
        <div class="col-md-10">
          <?=formInputText('nama',stripcslashes($rows['nama']),'Nama Lengkap','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NIP</label>
        <div class="col-md-10">
          <?=formInputText('nip',$rows['nip'],'NIP','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis Kelamin</label>
        <div class="col-md-10">
          <select name="jk" class="form-control" required>
            <?=opKodeApp('KELAMIN',$rows['jk'])?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Agama</label>
        <div class="col-md-10">
          <select name="agama" class="form-control" required>
            <?=opKodeApp('AGAMA',$rows['agama'])?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Alamat</label>
        <div class="col-md-10">
          <?=formInputText('alamat',stripcslashes($rows['alamat']),'Alamat Rumah','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Email</label>
        <div class="col-md-10">
          <?=formInputEmail('email',$rows['email'],'Alamat Email','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NO. HP</label>
        <div class="col-md-10">
          <?=formInputText('hp',$rows['hp'],'No. Handphone','required')?>
        </div>
      </div>

      
      <div class="form-group row">
        <label class="control-label col-md-2">Golongan/ Pangkat</label>
        <div class="col-md-10">
          <select name="gol" class="form-control" required>
            <?=opKodeApp('GOL',$rows['gol'])?>
          </select>
        </div>
      </div>

      
      <div class="form-group row">
        <label class="control-label col-md-2">Pendidikan Terakhir</label>
        <div class="col-md-10">
          <select name="pendidikan" class="form-control" required>
            <?=opKodeApp('PENDIDIKAN',$rows['pendidikan'])?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Alumni Dari</label>
        <div class="col-md-10">
          <?=formInputText('alumni',stripcslashes($rows['alumni']),'Instansi Pendikan Terakhir','')?>
        </div>
      </div>

     
      <div class="form-group row">
        <label class="control-label col-md-2"></label>
        <div class="col-md-10">
          <button class="btn btn-success" id="btnSimpan" name="simpan" type="submit"> Simpan</button>
          <a class="btn btn-danger" href="<?=base_url($link)?>" type="button">Cancel</a>
        </div>
      </div>

    </form>   
  </div>
  <!-- /.panel-body -->
</div>


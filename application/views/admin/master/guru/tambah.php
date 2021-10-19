<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'tambah')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group row">
        <label class="control-label col-md-2">Jenis SDM</label>
        <div class="col-md-10">
          <select name="jenis" class="form-control" required>
            <?=opEnum('guru','jenis','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nama Lengkap</label>
        <div class="col-md-10">
          <?=formInputText('nama','','Nama Lengkap','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NIP</label>
        <div class="col-md-10">
          <?=formInputText('nip','','NIP','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis Kelamin</label>
        <div class="col-md-10">
          <select name="jk" class="form-control" required>
            <?=opKodeApp('KELAMIN','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Agama</label>
        <div class="col-md-10">
          <select name="agama" class="form-control" required>
            <?=opKodeApp('AGAMA','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Alamat</label>
        <div class="col-md-10">
          <?=formInputText('alamat','','Alamat Rumah','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Email</label>
        <div class="col-md-10">
          <?=formInputEmail('email','','Alamat Email','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">NO. HP</label>
        <div class="col-md-10">
          <?=formInputText('hp','','No. Handphone','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jabatan</label>
        <div class="col-md-10">
          <select name="jabatan" class="form-control" required>
            <?=opJabatan('')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Golongan/ Pangkat</label>
        <div class="col-md-10">
          <select name="gol" class="form-control" required>
            <?=opKodeApp('GOL','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Status Pegawai</label>
        <div class="col-md-10">
          <select name="status" class="form-control" required>
            <?=opKodeApp('STSPEG','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Pendidikan Terakhir</label>
        <div class="col-md-10">
          <select name="pendidikan" class="form-control" required>
            <?=opKodeApp('PENDIDIKAN','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Alumni Dari</label>
        <div class="col-md-10">
          <?=formInputText('alumni','','Instansi Pendikan Terakhir','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Foto</label>
        <div class="col-md-10">
          <?=formInputGambar('gambar','')?>
          <small>Ukuran Maksimal 500Kb</small>
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


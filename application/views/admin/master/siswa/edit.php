<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="id" value="<?=$rows['id_siswa']?>">
      

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Nama Lengkap</label>
        <div class="col-md-10">
          <?=formInputText('nama',stripcslashes($rows['nama']),'Nama Lengkap','required')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">NISN</label>
        <div class="col-md-10">
          <?=formInputText('nisn',$rows['nisn'],'NISN','required')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">NIS</label>
        <div class="col-md-10">
          <?=formInputText('nis',$rows['nis'],'NIS','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Tanggal Masuk</label>
        <div class="col-md-10">
          <?=formInputDate('tgl_masuk',$rows['tgl_masuk'],'Tanggal Masuk','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Tempat Lahir</label>
        <div class="col-md-10">
          <?=formInputText('tempat_lahir',stripcslashes($rows['tempat_lahir']),'Tempat Lahir','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Tanggal Lahir</label>
        <div class="col-md-10">
          <?=formInputDate('tgl_lahir',$rows['tgl_lahir'],'Tanggal Lahir','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Jenis Kelamin</label>
        <div class="col-md-10">
          <select name="jk" class="form-control" required>
            <?=opKodeApp('KELAMIN',$rows['jk'])?>
          </select>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Agama</label>
        <div class="col-md-10">
          <select name="agama" class="form-control" required>
            <?=opKodeApp('AGAMA',$rows['agama'])?>
          </select>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Alamat</label>
        <div class="col-md-10">
          <?=formInputText('alamat',stripcslashes($rows['alamat']),'Alamat Rumah','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Nama Ayah</label>
        <div class="col-md-10">
          <?=formInputText('nama_ayah',stripcslashes($rows['nama_ayah']),'Nama Ayah','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">No. HP Ayah</label>
        <div class="col-md-10">
          <?=formInputText('hp_ayah',$rows['hp_ayah'],'No. HP Ayah','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Pekerjaan Ayah</label>
        <div class="col-md-10">
          <select name="pekerjaan_ayah" class="form-control" required>
            <?=opKodeApp('PEKERJAAN',$rows['pekerjaan_ayah'])?>
          </select>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Nama Ibu</label>
        <div class="col-md-10">
          <?=formInputText('nama_ibu',stripcslashes($rows['nama_ibu']),'Nama Ibu','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Pekerjaan Ibu</label>
        <div class="col-md-10">
          <select name="pekerjaan_ibu" class="form-control" required>
            <?=opKodeApp('PEKERJAAN',$rows['pekerjaan_ibu'])?>
          </select>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">No. HP Ibu</label>
        <div class="col-md-10">
          <?=formInputText('hp_ibu',$rows['hp_ibu'],'No. HP Ibu','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Nama Wali</label>
        <div class="col-md-10">
          <?=formInputText('nama_wali',stripcslashes($rows['nama_wali']),'Nama Wali','')?>
        </div>
      </div>
      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">No. HP Wali</label>
        <div class="col-md-10">
          <?=formInputText('hp_wali',$rows['hp_wali'],'No. HP Wali','')?>
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Foto Sebelumnya</label>
        <div class="col-md-10">
          <img src="<?=gambarAws($rows['gambar'])?>" width="150" alt="">
        </div>
      </div>

      <div class="form-group row m-b-5">
        <label class="control-label col-md-2">Foto</label>
        <div class="col-md-10">
          <?=formInputGambar('gambar','')?>
          <small>Kosongkan Jika Tidak Mengganti Foto, Ukuran Maksimal 500Kb</small>
        </div>
      </div>

      <div class="form-group row m-b-5">
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


<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="id" value="<?=$rows['id_fasilitas']?>">
     
      <div class="form-group row">
        <label class="control-label col-md-2">Nama Fasilitas</label>
        <div class="col-md-10">
          <?=formInputText('judul',stripcslashes($rows['judul']),'Nama Fasilitas','required')?>
        </div>
      </div>

      
      
      <div class="form-group row">
        <label class="control-label col-md-2">Foto Sebelumnya</label>
        <div class="col-md-10">
          <img src="<?=gambarAws($rows['gambar'])?>" width="150" alt="">
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Foto</label>
        <div class="col-md-10">
          <?=formInputGambar('gambar','')?>
          <small>Kosongkan Jika Tidak Mengganti Foto, Ukuran Maksimal 500Kb</small>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Keterangan</label>
        <div class="col-md-10">
          <?=formInputTextarea('isi',$rows['isi'],'mytextarea')?>
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


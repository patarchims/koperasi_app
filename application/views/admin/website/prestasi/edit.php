<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="id" value="<?=$rows['id_prestasi']?>">
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal</label>
        <div class="col-md-10">
          <?=formInputDate('tanggal',$rows['tanggal'],'Tanggal Berita','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Judul Prestasi</label>
        <div class="col-md-10">
          <?=formInputText('judul',stripcslashes($rows['judul']),'Judul Prestasi','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nama Yang Berprestasi</label>
        <div class="col-md-10">
          <?=formInputText('nama',stripcslashes($rows['nama']),'Nama Yang Berprestasi','required')?>
        </div>
      </div>

      

      <div class="form-group row">
        <label class="control-label col-md-2">Tingkat</label>
        <div class="col-md-10">
          <?=formInputText('tingkat',$rows['tingkat'],'Tingkat','')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Juara</label>
        <div class="col-md-10">
          <?=formInputText('juara',$rows['juara'],'Juara','')?>
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
        <label class="control-label col-md-2">Isi</label>
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

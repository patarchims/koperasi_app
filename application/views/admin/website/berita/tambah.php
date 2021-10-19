<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'tambah')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal</label>
        <div class="col-md-10">
          <?=formInputDate('tanggal',date('Y-m-d'),'Tanggal Berita','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Judul</label>
        <div class="col-md-10">
          <?=formInputText('judul','','Judul Berita','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Kategori</label>
        <div class="col-md-10">
          <select name="id_kategori" class="form-control" required>
            <?=opKategoriBerita('')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Kata Kunci</label>
        <div class="col-md-10">
          <?=formInputText('keyword','','Kata Kunci','')?>
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
        <label class="control-label col-md-2">Isi</label>
        <div class="col-md-10">
          <?=formInputTextarea('isi','','mytextarea')?>
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


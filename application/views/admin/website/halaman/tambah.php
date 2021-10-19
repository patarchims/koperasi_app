<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'tambah')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      
      <div class="form-group row">
        <label class="control-label col-md-2">Judul</label>
        <div class="col-md-10">
          <?=formInputText('judul','','Judul Halaman','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis Halaman</label>
        <div class="col-md-10">
          <select name="jenis" class="form-control" required>
            <?=opEnum('halaman','jenis','')?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Urutan</label>
        <div class="col-md-10">
          <?=formInputNumberInt('urutan','','Urutan Halaman','required')?>
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


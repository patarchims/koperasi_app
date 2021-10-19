<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <h4><?=stripcslashes($rows->judul)?></h4>
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'tambah/'.$seo)?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      

      <div class="form-group row">
        <label class="control-label col-md-2">Judul</label>
        <div class="col-md-10">
          <?=formInputText('judul','','Judul/ Nama File','required')?>
        </div>
      </div>

      
      <div class="form-group row">
        <label class="control-label col-md-2">File</label>
        <div class="col-md-10">
          <?=formInputFile('gambar','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Keterangan</label>
        <div class="col-md-10">
          <textarea name="keterangan" class="form-control" row="5" ></textarea>
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


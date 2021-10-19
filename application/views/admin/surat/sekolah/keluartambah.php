<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'tambah')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      
      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Surat</label>
        <div class="col-md-10">
          <?=formInputDate('tanggal',date('Y-m-d'),'Tanggal Surat','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nomor Surat</label>
        <div class="col-md-10">
          <?=formInputText('nomor','','Nomor Surat','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Perihal</label>
        <div class="col-md-10">
          <?=formInputText('perihal','','Perihal','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Pengirim</label>
        <div class="col-md-10">
          <?=formInputText('pengirim','','Pengirim','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Tujuan</label>
        <div class="col-md-10">
          <?=formInputText('tujuan','','Tujuan','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Upload File</label>
        <div class="col-md-10">
          <?=formInputFile('gambar','')?>
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


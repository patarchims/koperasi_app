<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="id" value="<?=$rows['id_kerjasama']?>">
      <div class="form-group row">
        <label class="control-label col-md-2">Judul</label>
        <div class="col-md-10">
          <?=formInputText('judul',stripcslashes($rows['judul']),'Judul Kerjasama','required')?>
        </div>
      </div>

     <div class="form-group row">
        <label class="control-label col-md-2">Jenis Kerjasama</label>
        <div class="col-md-10">
          <?=formInputText('jenis',stripcslashes($rows['jenis']),'Jenis Kerjasama','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Bidang Kerjasama</label>
        <div class="col-md-10">
          <?=formInputText('bidang',stripcslashes($rows['bidang']),'Bidang Kerjasama','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Rekan Kerjasama</label>
        <div class="col-md-10">
          <?=formInputText('rekanan',stripcslashes($rows['rekanan']),'Rekan Kerjasama','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Mulai Kerjasama</label>
        <div class="col-md-10">
          <?=formInputDate('tanggal_mulai',$rows['tanggal_mulai'],'Tanggal Mulai Kerjasama','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Tanggal Berakhir Kerjasama</label>
        <div class="col-md-10">
          <?=formInputDate('tanggal_selesai',$rows['tanggal_selesai'],'Tanggal Berkahir Kerjasama','required')?>
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


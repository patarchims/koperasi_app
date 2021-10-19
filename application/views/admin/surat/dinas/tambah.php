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
          <?=formInputDate('tgl_surat',date('Y-m-d'),'Tanggal Surat','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Nomor Surat</label>
        <div class="col-md-10">
          <?=formInputText('no_surat','','Nomor Surat','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis Surat</label>
        <div class="col-md-10">
          <select name="jenis_surat" class="form-control" required>
            <option value="">..::Pilih Jenis Surat::..</option>
            <?php
              foreach ($jenis as $row) {
                echo '<option value="'.$row->id_jenis.'">'.$row->nama_jenis.'</option>';
              }
            ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Perihal</label>
        <div class="col-md-10">
          <?=formInputText('isi_ringkas','','Perihal','required')?>
        </div>
      </div>

      
      <div class="form-group row">
        <label class="control-label col-md-2">File</label>
        <div class="col-md-10">
          <input type="file" name="gambar" accept="application/pdf" class="form-control" required>
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


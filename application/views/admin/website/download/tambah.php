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
          <?=formInputText('judul','','Judul Download','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis</label>
        <div class="col-md-10">
          <select name="jenis" id="jenis" class="form-control" required>
            <option value="">..::Pilih Jenis Berkas::..</option>
            <?=opEnum('download','jenis','')?>
          </select>
        </div>
      </div>

      <div class="form-group row" id="upload">
        <label class="control-label col-md-2">Upload File</label>
        <div class="col-md-10">
          <?=formInputFile('gambar','')?>
        </div>
      </div>

      <div class="form-group row" id="link">
        <label class="control-label col-md-2">Link File</label>
        <div class="col-md-10">
          <?=formInputUrl('link','','Link File','')?>
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#upload').hide();
    $('#link').hide();
  });
   $('#jenis').change(function(){
    var jenis=$(this).val();
    if(jenis=='Upload')
    {
      $('#upload').show();
      $('#link').hide();
      $('#upload').prop('required',true);
      $('#link').prop('required',false);
    }
    else if(jenis=='Link')
    {
      $('#upload').hide();
      $('#link').show();
      $('#upload').prop('required',false);
      $('#link').prop('required',true);
    }
    else
    {
      $('#upload').hide();
      $('#link').hide();
      $('#upload').prop('required',false);
      $('#link').prop('required',false);
    }
   });
</script>
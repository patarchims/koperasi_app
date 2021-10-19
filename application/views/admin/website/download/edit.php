<div class="panel panel-inverse">
  <div class="panel-heading">
    <div class="panel-heading-btn">
      
    </div>
    <h3 class="panel-title"><?=$title?></h3>
  </div>
  <div class="panel-body">
    <form class="form-horizontal" onsubmit="ShowLoading()" action="<?=base_url($link.'edit')?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">
      <input type="hidden" name="id" value="<?=$rows['id_download']?>">
      <div class="form-group row">
        <label class="control-label col-md-2">Judul</label>
        <div class="col-md-10">
          <?=formInputText('judul',$rows['judul'],'Judul Download','required')?>
        </div>
      </div>

      <div class="form-group row">
        <label class="control-label col-md-2">Jenis</label>
        <div class="col-md-10">
          <select name="jenis" id="jenis" class="form-control" required>
            <option value="">..::Pilih Jenis Berkas::..</option>
            <?=opEnum('download','jenis',$rows['jenis'])?>
          </select>
        </div>
      </div>

      <div id="upload">
        <div class="form-group row">
          <label class="control-label col-md-2">File Sebelumnya</label>
          <div class="col-md-10">
            <?php 
            if($rows['gambarkey']=='')
            {
              echo 'Tidak Ada File';
            }
            else
            {
              echo aksiModalLihat('#modalFile',$rows['id_download'],'Lihat');
            }
            ?>
          </div>
        </div>
        <div class="form-group row" >
          <label class="control-label col-md-2">Upload File</label>
          <div class="col-md-10">
            <?=formInputFile('gambar','')?>
            <small>Kosongkan Jika Tidak Mengganti File</small>
          </div>
        </div>
      </div>
      

      <div class="form-group row" id="link">
        <label class="control-label col-md-2">Link File</label>
        <div class="col-md-10">
          <?=formInputUrl('link',$rows['gambar'],'Link File','')?>
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

<div class="modal fade" id="modalFile">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header ">
              <h4 class="modal-title">File Pengumuman</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="fetch-data"></div>
            </div>
            <div class="modal-footer">
                <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
                
            </div>
          
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var jenis=$('#jenis').val();
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

   $('#modalFile').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        //menggunakan fungsi ajax untuk pengambilan data
        $.ajax({
            type : 'POST',
            url : '<?=base_url('website/downloadfile')?>',
            data :  'rowid='+ rowid,
            success : function(data){
            $('.fetch-data').html(data);//menampilkan data ke dalam modal
            }
        });
     });
</script>

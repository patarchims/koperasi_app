<!-- begin section-container -->
<div class="section-container section-with-top-border p-b-5">
  <!-- begin row -->
  <div class="row">

    <!-- begin col-8 -->
    <div class="col-md-12">
      <!-- begin panel -->
      <div class="panel panel-inverse">
        <div class="panel-heading">

          <h4 class="panel-title">Kop Surat</h4>
        </div>
        <div class="panel-body">
          <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                  <th>A4 & F4 Portrait</th>
                  <th>A4 Landscape</th>
                  <th>F4 Landscape</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?= aksiModalUploadBukti('#modalUpload', $rows['id'], 'pa4', 'Upload') ?></td>
                  <td><?= aksiModalUploadBukti('#modalUpload', $rows['id'], 'la4', 'Upload') ?></td>
                  <td><?= aksiModalUploadBukti('#modalUpload', $rows['id'], 'lf4', 'Upload') ?></td>
                </tr>
                <tr>
                  <td><?php if ($rows['pa4'] == '') {
                        echo 'Belum Upload';
                      } else {
                        echo '<object data="' . base_url('assets/img/' . $rows['pa4']) . '" type="application/pdf" width="100%" height="280"></object>';
                      } ?></td>
                  <td><?php if ($rows['la4'] == '') {
                        echo 'Belum Upload';
                      } else {
                        echo '<object data="' . base_url('assets/img/' . $rows['la4']) . '" type="application/pdf" width="100%" height="280"></object>';
                      } ?></td>
                  <td><?php if ($rows['lf4'] == '') {
                        echo 'Belum Upload';
                      } else {
                        echo '<object data="' . base_url('assets/img/' . $rows['lf4']) . '" type="application/pdf" width="100%" height="280"></object>';
                      } ?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

      </div>
      <!-- end panel -->
    </div>
    <!-- end col-8 -->
  </div>
  <!-- end row -->
</div>
<!-- end section-container -->

<div class="modal fade" id="modalUpload">
  <div class="modal-dialog">
    <div class="modal-content ">
      <div class="modal-header ">
        <h4 class="modal-title"><span id="judul"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

      </div>
      <form class="form-horizontal" enctype="multipart/form-data" action="<?= base_url($link) ?>" method="POST">
        <input type="hidden" name="jenis" id="jenis" value="">
        <div class="modal-body">
          <div class="form-group row">
            <label class="col-sm-3 control-label ">File PDF</label>
            <div class="col-sm-9">
              <input type="file" name="gambar" accept="application/pdf" class="form-control" required>
            </div>
          </div><!-- row -->
        </div>
        <div class="modal-footer">
          <a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
          <button type="submit" name="upload" class="btn width-100 btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>



<script type="text/javascript">
  $(document).ready(function() {
    $('#modalUpload').on('show.bs.modal', function(e) {
      var rowid = $(e.relatedTarget).data('id');
      var jenis = $(e.relatedTarget).data('jenis');
      $('#jenis').val(jenis);
      if (jenis == 'pa4') {
        $('#judul').text('Form Upload Kop Surat Portrait A4 dan F4');
      } else if (jenis == 'la4') {
        $('#judul').text('Form Upload Kop Surat Landscape A4');
      } else {
        $('#judul').text('Form Upload Kop Surat Landscape A4');
      }
    });
  });
</script>
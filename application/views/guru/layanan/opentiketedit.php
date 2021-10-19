<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <?= aksiKembali($link) ?>
        </div>
        <h3 class="panel-title"><?= $title ?></h3>
    </div>
    <div class="panel-body">
        <form onsubmit="ShowLoading()" action="<?= current_url() ?>" class="form-horizontal" method="post" enctype="multipart/form-data">
            <div class="form-group row">
                <label for="" class="control-label col-md-2">Tanggal</label>
                <div class="col-md-10">
                    <?= formInputDate('tanggal', $rows['tanggal'], '', 'readonly') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-2">Hal</label>
                <div class="col-md-10">
                    <?= formInputText('hal', stripslashes($rows['hal']), 'Perihal', 'required') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-2">Uraian</label>
                <div class="col-md-10">
                    <?= formInputTextarea('isi', gantiEdit($rows['isi']), 'form-control', 'Uraian') ?>
                </div>
            </div>
            <div class="form-group row">
                <label for="" class="control-label col-md-2">Lampiran</label>
                <div class="col-md-10">
                    <?= formInputFile('gambar', '') ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="control-label col-md-2"></label>
                <div class="col-md-10">
                    <button class="btn btn-success" id="btnSimpan" name="simpan" type="submit"> Simpan</button>
                    <a class="btn btn-danger" href="<?= base_url($link) ?>" type="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
    <!-- /.panel-body -->
</div>
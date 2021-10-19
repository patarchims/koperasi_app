<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">

        </div>
        <h3 class="panel-title">Form Edit <?= $title ?></h3>
    </div>
    <div class="panel-body">
        <form class="form-horizontal" onsubmit="ShowLoading()" action="<?= current_url() ?>" method="post" enctype="multipart/form-data" accept-charset="utf-8">

            <div class="form-group row">
                <label class="control-label col-md-2">Tahun</label>
                <div class="col-md-10">
                    <?= formInputText('tahun', $rows['tahun'], 'Tahun', 'readonly') ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">Nama Lengkap</label>
                <div class="col-md-10">
                    <?= formInputText('nama', stripslashes($rows['nama']), 'Nama Lengkap', 'required') ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">Tanggal Lahir</label>
                <div class="col-md-10">
                    <?= formInputDate('tgl_lahir', $rows['tgl_lahir'], 'Tanggal Lahir', 'required') ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">Jenis Kelamin</label>
                <div class="col-md-10">
                    <?= opEnumRadio('ppdb_pendaftar', 'jk', $rows['jk']) ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">Nama Orangtua</label>
                <div class="col-md-10">
                    <?= formInputText('nama_ortu', $rows['nama_ortu'], 'Nama Orang Tua', 'required') ?>
                </div>
            </div>


            <div class="form-group row">
                <label class="control-label col-md-2">NO. HP</label>
                <div class="col-md-10">
                    <?= formInputText('hp', $rows['hp'], 'No. Handphone', 'required') ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">Email</label>
                <div class="col-md-10">
                    <?= formInputEmail('email', stripslashes($rows['email']), 'Alamat Email', 'required') ?>
                </div>
            </div>


            <div class="form-group row">
                <label class="control-label col-md-2">Alamat</label>
                <div class="col-md-10">
                    <?= formInputText('alamat', stripslashes($rows['alamat']), 'Alamat Rumah', 'required') ?>
                </div>
            </div>

            <div class="form-group row">
                <label class="control-label col-md-2">NIK</label>
                <div class="col-md-10">
                    <?= formInputText('nik', stripslashes($rows['nik']), 'Nomor Induk Kependudukan', 'required') ?>
                </div>
            </div>



            <?php
            if (jurusanAktif() > 0) {
                echo '
                <div class="form-group row">
                    <label class="control-label col-md-2">Jurusan</label>
                    <div class="col-md-10">
                        <select name="id_jurusan" class="form-control" required>
                        ' . opJurusan($rows['id_jurusan']) . '
                        </select>
                    </div>
                </div>
                ';
            } else {
                echo '<input type="hidden" name="id_jurusan" value="0">';
            }
            ?>


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
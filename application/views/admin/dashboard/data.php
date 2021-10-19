<?php
if ($belum > 0) {
	echo '<div class="row">
			<div class="col-md-12">
				<div class="alert alert-success fade show">
				  <span class="close" data-dismiss="alert">×</span>
				  <h4><strong>Perhatian!</strong></h4>
				  <h5><b>Ada ' . $belum . ' Permintaan Data Oleh Dinas Yang Belum Anda Isi</b></h5>
			    <p> Silahkan Klik <a class="alert-link" href="' . base_url('permintaan/daftar') . '">Disini</a> Untuk Mengisi Permintaan Data</p> 
				</div>
			</div>
		  </div>';
}
?>

<div class="row m-b-10">
	<div class="col-md-12">
		<button type="button" class="btn btn-block btn-success" data-toggle="modal" data-target="#modalSimpelBos">Login Simpel Bos</button>
	</div>
</div>
<div class="row">
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
		<div class="widget widget-stats bg-red">
			<div class="stats-icon"><i class="fa fa-users"></i></div>
			<div class="stats-info">
				<h4>Jumlah Siswa</h4>
				<p><?= jlhSiswa('Aktif') ?></p>
			</div>
			<div class="stats-link">
				<a href="<?= base_url('master/siswa') ?>">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
		<div class="widget widget-stats bg-orange">
			<div class="stats-icon"><i class="fa fa-users"></i></div>
			<div class="stats-info">
				<h4>Jumlah Guru</h4>
				<p><?= jlhSdm('GURU') ?></p>
			</div>
			<div class="stats-link">
				<a href="<?= base_url('master/cari/GURU') ?>">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
		<div class="widget widget-stats bg-grey-darker">
			<div class="stats-icon"><i class="fa fa-users"></i></div>
			<div class="stats-info">
				<h4>Jumlah Pegawai</h4>
				<p><?= jlhSdm('PEGAWAI') ?></p>
			</div>
			<div class="stats-link">
				<a href="<?= base_url('master/cari/PEGAWAI') ?>">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
	<!-- begin col-3 -->
	<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
		<div class="widget widget-stats bg-black-lighter">
			<div class="stats-icon"><i class="fa fa-handshake"></i></div>
			<div class="stats-info">
				<h4>Jumlah Kerjasama</h4>
				<p><?= jlhKerjasama() ?></p>
			</div>
			<div class="stats-link">
				<a href="<?= base_url('website/kerjasama') ?>">View Detail <i class="fa fa-arrow-alt-circle-right"></i></a>
			</div>
		</div>
	</div>
	<!-- end col-3 -->
</div>

<div class="row">
	<div class="col-md-12 ">
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">Open Tiket Siswa</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline m-b-10" action="<?= current_url() ?>" method="POST">
					<div class="form-group">
						<label for="" class="control-label m-r-20">Tahun</label>
						<select name="tahun" id="" class="form-control" onchange="submit()">
							<?= opTahun($tahun) ?>
						</select>
					</div>
				</form>

				<div class="card">
					<div class="card-header">
						<ul class="nav nav-pills card-header-pills">
							<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#siswabaru">Baru (<?= count($siswabaru) ?>)</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#siswaproses">Proses (<?= count($siswaproses) ?>)</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#siswaselesai">Selesai (<?= count($siswaselesai) ?>)</a></li>
						</ul>
					</div>
					<div class="card-block">
						<div class="tab-content p-0 m-0">
							<div class="tab-pane fade active show" id="siswabaru">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($siswabaru as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiModalEdit('#modalSiswaProses', $row['id'], 'Proses') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="siswaproses">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($siswaproses as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiDetail($link . 'detail', enkrip($row['id']) . '/siswa', 'Detail') . '&nbsp;' . aksiModalReset('#modalSiswaSelesai', $row['id'], 'Selesai') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="siswaselesai">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($siswaselesai as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiDetail($link . 'detail', enkrip($row['id']) . '/siswa', 'Detail') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
	</div>

</div>

<div class="row">
	<div class="col-md-12 ">
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title">Open Tiket Guru</h3>
			</div>
			<div class="panel-body">
				<form class="form-inline m-b-10" action="<?= current_url() ?>" method="POST">
					<div class="form-group">
						<label for="" class="control-label m-r-20">Tahun</label>
						<select name="tahun" id="" class="form-control" onchange="submit()">
							<?= opTahun($tahun) ?>
						</select>
					</div>
				</form>

				<div class="card">
					<div class="card-header">
						<ul class="nav nav-pills card-header-pills">
							<li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#gurubaru">Baru (<?= count($gurubaru) ?>)</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#guruproses">Proses (<?= count($guruproses) ?>)</a></li>
							<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#guruselesai">Selesai (<?= count($guruselesai) ?>)</a></li>
						</ul>
					</div>
					<div class="card-block">
						<div class="tab-content p-0 m-0">
							<div class="tab-pane fade active show" id="gurubaru">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($gurubaru as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiModalEdit('#modalGuruProses', $row['id'], 'Proses') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="guruproses">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($guruproses as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiDetail($link . 'detail', enkrip($row['id']) . '/guru', 'Detail') . '&nbsp;' . aksiModalReset('#modalGuruSelesai', $row['id'], 'Selesai') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
							<div class="tab-pane fade" id="guruselesai">
								<div class="table-responsive">
									<table id="datatable1" class="table table-bordered">
										<thead>
											<tr>
												<th>No</th>
												<th>Tanggal</th>
												<th>Nama</th>
												<th>Hal</th>
												<th>Keterangan</th>
												<th width="1%">Lampiran</th>
												<th width="1%">Aksi</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$no = 0;
											foreach ($guruselesai as $row) {
												$lampiran = 'Tidak Ada';
												if ($row['gambar'] != '') {
													$lampiran = aksiUrl($row['gambar'], 'Lihat');
												}
												$no++;
												echo '<tr>
										<td>' . $no . '</td>
										<td>' . tgl_indo($row['tanggal']) . '</td>
										<td>' . stripslashes($row['nama']) . '</td>
										<td>' . stripslashes($row['hal']) . '</td>
										<td>' . gantiEnter($row['isi']) . '</td>
										<td nowrap>' . $lampiran . '</td>
										<td nowrap>' . aksiDetail($link . 'detail', enkrip($row['id']) . '/guru', 'Detail') . '</td>
										</tr>';
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>


					</div>
				</div>

			</div>
			<!-- /.panel-body -->
		</div>
	</div>

</div>


<div class="modal fade" id="modalSiswaProses">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header ">
				<h4 class="modal-title">Proses Open Tiket</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form class="form-horizontal" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" id="id_tiket" name="id_tiket">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Pesan</label>
						<div class="col-md-9">
							<?= formInputTextarea('pesan', '', 'form-control', 'Pesan', '3') ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Lampiran</label>
						<div class="col-md-9">
							<?= formInputFile('gambar', '') ?>
							<small>Kosongkan Jika Tidak Ada Lampiran</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
					<button type="submit" name="prosessiswa" class="btn width-100 btn-info">Proses</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modalSiswaSelesai">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header ">
				<h4 class="modal-title">Form Close(Selesai) Open Tiket</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form class="form-horizontal" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" id="id_tiket1" name="id_tiket">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Informasi</label>
						<div class="col-md-9">
							<?= formInputTextarea('informasi', '', 'form-control', 'Informasi', '3') ?>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
					<button type="submit" name="selesaisiswa" class="btn width-100 btn-info">Proses</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modalGuruProses">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header ">
				<h4 class="modal-title">Proses Open Tiket</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form class="form-horizontal" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" id="id_tiket2" name="id_tiket">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Pesan</label>
						<div class="col-md-9">
							<?= formInputTextarea('pesan', '', 'form-control', 'Pesan', '3') ?>
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Lampiran</label>
						<div class="col-md-9">
							<?= formInputFile('gambar', '') ?>
							<small>Kosongkan Jika Tidak Ada Lampiran</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
					<button type="submit" name="prosesguru" class="btn width-100 btn-info">Proses</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modalGuruSelesai">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header ">
				<h4 class="modal-title">Form Close(Selesai) Open Tiket</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form class="form-horizontal" action="<?= current_url() ?>" method="POST" enctype="multipart/form-data">
				<input type="hidden" id="id_tiket3" name="id_tiket">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="control-label col-md-3">Informasi</label>
						<div class="col-md-9">
							<?= formInputTextarea('informasi', '', 'form-control', 'Informasi', '3') ?>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
					<button type="submit" name="selesaiguru" class="btn width-100 btn-info">Proses</button>
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modalSimpelBos">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header ">
				<h4 class="modal-title">Form Login Simpel BOS</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<form action="https://simpelbos-batubara.com/" method="post" target="_blank">
				<input type="hidden" name="token" value="<?= token() ?>">
				<div class="modal-body">
					<div class="form-group row">
						<label for="" class="control-label col-md-4">Username</label>
						<div class="col-md-8">
							<input type="text" name="username" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="control-label col-md-4">Password Simpel BOS</label>
						<div class="col-md-8">
							<input type="password" name="password" class="form-control" required>
						</div>
					</div>
					<div class="form-group row">
						<label for="" class="control-label col-md-4">Tahun Anggaran</label>
						<div class="col-md-8">
							<select name="tahun" id="" class="form-control" required>
								<?php
								for ($i = 2021; $i <= date('Y'); $i++) {
									echo '<option value="' . $i . '">Tahun Anggaran ' . $i . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<a href="javascript:;" class="btn width-100 btn-danger" data-dismiss="modal">Tutup</a>
					<button type="submit" name="login" class="btn width-100 btn-success">Login</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(document).ready(function() {
		$('#modalSiswaProses').on('show.bs.modal', function(e) {
			var rowid = $(e.relatedTarget).data('id');
			$('#id_tiket').val(rowid);

		});
		$('#modalSiswaSelesai').on('show.bs.modal', function(e) {
			var rowid = $(e.relatedTarget).data('id');
			$('#id_tiket1').val(rowid);

		});

		$('#modalGuruProses').on('show.bs.modal', function(e) {
			var rowid = $(e.relatedTarget).data('id');
			$('#id_tiket2').val(rowid);

		});
		$('#modalGuruSelesai').on('show.bs.modal', function(e) {
			var rowid = $(e.relatedTarget).data('id');
			$('#id_tiket3').val(rowid);

		});
	});
</script>
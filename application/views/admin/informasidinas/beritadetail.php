<div class="row">

	<!-- begin col-3 -->
	<div class="col-md-12">

		<!-- begin card -->
		<div class="card ">
			<div class="card-header text-center">
				<?= $title ?>
			</div>
			<div class="card-block">
				<div class="row m-b-20">
					<div class="col-md-6 offset-3">
						<img src="<?= $rows->gambar ?>" class="img-fluid" alt="">
					</div>
				</div>

				<?= $rows->isi ?>

				<div class="card-footer text-muted m-t-20 text-center">
					<?= aksiKembali($link) ?>
				</div>
			</div>
		</div>
		<!-- end card -->
		<!-- end col-3 -->
	</div>
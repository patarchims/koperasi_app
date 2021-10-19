<div class="page-title-area bg-13">
	<div class="container">
		<div class="page-title-content">
			<h2><?= $title ?></h2>
			<ul>
				<li>
					<a href="<?= base_url('home') ?>">
						Home
					</a>
				</li>

				<li><?="Detail " . $hal?></li>
			</ul>
		</div>
	</div>
</div>



<?php if ($hal == 'foto') { ?>


	<section class="news-details-area ptb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">





					<div class="precious-wrap">

						<div class="shorting">
							<div class="row">

								<?php
								foreach ($record as $rowf) {
									$gambar = $rowf['gambar'];
									$url = base_url('gallery/detail/foto/' . $rowf['seo']);
									$jlh = viewJlhFoto($rowf['id_album']);

									$judul = $rowf['judul'];
								?>


									<div class="col-lg-4 col-sm-6 mix certified used">
										<div class="single-company">
											<a href="<?= $gambar  ?>" data-toggle="lightbox" data-gallery="Gallery" data-title="<?= $judul ?>"> <img src="<?= $gambar ?>" alt="Image"></a>

										</div>
									</div>

								<?php } ?>

							</div>
						</div>
					</div>









				</div>

			</div>
		</div>
	</section>



<?php } else { ?>





	<section class="news-details-area ptb-100">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-md-12">





					<div class="precious-wrap">

						<div class="shorting">
							<div class="row">

							<?php
								foreach ($record as $rowf) {
									$gambar = $rowf['gambar'];
									// $url = base_url('gallery/detail/video/' . $rowf['seo']);
									$jlh = viewJlhVideo($rowf['id_album']);
									$judul = $rowf['judul'];
									$link = $rowf['link'];
								?>


									<div class="col-lg-6 col-sm-6 mix certified used">
										<div class="single-company">
											<a href="<?= $link  ?>" data-toggle="lightbox" data-gallery="Gallery" data-title="<?= $judul ?>"> <img src="<?= $gambar ?>" alt="Image"></a>

										</div>
									</div>

								<?php } ?>

							</div>
						</div>
					</div>









				</div>

			</div>
		</div>
	</section>






	








<?php } ?>
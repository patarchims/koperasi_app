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

				<li><?= $title ?></li>
			</ul>
		</div>
	</div>
</div>


<section class="news-details-area ptb-100">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12">





				<div class="precious-wrap">

					<div class="shorting">
						<div class="row">

							<?php
							foreach ($record as $rowf) {
								$gambar = $rowf['gambar'];
								$url = base_url('gallery/detail/video/' . $rowf['seo']);
								$jlh = viewJlhVideo($rowf['id_album']);
								$judul = $rowf['judul'];
							?>

								<div class="col-lg-6 col-sm-6 mix certified used">
									<div class="single-company">
										<img src="<?= $gambar ?>" alt="Image">
										<div class="company-content">
											<a href="<?= $url ?>">
												<?= $judul ?>
												<i class="flaticon-right"></i>
											</a>
										</div>
									</div>
								</div>

							<?php } ?>

						</div>
					</div>
				</div>









			</div>
			<div class="col-lg-4 col-md-12">


				<?php $this->load->view('front/sidebar'); ?>

			</div>
		</div>
	</div>
</section>
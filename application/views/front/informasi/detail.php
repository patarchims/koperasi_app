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



<section class="news-details-area ptb-100">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12">

			
				<section class="articles-area articles-area-two">

					<div class="row">

				
							<div class="col-lg-12 col-md-6">
								<div class="single-articles">
								<?php if ($gambar != '') { ?>
									<a href="#">
										<img src="<?= $gambar ?>" alt="Image">
									</a>
									<?php } ?>
									<div class="articles-content">
										<ul>
											<li>By:
												<a href="#"><?= viewUser($rows['input_user']); ?></a>
											</li>
											<li>
											<?= tgl_indo($rows['tanggal']); ?>
											</li>
											<li>
												Dibaca : <?= $rows['dibaca'] ?>
											</li>
										</ul>
										<a href="#">
											<h3 style="margin-bottom: 0px;"><?= $rows['judul'] ?></h3>
										</a>
										<hr>

										<p><?= $rows['isi'] ?></p>
										<?php if ($hal == 'pengumuman' and $rows['gambar'] != '') { ?>
										<a target="_blank" href="<?= $rows['gambar'] ?>" class="read-more">
										Lampiran
										</a>
										<?php } ?>
									</div>
								</div>
							</div>
				


					
					</div>

				</section>







			</div>
			<div class="col-lg-4 col-md-12">


				<?php $this->load->view('front/sidebar'); ?>

			</div>
		</div>
	</div>
</section>
























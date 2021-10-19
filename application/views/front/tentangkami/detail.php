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


				<div class="row">

					
						<div class="col-lg-12 col-sm-6">
							<div class="single-opportunity">
							<?php if ($gambar != '') { ?>
								<img src="<?= $gambar ?>" alt="Image">
								<?php } ?>
								<div class="opportunity-content" style="text-align: left;">

									<a href="<?= $url ?>">
										<h3><?= $rows['judul'] ?></h3>


									</a>
									<p><?=$rows['isi']?></p>
								</div>
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


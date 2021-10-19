<div class="page-title-area bg-13">
	<div class="container">
		<div class="page-title-content">
			<h2><?=$title?></h2>
			<ul>
				<li>
				<a href="<?= base_url('home')?>">
						Home
					</a>
				</li>
		
				<li><?=$title?></li>
			</ul>
		</div>
	</div>
</div>


<section class="news-details-area ptb-100">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12">

			
							<div class="row">

							<?php
							foreach ($record as $rowf) {
								$gambar = $rowf['gambar'];
								$url = base_url('tentangkami/detail/fasilitas/' . $rowf['seo']);
								$judul = $rowf['judul'];
							?>
								<div class="col-lg-6 col-sm-6">
									<div class="single-opportunity">
										<img src="<?=$gambar?>" alt="Image">
										<div class="opportunity-content">
										
										<a href="<?=$url?>">		<h3><?=$judul?></h3>
										
								
											</a>
										</div>
									</div>
								</div>
								<?php } ?>
							</div>
			




			</div>
			<div class="col-lg-4 col-md-12">


				<?php $this->load->view('front/sidebar'); ?>

			</div>
		</div>
	</div>
</section>



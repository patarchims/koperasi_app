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

				<aside class="widget-area" id="secondary">
					<div class="widget widget_search">
					
						<div class="post-wrap">
							<form class="search-form" action="<?= base_url($link) ?>" method="POST">
								<label>
									<span class="screen-reader-text">Search for:</span>
									<input type="search" class="search-field" value="<?= $cari ?>" placeholder="<?= $title ?> . .." name="cari">
								</label>
								<button type="submit"><i class='bx bx-search'></i></button>
							</form>
						</div>
					</div>
				</aside>
				<section class="articles-area articles-area-two">

					<div class="row">

						<?php
						$no = 0;
						foreach ($record as $rowb) {
							$no++;
							$isi_berita = (strip_tags($rowb['isi']));
							$isi = substr($isi_berita, 0, 150);
							$isi = substr($isi_berita, 0, strrpos($isi, " "));
							$tgl = substr($rowb['tanggal'], 8, 2);
							$bln = getBulan(substr($rowb['tanggal'], 5, 2));
							$url = base_url('informasi/detail/berita/' . $rowb['seo']);
							$gambar = $rowb['gambar'];
							$dibaca = $rowb['dibaca'];
							$user = viewUser($rowb['input_user']);
							$judul = $rowb['judul'];
							$tanggal = tgl_indo($rowb['tanggal']);
							$tahun = substr($rowb['tanggal'], 0, 4);
							$kategori =  $rowb['kategori'];
							$url_kategori = base_url('informasi/beritakategori/' . $rowb['seokategori']);
						?>
							<div class="col-lg-6 col-md-6">
								<div class="single-articles">
									<a href="<?= $url ?>">
										<img src="<?= $gambar ?>" alt="Image">
									</a>
									<div class="articles-content">
										<ul>
											<li><i class="bx bx-user"></i>
												<a href="#"><?= $user ?></a>
											</li>
											<li> <i class="bx bx-calendar"></i>
												<?= $tanggal ?>
											</li>
										</ul>
										<a href="<?= $url ?>">
											<h3><?= $judul ?></h3>
										</a>

										<p><?= $isi ?></p>
										<a href="<?= $url ?>" class="read-more">
											Selengkapnya
										</a>
									</div>
								</div>
							</div>
						<?php } ?>


						<div class="col-lg-12">
							<div class="page-navigation-area">
								<nav>
									<ul class="pagination">
										<!-- <li class="page-item">
												<a class="page-link page-links" href="#">
													<i class='bx bx-chevrons-left'></i>
												</a>
											</li>
											<li class="page-item active">
												<a class="page-link" href="#">1</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="#">2</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="#">3</a>
											</li>
											<li class="page-item">
												<a class="page-link" href="#">
													<i class='bx bx-chevrons-right'></i>
												</a>
											</li> -->
										<?php echo $this->pagination->create_links(); ?>
									</ul>
								</nav>
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
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
			<div class="col-lg-12 col-md-12">

		
				<section class="articles-area articles-area-two">

					<div class="row">

				
							<div class="col-lg-4 col-md-6"style="display: block; margin-left:0px; margin-right:0px;">
								<div class="single-articles">
									<a href="#">
										<img src="<?= $gambar ?>" alt="Image">
									</a>
									<div class="articles-content">
										
										<a href="#">
										<h3 style="margin-bottom: 0px;"><?= $title ?></h3>
										</a>
										<hr>
                                        <p> <b style="margin-right: 110px;">Jabatan </b> : <span><?= viewJabatan($rows['id_jabatan']) ?></span> </p>
                                        <p><b style="margin-right: 65px;">Jenis Kelamin </b> : <span><?= viewKodeApp('KELAMIN', $rows['jk']) ?></span></p>
                                        <p><b style="margin-right:20px;">Pendidikan Terakhir </b> : <span> <?= viewKodeApp('PENDIDIKAN', $rows['pendidikan']) ?></p>
                                        <p><b style="margin-right: 83px;">Alumni dari </b> : <span> <?= stripcslashes($rows['alumni']) ?></span></p>
										
									</div>
								</div>
							</div>
					


					
					</div>

				</section>







			</div>
		
		</div>
	</div>
</section>








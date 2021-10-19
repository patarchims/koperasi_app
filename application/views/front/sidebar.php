<aside class="widget-area" id="secondary">


	<section class="widget widget_categories">
		<h3 class="widget-title">Kategori</h3>
		<div class="post-wrap">
			<ul>
				<?php
				foreach ($kategori as $rowk) :
					$judul = stripcslashes($rowk['kategori']);
					$jlh = JlhBerita($rowk['id_kategori']);
					$url = base_url('informasi/beritakategori/' . $rowk['seo']); ?>
					<li>
						<a href="<?= $url ?>"><?= $judul ?> <span><?= $jlh ?></span></a>
					</li>
				<?php endforeach; ?>

			</ul>
		</div>
	</section>
	<?php

	if ($link != 'infodinas/berita') {
	?>
	<section class="widget widget-peru-posts-thumb">
		<h3 class="widget-title">Info Dinas </h3>
		<div class="post-wrap">

			<?php
			if ($koneksi_api == true) {
				$nomor = 0;
				foreach ($berita_dinas as $key) {
					$gambar = $key->gambar;
					$url = base_url('infodinas/detail/berita/' . $key->seo);
					$tanggal = tgl_indo($key->tanggal);
					$kategori = stripcslashes($key->kategori);
					$judul = substr(stripcslashes($key->judul), 0, 50) . ' ...';
					$user = viewUser($key->input_user);
					$isi_berita = (strip_tags($key->isi));
					$isi = substr($isi_berita, 0, 50);

					$tahun = substr($key->tanggal, 0, 4);
					$dilihat = $key->dibaca;
					$isi = substr($isi_berita, 0, strrpos($isi, " "));
			?>
					<article class="item">
						<a href="<?= $url ?>" class="thumb">
							<img src="<?= $gambar ?>" alt="">
						</a>
						<div class="info">
							<time datetime="2020-06-30"><?= $tanggal ?></time>
							<h4 class="title usmall">
								<a href="<?= $url ?>">
									<?= $judul ?>
								</a>
							</h4>
						</div>
						<div class="clear"></div>
					</article>
			<?php }
			} ?>
		</div>
	</section>
<?php } ?>

<?php

	if ($agenda != NULL && $link != 'informasi/agenda') {

	?>
	<section class="widget widget-peru-posts-thumb">
		<h3 class="widget-title">Agenda Sekolah </h3>
		<div class="post-wrap">

		<?php
					foreach ($agenda as $rowa) :
						$tgl = substr($rowa['tanggal'], 8, 2);
						$tanggal = tgl_indo($rowa['tanggal']);
						$bulan = getBulan(substr($rowa['tanggal'], 5, 2));
						$isi_agenda = (strip_tags($rowa['isi']));
						$isi = substr($isi_agenda, 0, 50);
						$isi = substr($isi_agenda, 0, strrpos($isi, " "));
						$url =  base_url('informasi/detail/agenda/' . $rowa['seo']);
						$gambar = $rowa['gambar'];
						$judul = $rowa['judul'];
					?>
					<article class="item">
						<a href="<?= $url ?>" class="thumb">
							<img src="<?= $gambar ?>" alt="">
						</a>
						<div class="info">
							<time datetime="2020-06-30"><?= $tanggal ?></time>
							<h4 class="title usmall">
								<a href="<?= $url ?>">
									<?= $judul ?>
								</a>
							</h4>
						</div>
						<div class="clear"></div>
					</article>
			<?php endforeach; ?>
		</div>
	</section>
	<?php } ?>

	<section class="widget widget_tag_cloud">
		<h3 class="widget-title">Tautan Penting</h3>
		<div class="post-wrap">
			<div class="tagcloud">
				<?php foreach ($tautan_dinas as $rowt) :
					$gambar = $rowt->gambar;
					$url = $rowt->link ?>


					<a href="<?= $url ?>"><img style="width: 410px; " src="<?= $gambar ?>" alt=""></a>
					<!-- /.overlay -->

				<?php endforeach; ?>
			</div>
		</div>
	</section>
</aside>





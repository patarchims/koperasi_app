<section class="contolib-slider-area-two">
    <div class="contolib-slider-wrap owl-theme owl-carousel">
        <?php foreach ($slider as $row) :
            $gambar = $row['gambar'];
            $judul = $row['judul'];
        ?>
            <div class="contolib-slider-item">
                <img src="<?= $gambar ?>" alt="">
            </div>
        <?php endforeach; ?>
    </div>
</section>

<header class="header-area header-area-two">
    <div class="top-header-area" style="height: 60px; background-color:#dd0426;">
        <div class="container">
            <h4 class="entry-title">
                <marquee style="margin-top: 0px; color:white;" behavior="scroll" direction="left" scrollamount="8" onmouseover="this.stop();" onmouseout="this.start();"><?= $pengumuman ?></marquee>
            </h4>
        </div>
    </div>
</header>


<section class="news-details-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12">

                <div class="row align-items-center">
                    <div class="col-lg-8" style="text-align: center;">
                        <div class="section-title text-center">
                            <span>Info Sekolah</span>
                            <h2>Informasi Sekolah Terbaru</h2>
                        </div>
                    </div>

                </div>
                <section class="articles-area articles-area-two">

                    <div class="row">

                        <?php
                        foreach ($berita as $rowb) :
                            $isi_berita = (strip_tags($rowb['isi']));
                            $isi = substr($isi_berita, 0, 100);
                            $isi = substr($isi_berita, 0, strrpos($isi, " "));
                            $tgl = substr($rowb['tanggal'], 8, 2);
                            $tahun = substr($rowb['tanggal'], 0, 4);
                            $bln = getBulan(substr($rowb['tanggal'], 5, 2));
                            $url = base_url('informasi/detail/berita/' . $rowb['seo']);
                            $tanggal = $rowb['tanggal'];
                            $kategori = stripcslashes($rowb['kategori']);
                            $user = viewUser($rowb['input_user']);
                            $judul = stripcslashes($rowb['judul']);
                            $dilihat = $rowb['dibaca'];
                            $gambar = $rowb['gambar'];
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
                                            <h3 style="margin-bottom: 0px;"><?= $judul ?></h3>
                                        </a>
                                        <hr>

                                        <p><?= $isi ?></p>
                                        <a href="<?= $url ?>" class="read-more">
                                            Selengkapnya
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>



                    </div>

                </section>







            </div>
            <div class="col-lg-4 col-md-12">


                <aside class="widget-area" id="secondary">



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

            </div>
        </div>
    </div>
</section>


<section class="counter-area pt-100 pb-70">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter">
                    <i class="fas fa-users"></i>
                    <p>Siswa</p>
                    <h2>
                        <span class="odometer" data-count="<?= jlhSiswa('Aktif') ?>"></span>
                    </h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter">
                    <i class="fas fa-user-tie"></i>
                    <p>Guru & Pengawai</p>
                    <h2>
                        <span class="odometer" data-count="<?= JlhSdm() ?>"></span>
                    </h2>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter">
                    <i class="fas fa-trophy"></i>
                    <p>Prestasi</p>
                    <h2>
                        <span class="odometer" data-count="<?= JlhPrestasi() ?>"></span>
                    </h2>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="single-counter">
                    <i class="fas fa-handshake"></i>
                    <p>kerjasama</p>
                    <h2>
                        <span class="odometer" data-count="<?= JlhKerjasama() ?>"></span>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</section>


<?php if ($agenda != null) { ?>
    <section class="team-area-two ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="section-title text-left">
                        <span>Terbaru</span>
                        <h2>Agenda Sekolah</h2>
                    </div>
                </div>
                <div class="col-lg-4">
                    <a href="<?= base_url('informasi/agenda') ?>" class="default-btn two">Selengkapnya</a>
                </div>
            </div>
            <div class="team-wrap owl-theme owl-carousel">




                <?php
                $no = 0;
                foreach ($agenda as $rowb) :
                    $no++;
                    $tgl = substr($rowb['tanggal'], 8, 2);
                    $tanggal = tgl_indo($rowb['tanggal']);
                    $bulan = getBulan(substr($rowb['tanggal'], 5, 2));
                    $judul = stripcslashes($rowb['judul']);
                    $tahun = substr($rowb['tanggal'], 0, 4);
                    $isi_berita = (strip_tags($rowb['isi']));
                    $gambar = $rowb['gambar'];
                    $dilihat = $rowb['dibaca'];
                    $user = viewUser($rowb['input_user']);
                    $isi = substr($isi_berita, 0, 150);
                    $isi = substr($isi_berita, 0, strrpos($isi, " "));
                    $url = base_url('informasi/detail/agenda/' . $rowb['seo']);
                ?>

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
                                <h3 style="margin-bottom: 0px;"><?= $judul ?></h3>
                            </a>
                            <hr>

                            <p><?= $isi ?></p>
                            <a href="<?= $url ?>" class="read-more">
                                Selengkapnya
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>

            </div>
        </div>
    </section>
<?php } ?>



<?php if ($fasilitas != null) { ?>
    <section class="team-area-two ptb-100">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="section-title text-left">
                        <h2>Fasilitas Sekolah</h2>
                    </div>
                </div>

            </div>
            <div class="team-wrap owl-theme owl-carousel">


                <?php foreach ($fasilitas as $key) {
                    $url = base_url('tentangkami/detail/fasilitas/' . $key['seo']);
                    $gambar = $key['gambar'];
                    $judul = stripcslashes($key['judul']); ?>
                    <div class="single-team-two">
                        <img src="<?= $gambar ?>" alt="Image">
                        <div class="team-two-content">
                            <a href="<?= $url ?>">
                                <h3><?= $judul ?></h3>
                            </a>

                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>
<?php } ?>
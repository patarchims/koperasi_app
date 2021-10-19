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

                <div class="row">
                    <div class="col-lg-12">
                        <section class="faq-area ">


                            <div class="faq-accordion">

                                <ul class="accordion">

                                    <?php
                                    $no = 0;
                                    foreach ($record as $rowb) {
                                        $no++;
                                        $isi_berita = (strip_tags($rowb->isi));
                                        $isi = substr($isi_berita, 0, 150);
                                        $isi = substr($isi_berita, 0, strrpos($isi, " "));
                                        $tgl = substr($rowb->tanggal, 8, 2);
                                        $bln = getBulan(substr($rowb->tanggal, 5, 2));
                                        $url = base_url('infodinas/detail/berita/' . $rowb->seo);
                                        $tanggal = tgl_indo($rowb->tanggal);


                                       
                                        $judul = $rowb->judul;

                                        $dibaca =  $rowb->dibaca;
                                        $kategori =  $rowb->kategori;
                                        $gambar = $rowb->gambar;
                                        $user = viewUser($rowb->input_user);
                                        $tgl = substr($rowb->tanggal, 8, 2);
                                        $tahun = substr($rowb->tanggal, 0, 4);
                                        $bln = getBulan(substr($rowb->tanggal, 5, 2));
                                    ?>
                                        <li class="accordion-item">
                                            <a class="accordion-title <?= $no ?>" href="#">
                                                <i class="flaticon-plus"></i>
                                                <?= $judul ?>
                                            </a>
                                            <p class="accordion-content <?= $no ?>"><?= $isi_berita ?></p>
                                        </li>
                                    <?php } ?>

                                </ul>
                            </div>

                        </section>
                    </div>
                </div>







            </div>
            <div class="col-lg-4 col-md-12">


                <?php $this->load->view('front/sidebar'); ?>

            </div>
        </div>
    </div>
</section>




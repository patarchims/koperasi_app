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




<section class="contact-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="quick-contact">
                    <h3>Informasi Kontak </h3>
                    <ul>
                        <li>
                            <i class="flaticon-location"></i>
                        Alamat
                            <span><?=$identitas['alamat']?></span>
                        </li>
                        <li>
                            <i class="flaticon-telephone"></i>
                      Telepon
                            <a href="<?=$identitas['telp']?>"><?=$identitas['telp']?></a>
                         
                        </li>
                        <li>
                            <i class="flaticon-email"></i>
                            Email
                            <a href="<?=$identitas['email']?>"><span class="__cf_email__" data-cfemail="6008050c0c0f20030f0e140c09024e030f0d"><?=$identitas['email']?></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="contact-wrap">
                    <div class="contact-form">
                        <div class="section-title">
                            <h2><?=$title?></h2>
                        </div>
                        <form id="contactForm" action="<?= base_url('hubungikami') ?>" method="POST" >
                            <div class="row">
                            <?php
                                    if ($pesan != '') {
                                        echo '<div class="cf-msg"><div class="alert alert-success fade in"> <a class="close" data-dismiss="alert" href="#">×</a> <strong>Sukses!</strong> ' . $pesan . ' </div></div>';
                                    }
                                    ?>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control"  placeholder=" Name">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" class="form-control"  placeholder=" Email">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="number" name="nik" id="nik"  class="form-control" placeholder="No.KTP">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="number" name="hp" id="hp" class="form-control"  placeholder="No.HP">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="number" name="umur" id="umur" class="form-control"  placeholder="Umur">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control"  placeholder="Pekerjaan">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="alamat" id="alamat" class="form-control"  placeholder="Alamat">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="judul" id="judul" class="form-control"  placeholder="Subject/Keperluan">
                                       
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <div class="form-group">
                                        <textarea name="isi" class="form-control" id="isi" cols="30" rows="5" required data-error="Write your message" placeholder="Tulis Pesan"></textarea>
                                       
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <button type="submit" name="simpan" class="default-btn page-btn">
                               Kirim Pesan
                                    </button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



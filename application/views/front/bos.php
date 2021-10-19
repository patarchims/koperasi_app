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



        <section id="page-content-wrap">
            <div class="contact-page-wrap section-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">


                            <div class="row">
                                <div class="col-lg-12">
                                    <form class="form-horizontal" action="<?= current_url() ?>" method="POST">

                                        <div class="form-group row">
                                            <label for="" class="control-label col-md-2">Tahun</label>
                                            <div class="col-md-3">
                                                <select name="caritahun" class="form-control" onchange="submit()">
                                                    <?php
                                                    $sekarang = date('Y');
                                                    $awal = 2019;
                                                    $akhir = date('Y');
                                                    for ($i = $akhir; $i >= $awal; $i--) {
                                                        $cl = ($i == $caritahun) ? 'selected' : '';
                                                        echo '<option value="' . $i . '" ' . $cl . '>' . $i . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- end col-lg-12 -->
                            </div><!-- end row -->

                            <div class="row">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="table-responsive mt-60">
                                        <table class="table  table-bordered">
                                            <thead class="text-center">
                                                <tr>
                                                    <th>No</th>
                                                    <th>SNP/ Program</th>
                                                    <th>RKAS</th>
                                                    <th>Realisasi</th>
                                                    <th>Sisa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $no = 0;
                                                $trkas = 0;
                                                $treal = 0;
                                                foreach ($record['hasil'] as $row) {
                                                    $no++;
                                                    echo '<tr>
                                        <td class="text-center">' . $no . '</td>
                                        <td>' . stripslashes($row['uraian']) . '</td>
                                        <td class="text-right">' . rupiah($row['rkas']) . '</td>
                                        <td class="text-right">' . rupiah($row['realisasi']) . '</td>
                                        <td class="text-right">' . rupiah($row['sisa']) . '</td>
                                      </tr>';
                                                    $trkas = $trkas + $row['rkas'];
                                                    $treal = $treal + $row['realisasi'];
                                                }
                                                $tsisa = $trkas - $treal;
                                                ?>

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2" class="text-center">Total</td>
                                                    <td class="text-right"><?= rupiah($trkas) ?></td>
                                                    <td class="text-right"><?= rupiah($treal) ?></td>
                                                    <td class="text-right"><?= rupiah($tsisa) ?></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div><!-- end col-md-8-->

                            </div><!-- end row -->

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</section>
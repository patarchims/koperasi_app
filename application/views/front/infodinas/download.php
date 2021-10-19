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

    <div id="page-content-wrap">
      <div class="blog-page-content-wrap section-padding">
        <div class="container">
          <div class="row">
            <!-- Blog content Area Start -->
            <div class="col-lg-8">




              <div class="blog-page-contant-start ">


                <div class="row">

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

                  <div class="table-responsive">
                    <table id="mytable" class="table table_template darklinks table-bordered">
                      <br>
                      <br>
                      <thead>
                        <tr>
                          <th width="1%">No</th>
                          <th>Judul</th>
                          <th width="1%">Didownload</th>
                          <th width="1%">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 0;
                        foreach ($record as $row) {
                          $no++;
                          echo '<tr>
                              <td>' . $no . '</td>
                              <td>' . stripcslashes($row->judul) . '</td>
                              <td>' . $row->dibaca . '</td>
                              <td>' . aksiDownload('infodinas/downloadfile', enkrip($row->id_download), 'Download') . '</td>
                      </tr>';
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>


                <div class="col-lg-12 col-md-12">
                  <div class="pagination-area">
                    <!-- <a href="#" class="prev page-numbers"><i class="fas fa-angle-double-left"></i></a>
							<a href="#" class="page-numbers">1</a>
							<span class="page-numbers current" aria-current="page">2</span>
							<a href="#" class="page-numbers">3</a>
							<a href="#" class="page-numbers">4</a>
							<a href="#" class="next page-numbers"><i class="fas fa-angle-double-right"></i></a> -->
                    <?php echo $this->pagination->create_links(); ?>
                  </div>
                </div>
              </div>
            </div>
            <!-- Blog content Area End -->

            <div class="col-lg-4 sidebar sidebar-right widget-area">

              <?php $this->load->view('front/sidebar'); ?>

            </div>
          </div>
        </div>
      </div>
    </div>


  </div>

</section>
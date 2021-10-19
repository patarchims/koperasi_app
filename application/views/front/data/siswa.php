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


    <section id="page-content-wrap">
      <div class="contact-page-wrap section-padding">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">


              <div class="table-responsive">
                <table id="mytable" class="table table_template darklinks table-bordered" style="color:black">
                  <thead style="color:black">
                    <tr>
                      <th width="1%">No.</th>
                      <th width="1%">Nama</th>
                      <th>Jenis Kelamin</th>
                      <th width="1%">Agama</th>
                      <th width="1%">Tahun Masuk</th>
                      <th width="1%">Kelas</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div>


            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</section>
    







<script>
  $(document).ready(function() {

    table = $('#mytable').DataTable({

      "processing": true,
      "serverSide": true,
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('data/get_siswa') ?>",
        "type": "POST"
      },


      "columnDefs": [{
          "targets": [0, 1],
          "orderable": false,
        },
        {
          "targets": [0],
          "className": "text-nowrap",
        },
      ],

    });


  });
</script>
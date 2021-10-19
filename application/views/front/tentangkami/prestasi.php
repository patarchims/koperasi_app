
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
                    <tr >
                      <th width="1%">No</th>
                      <th>Tanggal</th>
                      <th>Event</th>
                      <th>Peserta</th>
                      <th>Juara</th>
                      <th>Tingkat</th>
                      <th width="1%">Detail</th>
                    </tr>
                  </thead>

                </table>
              </div>


            </div>
          </div>
        </div>
      </div>

    </section>
  </div></section>





















<script>
  $(document).ready(function() {

    table = $('#mytable').DataTable({

      "processing": false,
      "serverSide": true,
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('tentangkami/get_prestasi') ?>",
        "type": "POST"
      },


      "columnDefs": [{
          "targets": [0, 6],
          "orderable": false,
        },
        {
          "targets": [0, 6],
          "className": 'text-nowrap',
        }
      ],

    });


  });
</script>
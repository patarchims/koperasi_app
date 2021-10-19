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
      <!-- Blog content Area Start -->
      <div class="col-lg-12">


        <div class="row">

          <!-- Data Table Here -->
          <div class="table-responsive">
            <table id="mytable" class="table table_template darklinks table-bordered" style="color:black">
              <thead style="color:black">
                <tr>
                  <th width="1%">No</th>
                  <th>Judul</th>
                  <th width="1%">Didownload</th>
                  <th width="1%">Aksi</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>

        </div>


      </div>
      <!-- Blog content Area End -->

      <!-- Sidebar Area Start -->

      <!-- Sidebar Area End -->
    </div>


  </div>
</section>








<script>
  $(document).ready(function() {

    table = $('#mytable').DataTable({

      "processing": false,
      "serverSide": true,
      "order": [],

      "ajax": {
        "url": "<?php echo base_url('download/get_download') ?>",
        "type": "POST"
      },


      "columnDefs": [{
          "targets": [0, 3],
          "orderable": false,
        },
        {
          "targets": [0, 2, 3],
          "className": 'text-nowrap',
        }
      ],

    });


  });
</script>
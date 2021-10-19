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



    <div class="table-responsive">
      <table id="mytable" class="table table_template darklinks table-bordered" style="color:black">
        <thead style="color:black">
          <tr>
            <th width="1%">No</th>
            <th>Judul</th>
            <th>Jenis Kerjasama</th>
            <th>Bidang Kerjasama</th>
            <th>Rekanan</th>
            <th>Tanggal Kerjasama</th>
            <th width="1%">Detail</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
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
        "url": "<?php echo base_url('tentangkami/get_kerjasama') ?>",
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
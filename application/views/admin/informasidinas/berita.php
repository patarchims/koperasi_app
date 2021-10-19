<div class="row">
    <!-- begin col-12 -->
    <div class="col-md-12">
    	<!-- begin result-container -->
        <div class="result-container">
        	<!-- begin input-group -->
        	<form action="<?=base_url($link)?>" method="post" accept-charset="utf-8">
	            <div class="input-group input-group-lg m-b-20">
	                <input type="text" name="cari" class="form-control input-lg input-white" value="<?=$cari?>" placeholder="Cari Berita" />
	                <div class="input-group-append">
	                    <button type="submit" class="btn btn-primary btn-xs"><i class="fa fa-search fa-fw"></i> Search</button>
	                    
	                </div>
	            </div>
        	</form>
            <!-- end input-group -->
            
            <!-- begin result-list -->
            <ul class="result-list">
                
                	<?php 
                	foreach ($record as $b) {
                		  $isi_berita =(strip_tags($b->isi)); 
                          $isi = substr($isi_berita,0,300); 
                          $isi = substr($isi_berita,0,strrpos($isi," "));
                	echo'<li>
		                	<a href="'.base_url('informasidinas/beritadetail/'.$b->seo).'" class="result-image" style="background-image: url('.$b->gambar.')"></a>
		                    <div class="result-info">
		                        <h4 class="title"><a href="'.base_url('informasidinas/beritadetail/'.$b->seo).'">'.stripcslashes($b->judul).'</a></h4>
		                        <p class="desc">
		                            '.$isi.'
		                        </p>
		                        <div class="btn-row pull-right">
		                            <a class="btn btn-primary" href="'.base_url('informasidinas/beritadetail/'.$b->seo).'" data-toggle="tooltip" data-container="body" data-title="Selengkapnya">Selengkapnya...</a>
		                            
		                        </div>
		                    </div>
		                    
		                </li>';
                	}
                	?>
                    
                
            </ul>
            <!-- end result-list -->
            <!-- begin pagination -->
            <div class="clearfix m-t-20">
				<ul class="pagination pull-right">
					<?php echo $this->pagination->create_links(); ?>
				</ul>
            </div>
            <!-- end pagination -->
        </div>
        <!-- end result-container -->
    </div>
    <!-- end col-12 -->
</div>
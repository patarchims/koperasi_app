<div class="card">
  <div class="card-header card-inverse bg-dark">
    <h4 class="card-title"><?=$title?></h4>
  </div>
  <div class="card-header">
    <ul class="nav nav-pills card-header-pills">
      <?php
        $no=0;
        foreach ($record as $key) {
          $no++;
          $cl=($no==1)?'active':'';
          echo '<li class="nav-item"><a class="nav-link '.$cl.'" data-toggle="tab" href="#'.$key->seo.'">'.$key->judul.'</a></li>';
        }
      ?>
    </ul>
  </div>
  <div class="card-block">
    <div class="tab-content p-0 m-0">
      <?php
        $no=0;
        foreach ($record as $row) {
          $no++;
          $cl=($no==1)?'active show':'';
          echo'<div class="tab-pane fade '.$cl.'" id="'.$row->seo.'">
              '.$row->isi.'
              </div>';
        }
      ?>
    </div>
  </div>
</div>
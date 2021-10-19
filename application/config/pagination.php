<?php if (!defined('BASEPATH')) exit('Direct Access Not Allowed');

$config['first_link']       = false;
$config['last_link']        = false;

// $config['first_tag_open']   = '<li class="page-item">';
// $config['first_tagl_close'] = '</li>';

// $config['full_tag_open']    = '<a> ';
// $config['full_tag_close']   = '</a>';
// $config['num_tag_open']     = '<li>';
// $config['num_tag_close']    = '</li>';


// <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
//<li class="page-item active"><a class="page-link" href="#">1</a></li>
//<li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li> -->

// <!-- <a href="#0"><i class="fas fa-angle-left"></i></a> <a href="#0">01</a>
// <a href="#0" class="active">02</a> <a href="#0">03</a>
// <a href="#0"><i class="fas fa-angle-right"></i></a> -->

$config['prev_link']        = '<li>
<span class="page-link page-links" href="#">
    <i class="bx bx-chevrons-left"></i>
</span>
</li>';
$config['next_link']        = '<li>
<span class="page-link page-links" href="#">
    <i class="bx bx-chevrons-right"></i>
</span>
</li>';


// $config['prev_link']        = '<span href="#" class="prev page-numbers">
// <i class="bx bx-left-arrow-alt"></i>
// </span>';
// $config['next_link']        = '<span href="#" class="prev page-numbers">
// <i class="bx bx-right-arrow-alt"></i>
// </span>';

// $config['cur_tag_open']     = ' <li class="active"> <a>';
// $config['cur_tag_close']    = '</li></a>';

// $config['prev_link']        = '<i class="fa fa-angle-left"></i>';
// $config['full_tag_open']    = '<a class="active">';
// $config['full_tag_close']   = '</a>';
// $config['num_tag_open']     = '<li class="page-item" ><a class="page-link" >';
// $config['num_tag_close']    = '</span></li>';
// $config['next_tag_open']    = ' <li>  <span>';
// $config['next_tagl_close']  = '</span></li>';
// $config['prev_tag_open']    = ' <li>  <a>';
// $config['prev_tagl_close']  = '</a></li>';
// $config['first_tag_open']   = '';
// $config['first_tagl_close'] = '';
// $config['last_tag_open']    = '<li class="page-item"> <a class="page-link" >';
// $config['last_tagl_close']  = '</span></li>';


// $config['first_tag_open']  = '<li class="page-item">';
// $config['first_tag_close'] = '</li>';

// $config['full_tag_open']    = '<nav><ul class="pagination">';
// $config['full_tag_close']   = '</ul></nav>';
$config['cur_tag_open']     = '<li class="page-item active"><a class="page-link">';
$config['cur_tag_close']    = '</a></li>';
$config['num_tag_open']     = ' <li class="page-item"><span class="page-link">';
$config['num_tag_close']    = '</span></li>';
// $config['attributes']       = array('class' => 'page-link');

// <div class="row justify-content-center mt-4">
// <div class="col-lg-8 text-center">
//   <nav aria-label="Page navigation example">
//     <ul class="pagination justify-content-center mb-0">
//       <li class="page-item"><a class="page-link  rounded-left" href="#">Previous</a></li>
//       <li class="page-item active"><a class="page-link" href="#">1</a></li>
//       <li class="page-item"><a class="page-link" href="#">2</a></li>
//       <li class="page-item"><a class="page-link" href="#">3</a></li>
//       <li class="page-item"><a class="page-link  rounded-right" href="#">Next</a></li>
//     </ul>
//   </nav>
// </div>
// </div>
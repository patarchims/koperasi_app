<?php
Class Cetak extends CI_Controller{
    var $data;

    function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        $this->load->library('pdf');
        $this->load->library('Curl');
        $this->data = array(
            'namawebsite'=>identitas('nama'),
            'logo'=>identitas('logo'),
            'api'=>identitas('api'),
            'footer'=>identitas('footer'),
            
        );        
    } 
    
    function index(){
        
         }
    function suratpengajuan($seo){
      $data=$this->data;
      $this->pdf->kosong();
      $sekolah=dekrip($seo);
      $check=api($data['api'].'/sekolahpimpinan',array("sekolah"=>$sekolah));
      if($check->action==true)
      {
      $data['pimpinan']=$check->hasil;
      $data['rows']=$this->model_app->edit('web_domain',array('sekolah'=>$sekolah))->row_array();
      $this->load->view('sekolah/cetak/suratpengajuan',$data);
      }
      else
      {
        echo $check->pesan;
      }
    }

    
    
}//controller
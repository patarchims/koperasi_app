<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informasidinas extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	var $data;

    function __construct(){
        parent::__construct(); // needed when adding a constructor to a controller
        $identitas=$this->model_app->edit('identitas',array('id'=>1))->row_array();
        $notif=api('api/notifikasi',array("npsn"=>$identitas['kode'],"uid"=>$identitas['uid']));
        $this->data = array(
            'identitas'=>$identitas,
            'id_level'=>$this->session->level,
            'notif'=>$notif->jumlah,
            'header'=>'Tentang Dinas Pendidikan',
            'ctrl'=>'informasidinas'
        );
        
    }
    function index(){
        redirect('dashboard');
    }

    function profil(){
        $data=$this->data;
        $data['title']='Profil Dinas Pendidikan';
        $data['link']='informasidinas/profil';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            $cek=api('api/profil',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid']));
            if($cek->action==true)
            {
                $data['record']=$cek->hasil;
            }
            $this->template->load('admin','admin/informasidinas/profil',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function berita($hal=1){
        $data=$this->data;
        $data['title']='Berita Dinas Pendidikan';
        $data['link']='informasidinas/berita';
        $data['header']='Berita Dinas';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            if(isset($_POST['cari']))
            {
              $this->session->set_userdata(array('cariberita'=>postnumber('cari')));
            }
          $cari=$this->session->cariberita;
          $data['cari']=$cari;
          $config['per_page'] = 6;

          $row=api('api/beritadinas',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'jumlah'=>$config['per_page'],'halaman'=>$hal,'cari'=>$cari));

          $jumlah=$row->total;
          $config['base_url'] = base_url().'informasidinas/berita';
          $config['use_page_numbers'] = TRUE;
          $config['total_rows'] = $jumlah;
           
          $dari = ($hal-1) * $config['per_page'];
          
          if (is_numeric($dari)) {
            $data['record'] = $row->hasil;
            
          }else{
            redirect();
          }
          $this->pagination->initialize($config);
          $this->template->load('admin','admin/informasidinas/berita',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function beritadetail($seo){
        $data=$this->data;
        $data['link']='informasidinas/berita';
        $data['header']='Berita Dinas Pendidikan';

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
          $row=api('api/beritadetail',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'seo'=>$seo));
          $hasil=$row->hasil;
          $data['title']=stripcslashes($hasil->judul);
          $data['rows']=$hasil;
          $this->template->load('admin','admin/informasidinas/beritadetail',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function download($hal=1){
        $data=$this->data;
        $data['title']='Daftar Download';
        $data['link']='informasidinas/download';
        

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            if(isset($_POST['cari']))
            {
              $this->session->set_userdata(array('caridownload'=>postnumber('cari')));
            }
          $cari=$this->session->caridownload;
          $data['cari']=$cari;
          $config['per_page'] = 10;

          $row=api('api/downloaddinas',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'jumlah'=>$config['per_page'],'halaman'=>$hal,'cari'=>$cari));

          $jumlah=$row->total;
          $config['base_url'] = base_url().'informasidinas/download';
          $config['use_page_numbers'] = TRUE;
          $config['total_rows'] = $jumlah;
           
          $dari = ($hal-1) * $config['per_page'];
          
          if (is_numeric($dari)) {
            $data['record'] = $row->hasil;
            
          }else{
            redirect();
          }
          $this->pagination->initialize($config);
          $this->template->load('admin','admin/informasidinas/download',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    function downloadfile($seo){
        $data=$this->data;
        $id=dekrip($seo);
        $row=api('api/downloadfile',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'seo'=>$id));
       
        redirect($row->gambar);
    }


    function pengumuman($hal=1){
        $data=$this->data;
        $data['title']='Daftar Pengumuman';
        $data['link']='informasidinas/pengumuman';
        

        if(bisaBaca($data['link'],$data['id_level']))
        {
            
            if(isset($_POST['cari']))
            {
              $this->session->set_userdata(array('caripengumuman'=>postnumber('cari')));
            }
          $cari=$this->session->caripengumuman;
          $data['cari']=$cari;
          $config['per_page'] = 10;

          $row=api('api/pengumumandinas',array("npsn"=>$data['identitas']['kode'],"uid"=>$data['identitas']['uid'],'jumlah'=>$config['per_page'],'halaman'=>$hal,'cari'=>$cari));

          $jumlah=$row->total;
          $config['base_url'] = base_url().'informasidinas/pengumuman';
          $config['use_page_numbers'] = TRUE;
          $config['total_rows'] = $jumlah;
           
          $dari = ($hal-1) * $config['per_page'];
          
          if (is_numeric($dari)) {
            $data['record'] = $row->hasil;
            
          }else{
            redirect();
          }
          $this->pagination->initialize($config);
          $this->template->load('admin','admin/informasidinas/pengumuman',$data);

        }
        else
        {
            redirect('dashboard');
        }
    }

    
    
} //controller
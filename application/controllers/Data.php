<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data extends CI_Controller {

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
        $side_bd=api('api/sidebar',array("npsn"=>$identitas['kode'],"uid"=>$identitas['uid'],'jumlah'=>'6'));
        $this->data = array(
            'identitas'=>$identitas,
            'ctrl'=>'data',
            'tabs'=> menuwebsite(),
            'agenda'=>$this->model_app->agenda(),
            'kategori'=>$this->model_app->kategori_berita(),            
            'berita_dinas'=>$side_bd->berita,
            'tautan_dinas'=>$side_bd->tautan,
            'koneksi_api'=>$side_bd->action
            

        );
        
    } 

    function index(){
    	redirect();
    }
	
	function siswa(){
		$data=$this->data;
		$data['link']='data/siswa';
        $data['title']='Data Siswa';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
		    $this->template->load('front','front/data/siswa',$data);
	}

	function get_siswa()
    {
        $data=$this->data;
        $this->load->model('model_siswaaktif');
       
        
        $where=array('status'=>'Aktif');
        
        
        $list = $this->model_siswaaktif->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $nama=stripcslashes($field->nama);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
            
            $row[] = $nama;
            $row[] = viewKodeApp('KELAMIN',$field->jk);
            $row[] = viewKodeApp('AGAMA',$field->agama);
            $row[] = substr($field->tgl_masuk,0,4);
            $row[] = viewKelas($field->id_siswa);
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_siswaaktif->count_all($where),
            "recordsFiltered" => $this->model_siswaaktif->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function guru(){
    $data=$this->data;
    $data['link']='data/guru';
        $data['title']='Data Guru';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $this->template->load('front','front/data/guru',$data);
  }

  function pegawai(){
    $data=$this->data;
    $data['link']='data/pegawai';
        $data['title']='Data Pegawai';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $this->template->load('front','front/data/pegawai',$data);
  }

  function get_sdm($seo)
    {
        $data=$this->data;
        $this->load->model('model_sdm');
       
        
        $where=array('jenis'=>$seo);
        
        
        $list = $this->model_sdm->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $nama=stripcslashes($field->nama);
            $foto=gambarAws($field->gambar);
            
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = $nama;
            $row[] = viewKodeApp('KELAMIN',$field->jk);
            $row[] = viewKodeApp('PENDIDIKAN',$field->pendidikan);
            $row[] = stripcslashes($field->alumni);
            $row[] = stripcslashes($field->jabatan);
            $row[] = aksiDetail('data/detail',enkrip($field->id_guru),'Detail');
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_sdm->count_all($where),
            "recordsFiltered" => $this->model_sdm->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    function detail($seo){
        $data=$this->data;
        $id=dekrip($seo);
        
        $row=$this->model_app->edit('guru',array('id_guru'=>$id))->row_array();
        $data['title']=stripcslashes($row['nama']);
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $data['gambar']=gambarAws($row['gambar']);
        $data['hal']=strtolower($row['jenis']);
        $data['rows']=$row;
    
        $this->template->load('front','front/data/detail',$data);
    }

	
	
} //controller

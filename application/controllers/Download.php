<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Download extends CI_Controller {

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
            'ctrl'=>'download',
            'tabs'=> menuwebsite(),
            'agenda'=>$this->model_app->agenda(),
            'kategori'=>$this->model_app->kategori_berita(),            
            'berita_dinas'=>$side_bd->berita,
            'tautan_dinas'=>$side_bd->tautan,
            'koneksi_api'=>$side_bd->action
            

        );
        
    } 

    
	
	function index(){
		$data=$this->data;
		$data['link']='download';
        $data['title']='Data Download';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        
		    $this->template->load('front','front/download',$data);
	}

    function file($seo){
        $data=$this->data;
        $id=dekrip($seo);
        $row=$this->model_app->edit('download',array('id_download'=>$id))->row_array();
        $this->db->query("CALL download($id)");
        redirect($row['gambar']);
    }

	function get_download()
    {
        $data=$this->data;
        $this->load->model('model_download1');
        $data['link']='download';
        $where=array();
        
        
        $list = $this->model_download1->get_datatables($where);
        $no = $_POST['start'];
        $record=array();
        foreach ($list as $field) {
            
            $judul=stripcslashes($field->judul);
            
                $berkas=aksiDownload('download/file',enkrip($field->id_download),'Download');
           
            $no++;
            $row=array();
            $row[] = $no;
            $row[] = $judul;
            $row[] = $field->dibaca;
            $row[] = $berkas;
           
            
            $record[] = $row;
        }
        
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->model_download1->count_all($where),
            "recordsFiltered" => $this->model_download1->count_filtered($where),
            "data" => $record,
        );
        //output dalam format JSON
        echo json_encode($output);
    }

    

	
	
} //controller

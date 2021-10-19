<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends CI_Controller {

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
            'ctrl'=>'gallery',
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
	
	function foto(){
		$data=$this->data;
		$data['link']='gallery/foto';
        $data['title']='Gallery Foto';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $data['record']=$this->model_app->view_ordering('album_foto','id_album','desc');
		$this->template->load('front','front/gallery/foto',$data);
	}

    function video(){
        $data=$this->data;
        $data['link']='gallery/video';
        $data['title']='Gallery Video';
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $data['record']=$this->model_app->view_ordering('album_video','id_album','desc');
        $this->template->load('front','front/gallery/video',$data);
    }

    function detail($hal,$seo){
        $data=$this->data;
        $data['link']='gallery/detail';
        $where=array('seo'=>$seo);
        if($hal=='foto')
        {
            $data['header']='Foto';
            $row=$this->model_app->edit('album_foto',$where)->row_array();
            $where1=array('id_album'=>$row['id_album']);
            $data['record']=$this->model_app->view_where_ordering('foto',$where1,'id_foto','asc');
        }
        else if($hal=='video')
        {
            $data['header']='Video';
            $row=$this->model_app->edit('album_video',$where)->row_array();
            $where1=array('id_album'=>$row['id_album']);
            $data['record']=$this->model_app->view_where_ordering('video',$where1,'id_video','asc');
        }
        $data['title']=stripcslashes($row['judul']);
        $data['deskripsi']=$data['identitas']['deskripsi'];
        $data['keyword']=$data['identitas']['keyword'];
        $data['rows']=$row;
        $data['hal']=$hal;
        $data['gambar']=$row['gambar'];
        $this->template->load('front','front/gallery/detail',$data);
    }

    

	
	
} //controller

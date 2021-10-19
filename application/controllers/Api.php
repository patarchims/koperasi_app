<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {

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
	
	function index(){
		exit('No direct script access allowed');
	}

	function uid(){
		$obj = json_decode(file_get_contents("php://input",true));	       
		if ($obj != ''){
			$npsn=$obj->npsn;
    		$uid=$obj->uid;
    		$url=$obj->url;

				$cek = $this->model_app->view_where('identitas',array('kode'=>$npsn));
			    $total = $cek->num_rows();
				if ($total > 0)
				{
					$r=$cek->row_array();
					$this->model_app->update('identitas',array('uid'=>$uid,'api'=>$url),array('id'=>$r['id']));
					
					if($this->db->affected_rows()>0)
						{
					
							$response=array("action"=>true, "pesan"=>"UID Berhasil di Update","hasil"=>array());
						}
						else
						{
							$response=array("action"=>false, "pesan"=>"UID Berhasil di Update", "hasil"=>array());
						}
					

					
				}
				else
				{
						
					$response=array("action"=>false, "pesan"=>"NPSN Salah", "hasil"=>array());
					
				}
			
			
			echo json_encode($response);
		}
		else
		{
			exit('No direct script access allowed');
		}
	}

	function sekolahpimpinan(){
		$obj = json_decode(file_get_contents("php://input",true));	       
		if ($obj != ''){
			$sekolah=$obj->sekolah;
    		$cek = $this->db->query("SELECT a.nama_kepsek, a.nip_kepsek, b.nama, b.wilayah FROM bos_pimpinan as a JOIN bos_sekolah as b on a.sekolah=b.id WHERE a.sekolah='$sekolah' AND a.tahun='2020'");
			$total = $cek->num_rows();
				if ($total > 0)
				{
					$r=$cek->row_array();
					$response=array("action"=>true, "pesan"=>"Data Berhasil Diambil", "hasil"=>array('nama_kepsek'=>$r['nama_kepsek'],
									  'nip_kepsek'=>$r['nip_kepsek'],
									  'wilayah'=>$r['wilayah'],
									  'nama_sekolah'=>$r['nama']
										));
					
				}
				else
				{
						
					$response=array("action"=>false, "pesan"=>"Data Pimpinan Tidak Ada Pada Aplikasi Dana BOS (Lengkapi Terlebih Dahulu Nama Kepala Sekolah Beserta NIP dengan Benar).", "hasil"=>array());
					
				}
			
			
			echo json_encode($response);
		}
		else
		{
			exit('No direct script access allowed');
		}
	}

	

	

	
} //controller

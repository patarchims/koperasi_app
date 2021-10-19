<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Config extends CI_Controller {

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
        if(isset($_POST['cari']))
        {
            $this->session->set_userdata(array('modul'=>postnumber('modul'),'modul_sekolah'=>postnumber('modul_sekolah')));
        }
        $identitas=$this->model_app->edit('identitas',array('id'=>1))->row_array();
        $notif=api('api/notifikasi',array("npsn"=>$identitas['kode'],"uid"=>$identitas['uid']));
        $this->data = array(
            'identitas'=>$identitas,
            'id_level'=>$this->session->level,
            'modul'=>$this->session->modul,
            'notif'=>$notif->jumlah,
            'ctrl'=>'config',
            'header'=>'Konfigurasi Menu',


        );
        
        
    }
     


	function modul(){
       $data=$this->data;
		if($data['id_level']==1 AND $this->session->id_user==1)
        {
         $data['title']='Modul';
         $data['ctrl']='modul';
         $data['link']='config/modul';

      	 $data['record']=$this->model_app->view_ordering('modul','urutan','ASC');
		 $this->template->load('admin','admin/config/modul/modul',$data);
			
		}
		else
		{
			redirect('dashboard');
		}
    }

    function modultambah(){
        $data=$this->data;
        $data['title']='Form Tambah Modul';
        $data['ctrl']='modul';
        $data['link']='config/modul';
        if($this->session->level==1 AND $this->session->id_user==1)
        {
            if(isset($_POST['tambah']))
            {
                
                
                $data=array('nama_modul'=>$this->input->post('nama'),
                            'controller'=>$this->input->post('controller'),
                            'urutan'=>$this->input->post('urutan'),
                            'icon'=>$this->input->post('icon'));
                $simpan=$this->model_app->insert('modul',$data);
                $id = $this->db->insert_id();
                $modul_akses=[]; 
                $level=$this->db->query("SELECT * FROM level")->result_array();
                foreach ($level as $row1) {
                    $data2=array('id_modul'=>$id,
                                'id_level'=>$row1['id_level']);
                    array_push($modul_akses, $data2);
                }
                $this->model_app->insert_multiple('modul_akses',$modul_akses);
                  if($simpan)
                    {
                        $this->session->set_flashdata('sukses',"Data Modul Berhasil Disimpan");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Modul Gagal Disimpan");
                    }
                redirect('config/modul');
            }
            
            else
            {
        
                $this->template->load('admin','admin/config/modul/tambah',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }

    function moduledit($seo=''){
        $data=$this->data;
        $data['title']='Form Edit Modul';
        $data['ctrl']='modul';
        $data['link']='config/modul';
        if($this->session->level=='1' AND $this->session->id_user==1)
        {
            if(isset($_POST['edit']))
            {
                $data=array('nama_modul'=>$this->input->post('nama'),
                            'controller'=>$this->input->post('controller'),
                            'urutan'=>$this->input->post('urutan'),
                            'icon'=>$this->input->post('icon'));
                $where=array('id_modul'=>$this->input->post('id'));
                $update=$this->model_app->update('modul',$data,$where);
                if($update)
                    {
                        $this->session->set_flashdata('sukses',"Data Modul Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Modul Gagal Diedit");
                    }
                redirect('config/modul');
            }
            
            else
            {
         $id=dekrip($seo);

         $data['rows']=$this->model_app->edit('modul',array('id_modul'=>$id))->row_array();
          $this->template->load('admin','admin/config/modul/edit',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }


    function modulhapus(){
       if($this->session->level==1 AND $this->session->id_user==1)
            {
                
                $where=array('id_modul'=>dekrip($this->uri->segment('3')));
                $this->model_app->delete('modul',$where);
                $delete=$this->model_app->delete('modul_akses',$where);
                if($delete)
                    {
                        $this->session->set_flashdata('sukses',"Data Modul Berhasil Dihapus");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Modul Gagal Dihapus");
                    }
                redirect('config/modul');
            }
            else
        {
            redirect('dashboard');
        }
    }



    function menu(){
      $data=$this->data;
      $data['title']='Menu';
      $data['ctrl']='modul';
      $data['link']='config/menu';
         
        if($this->session->level==1 AND $this->session->id_user==1)
        {
          
         $data['record']=$this->model_app->view_menu_admin($data['modul']);
         $this->template->load('admin','admin/config/menu/menu',$data);
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function menutambah(){
      $data=$this->data;
      $data['title']='Form Tambah Menu';
      $data['ctrl']='modul';
      $data['link']='config/menu';
        if($this->session->level==1 AND $this->session->id_user==1)
        {
            if(isset($_POST['tambah']))
            {
                
                $link=$this->input->post('controller').'/'.$this->input->post('link');
                $data=array('id_modul'=>$this->input->post('modul'),
                            'id_parent'=>$this->input->post('parent'),
                            'nama_menu'=>$this->input->post('nama'),
                            'link'=>$link,
                            'urutan'=>$this->input->post('urutan'));
                $simpan=$this->model_app->insert('menu',$data);
                $id = $this->db->insert_id();
                $menu_akses=[]; 
                $level=$this->db->query("SELECT * FROM level")->result_array();
                foreach ($level as $row1) {
                    $data2=array('id_menu'=>$id,
                                'id_level'=>$row1['id_level']);
                    array_push($menu_akses, $data2);
                }
                $this->model_app->insert_multiple('menu_akses',$menu_akses);
                if($simpan)
                    {
                        $this->session->set_flashdata('sukses',"Data Menu Berhasil Disimpan");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Menu Gagal Disimpan");
                    }
                redirect('config/menu');
            }
            
            else
            {
      
         
          $this->template->load('admin','admin/config/menu/tambah',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }

    function menuedit($seo=''){
      $data=$this->data;
      $data['title']='Form Edit Menu';
      $data['ctrl']='modul';
      $data['link']='config/menu';
        if($this->session->level==1 AND $this->session->id_user==1)
        {
            if(isset($_POST['edit']))
            {
                $link=$this->input->post('controller').'/'.$this->input->post('link');
                $data=array('id_modul'=>$this->input->post('modul'),
                            'id_parent'=>$this->input->post('parent'),
                            'nama_menu'=>$this->input->post('nama'),
                            'link'=>$link,
                            'urutan'=>$this->input->post('urutan'));
                $where=array('id_menu'=>$this->input->post('id'));
                $update=$this->model_app->update('menu',$data,$where);
                if($update)
                    {
                        $this->session->set_flashdata('sukses',"Data Menu Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Menu Gagal Diedit");
                    }
                redirect('config/menu');
            }
            
            else
            {
        $id=dekrip($seo);
        
         $data['row']=$this->model_app->edit('menu',array('id_menu'=>$id))->row_array();
          $this->template->load('admin','admin/config/menu/edit',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }


    function menuhapus(){
       if($this->session->level==1 AND $this->session->id_user==1)
            {
                
                $where=array('id_menu'=>dekrip($this->uri->segment('3')));
                $this->model_app->delete('menu',$where);
                $hapus=$this->model_app->delete('menu_akses',$where);
                if($hapus)
                  {
                      $this->session->set_flashdata('sukses',"Data Menu Berhasil Dihapus");
                  }
                  else
                  {
                      $this->session->set_flashdata('gagal',"Data Modul Gagal Dihapus");
                  }
                redirect('config/menu');
            }
            else
        {
            redirect('dashboard');
        }
    }

    function level(){
     $data=$this->data;
      $data['title']='Level User';
      $data['ctrl']='akses';
      $data['link']='config/level';
        if($this->session->level=='1' AND $this->session->id_user==1)
        {
        
         $data['record']=$this->model_app->view_ordering('level','id_level','ASC');
          $this->template->load('admin','admin/config/level/level',$data);
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function leveltambah(){
      $data=$this->data;
      $data['title']='Form Tambah Level User';
      $data['ctrl']='akses';
      $data['link']='config/level';
         
        if($this->session->level=='1' AND $this->session->id_user==1)
        {
            if(isset($_POST['tambah']))
            {
                
                
                  $save=array('nama_level'=>$this->input->post('level'),'unit'=>'T','wilayah'=>postnumber('wilayah'));
                

                $simpan=$this->model_app->insert('level',$save);
                $id = $this->db->insert_id();
                $modul_akses=[];
                $modul=$this->db->query("SELECT * FROM modul")->result_array();
                foreach ($modul as $row) {
                    $data1=array('id_modul'=>$row['id_modul'],
                                'id_level'=>$id);
                    array_push($modul_akses, $data1);
                }
                
               $this->model_app->insert_multiple('modul_akses',$modul_akses);

               $menu_akses=[]; 
               $menu=$this->db->query("SELECT * FROM menu")->result_array();
               foreach ($menu as $row1) {
                    $data2=array('id_menu'=>$row1['id_menu'],
                                'id_level'=>$id);
                    array_push($menu_akses, $data2);
                }
                $this->model_app->insert_multiple('menu_akses',$menu_akses);
                if($simpan)
                    {
                        $this->session->set_flashdata('sukses',"Data Level Berhasil Disimpan");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Level Gagal Disimpan");
                    }
              redirect('config/level');
            }
            
            else
            {
                $this->template->load('admin','admin/config/level/tambah',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }

 function leveledit($seo=''){
      $data=$this->data;
      $data['title']='Form Edit Level User';
      $data['ctrl']='akses';
      $data['link']='config/level';
         
        if($this->session->level=='1' AND $this->session->id_user==1)
        {
            if(isset($_POST['edit']))
            {
                
               
                  $simpan=array('nama_level'=>$this->input->post('level'),'unit'=>'T','wilayah'=>postnumber('wilayah'));
                
                $where=array('id_level'=>$this->input->post('id'));
                $edit=$this->model_app->update('level',$simpan,$where);
                if($edit)
                    {
                        $this->session->set_flashdata('sukses',"Data Level Berhasil Diedit");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Level Gagal Diedit");
                    }
                redirect('config/level');
            }
            
            else
            {
        $id=dekrip($seo);
        
         $data['row']=$this->model_app->edit('level',array('id_level'=>$id))->row_array();
         $this->template->load('admin','admin/config/level/edit',$data);
            }
        }
        else
        {
            redirect('dashboard');
        }
    }


     function levelhapus(){
       if($this->session->level=='1' AND $this->session->id_user==1)
            {
                
                $where=array('id_level'=>dekrip($this->uri->segment('3')));
                $hapus=$this->model_app->delete('level',$where);
                if($hapus)
                    {
                        $this->session->set_flashdata('sukses',"Data Level Berhasil Dihapus");
                    }
                    else
                    {
                        $this->session->set_flashdata('gagal',"Data Level Gagal Dihapus");
                    }
                redirect('level');
            }
            else
        {
            redirect('dashboard');
        }
    }

    function akses(){
        $data=$this->data;
        $data['title']='Level Akses User';
        $data['ctrl']='akses';
        $data['link']='config/akses';
        if($this->session->level=='1' AND $this->session->id_user==1)
        {
        if(isset($_POST['level_id']))
        {
            $this->session->set_userdata(array('level_id'=>postnumber('level_id')));
        }
        
          $level_id=$this->session->level_id;
        
        
         $data['level_id']=$level_id;
         
         $data['record']=$this->model_app->view_where_ordering('view_modul',array('id_level'=>$level_id),'urutan','ASC');
          $this->template->load('admin','admin/config/akses/akses',$data);
            
        }
        else
        {
            redirect('dashboard');
        }
    }

    function aksesmenu($id_modul,$level_id){
      $data=$this->data;
    if($this->session->level=='1' AND $this->session->id_user==1)
        {
         $data['id_modul']=$id_modul;
         $data['level_id']=$level_id;
         
         $data['title']='Level Akses User';
         $data['ctrl']='akses';   
         $data['link']='config/akses';
         
         $data['record']=$this->model_app->view_where_ordering('view_menu',array('id_level'=>$level_id,'id_modul'=>$id_modul),'id_parent,urutan','ASC');
      $this->template->load('admin','admin/config/akses/menu',$data);
      
    }
    else
    {
      redirect('dashboard');
    }
    }

  



    public function aksibaca() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $id=$postData['id'];
    $value=$postData['value'];
    
    $data=array('baca'=>$value);
    $where=array('id'=>$id);
    $this->model_app->update('modul_akses',$data,$where);

   
      
   }

   public function menubaca() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $id=$postData['id'];
    $value=$postData['value'];
    $data=array('baca'=>$value);
    $where=array('id'=>$id);
    $this->model_app->update('menu_akses',$data,$where);

      
      
   }

   public function menutulis() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $id=$postData['id'];
    $value=$postData['value'];
    $data=array('tulis'=>$value);
    $where=array('id'=>$id);
    $this->model_app->update('menu_akses',$data,$where);

      
      
   }

   public function menuubah() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $id=$postData['id'];
    $value=$postData['value'];
    $data=array('ubah'=>$value);
    $where=array('id'=>$id);
    $this->model_app->update('menu_akses',$data,$where);

      
      
   }

   public function menudelete() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $id=$postData['id'];
    $value=$postData['value'];
    $data=array('hapus'=>$value);
    $where=array('id'=>$id);
    $this->model_app->update('menu_akses',$data,$where);

      
      
   }


public function getmodul() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $data = getModul($postData);
    echo json_encode($data);

      
      
   }

public function getMenu() { 
      $postData = $this->input->post();
      // load model 
       
    // get data 
    $data = getMenu($postData);
    echo json_encode($data);
    }


// function modulsekolah(){
//        $data=$this->data;
//        $data['title']='Modul Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/modulsekolah';
//       if($this->session->level==1 OR $this->session->id_user==1)
//       {

//            $data['record']=$this->model_app->view_ordering('sekolah_modul','urutan','ASC');
//        $this->template->load('admin','admin/config/sekolah/modul',$data);
        
//       }
//       else
//       {
//         redirect('dashboard');
//       }
//     }


//     function modulsekolahtambah(){
//        $data=$this->data;
//        $data['title']='Modul Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/modulsekolah';
//         if($this->session->level==1 AND $this->session->id_user==1)
//         {
//             if(isset($_POST['tambah']))
//             {
//                 $data=array('nama_modul'=>$this->input->post('nama'),
//                             'controller'=>$this->input->post('controller'),
//                             'urutan'=>$this->input->post('urutan'),
//                             'icon'=>$this->input->post('icon'));
//                 $simpan=$this->model_app->insert('sekolah_modul',$data);
               
//                   if($simpan)
//                     {
//                         $this->session->set_flashdata('sukses',"Data Modul Sekolah Berhasil Disimpan");
//                     }
//                     else
//                     {
//                         $this->session->set_flashdata('gagal',"Data Modul Sekolah Gagal Disimpan");
//                     }
//                 redirect('config/modulsekolah');
//             }
            
//             else
//             {
         
//           $this->template->load('admin','admin/config/sekolah/modultambah',$data);
//             }
//         }
//         else
//         {
//             redirect('dashboard');
//         }
//     }


//     function modulsekolahedit(){
//        $data=$this->data;
//        $data['title']='Modul Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/modulsekolah';
//         if($this->session->level=='1' AND $this->session->id_user==1)
//         {
//             if(isset($_POST['edit']))
//             {
//                 $data=array('nama_modul'=>$this->input->post('nama'),
//                             'controller'=>$this->input->post('controller'),
//                             'urutan'=>$this->input->post('urutan'),
//                             'icon'=>$this->input->post('icon'));
//                 $where=array('id_modul'=>$this->input->post('id'));
//                 $update=$this->model_app->update('sekolah_modul',$data,$where);
//                 if($update)
//                     {
//                         $this->session->set_flashdata('sukses',"Data Modul Berhasil Diedit");
//                     }
//                     else
//                     {
//                         $this->session->set_flashdata('gagal',"Data Modul Gagal Diedit");
//                     }
//                 redirect('config/modulsekolah');
//             }
            
//             else
//             {
//          $id=dekrip($this->uri->segment('3'));
         
//          $data['title']='Modul';
//          $data['rows']=$this->model_app->edit('sekolah_modul',array('id_modul'=>$id))->row_array();
//           $this->template->load('admin','admin/config/sekolah/moduledit',$data);
//             }
//         }
//         else
//         {
//             redirect('dashboard');
//         }
//     }


//     function modulsekolahhapus(){
//        if($this->session->level==1 AND $this->session->id_user==1)
//             {
                
//                 $where=array('id_modul'=>dekrip($this->uri->segment('3')));
//                 $delete=$this->model_app->delete('sekolah_modul',$where);
                
//                 if($delete)
//                     {
//                         $this->session->set_flashdata('sukses',"Data Modul Berhasil Dihapus");
//                     }
//                     else
//                     {
//                         $this->session->set_flashdata('gagal',"Data Modul Gagal Dihapus");
//                     }
//                 redirect('config/modulsekolah');
//             }
//             else
//         {
//             redirect('dashboard');
//         }
//     }



//     function menusekolah(){
//         $data=$this->data;
//        $data['title']='Menu Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/menusekolah';
         
//         if($this->session->level==1 AND $this->session->id_user==1)
//         {
            
         
//          $data['title']='Menu Sekolah';
//          $data['record']=$this->model_app->view_menu_sekolah($data['modul_sekolah']);
//          $this->template->load('admin','admin/config/sekolah/menu',$data);
            
//         }
//         else
//         {
//             redirect('dashboard');
//         }
//     }

//     function menusekolahtambah(){
//       $data=$this->data;
//        $data['title']='Menu Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/menusekolah';
//         if($this->session->level==1 AND $this->session->id_user==1)
//         {
//             if(isset($_POST['tambah']))
//             {
                
//                 $link='sekolah/'.$this->input->post('link');
//                 $data=array('id_modul'=>$this->input->post('modul'),
//                             'id_parent'=>$this->input->post('parent'),
//                             'nama_menu'=>$this->input->post('nama'),
//                             'link'=>$link,
//                             'urutan'=>$this->input->post('urutan'));
//                 $simpan=$this->model_app->insert('sekolah_menu',$data);
                
//                 if($simpan)
//                     {
//                         $this->session->set_flashdata('sukses',"Data Menu Sekolah Berhasil Disimpan");
//                     }
//                     else
//                     {
//                         $this->session->set_flashdata('gagal',"Data Menu Sekolah Gagal Disimpan");
//                     }
//                 redirect('config/menusekolah');
//             }
            
//             else
//             {

//           $this->template->load('admin','admin/config/sekolah/menutambah',$data);
//             }
//         }
//         else
//         {
//             redirect('dashboard');
//         }
//     }

//     function menusekolahedit(){
//       $data=$this->data;
//        $data['title']='Menu Sekolah';
//        $data['ctrl']='modul';
//        $data['link']='config/menusekolah';
//         if($this->session->level==1 AND $this->session->id_user==1)
//         {
//             if(isset($_POST['edit']))
//             {
//                 $link='sekolah/'.$this->input->post('link');
//                 $data=array('id_modul'=>$this->input->post('modul'),
//                             'id_parent'=>$this->input->post('parent'),
//                             'nama_menu'=>$this->input->post('nama'),
//                             'link'=>$link,
//                             'urutan'=>$this->input->post('urutan'));
//                 $where=array('id_menu'=>$this->input->post('id'));
//                 $update=$this->model_app->update('sekolah_menu',$data,$where);
//                 if($update)
//                     {
//                         $this->session->set_flashdata('sukses',"Data Menu Sekolah Berhasil Diedit");
//                     }
//                     else
//                     {
//                         $this->session->set_flashdata('gagal',"Data Menu Sekolah Gagal Diedit");
//                     }
//                 redirect('config/menusekolah');
//             }
            
//             else
//             {
//         $id=dekrip($this->uri->segment('3'));
//          $data['title']='Menu';
//          $data['row']=$this->model_app->edit('sekolah_menu',array('id_menu'=>$id))->row_array();
//           $this->template->load('admin','admin/config/sekolah/menuedit',$data);
//             }
//         }
//         else
//         {
//             redirect('dashboard');
//         }
//     }


//     function menusekolahhapus(){
//        if($this->session->level==1 AND $this->session->id_user==1)
//             {
                
//                 $where=array('id_menu'=>dekrip($this->uri->segment('3')));
//                 $hapus=$this->model_app->delete('sekolah_menu',$where);
            
//                 if($hapus)
//                   {
//                       $this->session->set_flashdata('sukses',"Data Menu Sekolah Berhasil Dihapus");
//                   }
//                   else
//                   {
//                       $this->session->set_flashdata('gagal',"Data Modul Sekolah Gagal Dihapus");
//                   }
//                 redirect('config/menusekolah');
//             }
//             else
//         {
//             redirect('dashboard');
//         }
//     }


//     public function getmodulsekolah() { 
//       $postData = $this->input->post();
//       // load model 
       
//     // get data 
//     $data = getModulSekolah($postData);
//     echo json_encode($data);

      
      
//    }

//    public function getMenuSekolah() { 
//       $postData = $this->input->post();
//       // load model 
       
//     // get data 
//     $data = getMenuSekolah($postData);
//     echo json_encode($data);
//     }


} //controller
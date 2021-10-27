<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

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

	function __construct()
	{
		parent::__construct(); // needed when adding a constructor to a controller
		$this->load->library('Curl');
		$identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
		$this->data = array(
			'identitas' => $identitas,
			'id_level' => $this->session->level
		);
	}

	function index()
	{
		$this->load->library('mathcaptcha');
		$data = $this->data;

		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		// $this->form_validation->set_rules('captcha', 'Hasil Captcha', 'required|numeric');
		//if (isset($_POST['login']))
		if ($this->form_validation->run() == FALSE) {
			if ($this->session->login == true and $this->session->id_level > 0) {
				redirect('dashboard');
			}
			$token = token();
			$this->session->set_userdata(array('token' => $token));
			$this->mathcaptcha->generatekode();
			$data['captcha'] = $this->mathcaptcha->showcaptcha();
			$data['token'] = $token;
			$data['title'] = 'Login Admin';
			$data['link'] = 'admin';

			$this->load->view('admin/login', $data);
		} else {

			$username = $this->db->escape_str($this->input->post('username'));
			$password = $this->input->post('password');
			$token = $this->input->post('token');
			// $captcha = $this->input->post('captcha');
			$token1 = $this->session->token;

			$os = getOS();
			$browser = getBrowser();
			$ip = getIP();

			$cek = $this->model_app->view_where('user', array('username' => $username, 'status' => 'Y'));
			$total = $cek->num_rows();
			if ($total > 0) {
				$r = $cek->row_array();
				$hash_pass = $r['password'];
				$salt = $r['salt'];
				$check = validateLogin($password, $hash_pass, $salt);
				if ($check == true) {
					$this->session->set_userdata('upload_image_file_manager', true);
					$this->session->set_userdata(array(
						'username' => $r['username'],
						'nama_user' => $r['nama'],
						'level' => $r['level'],
						'id_user' => $r['id_user'],
						'login' => true,
						'foto_user' => $r['gambar'],
						'tahun' => date('Y')

					));
					$this->session->set_flashdata('sukses', 'Selamat Anda Berhasil Login');
					redirect('dashboard');
				} else {
					echo "<script type=\"text/javascript\">window.alert(' Password Salah');
							window.location.href = '" . base_url() . "admin';</script>";
				}
			} else {

				echo "<script type=\"text/javascript\">window.alert('Username  Salah');
						window.location.href = '" . base_url() . "admin';</script>";
			}
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('admin');
	}
} //controller

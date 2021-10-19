<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
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
		$identitas = $this->model_app->edit('identitas', array('id' => 1))->row_array();
		$this->data = array(
			'identitas' => $identitas,
		);
	}

	function index()
	{
		$this->load->library('mathcaptcha');
		$data = $this->data;

		$this->form_validation->set_rules('username', 'Username', 'required|trim');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('sebagai', 'Login Sebagai', 'required|trim');
		$this->form_validation->set_rules('captcha', 'Hasil Captcha', 'required|numeric');
		//if (isset($_POST['login']))
		if ($this->form_validation->run() == FALSE) {

			$token = token();
			$this->session->set_userdata(array('token' => $token));
			$this->mathcaptcha->generatekode();
			$data['captcha'] = $this->mathcaptcha->showcaptcha();
			$data['token'] = $token;
			$data['title'] = 'Login Siswa, Guru dan Pegawai';
			$data['link'] = 'login';

			$this->load->view('login', $data);
		} else {

			$username = $this->db->escape_str($this->input->post('username'));
			$password = $this->input->post('password');
			$sebagai = $this->input->post('sebagai');
			$token = $this->input->post('token');
			$captcha = $this->input->post('captcha');
			$token1 = $this->session->token;

			$os = getOS();
			$browser = getBrowser();
			$ip = getIP();

			if ($token == $token1 and $captcha == $this->mathcaptcha->resultcaptcha()) {
				if ($sebagai == 'Siswa') {
					$cek = $this->model_app->view_where('siswa', array('nisn' => $username));
				} else {
					$cek = $this->model_app->view_where('guru', array('email' => $username));
				}

				$total = $cek->num_rows();
				if ($total > 0) {
					$r = $cek->row_array();
					$hash_pass = $r['password'];
					$salt = $r['salt'];
					$check = validateLogin($password, $hash_pass, $salt);
					if ($check == true) {
						$this->session->set_userdata('upload_image_file_manager', true);
						if ($sebagai == 'Siswa') {
							$this->session->set_userdata(array(
								'username' => $username,
								'nama_user' => $r['nama'],
								'level' => 'SISWA',
								'id_siswa' => $r['id_siswa'],
								'login' => true,
								'foto_user' => $r['gambar'],
								'tahun' => date('Y')

							));
							$this->session->set_flashdata('sukses', 'Selamat Anda Berhasil Login');
							redirect('siswa');
						} else {
							$this->session->set_userdata(array(
								'username' => $username,
								'nama_user' => $r['nama'],
								'level' => $r['jenis'],
								'id_guru' => $r['id_guru'],
								'login' => true,
								'foto_user' => $r['gambar'],
								'tahun' => date('Y')

							));
							$this->session->set_flashdata('sukses', 'Selamat Anda Berhasil Login');
							redirect('guru');
						}
					} else {
						echo "<script type=\"text/javascript\">window.alert(' Username atau Password Salah');
					window.location.href = '" . base_url() . "login';</script>";
					}
				} else {

					echo "<script type=\"text/javascript\">window.alert('Username atau Password Salah');
						window.location.href = '" . base_url() . "login';</script>";
				}
			} else {
				echo "<script type=\"text/javascript\">window.alert('Captcha Salah');
						window.location.href = '" . base_url() . "login';</script>";
			}
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect();
	}
} //controller

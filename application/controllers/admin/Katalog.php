<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Katalog extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('username'))) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong> Upss </strong>Anda tidak memiliki akses, silahkan login!</div>');
			redirect('login');
		}
		$this->load->model('Katalog_model', 'katalog_model');
	}


	public function index()
	{
		$data = array(
			'title' => 'JeWePe Wedding Organizer',
			'page' => 'admin/katalog',
			'getAllKatalog' => $this->katalog_model->get_all_katalog('')->result(),
		);

		$this->load->view('admin/template/main', $data);
	}

	public function add()
	{
		$data = array(
			'title' => 'Tambah Katalog - JeWePe Wedding Organizer',
			'page' => 'admin/add_katalog'
		);

		$this->load->view('admin/template/main', $data);
	}

	public function addData()
	{
		$post = $this->input->post();
		$fileName = date('Ymd') . '_' . rand();

		if ($post) {
			$data = array(
				'package_name' => $post['package_name'],
				'description' => $post['description'],
				'price' => $post['price'],
				'status_publish' => $post['status_publish'],
				'user_id' => $this->session->userdata('user_id')
			);

			if (!empty($_FILES['image']['name'])) {
				$upload = $this->_do_upload($fileName);
				$data['image'] = $upload;
			}

			$insert = $this->katalog_model->insert($data);

			if ($insert) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Data Berhasil Di Tambah! <i class="remove ti-close" data-dismiss="alert"></i></div>');
				redirect('admin/Katalog');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>UPSS! </strong>Data Gagal Di Tambah <i class="remove ti-close" data-dismiss="alert"></i></div>');
				redirect('admin/Katalog/add');
			}
		} else {
			redirect('admin/Katalog/add');
		}
	}

	public function edit()
	{
		$id = $this->input->get('id');
		$katalog = $this->katalog_model->get_katalog_by_id($id)->row();

		if (!$katalog) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
			redirect('admin/Katalog');
		}

		$data = array(
			'title' => 'Edit Katalog - JeWePe Wedding Organizer',
			'page' => 'admin/edit_katalog',
			'katalog' => $katalog
		);

		$this->load->view('admin/template/main', $data);
	}

	public function updateData()
	{
		$post = $this->input->post();
		$id = $post['catalogue_id'];
		$fileName = date('Ymd') . '_' . rand();

		if ($post) {
			$data = array(
				'package_name' => $post['package_name'],
				'description' => $post['description'],
				'price' => $post['price'],
				'status_publish' => $post['status_publish']
			);

			// Get old image
			$katalog = $this->katalog_model->get_katalog_by_id($id)->row();
			$old_image = $katalog ? $katalog->image : '';

			if (!empty($_FILES['image']['name'])) {
				if ($old_image != '') {
					unlink(FCPATH . 'assets/files/katalog/' . $old_image);
				}
				$upload = $this->_do_upload($fileName);
				$data['image'] = $upload;
			}

			$update = $this->katalog_model->update($id, $data);

			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Data Berhasil Di Update! <i class="remove ti-close" data-dismiss="alert"></i></div>');
			} else {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>UPSS! </strong>Data Gagal Di Update <i class="remove ti-close" data-dismiss="alert"></i></div>');
			}
			redirect('admin/Katalog');
		} else {
			redirect('admin/Katalog');
		}
	}

	public function delete()
	{
		$id = $this->input->get('id');

		$katalog = $this->katalog_model->get_katalog_by_id($id)->row();

		if ($katalog) {
			if ($katalog->image != '') {
				unlink(FCPATH . 'assets/files/katalog/' . $katalog->image);
			}
			$this->katalog_model->delete_by_id($id);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Data Berhasil Di Hapus! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error </strong>Data tidak ditemukan! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		}

		redirect('admin/Katalog');
	}

	private function _do_upload($fileName)
	{
		$config['file_name'] = $fileName;
		$config['upload_path'] = FCPATH . 'assets/files/katalog/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPG|JPEG';
		$config['max_size'] = 5000;
		$config['create_thumb'] = FALSE;
		$config['quality'] = '90%';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('image')) {
			$data['inputerror'][] = 'image';
			$data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', '');
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}





}

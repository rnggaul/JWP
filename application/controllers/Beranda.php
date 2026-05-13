<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Beranda extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Settings_model', 'settings_model');
		$this->load->model('Katalog_model', 'katalog_model');
		$this->load->model('Orders_model', 'orders_model');
		$this->load->helper('text'); // Load text helper for word_limiter function
	}
	public function index()
	{

		$data = array(
			'title' => 'Beranda - JeWePe Wedding Organizer',
			'page' => 'landing/beranda',
			'getDataWeb' => $this->settings_model->getSettings(1)->row(),
			'getAllKatalog' => $this->katalog_model->get_all_katalog_landing()->result(),
		);

		$this->load->view('landing/template/sites', $data);
	}


	public function detail()
	{
		$id = $this->input->get('id');
		if (empty($id)) {
			redirect('beranda');
		}

		$katalog = $this->katalog_model->get_katalog_by_id($id)->row();
		if (!$katalog) {
			show_404();
		}

		$data = array(
			'title' => $katalog->package_name . ' - JeWePe Wedding Organizer',
			'page' => 'landing/detail',
			'katalog' => $katalog,
		);

		$this->load->view('landing/template/sites', $data);
	}

	public function pesan()
	{
		$post = $this->input->post();
		if ($post) {
			$data = array(
				'catalogue_id' => $post['catalogue_id'],
				'name' => $post['name'],
				'email' => $post['email'],
				'phone_number' => $post['phone_number'],
				'wedding_date' => $post['wedding_date'],
				'status' => 'requested',
				'created_at' => date('Y-m-d H:i:s')
			);

			if ($this->orders_model->check_duplicate($data['catalogue_id'], $data['wedding_date'])) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Paket untuk tanggal tersebut sudah dipesan sebelumnya! <i class="remove ti-close" data-dismiss="alert"></i></div>');
			} else {
				if ($this->orders_model->insert_order($data)) {
					$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Pesanan berhasil dibuat! <i class="remove ti-close" data-dismiss="alert"></i></div>');
				} else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Gagal membuat pesanan! <i class="remove ti-close" data-dismiss="alert"></i></div>');
				}
			}
			redirect('beranda/detail?id=' . $data['catalogue_id']);
		} else {
			redirect('beranda');
		}
	}
}

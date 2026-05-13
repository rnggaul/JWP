<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('username'))) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong> Upss </strong>Anda tidak memiliki akses, silahkan login!</div>');
			redirect('login');
		}
		$this->load->model('Katalog_model', 'katalog_model');
		$this->load->model('Orders_model', 'orders_model');
	}

	public function index()
	{
		$data = array(
			'title' => 'Dashboard - JeWePe Wedding Organizer',
			'page' => 'admin/dashboard',
			'totalKatalog' => $this->katalog_model->get_total_katalog(),
			'totalOrders' => $this->orders_model->get_total_orders(),
			'pendingOrders' => $this->orders_model->get_pending_orders(),
			'acceptedOrders' => $this->orders_model->get_accepted_orders(),
		);

		$this->load->view('admin/template/main', $data);
	}
}

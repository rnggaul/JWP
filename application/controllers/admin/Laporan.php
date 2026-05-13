<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('username'))) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <strong> Upss </strong>Anda tidak memiliki akses, silahkan login!</div>');
			redirect('login');
		}
		$this->load->model('Orders_model', 'orders_model');
	}

	public function index()
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');

		$this->db->select('tbo.*, tbc.package_name, tbc.image');
		$this->db->from('tb_order tbo');
		$this->db->join('tb_catalogues tbc', 'tbc.catalogue_id = tbo.catalogue_id');
		if ($start_date && $end_date) {
			$this->db->where('tbo.created_at >=', $start_date . ' 00:00:00');
			$this->db->where('tbo.created_at <=', $end_date . ' 23:59:59');
		}
		$this->db->order_by('tbo.created_at', 'DESC');
		$query = $this->db->get();

		$data = array(
			'title' => 'Laporan Pesanan - JeWePe Wedding Organizer',
			'page' => 'admin/laporan',
			'getAllOrders' => $query->result(),
		);

		$this->load->view('admin/template/main', $data);
	}
}

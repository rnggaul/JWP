<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesanan extends CI_Controller
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
		$data = array(
			'title' => 'Manajemen Pesanan - JeWePe Wedding Organizer',
			'page' => 'admin/pesanan',
			'getAllOrders' => $this->orders_model->get_all_orders()->result(),
		);

		$this->load->view('admin/template/main', $data);
	}

	public function terima($id)
{
    if ($this->orders_model->update_status($id, 'accepted')) { // ubah jadi 'accepted'
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Status pesanan berhasil diupdate! <i class="remove ti-close" data-dismiss="alert"></i></div>');
    } else {
        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error </strong>Gagal update status! <i class="remove ti-close" data-dismiss="alert"></i></div>');
    }
    redirect('admin/Pesanan');
}

	public function batalkan($id)
	{
		if ($this->orders_model->update_status($id, 'dibatalkan')) {
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Status pesanan berhasil diupdate! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error </strong>Gagal update status! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		}
		redirect('admin/Pesanan');
	}

	public function delete($id)
	{
		if ($this->orders_model->delete_order($id)) {
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Success </strong>Pesanan berhasil dihapus! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		} else {
			$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Error </strong>Gagal menghapus pesanan! <i class="remove ti-close" data-dismiss="alert"></i></div>');
		}
		redirect('admin/Pesanan');
	}
}

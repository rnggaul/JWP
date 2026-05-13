<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Orders_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function check_duplicate($catalogue_id, $wedding_date)
    {
        $this->db->where('catalogue_id', $catalogue_id);
        $this->db->where('wedding_date', $wedding_date);
        $query = $this->db->get('tb_order');
        return $query->num_rows() > 0;
    }


public function insert_order($data)
{
    if (!isset($data['status']) || empty($data['status'])) {
        $data['status'] = 'requested'; // Default status
    }
    return $this->db->insert('tb_order', $data);
}

    public function get_all_orders()
    {
        $this->db->select('tbo.*, tbc.package_name, tbc.image');
        $this->db->from('tb_order tbo');
        $this->db->join('tb_catalogues tbc', 'tbc.catalogue_id = tbo.catalogue_id');
        $this->db->order_by('tbo.created_at', 'DESC');
        $query = $this->db->get();
        return $query;
    }

    public function get_order_by_id($id)
    {
        $this->db->select('tbo.*, tbc.package_name, tbc.image');
        $this->db->from('tb_order tbo');
        $this->db->join('tb_catalogues tbc', 'tbc.catalogue_id = tbo.catalogue_id');
        $this->db->where('tbo.order_id', $id);
        $query = $this->db->get();
        return $query;
    }

    public function update_status($id, $status)
    {
        $this->db->where('order_id', $id);
        return $this->db->update('tb_order', array('status' => $status));
    }

    public function delete_order($id)
    {
        $this->db->where('order_id', $id);
        return $this->db->delete('tb_order');
    }

    public function get_total_orders()
    {
        return $this->db->count_all('tb_order');
    }

    public function get_pending_orders()
    {
        $this->db->where_in('status', ['requested', 'menunggu', 'pending']);
        return $this->db->count_all_results('tb_order');
    }

    public function get_accepted_orders()
    {
        $this->db->where_in('status', ['accepted', 'diterima']);
        return $this->db->count_all_results('tb_order');
    }

}

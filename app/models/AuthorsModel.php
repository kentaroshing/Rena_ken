<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class AuthorsModel extends Model
{
    protected $table = 'authors';

    public function all()
    {
        return $this->db->select('*')->from($this->table)->get()->result_array();
    }

    public function find($id)
    {
        return $this->db->select('*')->from($this->table)->where('id', $id)->get()->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }

    public function page($q = '', $records_per_page = 10, $page = 1)
    {
        $offset = ($page - 1) * $records_per_page;

        $this->db->from($this->table);

        if (!empty($q)) {
            $this->db->group_start();
            $this->db->like('first_name', $q);
            $this->db->or_like('last_name', $q);
            $this->db->or_like('email', $q);
            $this->db->group_end();
        }

        $total_rows = $this->db->count_all_results('', false);

        $this->db->limit($records_per_page, $offset);
        $query = $this->db->get();

        $records = $query->result_array();

        return [
            'total_rows' => $total_rows,
            'records' => $records
        ];
    }
}

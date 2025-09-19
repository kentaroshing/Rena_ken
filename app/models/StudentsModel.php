<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: StudentsModel
 * 
 * Automatically generated via CLI.
 */
class StudentsModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        return $this->db->table('students')->select('id, first_name, last_name, email')->get_all();
    }

    public function get_paginated($q = '', $limit = 10, $offset = 0)
    {
        $query = $this->db->table('students')->select('id, first_name, last_name, email');

        if (!empty($q)) {
            $query->like('first_name', $q)->or_like('last_name', $q)->or_like('email', $q);
        }

        $total_rows = $query->count_all_results(false);
        $records = $query->limit($limit, $offset)->get_all();

        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }
    
}

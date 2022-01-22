<?php
// models/Users.php
defined('BASEPATH') or exit('No direct script access allowed');

class Pagination_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function getCountData($table)
    {
        return $this->db->count_all($table);
    }

    public function getCountDataWhe($table, $where)
    {
        $this->db->where($where);
        return $this->db->get($table)->num_rows();
    }

    public function get_current_page_records($table, $limit, $start)
    {
        $this->db->limit($limit, $start);
        $query = $this->db->get($table);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return false;
    }
}

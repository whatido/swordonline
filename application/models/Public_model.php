<?php

class Public_model extends MY_Model
{
    function addData($from, $data)
    {
        $this->db->insert($from, $data);
    }

    function getData($select = '*', $from, $where)
    {
        $this->db->select($select);
        $this->db->from($from);
        $query = $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }
    function updData($from, $data, $where)
    {
        $this->db->where($where);
        $this->db->update($from, $data);
    }
    public function update($table, $data)
    {
        $this->db->where($data['where']);
        $this->db->set($data['update']);
        $this->db->update($table);
    }
    public function delete($table, $id)
    {
        $this->db->where('id', $id);
        $this->db->delete($table);
    }
    public function delWhe($table, $whe)
    {
        $this->db->where($whe);
        $this->db->delete($table);
    }
}

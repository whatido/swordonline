<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
    public $template_main;
    public function __construct()
    {
        parent::__construct();
        // config path
        $template_main = 'public/layout';
    }

    function session($type, $data)
    {
        switch ($type) {
            case 'set':
                $this->session->set_userdata($data);
                break;
            case 'remove':
                $this->session->unset_userdata($data);
                break;
        }
    }

    public function setCacheFile($timeOut = 1)
    {
        $this->output->cache($timeOut);
    }
    public function setCache($key, $data, $timeOut = 3600)
    {
        $this->cache->save($key, $data, $timeOut);
    }

    public function getCache($key)
    {
        return $this->cache->get($key);
    }

    public function deleteCache($key = null)
    {
        if (!empty($key)) {
            return $this->cache->delete($key);
        } else return $this->cache->clean();
    }

    function getDataBy($table, $param = [])
    {

        $cache = "cache_by_$table".implode('_', $param);
        //$data = $this->getCache($cache);
        if (empty($data)) {
            $this->db->select('*');
            if (count($param) > 1) {
                foreach ($param as $item) {
                    $this->db->where($item);
                }
            } else $this->db->where($param);
            $this->db->order_by('id', "ASC");
            $query = $this->db->get($table);
            $data = $query->result_array();
            $this->setCache($cache, $data, 100);
        };
        if (count($data) === 1) {
            return (array) $query->row();
        } else {
            return $data;
        }
        
    }

    function getDataByODR($table, $param = [], $order=['id'=>'ASC'])
    {

        $cache = "cache_by_".implode('_', $param);
        //$data = $this->getCache($cache);
        if (empty($data)) {
            $this->db->select('*');
            $this->db->where($param);
            if(!empty($order)) foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
            $query = $this->db->get($table);
            $data = $query->result_array();
            $this->setCache($cache, $data, 100);
        }
        if (count($data) === 1) {
            return (array) $query->row();
        } else {
            return $data;
        }
    }

    function getDataByLM($table, $param = '', $limit, $page = 1, $order = null, $search = null, $select='*')
    {
        $this->db->select($select);
        $this->db->where($param);
        if(is_string($order)) {
            $this->db->order_by($order, "ASC");
        } else {
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        $offset = ($page - 1) * $limit;
        if (empty($search)) $this->db->limit($limit, $offset);
        if (!empty($search)) {
            $query = $this->db->get($table)->result_array();
            $rs = [];
            if (!empty($query)) foreach ($query as $key => $value) {
                if (strpos($value[$search[0]], $search[1]) !== false) {
                    $rs[] = $value;
                }
            };
            return $rs;
        }
        $query = $this->db->get($table);
        return $query->result_array();
    }

    public function getLevel($table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('position', 'ASC');
        $query = $this->db->get();
        $res = $query->result();
        if ($res){
            return $res;
        }
        else{
            return false;
        }
    }

    public function updateData($db, $where, $data)
    {
        $this->db->where($where);
        $this->db->update($db, $data);
        return true;
    }

    public function updateDataRsID($db, $where, $data)
    {
        $this->db->where($where);
        $this->db->update($db, $data);
        return true;
    }

    function inserData($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function deleteDataBy($table, $where)
    {
        $this->db->delete($table, $where);
        return true;
    }
}

class MYDungeon_Model extends MY_Model
{
    public function gameSetting()
    {
        $data = $this->getCache('game_settings');
        if (empty($data)) {
            $data = json_decode(file_get_contents(base_url('game_settings.json')));
            $this->setCache('game_settings', $data);
        }
        return $data;
    }
}

class MYAdmin_Model extends MY_Model
{

}

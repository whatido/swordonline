<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends Dungeon_Controller
{
    protected $_dungeon;
    protected $templates_media;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['Dungeon_model']);
        $this->_dungeon = new Dungeon_model();
    }

    public function index()
    {
        $__layout = 'default/guide/welcome';
        $__view = 'default/guide/guide';
        $data = array_merge([], $this->___root);
        /////////////////////////////////////////
        $data['main'] = $this->load->view($__view, $data, true);
        $this->load->view($__layout, $data);
    }
}

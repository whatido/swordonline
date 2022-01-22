<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Library extends Dungeon_Controller
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
}

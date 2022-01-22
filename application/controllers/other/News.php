<?php
defined('BASEPATH') or exit('No direct script access allowed');

class News extends PUBLIC_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['Dungeon_model']);
        $this->_dungeon = new Dungeon_model();
    }

    public function index($item=null)
    {
        $data['title'] = 'News - tin tức tổng hợp nổi bật trong tuần';
        if(!empty($item)) {
            $data['feets'] = $this->getFeeds('https://vnexpress.net/rss/'.$item.'.rss', 50);
        } else $data['feets'] = $this->getFeeds('https://vnexpress.net/rss/tin-moi-nhat.rss', 50);
        
            $data['stories'] = $this->getFeeds('https://vnexpress.net/rss/tam-su.rss', 5);
            $data['funny'] = $this->getFeeds('https://vnexpress.net/rss/cuoi.rss', 5);
            $this->view('default/other/news/index', $data);
    }

    public function quest($item=null)
    {
        $data['feets'] = $this->getFeeds('https://vnexpress.net/rss/'.$item.'.rss', 50);
        echo $this->view('default/other/news/quest', $data);
    }

    private function view($view, $data) {
        $__layout = 'default/other/layout';
        $data['main'] = $this->load->view($view, (object) $data, true);
        $this->load->view($__layout, $data);
    }
}

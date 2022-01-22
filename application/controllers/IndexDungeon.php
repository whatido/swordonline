<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IndexDungeon extends Dungeon_Controller
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
        $view = 'default/public/dungeon/index';
        $data = array_merge([], $this->___root);
        /////////////////////////////////////////
        if (!empty($_SESSION['users'])) {
            $this->createmonster();
            $_SESSION['message'] = '';
            if (!empty($data['heroes'])) {
                $view = 'default/public/dungeon/index2';
                $map = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $_SESSION['heroes']['map']]);
                if (!empty($map)) {
                    $data['map'] = $map[0];
                    $data['map']['background'] = json_decode($data['map']['background']);
                    $data['map']['inbackground'] = json_decode($data['map']['inbackground']);
                    $data['plink'] = $plink = json_decode($data['map']['plink']);
                    $data['link'] = $link = json_decode($data['map']['link']);
                    $hmap = $this->_dungeon->getData('*', 'dungeon_hmap', ['map' => $_SESSION['heroes']['map']]);
                    $data['hmap'] = $this->array_group_by($hmap, function ($a) {
                        return $a['where'];
                    });
                    if (in_array($_SESSION['heroes']['x'], $plink) === true && is_numeric($link[array_search($_SESSION['heroes']['x'], $plink)])) {
                        $map_id = $link[array_search($_SESSION['heroes']['x'], $plink)];
                        $data['nextmap'] = $this->_dungeon->getData('*', 'dungeon_map', ['id' => $map_id]);
                    };
                };
                
            } else {
                redirect(base_url('dungeon/account/register'));
            }
        };
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function spells()
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/spells';
        if (!empty($_SESSION['users'])) {
            $data['list'] = $this->_dungeon->getData('*', 'dungeon_uspells', ['user' => $_SESSION['heroes']['id']]);
            if (!empty($_GET['active'])) {
                $this->_dungeon->update('dungeon_uspells', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => ['active' => '0']]);
                $this->_dungeon->update('dungeon_uspells', ['where' => ['id' => $_GET['id']], 'update' => ['active' => '1']]);
                redirect(base_url('dungeon/spells'));
            }
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function online()
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/online';
        if (!empty($_SESSION['users'])) {
            $data['list'] = $this->_dungeon->getOnline('list');
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function credits($status = null, $code = null)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/credits';
        switch ($status) {

            case 'add':
                $data['status'] = $status;
                if (!empty($this->input->post())) {
                    $number = $this->input->post()['number'];
                    $gold = $number * 1000;
                    if ($_SESSION['heroes']['gold'] > $gold) {
                        $_SESSION['heroes']['gold'] = $_SESSION['heroes']['gold'] - $gold;
                        $_SESSION['heroes']['credit'] = $_SESSION['heroes']['credit'] + $number;
                        $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                    }
                    redirect(base_url('dungeon/credits'));
                }
                break;
            case 'remove':
                $data['status'] = $status;
                if (!empty($this->input->post()['numdateDiamond'])) {
                    $mode = $this->_dungeon->getData('*', 'dungeon_mode', ['user' => $_SESSION['heroes']['id'], 'name' => 'Diamond'])[0];
                    $numdateDiamond = $this->input->post()['numdateDiamond'];
                    $credit = $numdateDiamond * 100;
                    $time_start = time();
                    $time_end = $time_start + (86400 * $numdateDiamond);
                    if (!empty($mode)) {
                        $datamode = [
                            'date_end' => ($mode['date_end'] + (86400 * $numdateDiamond))
                        ];
                        $_SESSION['mode_Diamond'] = ($mode['date_end'] + (86400 * $numdateDiamond));
                        if ($_SESSION['heroes']['max_inventory'] < 100) {
                            $_SESSION['heroes']['max_inventory'] = 100;
                            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                        }
                        $this->_dungeon->update('dungeon_mode', ['where' => ['id' => $mode['id']], 'update' => $datamode]);
                    } else {
                        $datamode = [
                            'user' => $_SESSION['heroes']['id'],
                            'name' => 'Diamond',
                            'date_start' => $time_start,
                            'date_end' => $time_end
                        ];
                        if ($_SESSION['heroes']['max_inventory'] < 100) {
                            $_SESSION['heroes']['max_inventory'] = 100;
                            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                        }
                        $_SESSION['mode_Diamond'] = $time_end;
                        $this->_dungeon->addData('dungeon_mode', $datamode);
                    }
                    if ($_SESSION['heroes']['credit'] >= $credit) {
                        $_SESSION['heroes']['credit'] = $_SESSION['heroes']['credit'] - $credit;
                        $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                    }
                    redirect(base_url('dungeon/credits'));
                }

                if (!empty($this->input->post()['numdateExperian'])) {
                    $mode = $this->_dungeon->getData('*', 'dungeon_mode', ['user' => $_SESSION['heroes']['id'], 'name' => 'Experian'])[0];
                    $numdateExperian = $this->input->post()['numdateExperian'];
                    $credit = $numdateExperian * 10;
                    $time_start = time();
                    $time_end = $time_start + (86400 * $numdateExperian);
                    if (!empty($mode)) {
                        $datamode = [
                            'date_end' => ($mode['date_end'] + (86400 * $numdateExperian))
                        ];
                        $_SESSION['mode_Experian'] = ($mode['date_end'] + (86400 * $numdateExperian));
                        if ($_SESSION['heroes']['max_inventory'] < 100) {
                            $_SESSION['heroes']['max_inventory'] = 100;
                            $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                        }
                        $this->_dungeon->update('dungeon_mode', ['where' => ['id' => $mode['id']], 'update' => $datamode]);
                    } else {
                        $datamode = [
                            'user' => $_SESSION['heroes']['id'],
                            'name' => 'Experian',
                            'date_start' => $time_start,
                            'date_end' => $time_end
                        ];
                        $_SESSION['mode_Experian'] = $time_end;
                        $this->_dungeon->addData('dungeon_mode', $datamode);
                    }
                    if ($_SESSION['heroes']['credit'] > $credit) {
                        $_SESSION['heroes']['credit'] = $_SESSION['heroes']['credit'] - $credit;
                        $this->_dungeon->update('dungeon_uheroes', ['where' => ['id' => $_SESSION['heroes']['id']], 'update' => $_SESSION['heroes']]);
                    }
                    redirect(base_url('dungeon/credits'));
                }
                break;

            default:
                $data['heroes'] = $udungeon = $this->_dungeon->getData('*', 'dungeon_uheroes', ['id' => $_SESSION['heroes']['id']])[0];
                $data['users'] = $users = $this->_dungeon->getData('*', 'users', ['id' => $udungeon['users']])[0];
                $udungeon['username'] = $users['username'];
                $data['users'] = (object) $udungeon;

                $data['status'] = 'view';
                break;
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function inbox($status = null, $code = null)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/inbox';
        switch ($status) {
            case 'detail':
                $data['item'] = $item = $this->_dungeon->getData('*', 'dungeon_inbox', ['id' => $code])[0];
                $data['status'] = 'detail';
                if (!empty($this->input->post())) {
                    $item = $this->_dungeon->getData('*', 'dungeon_inbox', ['id' => $code])[0];
                    $query = $this->input->post();
                    $query['go'] = $_SESSION['users']['username'];
                    $query['to'] = $item['to'];
                    $query['parent'] = $item['id'];
                    $query['time'] = time();
                    $this->_dungeon->addData('dungeon_inbox', $query);
                }
                $data['list'] = $list = $this->_dungeon->getData('*', 'dungeon_inbox', ['parent' => $code]);
                break;
            case 'mes':
                $data['status'] = $status;
                $data['to'] = $code;
                if (!empty($this->input->post())) {
                    $query = $this->input->post();
                    $query['go'] = $_SESSION['users']['username'];
                    $query['time'] = time();
                    $this->_dungeon->addData('dungeon_inbox', $query);
                    redirect(base_url('dungeon/inbox'));
                }
                break;

            default:
                $listto = $this->_dungeon->getData('*', 'dungeon_inbox', ['to' => $_SESSION['users']['username'], 'parent' => 0]);
                $listgo = $this->_dungeon->getData('*', 'dungeon_inbox', ['go' => $_SESSION['users']['username'], 'parent' => 0]);
                $data['list'] = array_merge($listgo, $listto);
                $data['status'] = 'view';
                break;
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function friends($status = null, $code = null)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/friends';
        switch ($status) {

            case 'add':
                $data['status'] = $status;
                $data['to'] = $code;
                if (!empty($this->input->post())) {
                    $username = $this->input->post()['username'];
                    $fri = $this->_dungeon->getData('*', 'users', ['username' => $username])[0];
                    $query = [
                        'users' => $_SESSION['users']['id'],
                        'friends' => $fri['id'],
                        'time' => time()
                    ];
                    $this->_dungeon->addData('dungeon_friends', $query);
                    redirect(base_url('dungeon/friends'));
                }
                break;
            case 'remove':
                $data['status'] = $status;
                $data['to'] = $code;
                if (!empty($this->input->post())) {
                    $username = $this->input->post()['username'];
                    $fri = $this->_dungeon->getData('*', 'users', ['username' => $username])[0];
                    $query = [
                        'users' => $_SESSION['users']['id'],
                        'friends' => $fri['id']
                    ];
                    $this->_dungeon->delWhe('dungeon_friends', $query);
                    redirect(base_url('dungeon/friends'));
                }
                break;

            default:
                $data['list'] = $this->_dungeon->getFriends($_SESSION['users']['id']);
                $data['status'] = 'view';
                break;
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function chat($status = null, $code = null)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/chat';
        switch ($status) {
            default:
                if (!empty($this->input->post())) {
                    $query = $this->input->post();
                    $query['users'] = $_SESSION['users']['username'];
                    $query['time'] = time();
                    $this->_dungeon->addData('dungeon_chat', $query);
                }
                $data['list'] = $this->_dungeon->getData('*', 'dungeon_chat', []);
                $data['status'] = 'view';
                break;
        }
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function setting($status = null, $code = null)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/setting';

        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function lang()
    {
        $lang = $_GET['lang'];
        if ($lang == 'vi') $_SESSION['lang'] = 'vi';
        if ($lang == 'en') $_SESSION['lang'] = 'en';
        redirect(base_url(''));
    }

    public function library()
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/library/index';
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/library/layout', $data);
    }

    public function reset() {
        $this->_dungeon->truncate('users');
        $this->_dungeon->truncate('dungeon_uspells');
        $this->_dungeon->truncate('dungeon_uitems');
        $this->_dungeon->truncate('dungeon_uheroes');
        $this->_dungeon->truncate('dungeon_mode');
        $this->_dungeon->truncate('dungeon_hmap');
        $this->_dungeon->truncate('dungeon_chat');
    }
}

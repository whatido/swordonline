<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Account extends Dungeon_Controller
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

    public function login()
    {
        $data = [];
        if (isset($_SESSION['email'])) {
            redirect(base_url('dungeon'));
        };
        $data['lang'] = $lang = $this->language();
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == TRUE) {
                $post = $this->input->post();
                unset($post['submit']);
                $login = $this->_dungeon->login($post);
                if (!empty($login)) {
                    $this->_dungeon->update('users', ['where' => ['id' => $login[0]['id']], 'update' => ['last_signin' => time()]]);
                    $udungeon = $this->_dungeon->getData('*', 'dungeon_uheroes', ['users' => $login[0]['id']])[0];
                    $users['users'] = $login[0];
                    $heroes['heroes'] = $udungeon;
                    $mode = $this->_dungeon->getData('*', 'dungeon_mode', ['user' => $udungeon['id'], 'name' => 'Diamond'])[0];
                    if (!empty($mode)) $_SESSION['mode_Diamond'] = $mode['date_end'];
                    $this->session->set_userdata($users);
                    $this->session->set_userdata($heroes);
                    redirect(base_url('dungeon'));
                } else {
                    $data['error'] = "bad password or account not be register!";
                }
            }
        }
        $data['main'] = $this->load->view('default/public/dungeon/index', $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function register()
    {
        $data = [];
        $data['lang'] = $lang = $this->language();
        $view = 'default/public/dungeon/register';
        if ($this->input->post() && (!isset($_SESSION['users']['email']))) {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == TRUE) {
                $post = $this->input->post();
                $user_id = $this->_dungeon->register($post);
                if (!empty($user_id[0])) {
                    $users['users'] = $user_id[0];
                    $this->session->set_userdata($users);
                    redirect(base_url('dungeon/account/register'));
                } else {
                    $data['error']['mes'] = "registered account or email";
                }
            } else {
                $data['error']['mes'] = "full not fill information";
                $data['error']['username'] = $this->input->post('username');
                $data['error']['email'] = $this->input->post('email');
                $data['error']['password'] = $this->input->post('password');
            }
        }
        if (isset($_SESSION['users']['email']) && (!isset($_GET['confirm']))) {
            $users = $_SESSION['users'];
            $data['heroes'] = $heroes = $this->_dungeon->allHeroes();
        }
        if (isset($_GET['confirm'])) {
            $users = $this->_dungeon->getData('*', 'users', ['email' => $_SESSION['users']['email']])[0];
            $heroes = $this->_dungeon->get_heroes(['id' => $_GET['confirm']])[0];
            unset($heroes['id']);
            $heroes['users'] = $users['id'];
            $heroes['x'] = 24;
            $this->_dungeon->add_uheroes($heroes);
            $udungeon = $this->_dungeon->getData('*', 'dungeon_uheroes', ['users' => $users['id']])[0];
            $heroess['heroes'] = $udungeon;

            if ($udungeon['class'] == 'barbarian') $litem = ['1'];
            if ($udungeon['class'] == 'druid') $litem = ['40'];
            if ($udungeon['class'] == 'paladin') $litem = ['30'];
            if ($udungeon['class'] == 'necromancer') $litem = ['34'];
            if ($udungeon['class'] == 'amazon') $litem = ['33'];
            if ($udungeon['class'] == 'assassin') $litem = ['32'];
            foreach ($litem as $key => $value) {
                $tem = $this->_dungeon->getData('*', 'dungeon_items', ['id' => $value])[0];
                unset($tem['id']);
                unset($tem['status']);
                $tem['user'] = $udungeon['id'];;
                $this->_dungeon->add_item($tem);
            }
            $this->session->set_userdata($heroess);
            redirect(base_url('dungeon'));
        };
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect(base_url(''));
    }

    public function info($idcode)
    {
        $data = array_merge([], $this->___root);
        $view = 'default/public/dungeon/info';
        $udungeon = $this->_dungeon->getData('*', 'dungeon_uheroes', ['id' => $idcode])[0];
        $data['users'] = $users = $this->_dungeon->getData('*', 'users', ['id' => $udungeon['users']])[0];
        $bonus = $this->_dungeon->getBonusData('*', 'dungeon_bonus', ['type' => $udungeon['class'], 'level <=' => $udungeon['level']])[0];
        $data['bonus'] = json_decode($bonus['data'], true);
        $data['usersbonus'] = $this->bonus($udungeon);
        $udungeon['username'] = $users['username'];
        $data['users'] = (object) $udungeon;
        $data['main'] = $this->load->view($view, $data, true);
        $this->load->view('default/public/dungeon/layout', $data);
    }
}

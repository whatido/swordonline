<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notecode extends PUBLIC_Controller
{
    public $_public;
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model(['Public_model']);
        $this->_public = new Public_model();
    }

    public function index($item = null)
    {
        $data['title'] = 'Code blog - nơi chia sẻ, lưu trữ code mà bạn tìm thấy';
        if (!empty($this->input->post())) {
            $data = $this->input->post();
            $data['created_time'] = time();
            $data['updated_time'] = time();
            unset($data['note']);
            $this->_public->addData('other_notecode', $data);
            redirect(base_url('codes'));
        };
        $this->view('default/other/codes/index', $data);
    }

    private function view($view, $data)
    {
        $__layout = 'default/other/layout';
        $data['main'] = $this->load->view($view, (object) $data, true);
        $this->load->view($__layout, $data);
    }

    private function validate($key)
    {
        $config = array(
            'signup' => array(
                array(
                    'field' => 'username',
                    'label' => 'Username',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'passconf',
                    'label' => 'Password Confirmation',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'email',
                    'label' => 'Email',
                    'rules' => 'required'
                )
            ),
            'email' => array(
                array(
                    'field' => 'emailaddress',
                    'label' => 'EmailAddress',
                    'rules' => 'required|valid_email'
                ),
                array(
                    'field' => 'name',
                    'label' => 'Name',
                    'rules' => 'required|alpha'
                ),
                array(
                    'field' => 'title',
                    'label' => 'Title',
                    'rules' => 'required'
                ),
                array(
                    'field' => 'message',
                    'label' => 'MessageBody',
                    'rules' => 'required'
                )
            )
        );
        return $config[$key];
    }
}

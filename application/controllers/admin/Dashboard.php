<?php defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends ADMIN_Controller
{
	public function __construct()
	{
		parent::__construct();
		auth_check(); // check login auth
		$this->rbac->check_module_access();
		if ($this->uri->segment(3) != '')
			$this->rbac->check_operation_access();

		$this->load->model('admin/dashboard_model', 'dashboard_model');
	}
	//--------------------------------------------------------------------------

	public function index()
	{
		$data['all_users'] = $this->dashboard_model->get_all_users();
		$data['active_users'] = $this->dashboard_model->get_active_users();
		$data['deactive_users'] = $this->dashboard_model->get_deactive_users();
		$data['title'] = 'Dashboard';
		
		$this->view('admin/dashboard/index', $data);
	}
}
